<?php

namespace Main\Widgets;

use Admin\Classes\BaseWidget;
use ApplicationException;
use Exception;
use File;
use Input;
use Main\Classes\MediaLibrary;
use Request;
use Response;

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

    public $chooseButtonText = 'main::lang.media_manager.text_choose';

    public $selectMode = 'multi';

    public $selectItem;

    //
    // Object properties
    //

    protected $defaultAlias = 'mediamanager';

    public $configSetting;

    protected $popupLoaded = FALSE;

    public function __construct($controller, $config = [])
    {
        parent::__construct($controller, $config);

        $this->checkUploadHandler();
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
        $this->vars['items'] = $items = $this->listFolderItems($folder, $sortBy, $searchTerm);
        $this->vars['folderSize'] = $this->getCurrentFolderSize();
        $this->vars['totalItems'] = count($items);
        $this->vars['folderList'] = $this->getFolderList();
        $this->vars['folderTree'] = $this->getFolderTreeNodes();
        $this->vars['sortBy'] = $sortBy;
        $this->vars['searchTerm'] = $searchTerm;
        $this->vars['isPopup'] = $this->popupLoaded;
        $this->vars['selectMode'] = $this->selectMode;
        $this->vars['selectItem'] = $this->selectItem;
        $this->vars['maxUploadSize'] = round($this->getSetting('max_size', 380) / 1024, 2);
        $this->vars['allowedExtensions'] = $this->getMediaLibrary()->getAllowedExtensions();
        $this->vars['chooseButton'] = $this->chooseButton;
        $this->vars['chooseButtonText'] = $this->chooseButtonText;
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

    public function getSetting($name, $default = null)
    {
        return $this->getMediaLibrary()->getConfig($name, $default);
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
            '#'.$this->getId('toolbar') => $this->makePartial('mediamanager/toolbar'),
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

        if (post('resetCache')) {
            $this->getMediaLibrary()->resetCache();
        }

        if (post('resetSearch')) {
            $this->setSearchTerm(null);
        }

        $this->setCurrentFolder($path);
        $this->prepareVars();

        return [
            '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
            '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
            '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
            '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
        ];
    }

    public function onLoadPopup()
    {
        $this->popupLoaded = TRUE;
        $this->selectMode = post('selectMode');
        $this->chooseButton = post('chooseButton');
        $this->chooseButtonText = post('chooseButtonText', $this->chooseButtonText);

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
            if (!$this->getSetting('new_folder'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_new_folder_disabled'));

            if (!$path = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $name = trim(post('name'));
            if (!strlen($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_name_required'));

            if (!$this->validateFileName($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_file_name'));

            $fullPath = $path.'/'.$name;
            if ($mediaLibrary->exists($fullPath))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_exists'));

            $mediaLibrary->makeFolder($fullPath);

            $mediaLibrary->resetCache();

            $this->setCurrentFolder($fullPath);

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onRenameFolder()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('rename'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_rename_disabled'));

            if (!$path = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $name = trim(post('name'));
            if (!strlen($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_name_required'));

            if (!$this->validateFileName($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_file_name'));

            $newPath = File::dirname($path).'/'.$name;
            if ($mediaLibrary->exists($newPath))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_exists'));

            $mediaLibrary->rename($path, $newPath);

            $mediaLibrary->resetCache();

            $this->setCurrentFolder($newPath);

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onRenameFile()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('rename'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_rename_disabled'));

            if (!$path = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $oldName = trim(post('file'));
            if (!strlen($oldName))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_name_required'));

            $name = trim(post('name'));
            if (!strlen($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_new_file_name'));

            if (!$mediaLibrary->isAllowedExtension($name))
                throw new ApplicationException(lang('main::lang.media_manager.alert_extension_not_allowed'));

            if (!$this->validateFileName($name) OR !$this->validateFileName($oldName))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_file_name'));

            $newPath = $path.'/'.$name;
            if ($mediaLibrary->exists($newPath))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_exists'));

            $mediaLibrary->rename($path.'/'.$oldName, $newPath);

            $mediaLibrary->resetCache();

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onDeleteFolder()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('delete'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_delete_disabled'));

            if (!$path = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $mediaLibrary->deleteFolder($path);

            $mediaLibrary->resetCache();

            $this->setCurrentFolder(dirname($path));

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onDeleteFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('delete')) {
                $json['alert'] = lang('main::lang.media_manager.alert_delete_disabled');
            }

            if (!$path = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $files = post('files');
            if (empty($files) OR !is_array($files)) {
                throw new ApplicationException(lang('main::lang.media_manager.alert_select_delete_file'));
            }

            $files = array_map(function ($value) use ($path) {
                return $this->validateFileName($value['path'])
                    ? $path.'/'.$value['path']
                    : FALSE;
            }, $files);

            $mediaLibrary->deleteFiles($files);

            $mediaLibrary->resetCache();

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onMoveFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('move'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_move_disabled'));

            if (!$source = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            if (!$destination = $mediaLibrary->validatePath(post('destination')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $files = post('files');
            if (empty($files) OR !is_array($files))
                throw new ApplicationException(lang('main::lang.media_manager.alert_select_move_file'));

            foreach ($files as $file) {
                $name = $file['path'];
                if ($this->validateFileName($name))
                    $mediaLibrary->moveFile($source.'/'.$name, $destination.'/'.$name);
            }

            $mediaLibrary->resetCache();

            $this->setCurrentFolder($destination);

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function onCopyFiles()
    {
        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->getSetting('copy'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_copy_disabled'));

            if (!$source = $mediaLibrary->validatePath(post('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            if (!$destination = $mediaLibrary->validatePath(post('destination')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $files = post('files');
            if (empty($files) OR !is_array($files))
                throw new ApplicationException(lang('main::lang.media_manager.alert_select_copy_file'));

            foreach ($files as $file) {
                $name = $file['path'];
                if ($this->validateFileName($name))
                    $mediaLibrary->copyFile($source.'/'.$name, $destination.'/'.$name);
            }

            $mediaLibrary->resetCache();

            $this->setCurrentFolder($destination);

            $this->prepareVars();

            return [
                '#'.$this->getId('item-list') => $this->makePartial('mediamanager/item_list'),
                '#'.$this->getId('folder-tree') => $this->makePartial('mediamanager/folder_tree'),
                '#'.$this->getId('breadcrumb') => $this->makePartial('mediamanager/breadcrumb'),
                '#'.$this->getId('statusbar') => $this->makePartial('mediamanager/statusbar'),
            ];
        }
        catch (Exception $ex) {
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

    protected function listFolderItems($folder, $sortBy, $filter)
    {
        return $this->getMediaLibrary()->fetchFiles($folder, $sortBy, $filter);
    }

    protected function getFolderList()
    {
        $result = [];

        $currentFolder = $this->getCurrentFolder();
        $folderList = $this->getMediaLibrary()->listAllFolders();

        foreach ($folderList as $value) {
            if ($value == $currentFolder)
                continue;

            $result[] = $value;
        }

        return $result;
    }

    protected function getFolderTreeNodes()
    {
        $result = [];

        $mediaLibrary = $this->getMediaLibrary();

        $folderTree = function ($path) use (&$folderTree, $mediaLibrary, $result) {

            if (!($folders = $mediaLibrary->listFolders($path)))
                return null;

            foreach ($folders as $folder) {
                $node = [];
                $node['text'] = $folder;
                $node['path'] = $folder;

                $node['state']['expanded'] = $this->isFolderTreeNodeExpanded($folder);
                $node['state']['selected'] = $this->isFolderTreeNodeSelected($folder);

                $node['nodes'] = ($folder != static::ROOT_FOLDER)
                    ? $folderTree($folder)
                    : null;

                $result[] = $node;
            }

            return $result;
        };

        return $folderTree(static::ROOT_FOLDER);
    }

    protected function getCurrentFolderSize()
    {
        return $this->makeReadableSize($this->getMediaLibrary()->folderSize($this->getCurrentFolder()));
    }

    protected function setCurrentFolder($path)
    {
        $path = $this->getMediaLibrary()->validatePath($path);
        $this->putSession('media_folder', $path);
    }

    protected function getCurrentFolder()
    {
        return $this->getSession('media_folder', static::ROOT_FOLDER);
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
        if ($sort AND in_array($direction, $sort))
            $direction = 'ascending';

        $sortBy = [$sortBy, $direction];

        return $this->putSession('media_sort_by', $sortBy);
    }

    protected function getSortBy()
    {
        return $this->getSession('media_sort_by', null);
    }

    protected function checkUploadHandler()
    {
        if (!($uniqueId = Request::header('X-IGNITER-FILEUPLOAD')) OR $uniqueId != $this->getId())
            return;

        $mediaLibrary = $this->getMediaLibrary();

        try {
            if (!$this->controller->getUser()->hasPermission('Admin.MediaManager'))
                throw new ApplicationException(sprintf(lang('main::lang.media_manager.alert_permission'), 'upload'));

            if (!Input::hasFile('file_data'))
                throw new ApplicationException(lang('main::lang.media_manager.alert_file_not_found'));

            $uploadedFile = Input::file('file_data');

            $fileName = $uploadedFile->getClientOriginalName();

            if (!$path = $mediaLibrary->validatePath(Input::get('path')))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_path'));

            $extension = strtolower($uploadedFile->getClientOriginalExtension());
            $fileName = File::name($fileName).'.'.$extension;
            $filePath = $path.'/'.$fileName;

            if (!$this->validateFileName($fileName))
                throw new ApplicationException(lang('main::lang.media_manager.alert_invalid_new_file_name'));

            if (!$mediaLibrary->isAllowedExtension($extension))
                throw new ApplicationException(lang('main::lang.media_manager.alert_extension_not_allowed'));

            if (!$uploadedFile->isValid())
                throw new ApplicationException($uploadedFile->getErrorMessage());

            $mediaLibrary->put(
                $filePath,
                File::get($uploadedFile->getRealPath())
            );

            $mediaLibrary->resetCache();

            $this->fireSystemEvent('media.file.upload', [$filePath, $uploadedFile]);

            Response::json([
                'link' => $mediaLibrary->getMediaUrl($filePath),
                'result' => 'success',
            ])->send();
        }
        catch (Exception $ex) {
            Response::json($ex->getMessage(), 400)->send();
        }

        exit;
    }

    protected function validateFileName($name)
    {
        if (!preg_match('/^[0-9a-z@\.\s_\-]+$/i', $name)) {
            return FALSE;
        }

        if (strpos($name, '..') !== FALSE) {
            return FALSE;
        }

        return TRUE;
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

    protected function isFolderTreeNodeExpanded($node)
    {
        return starts_with($this->getCurrentFolder(), $node);
    }

    protected function isFolderTreeNodeSelected($node)
    {
        return $this->getCurrentFolder() == $node;
    }
}
