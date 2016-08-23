<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Assets helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\assets_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('get_doctype')) {
	/**
	 * Get Doctype
	 *
	 * @return    string
	 */
	function get_doctype() {
		return get_instance()->assets->getDocType();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_doctype')) {
	/**
	 * Set Doctype
	 *
	 * @param string $doctype
	 */
	function set_doctype($doctype = '') {
		get_instance()->assets->setHeadTag('doctype', $doctype);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_metas')) {
	/**
	 * Get metas html tags
	 *
	 * @return    string
	 */
	function get_metas() {
		return get_instance()->assets->getMetas();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_meta')) {
	/**
	 * Set metas html tags
	 */
	function set_meta($meta = array()) {
		get_instance()->assets->setHeadTag('meta', $meta);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_favicon')) {
	/**
	 * Get favicon html tag
	 *
	 * @return    string
	 */
	function get_favicon() {
		return get_instance()->assets->getFavIcon();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_favicon')) {
	/**
	 * Set favicon html tag
	 *
	 * @param string $href
	 */
	function set_favicon($href = '') {
		get_instance()->assets->setHeadTag('favicon', $href);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_style_tags')) {
	/**
	 * Get multiple stylesheet html tags
	 *
	 * @return    string
	 */
	function get_style_tags() {
		return get_instance()->assets->getStyleTags();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_style_tag')) {
	/**
	 * Set single stylesheet html tag
	 *
	 * @param string $href
	 * @param string $name
	 * @param null   $priority
	 *
	 * @return string
	 */
	function set_style_tag($href = '', $name = '', $priority = NULL) {
		get_instance()->assets->setStyleTag($href, $name, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_style_tags')) {
	/**
	 * Set multiple stylesheet html tags
	 *
	 * @param array $tags
	 *
	 * @return string
	 */
	function set_style_tags($tags = array()) {
		get_instance()->assets->setStyleTag($tags);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_script_tags')) {
	/**
	 * Get multiple scripts html tags
	 *
	 * @return    string
	 */
	function get_script_tags() {
		return get_instance()->assets->getScriptTags();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_script_tag')) {
	/**
	 * Set single scripts html tags
	 *
	 * @param string $href
	 * @param string $name
	 * @param null   $priority
	 *
	 * @return string
	 */
	function set_script_tag($href = '', $name = '', $priority = NULL) {
		get_instance()->assets->setScriptTag($href, $name, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_script_tags')) {
	/**
	 * Set multiple scripts html tags
	 *
	 * @param array $tags
	 *
	 * @return string
	 */
	function set_script_tags($tags = array()) {
		get_instance()->assets->setScriptTag($tags);
	}
}

// ------------------------------------------------------------------------

/* End of file assets_helper.php */
/* Location: ./system/tastyigniter/helpers/assets_helper.php */