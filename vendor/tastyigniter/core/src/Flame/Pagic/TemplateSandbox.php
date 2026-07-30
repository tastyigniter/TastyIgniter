<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use Igniter\Flame\Exception\SystemException;

class TemplateSandbox
{
    protected const array ALLOWED_DIRECTIVES = [
        'if', 'elseif', 'else', 'endif',
        'foreach', 'endforeach',
        'forelse', 'endforelse',
        'isset', 'endisset',
        'empty', 'endempty',
        'unless', 'endunless',
        'switch', 'case', 'default', 'endswitch',
        'break', 'continue',
        'partial', 'endpartial',
        'lang', 'choice',
    ];

    protected const array ALLOWED_FUNCTIONS = [
        'setting', 'lang', 'trans', 'media_thumb', 'date', 'e',
        'config', 'route', 'url', 'page_url', 'asset', 'empty', 'isset',
        'count', 'trim', 'strip_tags', 'nl2br', 'number_format',
    ];

    protected const array DANGEROUS_FUNCTIONS = [
        'eval', 'system', 'exec', 'shell_exec', 'passthru', 'popen', 'proc_open',
        'file_put_contents', 'file_get_contents', 'readfile', 'file', 'scandir', 'glob',
        'fopen', 'fgets', 'fread', 'fwrite', 'fclose', 'fpassthru',
        'base64_decode', 'str_rot13', 'gzinflate', 'gzuncompress', 'gzdecode',
        'create_function', 'assert', 'phpinfo', 'getallheaders', 'header', 'setcookie',
        'move_uploaded_file', 'unlink', 'rmdir', 'mkdir', 'chmod', 'chown',
        'call_user_func', 'call_user_func_array', 'forward_static_call', 'forward_static_call_array',
        'array_map', 'array_filter', 'array_walk', 'array_walk_recursive',
        'usort', 'uasort', 'uksort',
        'preg_replace_callback', 'preg_replace_callback_array',
        'unserialize', 'include', 'require', 'include_once', 'require_once',
        'getenv', 'putenv', 'env', 'ini_set', 'curl_exec', 'curl_init', 'curl_setopt',
        'fsockopen', 'define', 'extract', 'parse_str', 'chr', 'preg_replace',
    ];

    protected const array ALLOWED_METHODS = [
        'getthumb', 'getthumborblank', 'getpath', 'geturl',
    ];

    /** @var array<int, string> */
    protected array $registeredFunctions = [];

    /** @var array<int, string> */
    protected array $registeredMethods = [];

    /**
     * @param array<int, string> $functions
     */
    public function registerAllowedFunctions(array $functions): void
    {
        $this->registeredFunctions = array_merge(
            $this->registeredFunctions,
            array_map(strtolower(...), $functions),
        );
    }

    /**
     * @param array<int, string> $methods
     */
    public function registerAllowedMethods(array $methods): void
    {
        $this->registeredMethods = array_merge(
            $this->registeredMethods,
            array_map(strtolower(...), $methods),
        );
    }

    public function assertSafe(string $template, SandboxProfile $profile = SandboxProfile::Mail): void
    {
        $violation = $this->findFirstViolation($template, $profile);

        if ($violation !== null) {
            throw new SystemException('Template contains unsafe content: '.$violation);
        }
    }

    public function sanitize(string $template, SandboxProfile $profile = SandboxProfile::Theme): string
    {
        if ($profile === SandboxProfile::Mail) {
            return $this->sanitizeMail($template);
        }

        return $this->sanitizeTheme($template);
    }

    protected function sanitizeTheme(string $template): string
    {
        $template = $this->removeNullBytes($template);
        $template = $this->removePhpTags($template);
        $template = $this->removeDangerousBladeDirectives($template);
        $template = $this->removeDangerousFunctionCalls($template);
        $template = $this->removeUnescapedOutput($template);
        $template = $this->removeObfuscation($template);
        $template = $this->removeVariableVariables($template);

        return $this->removePathTraversal($template);
    }

    protected function sanitizeMail(string $template): string
    {
        $template = $this->removeNullBytes($template);
        $template = $this->removePhpTags($template);
        $template = $this->stripHtmlComments($template);
        $template = $this->removeDangerousBladeDirectives($template);
        $template = $this->neutralizeUnsafeDirectives($template);
        $template = $this->neutralizeUnsafeExpressions($template);
        $template = $this->sanitizeUnescapedOutputForMail($template);
        $template = $this->removeObfuscation($template);
        $template = $this->removeVariableVariables($template);
        $template = $this->removePathTraversal($template);

        return $this->removeDangerousFunctionCalls($template);
    }

