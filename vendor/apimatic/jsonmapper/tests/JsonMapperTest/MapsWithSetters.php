<?php

class MapsWithSetters
{
    private $name;
    private $age;
    private $mappedAndFactory;

    /**
     * @maps public
     */
    public $publicProp;

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @maps my_age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @factory MapsWithSetters::factory
     * @maps factoryValue
     */
    public function setMappedAndFactory($val)
    {
        $this->mappedAndFactory = $val;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getMappedAndFactory()
    {
        return $this->mappedAndFactory;
    }

    public static function factory($val)
    {
        return 'value is ' . $val;
    }
}
