<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Exception;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\File;
use Igniter\System\Actions\SettingsModel;
use Illuminate\Support\Facades\Cache;
use Override;

/**
 * MailTheme Model Class
 *
 * @property int $id
 * @property string $item
 * @property array<array-key, mixed>|null $data
 * @method static Builder<static>|MailTheme applyFilters(array $options = [])
 * @method static Builder<static>|MailTheme applySorts(array $sorts = [])
 * @method static Builder<static>|MailTheme listFrontEnd(array $options = [])
 * @method static Builder<static>|MailTheme newModelQuery()
 * @method static Builder<static>|MailTheme newQuery()
 * @method static Builder<static>|MailTheme query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class MailTheme extends Model
{
    public const WHITE_COLOR = '#fff';

    public const BODY_BG = '#f5f8fa';

    public const PRIMARY_BG = '#3498db';

    public const POSITIVE_BG = '#31ac5f';

    public const NEGATIVE_BG = '#ab2a1c';

    public const HEADER_COLOR = '#bbbfc3';

    public const HEADING_COLOR = '#2f3133';

    public const TEXT_COLOR = '#74787e';

    public const LINK_COLOR = '#0181b9';

    public const FOOTER_COLOR = '#aeaeae';

    public const BORDER_COLOR = '#edeff2';

    public const PROMOTION_BORDER_COLOR = '#9ba2ab';

    public array $implement = [SettingsModel::class];

    /**
     * @var string Unique code
     */
    public $settingsCode = 'system_mail_theme_settings';

    /**
     * @var mixed Settings form field definitions
     */
    public $settingsFieldsConfig = 'mail_themes';

    /**
     * @var string The key to store rendered CSS in the cache under
     */
    public $cacheKey = 'system::mailtheme.custom_css';

    /**
     * Initialize the seed data for this model. This only executes when the
     * model is first created or reset to default.
     */
    public function initSettingsData(): void
    {
        foreach (static::getCssVars() as $var => $default) {
            $this->{$var} = config('theme.mail.'.studly_case($var), $default);
        }
    }

    #[Override]
    protected function afterSave()
    {
        $this->resetCache();
    }

    //
    // Helpers
    //

    public function resetCache(): void
    {
        Cache::forget(self::instance()->cacheKey);
    }

    public static function renderCss()
    {
        $cacheKey = self::instance()->cacheKey;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $customCss = self::compileCss();
            Cache::forever($cacheKey, $customCss);
        } catch (Exception $exception) {
            $customCss = '/* '.$exception->getMessage().' */';
        }

        return $customCss;
    }

    protected static function getCssVars(): array
    {
        return [
            'body_bg' => static::BODY_BG,
            'content_bg' => static::WHITE_COLOR,
            'content_inner_bg' => static::WHITE_COLOR,
            'button_text_color' => static::WHITE_COLOR,
            'button_primary_bg' => static::PRIMARY_BG,
            'button_positive_bg' => static::POSITIVE_BG,
            'button_negative_bg' => static::NEGATIVE_BG,
            'header_color' => static::HEADER_COLOR,
            'heading_color' => static::HEADING_COLOR,
            'text_color' => static::TEXT_COLOR,
            'link_color' => static::LINK_COLOR,
            'footer_color' => static::FOOTER_COLOR,
            'body_border_color' => static::BORDER_COLOR,
            'subcopy_border_color' => static::BORDER_COLOR,
            'table_border_color' => static::BORDER_COLOR,
            'panel_bg' => static::BORDER_COLOR,
            'promotion_bg' => static::WHITE_COLOR,
            'promotion_border_color' => static::PROMOTION_BORDER_COLOR,
        ];
    }

    protected static function makeCssVars(): array
    {
        $result = [];
        foreach (static::getCssVars() as $var => $default) {
            // panel_bg -> panel-bg
            $cssVar = str_replace('_', '-', $var);
            $result[$cssVar] = self::get($var, $default);
        }

        return $result;
    }

    public static function compileCss()
    {
        return File::get(File::symbolizePath('igniter::views/system/_mail/themes/default.css'));
    }
}