    protected function findFirstViolation(string $template, SandboxProfile $profile): ?string
    {
        $template = $this->removeNullBytes($template);
        $template = $this->stripHtmlComments($template);

        if ($this->containsPhpTags($template)) {
            return 'PHP tags are not allowed';
        }

        if (preg_match('/@php\b/i', $template)) {
            return '@php blocks are not allowed';
        }

        if ($violation = $this->findUnsafeDirectiveViolation($template)) {
            return $violation;
        }

        if ($violation = $this->findExpressionViolations($template, $profile)) {
            return $violation;
        }

        if ($violation = $this->findUnescapedOutputViolation($template, $profile)) {
            return $violation;
        }

        return $this->findGlobalViolation($template);
    }

    protected function findGlobalViolation(string $template): ?string
    {
        $lower = strtolower($template);

        foreach (['$_env', '$_server', '$_get', '$_post', '$_cookie', '$_files', '$_request', '$globals'] as $pattern) {
            if (str_contains($lower, $pattern)) {
                return 'Superglobal access is not allowed';
            }
        }

        if (preg_match('/\$\$[a-zA-Z_]/', $template)) {
            return 'Variable variables are not allowed';
        }

        if (preg_match('/\$\{[^}]*\}/', $template)) {
            return 'Variable variables are not allowed';
        }

        if (preg_match('/\.\.\//', $template) || preg_match('/\.\.\\\\/', $template)) {
            return 'Path traversal is not allowed';
        }

        foreach (self::DANGEROUS_FUNCTIONS as $function) {
            if (preg_match('/\b'.preg_quote($function, '/').'\s*\(/i', $template)) {
                return 'Forbidden function: '.$function;
            }
        }

        return null;
    }

    protected function findUnsafeDirectiveViolation(string $template): ?string
    {
        if (!preg_match_all('/@([a-zA-Z]+)\b/', $template, $matches)) {
            return null;
        }

        foreach ($matches[1] as $directive) {
            $directive = strtolower($directive);
            if (!in_array($directive, self::ALLOWED_DIRECTIVES, true)) {
                return 'Disallowed Blade directive: @'.$directive;
            }
        }

        if (preg_match_all('/@([a-zA-Z]+)\s*\(([^)]*)\)/s', $template, $directiveMatches, PREG_SET_ORDER)) {
            foreach ($directiveMatches as $match) {
                $directive = strtolower($match[1]);
                if (!in_array($directive, self::ALLOWED_DIRECTIVES, true)) {
                    continue;
                }

                if ($violation = $this->validateExpression(trim($match[2]), false)) {
                    return 'Unsafe directive argument in @'.$directive.': '.$violation;
                }
            }
        }

        return null;
    }

    protected function findExpressionViolations(string $template, SandboxProfile $profile): ?string
    {
        if (!preg_match_all('/\{\{\s*(.*?)\s*\}\}/s', $template, $matches)) {
            return null;
        }

        foreach ($matches[1] as $expression) {
            if ($violation = $this->validateExpression($expression, false)) {
                return $violation;
            }
        }

        return null;
    }

    protected function findUnescapedOutputViolation(string $template, SandboxProfile $profile): ?string
    {
        if (!preg_match_all('/\{!!\s*(.*?)\s*!!\}/s', $template, $matches)) {
            return null;
        }

        foreach ($matches[1] as $expression) {
            if ($profile === SandboxProfile::Theme) {
                return 'Unescaped output is not allowed';
            }

            if ($violation = $this->validateUnescapedExpression($expression)) {
                return $violation;
            }
        }

        return null;
    }

    protected function validateUnescapedExpression(string $expression): ?string
    {
        $expression = trim($expression);

        if (preg_match('/^\$[a-zA-Z_]\w*(\s*\[(?:\'[^\']*\'|"[^"]*")\])?$/', $expression)) {
            return null;
        }

        if ($this->validateExpression($expression, true) === null) {
            return null;
        }

        return 'Unescaped output may only reference simple variables or safe expressions';
    }

