<?php

namespace Admin\Widgets;

use Admin\Classes\BaseWidget;
use Exception;
use File;
use System\Libraries\MediaManager as MediaLibrary;

/**
 * Media Manager widget.
 * @package Admin
 */
class MediaManager extends BaseWidget
{
    const ROOT_FOLDER = '/';

    /**
     * @var string Media size
     */
    public $size = 'large';

    /**
     * @var bool Allow rows to be sorted
     * @todo Not implemented...
     */
    public $rowSorting = FALSE;

    public $chooseButton = FALSE;

    public $selectMode = 'multi';

    public $selectItem;

    //
    // Object properties
    //

    protected $defaultAlias = 'mediamanager';

    public $configSetting;

    protected $rootFolder = 'data/';

    protected $currentFolderSize = 0;

    protected $popupLoaded = FALSE;

    public function initialize()
    {
//        $this->getController()->load->library('media_manager', setting('image_manager'));
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('mediamanager/mediamanager');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $folder = $this->getCurrentFolder();
        $sortBy = $this->getSortBy();
        $searchTerm = $this->getSearchTerm();

        $this->vars['currentFolder'] = $folder;
        $this->vars['isRootFolder'] = $folder == static::ROOT_FOLDER;
        $this->vars['items'] = $this->listFolderItems($folder, $sortBy, $searchTerm);
        $this->vars['folderSize'] = $this->getCurrentFolderSize();
        $this->vars['totalItems'] = count($this->vars['items']);
        $this->vars['folderList'] = $this->getFolderList();
        $this->vars['folderTree'] = $this->getFolderTree();
        $this->vars['sortBy'] = $sortBy;
        $this->vars['isPopup'] = $this->popupLoaded;
        $this->vars['selectMode'] = $this->selectMode;
        $this->vars['selectItem'] = $this->selectItem;
        $this->vars['maxUploadSize'] = round($this->getMediaLibrary()->getUploadMaxSize() / 1024, 2);
        $this->vars['allowedExt'] = $this->getMediaLibrary()->getAllowedExt();
        $this->vars['searchTerm'] = $searchTerm;
        $this->vars['chooseButton'] = $this->chooseButton;
        $this->vars['breadcrumbs'] = $this->makeBreadcrumb();
    }

    public function loadAssets()
    {
        $this->addCss('vendor/treeview/bootstrap-treeview.min.css', 'treeview-css');
        $this->addCss('vendor/dropzone/dropzone.min.css', 'dropzone-css');
        $this->addCss('css/mediamanager.css', 'mediamanager-css');

        $this->addJs('vendor/bootbox/bootbox.min.js', 'bootbox-js');
        $this->addJs('vendor/treeview/bootstrap-treeview.min.js', 'treeview-js');
        $this->addJs('vendor/selectonic/selectonic.min.js', 'selectonic-js');
        $this->addJs('vendor/dropzone/dropzone.min.js', 'dropzone-js');
        $this->addJs('js/mediamanager.js', 'mediamanager-js');
        $this->addJs('js/mediamanager.modal.js', 'mediamanager-modal-js');
    }

    public function getFolderTree()
    {
        $rootFolder = image_path($this->rootFolder);
        $directoryMap = File::directories($rootFolder);
        $result = $this->makeFolderTreeNodes([static::ROOT_FOLDER => []] + $directoryMap);

        return $result;
    }

    public function getSetting($action, $default = null)
    {
        if (!$this->configSetting)
            $this->configSetting = $this->getMediaLibrary()->getOptions();

        return isset($this->configSetting[$action]) ? $this->configSetting[$action] : $default;
    }

    //
    // Event handlers
    //

    public function onSetSorting()
    {
        $sortBy = input('sortBy');
        $path = input('path');

        $this->setSortBy($sortBy);
        $this->setCurrentFolder($path);

        $this->prepareVars();

        return [
            '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
            '#'.$this->getId('toolbar')   => $this->makePartial('mediamanager/toolbar'),
        ];
    }

    public function onSearch()
    {
        $search = input('search');
        $this->setSearchTerm($search);

        $this->prepareVars();

        return [
            '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
        ];
    }

    public function onGoToFolder()
    {
        $path = post('path');

        if (post('resetSearch')) {
            $this->setSearchTerm(null);
        }

        $this->setCurrentFolder($path);
        $this->prepareVars();

        return [
            '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
            '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
            '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
            '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
        ];
    }

    public function onLoadPopup()
    {
        $this->popupLoaded = TRUE;
        $this->selectMode = post('selectMode');
        $this->chooseButton = post('chooseButton');

        $goToItem = post('goToItem');
        if ($goToPath = dirname($goToItem)) {
            $this->selectItem = basename($goToItem);
            $this->setCurrentFolder($goToPath);
        }

        return $this->makePartial('mediamanager/popup', ['_mediamanager' => $this]);
    }

