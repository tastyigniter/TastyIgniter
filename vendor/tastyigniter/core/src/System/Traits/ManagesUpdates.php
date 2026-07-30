<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use Exception;
use Igniter\Flame\Composer\Manager;
use Igniter\Flame\Exception\FlashException;
use Igniter\System\Classes\HubManager;
use Igniter\System\Classes\PackageInfo;
use Igniter\System\Classes\UpdateManager;
use Igniter\System\Notifications\SystemUpdateNotification;
use Illuminate\Http\RedirectResponse;
use Throwable;

trait ManagesUpdates
{
    public function search(): array
    {
        $this->validate(input(), [
            'filter' => ['sometimes', 'array'],
            'filter.type' => ['sometimes', 'string', 'in:extension,theme'],
            'filter.search' => ['sometimes', 'string'],
        ]);

        try {
            $itemType = input('filter.type', 'extension');
            $searchQuery = strtolower((string)input('filter.search'));

            $json = $this->processSearch($itemType, $searchQuery);
        } catch (Exception $exception) {
            $json = ['error' => $exception->getMessage()];
        }

        return $json;
    }

    public function onApplyItems(): array
    {
        $updateManager = resolve(UpdateManager::class);

        throw_unless($updateManager->hasValidCarte(), new FlashException(
            lang('igniter::system.updates.alert_no_carte_key'),
        ));

        $validated = $this->validate(post(), [
            'item.code' => ['required'],
            'item.name' => ['required'],
            'item.package' => ['required'],
            'item.type' => ['required', 'in:core,extension,theme'],
            'item.version' => ['required'],
            'item.action' => ['required', 'in:install'],
        ], [
            'item.package.required' => lang('igniter::system.updates.error_meta_package'),
        ], [
            'item.code' => lang('igniter::system.updates.label_meta_code'),
            'item.name' => lang('igniter::system.updates.label_meta_name'),
            'item.package' => lang('igniter::system.updates.label_meta_package'),
            'item.type' => lang('igniter::system.updates.label_meta_type'),
            'item.version' => lang('igniter::system.updates.label_meta_version'),
            'item.action' => lang('igniter::system.updates.label_meta_action'),
        ]);

        $validated['item']['package'] ??= resolve(Manager::class)->getPackageName(array_get($validated, 'item.code'));
        $packageInfo = PackageInfo::fromArray($validated['item']);

        [$response, $success] = $this->processInstallOrUpdate([$packageInfo]);

        return [
            'message' => implode('<br>', $response),
            'success' => $success,
            'redirect' => $success ? admin_url(str_plural($validated['item']['type'])) : null,
        ];
    }

    public function onApplyUpdate(): array
    {
        $updateManager = resolve(UpdateManager::class);

        throw_unless($updateManager->hasValidCarte(), new FlashException(
            lang('igniter::system.updates.alert_no_carte_key'),
        ));

        $updates = $updateManager->requestUpdateList();
        $itemsToUpdate = array_get($updates, 'items', []);
        if ($itemsToUpdate->isEmpty()) {
            throw new FlashException(lang('igniter::system.updates.alert_item_to_update'));
        }

        [$response, $success] = $this->processInstallOrUpdate($itemsToUpdate->all(), isUpdate: true);

        $updateManager->requestUpdateList(true);

        return [
            'message' => implode('<br>', $response),
            'success' => $success,
            'redirect' => $success ? admin_url('updates') : null,
        ];
    }

    public function onCheckUpdates(): RedirectResponse
    {
        $updates = resolve(UpdateManager::class)->requestUpdateList(true);

        SystemUpdateNotification::make(array_only($updates, ['count']))->broadcast();

        return $this->redirectBack();
    }

    public function onIgnoreUpdate(): RedirectResponse
    {
        $itemCode = post('code', '');
        if (empty($itemCode)) {
            throw new FlashException(lang('igniter::system.updates.alert_item_to_ignore'));
        }

        resolve(UpdateManager::class)->markedAsIgnored($itemCode, (bool)post('remove'));

        return $this->redirectBack();
    }

    public function onApplyCarte(): RedirectResponse
    {
        if (!$carteKey = post('carte_key')) {
            throw new FlashException(lang('igniter::system.updates.alert_no_carte_key'));
        }

        resolve(UpdateManager::class)->applyCarte($carteKey);

        return $this->redirectBack();
    }

    public function onClearCarte(): RedirectResponse
    {
        resolve(UpdateManager::class)->clearCarte();

        return $this->redirectBack();
    }

    //
    //
    //

    protected function initUpdate(string $itemType)
    {
        $this->prepareAssets();

        $updateManager = resolve(UpdateManager::class);

        $this->vars['itemType'] = $itemType;
        $this->vars['carteInfo'] = $updateManager->getCarteInfo();
        $this->vars['installedItems'] = $updateManager->getInstalledItems();
    }

    protected function prepareAssets()
    {
        $this->addJs('vendor/typeahead.js', 'typeahead-js');
        $this->addJs('updates.js', 'updates-js');
        $this->addJs('formwidgets/recordeditor.modal.js', 'recordeditor-modal-js');
    }

    protected function processSearch(string $itemType, string $searchQuery): array
    {
        $items = resolve(HubManager::class)->listItems([
            'type' => $itemType,
            'search' => $searchQuery,
        ]);

        if (isset($items['data'])) {
            $installedItems = array_column(resolve(UpdateManager::class)->getInstalledItems(), 'name');
            foreach ($items['data'] as &$item) {
                $item['icon'] = generate_extension_icon($item['icon'] ?? []);
                $item['installed'] = in_array($item['code'], $installedItems);
            }
        }

        return $items;
    }

    protected function processInstallOrUpdate(array $items, bool $isUpdate = false): array
    {
        $response = [];
        $composerLog = [];
        $success = false;

        try {
            $response[] = $isUpdate
                ? lang('igniter::system.updates.progress_update')
                : lang('igniter::system.updates.progress_install');

            $updateManager = resolve(UpdateManager::class);
            $installedPackages = $updateManager->install($items, function($type, $line) use (&$composerLog): void {
                $composerLog[] = $line;
            });
            $updateManager->completeInstall($installedPackages);

            logger()->info(implode(PHP_EOL, $composerLog));
            $response[] = implode('<br>', $updateManager->getLogs());
            $response[] = $isUpdate
                ? lang('igniter::system.updates.progress_update_ok')
                : lang('igniter::system.updates.progress_install_ok');

            // Run migrations
            $response[] = lang('igniter::system.updates.progress_migrate_database');
            $updateManager->migrate();
            $response[] = lang('igniter::system.updates.progress_migrate_database_ok');

            $success = true;
        } catch (Throwable $throwable) {
            logger()->error($throwable->getMessage(), [
                'trace' => $throwable->getTraceAsString(),
                'line' => $throwable->getLine(),
                'file' => $throwable->getFile(),
            ]);
            $response[] = nl2br($throwable->getMessage()
                ."\n\n"
                .'<a href="https://tastyigniter.com/support/articles/failed-updates" target="_blank">Troubleshoot</a>'
                ."\n\n",
            );
        }

        $response[] = lang('igniter::system.updates.text_see_logs');

        return [$response, $success];
    }
}
