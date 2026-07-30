<?php

namespace namespacetest\model;

class Group
{
    /**
     * @var User[]
     */
    private $users;

    /**
     * @maps lead
     * @var User
     */
    public $lead;

    /**
     * @maps users
     *
     * @param User[] $users
     */
    public function setUsers(array $users)
    {
        $this->users = $users;
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}