    public function onCreateFolder()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('new_folder')) {
                throw new Exception(lang('alert_new_folder_disabled'));
            }

            $name = trim(post('name'));
            if (!strlen($name)) {
                throw new Exception(lang('alert_file_name_required'));
            }

            $name = $mediaLibrary->fixFileName($name);
            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            if ($path !== '' AND !$mediaLibrary->validatePath($path)) {
                throw new Exception(lang('alert_invalid_file_name'));
            }

            $newFolderPath = $path.'/'.$name;
            if ($mediaLibrary->fileExists($newFolderPath)) {
                throw new Exception(lang('alert_file_exists'));
            }

            $mediaLibrary->newFolder($newFolderPath);

//        $json['success'] = lang('alert_success_new_folder');
            $this->setCurrentFolder($newFolderPath);
            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onRenameFolder()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('rename')) {
                throw new Exception(lang('alert_rename_disabled'));
            }

            $name = trim(post('name'));
            if (!strlen($name)) {
                throw new Exception(lang('alert_file_name_required'));
            }

            $name = $mediaLibrary->fixFileName($name);
            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            if (!$mediaLibrary->validatePath($path)) {
                throw new Exception(lang('alert_invalid_path'));
            }

            if (!$mediaLibrary->rename($path, $name))
                throw new Exception(lang('alert_file_exists'));

