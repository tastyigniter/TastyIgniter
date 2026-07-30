<?php
namespace namespacetest\model;

class User
{
    /** @var string */
    public $name;

    function __construct($name = null)
    {
        $this->name = $name;
    }
}

?>
