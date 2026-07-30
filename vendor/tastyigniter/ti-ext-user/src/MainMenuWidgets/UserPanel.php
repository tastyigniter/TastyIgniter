<?php

declare(strict_types=1);

namespace Igniter\User\MainMenuWidgets;

use Igniter\Admin\Classes\BaseMainMenuWidget;
use Igniter\Admin\Traits\ValidatesForm;
use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Html\HtmlFacade;
use Igniter\User\Classes\UserState;
use Igniter\User\Models\User;
use Igniter\User\Subscribers\NavigationExtendUserMenuLinksEvent;
use Override;

class UserPanel extends BaseMainMenuWidget
{
    use ValidatesForm;

    public array $links = [];

    protected User $user;

    protected UserState $userState;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'links',
        ]);

        $this->user = $this->getController()->getUser();
        $this->userState = UserState::forUser($this->user);
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('userpanel/userpanel');
    }

    public function prepareVars(): void
    {
        $this->vars['avatarUrl'] = $this->user->avatar_url;
        $this->vars['userName'] = $this->user->name;
        $this->vars['roleName'] = $this->user->role?->name;
        $this->vars['userIsOnline'] = $this->userState->isOnline();
        $this->vars['userIsIdle'] = $this->userState->isIdle();
        $this->vars['userIsAway'] = $this->userState->isAway();
        $this->vars['userStatusName'] = $this->userState->getStatusName();
        $this->vars['links'] = $this->listMenuLinks();
    }

    public function onLoadStatusForm(): string
    {
        $this->prepareVars();

        $this->vars['statuses'] = UserState::getStatusDropdownOptions();
        $this->vars['clearAfterOptions'] = UserState::getClearAfterMinutesDropdownOptions();
        $this->vars['message'] = $this->userState->getMessage();
        $this->vars['userStatus'] = $this->userState->getStatus();
        $this->vars['clearAfterMinutes'] = $this->userState->getClearAfterMinutes();
        $this->vars['statusUpdatedAt'] = $this->userState->getUpdatedAt();

        return $this->makePartial('userpanel/statusform');
    }

    public function onSetStatus(): array
    {
        $validated = $this->validate(request()->post(), [
            'status' => 'required|integer',
            'message' => 'nullable|string|max:128',
            'clear_after' => 'required_if:status,'.UserState::CUSTOM_STATUS.'|integer',
        ]);

        throw_if($validated['status'] < 1 && !strlen((string)$validated['message']),
            new FlashException(lang('igniter::admin.side_menu.alert_invalid_status')),
        );

        $this->userState->updateState((int)$validated['status'], $validated['message'] ?? '', (int)$validated['clear_after']);

        return [
            '~#'.$this->getId() => $this->render(),
        ];
    }

    protected function listMenuLinks()
    {
        $items = collect($this->links);

        NavigationExtendUserMenuLinksEvent::dispatch($items);

        return $items
            ->mapWithKeys(function($item, $code): array {
                $item = array_merge([
                    'priority' => 999,
                    'label' => null,
                    'cssClass' => null,
                    'iconCssClass' => null,
                    'attributes' => [],
                    'permission' => null,
                ], $item);

                if (array_key_exists('url', $item)) {
                    $item['attributes']['href'] = $item['url'];
                }

                $item['attributes'] = HtmlFacade::attributes($item['attributes']);

                return [
                    $code => (object)$item,
                ];
            })
            ->filter(fn(object $item): bool => !$item->permission || $this->user->hasPermission($item->permission))
            ->sortBy('priority');
    }
}