//            $json['success'] = lang('alert_success_rename');
            $this->setCurrentFolder(dirname($path).'/'.$name);
            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onDeleteFolder()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('delete')) {
                $json['alert'] = lang('alert_delete_disabled');
            }

            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            if (!$mediaLibrary->validatePath($path)) {
                throw new Exception(lang('alert_invalid_path'));
            }

            if (!$mediaLibrary->isWritable($path)) {
                throw new Exception(lang('alert_file_not_writable'));
            }

            $mediaLibrary->delete($path);

            $this->setCurrentFolder(dirname($path));
            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onRenameFile()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('rename')) {
                throw new Exception(lang('alert_rename_disabled'));
            }

            $name = trim(post('name'));
            if (!strlen($name)) {
                throw new Exception(lang('alert_invalid_new_file_name'));
            }

            $fileName = trim(post('file'));
            if (!strlen($fileName)) {
                throw new Exception(lang('alert_file_name_required'));
            }

            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            if ($path !== '' AND !$mediaLibrary->validatePath($path)) {
                throw new Exception(lang('alert_invalid_path'));
            }

            $name = $mediaLibrary->fixFileName($name);
            $fileName = $mediaLibrary->fixFileName($fileName);

            $allowedExt = $this->getMediaLibrary()->getAllowedExt();
            if ($nameExt = pathinfo($name, PATHINFO_EXTENSION) AND !in_array($nameExt, $allowedExt)) {
                throw new Exception(lang('alert_extension_not_allowed'));
            }

            $name = $nameExt ? $name : $name.'.'.pathinfo($fileName, PATHINFO_EXTENSION);
            if (!$mediaLibrary->rename($path.'/'.$fileName, $name))
                throw new Exception(lang('alert_file_exists'));

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onMoveFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('move')) {
                throw new Exception(lang('alert_move_disabled'));
            }

            $destination = $this->getController()->security->sanitize_filename(
                post('destination'), TRUE
            );

            if (!$mediaLibrary->validatePath($destination)) {
                throw new Exception(lang('alert_select_move_folder'));
            }

            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            $files = post('files');
            if (!$files OR !is_array($files)) {
                throw new Exception(lang('alert_select_move_file'));
            }

            foreach ($files as $file) {
                $fileName = $file['path'];
                $fileName = $mediaLibrary->fixFileName($fileName);
                $mediaLibrary->move(trim($path, '/').'/'.$fileName, trim($destination, '/').'/'.$fileName);
            }

            $this->setCurrentFolder($destination);
            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onCopyFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('copy')) {
                throw new Exception(lang('alert_copy_disabled'));
            }

            $destination = $this->getController()->security->sanitize_filename(
                post('destination'), TRUE
            );

            if (!$mediaLibrary->validatePath($destination)) {
                throw new Exception(lang('alert_invalid_path'));
            }

            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            $files = post('files');
            if (!$files OR !is_array($files)) {
                throw new Exception(lang('alert_select_copy_file'));
            }

            foreach ($files as $file) {
                $fileName = $file['path'];
                $fileName = $mediaLibrary->fixFileName($fileName);
                $mediaLibrary->copy(trim($path, '/').'/'.$fileName, trim($destination, '/').'/'.$fileName);
            }

            $this->setCurrentFolder($destination);
            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onDeleteFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('delete')) {
                $json['alert'] = lang('alert_delete_disabled');
            }

            $path = $this->getController()->security->sanitize_filename(
                post('path'), TRUE
            );

            if (!$mediaLibrary->validatePath($path)) {
                throw new Exception(lang('alert_invalid_path'));
            }

            $files = post('files');
            if (!$files OR !is_array($files)) {
                throw new Exception(lang('alert_select_delete_file'));
            }

            foreach ($files as $file) {
                $fileName = $file['path'];
                $fileName = $mediaLibrary->fixFileName($fileName);
                $mediaLibrary->delete(trim($path, '/').'/'.$fileName);
            }

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list')   => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb')  => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar')   => $this->makePartial('mediamanager/statusbar'),
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //
    // Methods for internal use
    //

    /**
     * @return MediaLibrary
     */
    protected function getMediaLibrary()
    {
        return MediaLibrary::instance();
    }

    protected function listFolderItems($folder, $sortBy, $searchTerm)
    {
        $folder = rtrim($folder, '/').'/';
        $items = $this->getMediaLibrary()->fetchFiles($folder, [
            'by'     => $sortBy[0],
            'order'  => $sortBy[1],
            'filter' => $searchTerm,
        ]);

        foreach ($items as &$item) {
            $itemName = $item['name'];
            $itemType = $item['type'];
            $item['path'] = $folder.$itemName;
            $item['url'] = image_url($this->rootFolder.$folder.$itemName);

            if ($itemType == 'img') {
                $thumbnail = $this->getMediaLibrary()->getThumbnail($itemName, ltrim($folder, '/'));
                $item['thumb'] = $thumbnail;
            }

            $this->currentFolderSize += $item['size'];
            $item['size'] = $this->makeReadableSize($item['size']);
        }

        return $items;
    }

    protected function getFolderList()
    {
        $result = [];

        $currentFolder = $this->getCurrentFolder();
        $folderList = $this->getMediaLibrary()->recursiveFolders();

        foreach ($folderList as $value) {
            if ($value == $currentFolder OR $value == '/')
                continue;

            $result[] = $value;
        }

        return $result;
    }

    protected function getCurrentFolderSize()
    {
        return $this->makeReadableSize($this->currentFolderSize);
    }

    protected function setCurrentFolder($path)
    {
        $path = $this->getMediaLibrary()->validatePath($path);
        $this->putSession('media_folder', $path);
    }

    protected function getCurrentFolder()
    {
        return trim($this->getSession('media_folder', static::ROOT_FOLDER), '/');
    }

    protected function setSearchTerm($searchTerm)
    {
        $this->putSession('media_search', trim($searchTerm));
    }

    protected function getSearchTerm()
    {
        return $this->getSession('media_search', null);
    }

    protected function setSortBy($sortBy)
    {
        $sort = $this->getSortBy();
        $direction = 'descending';
        if (in_array($direction, $sort))
            $direction = 'ascending';

        $sortBy = [$sortBy, $direction];

        return $this->putSession('media_sort_by', $sortBy);
    }

    protected function getSortBy()
    {
        return $this->getSession('media_sort_by', null);
    }

    protected function makeBreadcrumb()
    {
        $result = [];

        $folder = $this->getCurrentFolder();
        if ($folderArray = explode('/', $folder)) {
            $tmpPath = '';
            $result[] = ['name' => '<i class="fa fa-home"></i>'];
            foreach ($folderArray as $key => $p_dir) {
                $tmpPath .= $p_dir.'/';
                if ($p_dir != '') {
                    $result[] = ['name' => $p_dir, 'link' => $tmpPath];
                }
            }
        }

        return $result;
    }

    protected function makeReadableSize($size)
    {
        if (!$size) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $u = 0;
        while ((round($size / 1024) > 0) AND ($u < 4)) {
            $size = $size / 1024;
            $u++;
        }

        return (number_format($size, 0)." ".$units[$u]);
    }

    protected function makeFolderTreeNodes($directoryMap, $parent = null, $result = [])
    {
        foreach ($directoryMap as $key => $value) {
            if (!is_string($key)) continue;

            $path = ($parent ? $parent.'/' : null).$key;
            $node = [];
            $node['text'] = $key;
            $node['path'] = $path;
            $nodes = $this->makeFolderTreeNodes($value, $path);
            if (count($nodes))
                $node['nodes'] = $nodes;

            if ($this->isFolderTreeNodeActive($key)) {
                $node['state']['expanded'] = TRUE;
                $node['state']['selected'] = TRUE;
            }

            $result[] = $node;
        }

        return $result;
    }

    protected function isFolderTreeNodeActive($node)
    {
        $currentFolder = explode('/', $this->getCurrentFolder());

        return in_array($node, $currentFolder);
    }
}
