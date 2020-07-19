<?php

namespace Admin\Classes;

use Igniter\Flame\Location\Manager;

class Location extends Manager
{
    protected $sessionKey = 'admin_local_info';

    protected $locationModel = 'Admin\Models\Locations_model';

    public function check()
    {
        return (bool)$this->current();
    }

    public function current()
    {
        if (!is_null($this->model))
            return $this->model;

        if (!$this->getAuth()->isLogged())
            return null;

        $model = null;
        if ($this->isSingleMode()) {
            $model = $this->getById(params('default_location_id'));
        }
        else {
            $id = $this->getSession('id');
            if (!$id AND $this->hasRestriction())
                $id = $this->getDefaultLocation();

            if ($id) $model = $this->getById($id);
        }

        if ($model)
            $this->setCurrent($model);

        return $this->model;
    }

    public function clearCurrent()
    {
        $this->forgetSession();
    }

    public function hasAccess($location)
    {
        if ($this->getAuth()->isSuperUser())
            return TRUE;

        return $this->getAuth()->user()->hasLocationAccess($location);
    }

    public function hasRestriction()
    {
        if ($this->getAuth()->isSuperUser())
            return FALSE;

        return $this->getAuth()->locations()->isNotEmpty();
    }

    public function isSingleMode()
    {
        return is_single_location();
    }

    public function getId()
    {
        return optional($this->getLocation())->getKey();
    }

    public function getLocation()
    {
        return $this->model;
    }

    public function listLocations()
    {
        $locations = null;
        if (!$this->getAuth()->isSuperUser()) {
            $locations = $this->getAuth()->locations()->where('location_status', TRUE)->pluck(
                'location_name', 'location_id'
            );
        }

        return ($locations AND $locations->isNotEmpty()) ?
            $locations : $this->createLocationModel()->getDropdownOptions();
    }

    public function getDefaultLocation()
    {
        if (!$staffLocation = $this->getAuth()->locations()->first())
            return null;

        return $staffLocation->getKey();
    }

    /**
     * @return \Admin\Classes\User
     */
    protected function getAuth()
    {
        return app('admin.auth');
    }
}