<?php
class JsonMapperTest_DependencyInjector extends \apimatic\jsonmapper\JsonMapper
{
    /**
     * Create a new object of the given type.
     *
     * This method exists to be overwritten in child classes,
     * so you can do dependency injection or so.
     *
     * @param string  $class            Class name to instantiate
     * @param object  $jobject          Use jobject for constructor args
     * @param bool    $forMultipleTypes True if looking to map for multiple types, Default: false
     *
     * @return object Freshly created object
     */
    public function createInstance(
        $class, &$jobject = null, $forMultipleTypes = false
    ) {
        $object = parent::createInstance($class, $jobject, $forMultipleTypes);

        //dummy dependency injection
        $object->db = 'database';

        return $object;
    }
}
?>