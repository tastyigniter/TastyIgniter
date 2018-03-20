<?php
/**
 * Assets helper functions
 */

if (!function_exists('get_metas')) {
    /**
     * Get metas html tags
     * @return    string
     */
    function get_metas()
    {
        return Assets::getMetas();
    }
}

if (!function_exists('set_meta')) {
    /**
     * Set metas html tags
     *
     * @param array $meta
     */
    function set_meta($meta = [])
    {
        Assets::collection()->addMeta($meta);
    }
}

if (!function_exists('get_favicon')) {
    /**
     * Get favicon html tag
     * @return    string
     */
    function get_favicon()
    {
        return Assets::getFavIcon();
    }
}

if (!function_exists('set_favicon')) {
    /**
     * Set favicon html tag
     *
     * @param string $href
     */
    function set_favicon($href = '')
    {
        Assets::addFavIcon($href);
    }
}

if (!function_exists('get_style_tags')) {
    /**
     * Get multiple stylesheet html tags
     *
     * @param mixed $collection
     *
     * @return string
     */
    function get_style_tags($collection = null)
    {
        if (is_null($collection))
            $collection = \System\Libraries\Assets::DEFAULT_COLLECTION;

        if (!is_array($collection))
            $collection = [$collection];

        $css = '';
        foreach ($collection as $item) {
            $css .= Assets::collection($item)->getCss().PHP_EOL;
        }

        return $css;
    }
}

if (!function_exists('set_style_tag')) {
    /**
     * Set single stylesheet html tag
     *
     * @param string $href
     * @param string $name
     */
    function set_style_tag($href = '', $name = '')
    {
        Assets::collection()->addCss($href, $name);
    }
}

if (!function_exists('set_style_tags')) {
    /**
     * Set multiple stylesheet html tags
     *
     * @param array $tags
     */
    function set_style_tags(array $tags = [])
    {
        Assets::collection()->addCss($tags);
    }
}

if (!function_exists('get_script_tags')) {
    /**
     * Get multiple scripts html tags
     *
     * @param mixed $collection
     *
     * @return string
     */
    function get_script_tags($collection = null)
    {
        if (is_null($collection))
            $collection = \System\Libraries\Assets::DEFAULT_COLLECTION;

        if (!is_array($collection))
            $collection = [$collection];

        $js = '';
        foreach ($collection as $item) {
            $js .= Assets::collection($item)->getJs().PHP_EOL;
        }

        return $js;
    }
}

if (!function_exists('set_script_tag')) {
    /**
     * Set single scripts html tags
     *
     * @param string $href
     * @param string $name
     */
    function set_script_tag($href = '', $name = '')
    {
        Assets::collection()->addJs($href, $name);
    }
}

if (!function_exists('set_script_tags')) {
    /**
     * Set multiple scripts html tags
     *
     * @param array $tags
     */
    function set_script_tags(array $tags = [])
    {
        Assets::collection()->addJs($tags);
    }
}
