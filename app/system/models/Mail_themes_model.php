<?php namespace System\Models;

use Cache;
use Exception;
use File;
use Model;

/**
 * MailThemes Model Class
 * @package System
 * @method static instance()
 * @method static get($var, $default)
 */
class Mail_themes_model extends Model
{
    const WHITE_COLOR = '#fff';
    const BODY_BG = '#f5f8fa';
    const PRIMARY_BG = '#3498db';
    const POSITIVE_BG = '#31ac5f';
    const NEGATIVE_BG = '#ab2a1c';
    const HEADER_COLOR = '#bbbfc3';
    const HEADING_COLOR = '#2f3133';
    const TEXT_COLOR = '#74787e';
    const LINK_COLOR = '#0181b9';
    const FOOTER_COLOR = '#aeaeae';
    const BORDER_COLOR = '#edeff2';
    const PROMOTION_BORDER_COLOR = '#9ba2ab';

    public $implement = ['System\Actions\SettingsModel'];

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
     * @return void
     */
    public function initSettingsData()
    {
        foreach (static::getCssVars() as $var => $default) {
            $this->{$var} = config('theme.mail.'.studly_case($var), $default);
        }
    }

    protected function afterSave()
    {
        $this->resetCache();
    }

    //
    // Helpers
    //

    public function resetCache()
    {
        Cache::forget(self::instance()->cacheKey);
    }

    public static function renderCss()
    {
        self::instance()->resetCache();
        $cacheKey = self::instance()->cacheKey;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $customCss = self::compileCss();
            Cache::forever($cacheKey, $customCss);
        }
        catch (Exception $ex) {
            $customCss = '/* '.$ex->getMessage().' */';
        }

        return $customCss;
    }

    protected static function getCssVars()
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

    protected static function makeCssVars()
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
        $basePath = app_path('system/views/_mail/themes');

        return File::get($basePath.'/default.css');
    }
}