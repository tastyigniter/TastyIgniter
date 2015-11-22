Upgrading TastyIgniter v1.4.x to 2.0.x
==============

NOTE: THIS IS FOR UPGRADE ON EXISTING INSTALLS ONLY!
IF INSTALLING NEW, BE SURE TO READ THE README.md FILE INSTEAD


* BACKUP YOUR EXISTING STORE FILES AND DATABASE!!
- Backup your database via your store Admin->Tools->Maintenance->Backup
- Backup your files using FTP file copy or use cPanel filemanager to create a zip of all the existing tastyigniter files and folders

* Download the latest version of TastyIgniter and upload ALL new files on top of your current install EXCEPT your `system/tastyigniter/config/database.php`.
- Make sure your `system/tastyigniter/config/database.php` old file was not overwritten.

3. Go to http://<yourstore.com>/ Replacing <yourstore.com> with your actual site (and subdirectory if applicable).

4. You should see the TastyIgniter Setup script.

5. Click "Continue". After a few seconds you should see the installation success page.
- If you see the database configuration and/or site settings TastyIgniter Setup page, then that means you have replaced your old `system/tastyigniter/config/database.php` file. Restore them from your backup first. Then try again.

6. Clear any cookies in your browser

7. Go to the administrator panel and login as the main administrator. Press Ctrl+F5 3x times to refresh your browser cache. That will prevent oddly shifted elements due to stylesheet changes.
- If you see any errors, report them immediately in the forum before continuing.

9. Go to Admin->System Settings
- Update any blank fields and click save.
- Even if you do not see any new fields, click save anyway to update the database with any new field names.


Troubleshooting:
------------------------------
If you have any upgrade script errors, post them in the forum
You should always visit the forum immediately after a fresh upgrade to see if there are any immediate bug fixes
If nobody has reported your bug, then please report it.