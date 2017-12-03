<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['text_title'] 		            = 'Database Maintenance';
$lang['text_heading'] 		            = 'Database Maintenance';
$lang['text_backup_heading'] 		    = 'Database Backup';
$lang['text_browse_heading'] 		    = 'Database Browse: %s';
$lang['text_list'] 		                = 'Database Maintenance List';
$lang['text_tab_backup'] 		        = 'Backup';
$lang['text_tab_existing_backup'] 		= 'Existing Backups';
$lang['text_tab_migrations'] 		    = 'Migrations';
$lang['text_tab_create_backup'] 		= 'Create A New Backup';
$lang['text_empty'] 		            = 'There are no backup available.';
$lang['text_no_backup'] 		        = 'There are no backup available.';
$lang['text_no_row'] 		            = 'There are no rows available for this table.';
$lang['text_installed_version'] 		= 'Installed Version';
$lang['text_latest_version'] 		    = 'Latest Available Version';
$lang['text_select_version'] 		    = 'Select version file';
$lang['text_zip'] 		                = 'zip';
$lang['text_gzip'] 		                = 'gzip';
$lang['text_drop_tables'] 		        = 'Add DROP TABLE statement:';
$lang['text_add_inserts'] 		        = 'Add INSERT statement for data dump:';

$lang['button_backup'] 		            = 'Backup';
$lang['button_migrate'] 		        = 'Migrate';
$lang['button_modules'] 		        = 'Modules';

$lang['column_select_tables'] 		    = 'Select tables to backup';
$lang['column_records'] 		        = '# Records';
$lang['column_data_size'] 		        = 'Data Size';
$lang['column_index_size'] 		        = 'Index Size';
$lang['column_data_free'] 		        = 'Data Free';
$lang['column_engine'] 		            = 'Engine';
$lang['column_name'] 		            = 'Name';
$lang['column_download'] 		        = 'Download';
$lang['column_restore'] 		        = 'Restore';
$lang['column_delete'] 		            = 'Delete';

$lang['label_file_name'] 		        = 'File Name';
$lang['label_drop_tables'] 		        = 'Drop Tables';
$lang['label_add_inserts'] 		        = 'Insert Data';
$lang['label_compression'] 		        = 'Compression Format';
$lang['label_backup_table'] 		    = 'Backup Tables';
$lang['label_migrate_version'] 		    = 'Migrate to verison';

$lang['alert_info_memory_limit'] 		= '<p>Note: Due to the limited execution time and memory available to PHP, backing up very large databases may not be possible.If your database is very large you might need to backup directly from your SQL server via the command line,or have your server admin do it for you if you do not have root privileges.</p>';
$lang['alert_warning_migration'] 		= '<b>BE CAREFUL!</b> Do not migrate unless you know what you\'re doing.';
$lang['alert_warning_maintenance'] 		= 'Your site is live you can\'t %s the database, please enable maintenance mode. Make sure you <b>BACKUP</b> your database.';

$lang['help_compression'] 		        = 'The Restore option is only capable of reading un-compressed files. Gzip or Zip compression is good if you just want a backup to download and store on your computer.';

/* End of file maintenance_lang.php */
/* Location: ./admin/language/english/maintenance_lang.php */