    protected function validateExpression(string $expression, bool $unescaped): ?string
    {
        $expression = trim($expression);

        if ($expression === '') {
            return null;
        }

        $scan = $this->stripStringLiterals($expression);

        if (str_contains($scan, '\\')) {
            return 'Namespace separators are not allowed';
        }

        if (str_contains($scan, '::')) {
            return 'Static calls are not allowed';
        }

        if (str_contains($scan, '->') && $violation = $this->validateObjectMethodCalls($scan)) {
            return $violation;
        }

        if (preg_match('/\bnew\s+/i', $scan)) {
            return 'Object instantiation is not allowed';
        }

        if (str_contains($scan, '`')) {
            return 'Shell execution is not allowed';
        }

        if (preg_match('/\$[a-zA-Z_]\w*\s*\(/', $scan)) {
            return 'Variable functions are not allowed';
        }

        if (preg_match('/(?<![=!<>])=(?!=|>)/', $scan)) {
            return 'Assignment expressions are not allowed';
        }

        if (preg_match('/\b(app|resolve)\s*\(/i', $scan)) {
            return 'Container resolution is not allowed';
        }

        if (preg_match('/\bContainer\s*::/i', $scan) || stripos($scan, 'Illuminate\\') !== false) {
            return 'Framework internals are not allowed';
        }

        if (preg_match('/\'\s*\.\s*\'/', $scan)) {
            return 'String concatenation is not allowed';
        }

        if (preg_match('/\)\s*\(/', $scan)) {
            return 'Dynamic invocation is not allowed';
        }

        if (preg_match('/\\\\x[0-9a-fA-F]{2}/i', $scan) || preg_match('/\\\\u[0-9a-fA-F]{4}/i', $scan)) {
            return 'Encoded characters are not allowed';
        }

        if (preg_match('/\bReflection[A-Za-z]*\b/i', $scan)) {
            return 'Reflection is not allowed';
        }

        if (!preg_match_all('/\b([a-zA-Z_]\w*)\s*\(/', $scan, $functionMatches, PREG_OFFSET_CAPTURE)) {
            return null;
        }

        foreach ($functionMatches[1] as $index => $functionMatch) {
            $function = $functionMatch[0];
            $offset = $functionMatches[0][$index][1];
            $before = substr($scan, 0, $offset);

            if (preg_match('/->\s*$/', rtrim($before))) {
                continue;
            }

            $functionLower = strtolower($function);

            if (in_array($functionLower, self::DANGEROUS_FUNCTIONS, true)) {
                return 'Forbidden function: '.$function;
            }

            if (!in_array($functionLower, $this->getAllowedFunctions(), true)) {
                return 'Disallowed function: '.$function;
            }
        }

        return null;
    }

    protected function validateObjectMethodCalls(string $scan): ?string
    {
        if (!preg_match_all(
            '/(\$[a-zA-Z_]\w*(?:\s*\[(?:\'[^\']*\'|"[^"]*")\])?)\s*->\s*([a-zA-Z_]\w*)\s*\(/',
            $scan,
            $matches,
            PREG_SET_ORDER,
        )) {
            return 'Object method calls are not allowed';
        }

        $remaining = $scan;

        foreach ($matches as $match) {
            $methodLower = strtolower($match[2]);

            if (!in_array($methodLower, $this->getAllowedMethods(), true)) {
                return 'Disallowed object method: '.$match[2];
            }

            $remaining = str_replace($match[0], '$__safe__', $remaining);
        }

        if (str_contains($remaining, '->')) {
            return 'Object method calls are not allowed';
        }

        return null;
    }

    /**
     * @return array<int, string>
     */
    protected function getAllowedFunctions(): array
    {
        return array_values(array_unique(array_merge(self::ALLOWED_FUNCTIONS, $this->registeredFunctions)));
    }

    /**
     * @return array<int, string>
     */
    protected function getAllowedMethods(): array
    {
        return array_values(array_unique(array_merge(self::ALLOWED_METHODS, $this->registeredMethods)));
    }

    protected function stripStringLiterals(string $expression): string
    {
        $expression = preg_replace("/'(?:\\\\'|[^'])*'/", "''", $expression) ?? $expression;

        return preg_replace('/"(?:\\\\"|[^"])*"/', '""', $expression) ?? $expression;
    }

