<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Profiler Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\TI_Profiler.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Profiler extends CI_Profiler
{

	public function __construct($config = [])
	{
		parent::__construct($config);

		// Make sure the Console is loaded.
		if (!class_exists('Console')) {
			$this->CI->load->library('Console');
		}
	}

	/**
	 * Run the Profiler
	 *
	 * @return    string
	 */
	public function run()
	{
		$sections = array_flip($this->_available_sections);

		$output = link_tag(assets_url('css/profiler/profiler.css'));
		$output .= '<script src="' . assets_url('js/vendor/js.cookie.js') . '" charset="utf-8" type="text/javascript"></script>';
		$output .= '<script src="' . assets_url('js/profiler/profiler.js') . '" charset="utf-8" type="text/javascript"></script>';

		$output .= '<div id="codeigniter_profiler" style="clear:both;background-color:#fff;">';
		$output .= '<a class="btn btn-success btn-profiler"><i class="fa fa-bug"></i></a>';
		$output .= '<div class="profiler" style="display: none">';
		$output .= '<div class="profiler-menu"><ul class="nav nav-tabs" role="tablist">';
		$output .= '<li role="presentation" class="disabled"><a id="profiler-menu-icon" class="btn btn-success"><i class="fa fa-bug"></i></a></li>';

		$logs = $this->CI->console->get_logs();
		$output .= '<li role="presentation">';
		$output .= '<a href="#profiler-tab-console" id="profiler-menu-console" data-toggle="tab">';
		if ($logs['log_count'] > 0) {
			$output .= '<span class="label label-primary hidden-xs"> ' . $logs['log_count'] . '</span>&nbsp;&nbsp;';
		}
		$output .= '<span class="hidden-xs">Console</span>';
		$output .= '<i class="fa fa-terminal visible-xs"></i>';
		$output .= '</a></li>';

		if (isset($sections['benchmarks'])) {
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-benchmarks" id="profiler-menu-time" data-toggle="tab">';
			$output .= '<span class="label label-primary hidden-xs"> ' . $this->CI->benchmark->elapsed_time("total_execution_time_start", "total_execution_time_end") . ' s</span>';
			$output .= '<span class="hidden-xs">&nbsp;&nbsp;Load Time</span>';
			$output .= '<i class="fa fa-tachometer visible-xs"></i>';
			$output .= '</a></li>';

			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-memory_usage" id="profiler-menu-memory" data-toggle="tab">';
			$output .= '<span class="label label-primary hidden-xs"> ' . ((!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage() / 1024 / 1024, 2) . ' MB') . '</span>';
			$output .= '<span class="hidden-xs">&nbsp;&nbsp;Memory Used</span>';
			$output .= '<i class="fa fa-hdd-o visible-xs"></i>';
			$output .= '</a></li>';
		}

		if (isset($sections['queries'])) {
			$queries = isset($this->CI->db) ? count($this->CI->db->queries) : 0;
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-queries" id="profiler-menu-queries" data-toggle="tab">';
			$output .= '<span class="label label-primary hidden-xs"> ' . ($queries > 0 ? ($queries - 1) : 0) . '</span>';
			$output .= '<span class="hidden-xs">&nbsp;&nbsp;Queries</span>';
			$output .= '<i class="fa fa-cogs visible-xs"></i>';
			$output .= '</a></li>';
		}

		if (isset($sections['http_headers']) OR isset($sections['uri_string'])
			OR isset($sections['controller_info'])
		) {
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-vars" id="profiler-menu-vars" data-toggle="tab">';
			$output .= '<span class="hidden-xs">vars</span>';
			$output .= '<i class="fa fa-code visible-xs"></i>';
			$output .= '</a></li>';
		}

		if (isset($sections['get']) OR isset($sections['post'])) {
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-request" id="profiler-menu-config" data-toggle="tab">';
			$output .= '<span class="hidden-xs">Request</span>';
			$output .= '<i class="fa fa-globe visible-xs"></i>';
			$output .= '</a></li>';
		}

		if (isset($sections['config'])) {
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-config" id="profiler-menu-config" data-toggle="tab">';
			$output .= '<span class="hidden-xs">Config</span>';
			$output .= '<i class="fa fa-wrench visible-xs"></i>';
			$output .= '</a></li>';
		}

		if (isset($sections['session_data'])) {
			$output .= '<li role="presentation">';
			$output .= '<a href="#profiler-tab-session" id="profiler-menu-session" data-toggle="tab">';
			$output .= '<span class="hidden-xs">Session Data</span>';
			$output .= '<i class="fa fa-history visible-xs"></i>';
			$output .= '</a></li>';
		}

		$output .= '<li role="presentation" class="pull-right"><a class="btn btn-profiler"><i class="fa fa-times"></i></a></li>';
		$output .= '<li role="presentation" class="pull-right"><a class="btn btn-collapse"><i class="fa fa-chevron-up"></i></a></li>';
		$output .= '</ul></div>';

		$output .= '<div class="profiler-sections tab-content" style="display: none">';

		$output .= '<div id="profiler-tab-console" class="tab-pane" role="tabpanel">';
		$output .= $this->_compile_console();
		$output .= '</div>';

		if (isset($sections['benchmarks'])) {
			$output .= '<div id="profiler-tab-benchmarks" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_benchmarks();
			$output .= '</div>';

			$output .= '<div id="profiler-tab-memory_usage" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_memory_usage();
			$output .= '</div>';
		}

		if (isset($sections['queries'])) {
			$output .= '<div id="profiler-tab-queries" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_queries();
			$output .= '</div>';
		}

		if (isset($sections['http_headers']) OR isset($sections['uri_string'])
			OR isset($sections['controller_info'])
		) {
			$output .= '<div id="profiler-tab-vars" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_var();
			$output .= $this->_compile_http_headers();
			$output .= '</div>';
		}

		if (isset($sections['get']) OR isset($sections['post'])) {
			$output .= '<div id="profiler-tab-request" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_get();
			$output .= $this->_compile_post();
			$output .= '</div>';
		}

		if (isset($sections['config'])) {
			$output .= '<div id="profiler-tab-config" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_config();
			$output .= '</div>';
		}

		if (isset($sections['session_data'])) {
			$output .= '<div id="profiler-tab-session" class="tab-pane" role="tabpanel">';
			$output .= $this->_compile_session_data();
			$output .= '</div>';
		}

		if (count($sections) === 0) {
			$output .= '<p style="border:1px solid #5a0099;padding:10px;margin:20px 0;background-color:#eee;">'
				. $this->CI->lang->line('profiler_no_profiles') . '</p>';
		}
		$output .= '</div>';

		return $output . '</div></div>';
	}

	public function _compile_console()
	{
		$output = "\n\n";
		$logs = $this->CI->console->get_logs();
		if ($logs['console']) {
			foreach ($logs['console'] as $key => $log) {
				if ($log['type'] == 'log') {
					$output .= '<pre>';
					$output .= print_r($log['data'], TRUE);
					$output .= '</pre>';
				}
			}
		}

		return $output;
	}

	protected function _compile_var()
	{
		return "\n\n"
		. '<fieldset id="ci_profiler_vars" style="border:1px solid #000;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'
		. "\n"
		. '<legend style="color:#000;">&nbsp;&nbsp;' . $this->CI->lang->line('profiler_uri_string') . "&nbsp;&nbsp;</legend>\n"
		. '<table style="width:100%;">' . "\n"
		. '<tr><td style="width:50%;padding:5px;color:#900;background-color:#ddd;">'
		. $this->CI->lang->line('profiler_uri_string') . '&nbsp;&nbsp;</td><td style="width:50%;padding:5px;color:#000;background-color:#ddd;">'
		. ($this->CI->uri->uri_string === '' ? $this->CI->lang->line('profiler_no_uri') : $this->CI->uri->uri_string)
		. "</td></tr>\n"
		. '<tr><td style="width:50%;padding:5px;color:#900;background-color:#ddd;">'
		. $this->CI->lang->line('profiler_controller_info') . '&nbsp;&nbsp;</td><td style="width:50%;padding:5px;color:#000;background-color:#ddd;">'
		. $this->CI->router->class . '/' . $this->CI->router->method
		. "</td></tr>\n"
		. '</table></fieldset>';
	}

	protected function _compile_session_data()
	{
		if (!isset($this->CI->session)) {
			return;
		}

		$output = '<fieldset id="ci_profiler_csession" style="border:1px solid #000;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'
			. '<legend style="color:#000;">&nbsp;&nbsp;' . $this->CI->lang->line('profiler_session_data') . '&nbsp;&nbsp;(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_session_data\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\'' . $this->CI->lang->line('profiler_section_show') . '\'?\'' . $this->CI->lang->line('profiler_section_hide') . '\':\'' . $this->CI->lang->line('profiler_section_show') . '\';">' . $this->CI->lang->line('profiler_section_show') . '</span>)</legend>'
			. '<table style="width:100%;display:none;" id="ci_profiler_session_data">';

		foreach ($this->CI->session->userdata() as $key => $val) {
			if (is_array($val) OR is_object($val)) {
				$val = print_r($val, TRUE);
			}

			$output .= '<tr><td style="padding:5px;vertical-align:top;color:#900;background-color:#ddd;">'
				. $key . '&nbsp;&nbsp;</td><td style="padding:5px;color:#000;background-color:#ddd;"><pre>' . htmlspecialchars($val) . "</pre></td></tr>\n";
		}

		return $output . "</table>\n</fieldset>";
	}
}