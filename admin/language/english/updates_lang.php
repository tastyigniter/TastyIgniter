<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['text_title'] 		            = 'Updates';
$lang['text_heading'] 		            = 'Updates';
$lang['text_browse_title'] 		        = 'Browse %s';
$lang['text_browse_heading'] 		 	= 'Browse %s';
$lang['text_upgrade_title'] 		    = 'Update %s';
$lang['text_upgrade_heading'] 		    = 'Update %s &nbsp;&nbsp;<i id="updateProgress" class="fa fa-spinner fa-pulse" title="Loading, please wait"></i>';
$lang['text_tab_title_core'] 	        = 'TastyIgniter';
$lang['text_tab_title_marketplace'] 	= 'Marketplace';
$lang['text_tab_title_extensions'] 	    = 'Extensions';
$lang['text_tab_title_themes'] 		    = 'Themes';
$lang['text_tab_title_translations']    = 'Translations';
$lang['text_search'] 		       		= 'Search marketplace for %s to install';
$lang['text_popular_title']    			= 'Popular %s';
$lang['text_last_checked']              = '<b>Last checked:</b> %s';
$lang['text_core_updated'] 		        = 'Yippee! You are running the latest version of TastyIgniter.';
$lang['text_core_update_available'] 	= 'A new update is ready to install';
$lang['text_core_update_ignored'] 		= 'A new update is ignored, check again';
$lang['text_no_updates'] 		       	= 'Nothing to Update';
$lang['text_item_update_summary'] 		= 'Update from version <strong>%s</strong> to <strong>%s</strong>';

$lang['text_updated'] 		            = 'Yippee! Your %s are all up to date.';
$lang['text_update_available'] 		    = 'The following have new update available. Check the ones you want to update and then click “Update %s”.';
$lang['text_maintenance_mode'] 		    = 'While your site is being updated, maintenance mode will be enabled then disabled as soon as your updates are complete.';

$lang['text_update_start'] 		        = 'The update process is starting. This process may take a while on some hosts, so please be patient.';
$lang['text_complete_installation']     = '<a href="%s" target="_parent">Complete Installation</a>';
$lang['text_files_added']               = '<strong>Files Added: (%s)</strong>';
$lang['text_files_modified']            = '<strong>Files Modified: (%s)</strong>';
$lang['text_files_deleted']             = '<strong>Files Deleted: (%s)</strong>';
$lang['text_files_unchanged']           = '<strong>Files Unchanged: (%s)</strong>';
$lang['text_files_failed']              = '<strong>Files failed to update: (%s)</strong>';

$lang['text_fetch_extensions']          = 'Fetching extensions from the TastyIgniter Marketplace...';

$lang['progress_download'] 	    		= '<i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;&nbsp;Downloading %s&#8230;';
$lang['progress_extract'] 	    		= '<i class="fa fa-file-archive-o fa-fw"></i>&nbsp;&nbsp;&nbsp;Extracting %s&#8230;';
$lang['progress_complete'] 	    		= '<i class="fa fa-download fa-fw"></i>&nbsp;&nbsp;&nbsp;Completing %s&#8230;';

$lang['progress_update'] 	            = '<strong id="progress-updating">Updating %s&#8230;</strong>';
$lang['progress_enable_maintenance']    = 'Enabling Maintenance mode&#8230;';
$lang['progress_disable_maintenance']   = 'Restoring/Disabling Maintenance mode&#8230;';
$lang['progress_download_update'] 	    = '<i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;&nbsp;Downloading the update&#8230;';
$lang['progress_extract_update'] 	    = '<i class="fa fa-file-archive-o fa-fw"></i>&nbsp;&nbsp;&nbsp;Extracting the update&#8230;';
$lang['progress_install_update'] 	    = '<i class="fa fa-download fa-fw"></i>&nbsp;&nbsp;&nbsp;Installing the update&#8230;';
$lang['progress_modified_files']        = '<i class="fa fa-files-o fa-fw"></i>&nbsp;&nbsp;&nbsp;<a id="toggleUpdatedFiles" class="clickable">See updated files</a>';
$lang['progress_update_success'] 	    = '<strong id="progress-updated">Updated %s successfully.</strong>';
$lang['progress_download_failed']       = '<span class="text-danger">Downloading the update failed, check your error log.</span>';
$lang['progress_extract_failed'] 	    = '<span class="text-danger">The downloaded zip could not be opened, check your file permissions&#8230;</span>';
$lang['progress_install_failed']        = '<span class="text-danger">Installing the update failed, check your error log.</span>';
$lang['progress_update_incomplete'] 	= '<span class="text-warning">Installation process is incomplete, please wait to complete</span>';
$lang['progress_archive_not_found']     = '<span class="text-danger">The downloaded update archive could not be found/opened.</span>';

$lang['button_browse']             		= '<i class="fa fa-globe"></i> Browse %s';
$lang['button_add_site']         		= '<i class="fa fa-key"></i> Attach Site Key';
$lang['button_edit_site']         		= '<i class="fa fa-key"></i> Edit Site Key';
$lang['button_check']             		= '<i class="fa fa-refresh"></i> Check Updates';
$lang['button_check_again']             = '<i class="fa fa-refresh"></i> Check Again';
$lang['button_update']              	= '<i class="fa fa-check"></i> Update %s';
$lang['button_ignore_update']       	= '<i class="fa fa-times"></i> Ignore this update';
$lang['button_update_extensions']       = 'Update Extensions';
$lang['button_update_themes']           = 'Update Themes';
$lang['button_update_translations']     = 'Update Translations';
//$lang['button_download_update']         = 'Download <b>%s</b>';
//$lang['button_skip_update']             = 'Skip Update';

$lang['help_core_update'] 		        = 'TastyIgniter just got better, click the update button to install the latest version (%s)';

$lang['alert_modification_warning']     = '<b>Caution:</b> Any modifications you have made to TastyIgniter core files will be lost. Please back up your database and files';
$lang['alert_updates_warning']          = '<b>Caution:</b> before updating, please back up your database and files.';
$lang['alert_zip_warning']              = '<b>Warning:</b> ZIP extension needs to be loaded on your server! Please, ask your hosting company for further help.';
$lang['alert_permission_warning']       = '<b>Warning:</b> You do not have the right permission to apply updates.';
$lang['alert_bad_request']              = 'BAD REQUEST, please check and try again.';

/* End of file updates_lang.php */
/* Location: ./admin/language/english/updates_lang.php */