<?php

declare(strict_types=1);

namespace Igniter\System\Health;

use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Throwable;

class MediaPhpExecutionProbe
{
    public const string PROBE_FILENAME = '.ti-health-probe.php';

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    public function run(): array
    {
        $probePath = storage_path('app/public/media/'.self::PROBE_FILENAME);
        $url = $this->probeUrl();

        if ($url === null) {
            return [
                'status' => 'unverified',
                'summary' => lang('igniter::system.system.checks.web_server_security_probe_url_missing'),
            ];
        }

        if (!$this->ensureMediaDirectory(dirname($probePath))) {
            return [
                'status' => 'unverified',
                'summary' => lang('igniter::system.system.checks.web_server_security_probe_not_writable'),
            ];
        }

        $token = 'ti-health-probe-'.bin2hex(random_bytes(8));

        try {
            if (!File::put($probePath, "<?php echo '".$token."';")) {
                return [
                    'status' => 'unverified',
                    'summary' => lang('igniter::system.system.checks.web_server_security_probe_not_writable'),
                ];
            }

            $response = $this->httpClient()->get($url);

            if (str_contains((string) $response->body(), $token)) {
                return [
                    'status' => 'vulnerable',
                    'summary' => lang('igniter::system.system.checks.web_server_security_probe_vulnerable'),
                ];
            }

            return [
                'status' => 'secured',
                'summary' => lang('igniter::system.system.checks.web_server_security_probe_secured', [
                    'code' => $response->status(),
                ]),
            ];
        } catch (Throwable) {
            return [
                'status' => 'unverified',
                'summary' => lang('igniter::system.system.checks.web_server_security_probe_request_failed'),
            ];
        } finally {
            File::delete($probePath);
        }
    }

    protected function probeUrl(): ?string
    {
        $baseUrl = (string) config('app.url');

        if (blank($baseUrl)) {
            return null;
        }

        return rtrim($baseUrl, '/').'/storage/media/'.self::PROBE_FILENAME;
    }

    protected function ensureMediaDirectory(string $directory): bool
    {
        if (File::isDirectory($directory)) {
            return is_writable($directory);
        }

        return File::makeDirectory($directory, 0755, true, true)
            && is_writable($directory);
    }

    protected function httpClient()
    {
        $client = Http::timeout(10);

        if (app()->environment('local', 'testing')) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }
}
