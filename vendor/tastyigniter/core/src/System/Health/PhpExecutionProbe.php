<?php

declare(strict_types=1);

namespace Igniter\System\Health;

use Igniter\Flame\Support\Facades\File;
use Igniter\System\Health\Concerns\InteractsWithHttpProbes;
use Throwable;

class PhpExecutionProbe
{
    use InteractsWithHttpProbes;

    public const string PROBE_FILENAME = '.ti-health-probe.php';

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    public function run(string $relativePublicPath, string $urlPath): array
    {
        $baseUrl = $this->baseUrl();

        if ($baseUrl === null) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_url_missing'));
        }

        $relativePath = trim($relativePublicPath, '/');
        $probePath = $relativePath === ''
            ? storage_path('app/public/'.self::PROBE_FILENAME)
            : storage_path('app/public/'.$relativePath.'/'.self::PROBE_FILENAME);
        $url = $baseUrl.'/'.trim($urlPath, '/').'/'.self::PROBE_FILENAME;

        if (!$this->ensureDirectory(dirname($probePath))) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_not_writable'));
        }

        $token = 'ti-health-probe-'.bin2hex(random_bytes(8));

        try {
            if (!File::put($probePath, "<?php echo '".$token."';")) {
                return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_not_writable'));
            }

            $response = $this->httpClient()->get($url);

            if ($this->probeWasExecuted($response->body(), $token)) {
                return $this->vulnerable(lang('igniter::system.system.checks.web_server_security_php_vulnerable', [
                    'path' => trim($urlPath, '/'),
                ]));
            }

            return $this->secured(lang('igniter::system.system.checks.web_server_security_probe_secured', [
                'code' => $response->status(),
            ]));
        } catch (Throwable) {
            return $this->unverified(lang('igniter::system.system.checks.web_server_security_probe_request_failed'));
        } finally {
            File::delete($probePath);
        }
    }

    protected function ensureDirectory(string $directory): bool
    {
        if (File::isDirectory($directory)) {
            return is_writable($directory);
        }

        return File::makeDirectory($directory, 0755, true, true)
            && is_writable($directory);
    }

    protected function probeWasExecuted(string $body, string $token): bool
    {
        if (str_contains($body, '<?php') || str_contains($body, '<?=')) {
            return false;
        }

        return trim($body) === $token;
    }
}