    protected function neutralizeUnsafeDirectives(string $content): string
    {
        $content = preg_replace('/@php\b.*?@endphp/si', '', $content) ?? $content;

        if (!preg_match_all('/@([a-zA-Z]+)\b/', $content, $matches)) {
            return $content;
        }

        $directives = array_unique(array_map('strtolower', $matches[1]));

        foreach ($directives as $directive) {
            if (!in_array($directive, self::ALLOWED_DIRECTIVES, true)) {
                $content = preg_replace('/@'.preg_quote($directive, '/').'\b[^@]*/i', '', $content) ?? $content;
            }
        }

        $patterns = [
            '/@inject\s*\([^)]*\)/i',
            '/@include[a-zA-Z]*\s*\([^)]*\)/i',
            '/@require[a-zA-Z]*\s*\([^)]*\)/i',
            '/@extends\s*\([^)]*\)/i',
            '/@component[a-zA-Z]*\s*\([^)]*\)/i',
            '/@livewire[a-zA-Z]*\s*\([^)]*\)/i',
        ];

        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content) ?? $content;
        }

        return $content;
    }

    protected function neutralizeUnsafeExpressions(string $content): string
    {
        return preg_replace_callback('/\{\{\s*(.*?)\s*\}\}/s', fn(array $matches): string => $this->validateExpression($matches[1], false) === null ? $matches[0] : '', $content) ?? $content;
    }

    protected function sanitizeUnescapedOutputForMail(string $content): string
    {
        return preg_replace_callback('/\{!!\s*(.*?)\s*!!\}/s', fn(array $matches): string => $this->validateUnescapedExpression($matches[1]) === null ? $matches[0] : '', $content) ?? $content;
    }

    protected function containsPhpTags(string $content): bool
    {
        return (bool)preg_match('/<\?(?:php|=)/i', $content)
            || (bool)preg_match('/<\?(?!xml)/i', $content);
    }

    protected function stripHtmlComments(string $content): string
    {
        return preg_replace('/<!--.*?-->/s', '', $content) ?? $content;
    }

    protected function removeNullBytes(string $content): string
    {
        return str_replace("\0", '', $content);
    }

    protected function removePhpTags(string $content): string
    {
        // With closing tag
        $content = preg_replace('/<\?(?:php|=).*?\?>/si', '', $content) ?? $content;

        // Without closing tag - rest of content after opening tag
        $content = preg_replace('/<\?(?:php|=)[\s\S]*$/i', '', $content) ?? $content;

        // Short open tags (but preserve <?xml)
        $content = preg_replace('/<\?(?!xml)[\s\S]*$/i', '', $content) ?? $content;

        // Catch any remnants
        return str_replace(['<?', '?>'], '', $content);
    }

    protected function removeDangerousBladeDirectives(string $content): string
    {
        $patterns = [
            // @php ... @endphp blocks
            '/@php\b.*?@endphp/si',
            // @inject directive
            '/@inject\s*\([^)]*\)/i',
            // Dangerous includes that load arbitrary files
            '/@include[a-zA-Z]*\s*\([^)]*\)/i',
            '/@require[a-zA-Z]*\s*\([^)]*\)/i',
            // Layout directives that could load arbitrary files
            '/@extends\s*\([^)]*\)/i',
            // Component loading
            '/@component[a-zA-Z]*\s*\([^)]*\)/i',
            '/@livewire[a-zA-Z]*\s*\([^)]*\)/i',
        ];

        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content) ?? $content;
        }

        return $content;
    }

    protected function removeDangerousFunctionCalls(string $content): string
    {
        $patterns = [
            '/\bpreg_replace\s*\(\s*[\'"].*?e[\'"]/i',
        ];

        foreach (self::DANGEROUS_FUNCTIONS as $function) {
            $patterns[] = '/\b'.preg_quote($function, '/').'\s*\([^)]*\)/i';
        }

        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content) ?? $content;
        }

        return $content;
    }

    protected function removeUnescapedOutput(string $content): string
    {
        // {!! unescaped !!} - force all output through Blade's escaping
        return preg_replace('/\{!!\s*.+?\s*!!\}/s', '', $content) ?? $content;
    }

    protected function removeObfuscation(string $content): string
    {
        $patterns = [
            '/\\\\x[0-9a-fA-F]{2}/i',  // \x47 hex encoding
            '/\\\\u[0-9a-fA-F]{4}/i',  // \u0047 unicode
            '/chr\s*\(\s*\d+\s*\)/i',  // chr(72) char concatenation
            '/GLOBALS\s*\[[^\]]*\]/i',  // $GLOBALS['var']
        ];

        foreach ($patterns as $pattern) {
            $content = preg_replace($pattern, '', $content) ?? $content;
        }

        return $content;
    }

    protected function removeVariableVariables(string $content): string
    {
        // $$var and ${...} variable variables
        $content = preg_replace('/\$\$[a-zA-Z_\x7f-\xff]/i', '', $content) ?? $content;

        return preg_replace('/\$\{[^}]*\}/i', '', $content) ?? $content;
    }

    protected function removePathTraversal(string $content): string
    {
        $content = preg_replace('/\.\.\//i', '', $content) ?? $content;

        return preg_replace('/\.\.\\\\/i', '', $content) ?? $content;
    }
}
