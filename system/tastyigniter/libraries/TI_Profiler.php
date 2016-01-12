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

/**
 * TastyIgniter Profiler Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Profiler.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Profiler extends CI_Profiler {

    /**
     * Run the Profiler
     *
     * @return	string
     */
    public function run()
    {
        $output = '<div id="codeigniter_profiler" style="clear:both;background-color:#fff;">';
        $output .= '<a class="btn btn-success btn-profiler"><i class="fa fa-bug"></i></a>';
        $output .= '<style>#codeigniter_profiler .sections{background-color:#f9fafc!important;padding:10px 20px!important}#codeigniter_profiler #ci_profiler_benchmarks,#codeigniter_profiler #ci_profiler_benchmarks td{background-color:#ffd4d4!important}#codeigniter_profiler #ci_profiler_get,#codeigniter_profiler #ci_profiler_get td{background-color:#ffe8cd!important}#codeigniter_profiler #ci_profiler_memory_usage,#codeigniter_profiler #ci_profiler_memory_usage td{background-color:#edd4ff!important}#codeigniter_profiler #ci_profiler_post,#codeigniter_profiler #ci_profiler_post td{background-color:#e7ffe7!important}#codeigniter_profiler #ci_profiler_config,#codeigniter_profiler #ci_profiler_config td,#codeigniter_profiler #ci_profiler_csession,#codeigniter_profiler #ci_profiler_csession td,#codeigniter_profiler #ci_profiler_http_headers,#codeigniter_profiler #ci_profiler_http_headers td,#codeigniter_profiler #ci_profiler_uri_string,#codeigniter_profiler #ci_profiler_uri_string td{background-color:#e0e0e0!important}#codeigniter_profiler #ci_profiler_controller_info,#codeigniter_profiler #ci_profiler_controller_info td{background-color:#ffe2c0!important}#codeigniter_profiler fieldset{background-color:#ebebff!important;margin-bottom:15px;overflow-x:scroll;overflow-y:hidden;width:100%}#codeigniter_profiler legend{border:0;width:auto!important;margin-bottom:4px}#codeigniter_profiler td{background-color:#ebebff!important;border-bottom:2px solid #FCFCFC}#codeigniter_profiler td:first-child{border-right:2px solid #FCFCFC}#codeigniter_profiler #ci_profiler_benchmarks td:first-child,#codeigniter_profiler #ci_profiler_http_headers td:first-child{width:10%!important}#codeigniter_profiler code{background-color:#ebebff!important;display:inline-block;width:100%;word-wrap:break-word}#codeigniter_profiler #ci_profiler_post td:first-child{width:30%!important}#codeigniter_profiler #ci_profiler_post td:last-child{width:70%!important}.btn-profiler{position:fixed;bottom:0px;left:0px;z-index:99999;}</style>';
        $output .= '<script type="text/javascript">
                        $(document).ready(function() {
                            $(".btn-profiler").on("click", function(){
                                if($("#codeigniter_profiler .sections").is(":visible")) {
                                    $("#codeigniter_profiler .sections").fadeOut();
                                } else {
                                    $("#codeigniter_profiler .sections").fadeIn();
                                }
                            });

                            $("#codeigniter_profiler .sections").fadeOut();
                        });
                    </script>';

        $output .= '<div class="sections" style="padding:10px;">';

        $fields_displayed = 0;

        foreach ($this->_available_sections as $section)
        {
            if ($this->_compile_{$section} !== FALSE)
            {
                $func = '_compile_'.$section;
                $output .= $this->{$func}();
                $fields_displayed++;
            }
        }

        if ($fields_displayed === 0)
        {
            $output .= '<p style="border:1px solid #5a0099;padding:10px;margin:20px 0;background-color:#eee;">'
                .$this->CI->lang->line('profiler_no_profiles').'</p>';
        }

        return $output.'</div></div>';
    }
}
