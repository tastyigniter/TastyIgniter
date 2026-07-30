<?php

class PrivateWithSetter
{
    /**
     * @var int
     */
    private $privateProperty = 0;

    /**
     * @var int
     */
    private $privateNoSetter = 0;

    /**
     * @var int
     */
    private $privatePropertyPrivateSetter = 0;

    /**
     * @param int $privateProperty
     *
     * @return $this
     */
    public function setPrivateProperty($privateProperty)
    {
        $this->privateProperty = $privateProperty;
        return $this;
    }

    /**
     * @param int $ppps
     *
     * @return $this
     */
    private function setPrivatePropertyPrivateSetter($ppps)
    {
        $this->privatePropertyPrivateSetter = $ppps;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrivateProperty()
    {
        return $this->privateProperty;
    }
}
?>
