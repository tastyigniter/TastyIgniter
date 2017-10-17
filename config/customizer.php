<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['styles'] = array(
    'nav'               => array('<ul class="nav nav-tabs nav-stacked" role="tablist">', '</ul>'),
    'nav_item'          => array('<li>', '</li>'),
    'nav_active_item'   => array('<li class="active">', '</li>'),
    'nav_icon'          => array('<i class="{class}">', '</i>'),
    'nav_link'          => array('<a href="#section-{id}" data-toggle="tab">', '</a>'),
    'section'           => array('<div id="section-{id}" class="tab-pane {active}">', '</div>'),
    'section_heading'   => array('<h4 class="section-heading">', '</h4>'),
    'section_desc'      => array('<p>', '</p>'),
    'fieldset'          => array('<fieldset class="fieldset-bordered">', '</fieldset>'),
    'fieldset_legend'   => array('<legend><span>', '</span></legend>'),
    'field'             => array('<div class="form-group">', '</div>'),
    'control'           => array('<div class="col-sm-8">', '</div>'),
    'label'             => array('<label class="col-sm-3 control-label" for="{id}">', '</label>'),
    'label_desc'        => array('<span class="help-block">', '</span>'),
    'error'             => array('<span class="text-danger">', '</span>'),
    'input_group'       => array('<div class="control-group control-group-{group_count}">', '</div>'),
    'input_addon'       => array('<div class="input-group">', '</div>'),
    'input_l_addon'     => array('<span class="input-group-addon lg-addon">', '</span>'),
    'input_r_addon'     => array('<span class="input-group-addon">', '</span>'),
    'color_addon'       => array('<div class="input-group ti-color-picker">', '</div>'),
    'color_l_addon'     => array('<span class="input-group-addon">', '</span>'),
    'media_addon'       => array('<div class="input-group image-preview">', '</div>'),
    'media_l_addon'     => array('<span class="input-group-addon lg-addon">', '</span>'),
    'media_r_addon'     => array('<span class="input-group-btn">', '</span>'),
    'button_switch'     => array('<div class="btn-group btn-group-switch" data-toggle="buttons">', '</div>'),
    'button_group'      => array('<div class="btn-group btn-group-toggle btn-group-{group_count}" data-toggle="buttons">', '</div>'),
    'button_label'      => array('<label class="btn {data_btn} {active}">', '</label>'),
    'table_responsive'  => array('<div class="table-responsive">', '</div>'),
    'table'             => array('<table class="table">', '</table>'),
    'table_border'      => array('<table class="table table-border">', '</table>'),
    'table_striped'     => array('<table class="table table-striped">', '</table>'),
    'table_sortable'    => array('<table class="table table-border table-sortable">', '</table>'),
);

$config['form_classes'] = array(
    'text'          => 'form-control',
    'color'         => 'form-control',
    'media'         => 'form-control',
    'textarea'      => 'form-control',
    'dropdown'      => 'form-control',
);