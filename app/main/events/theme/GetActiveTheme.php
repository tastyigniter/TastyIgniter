<?php

namespace Main\Events\Theme;

use System\Classes\BaseEvent;

class GetActiveTheme extends BaseEvent
{
    protected $themeCode;

    public function __construct($themeCode)
    {
        $this->themeCode = $themeCode;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->themeCode;
    }

    /**
     * @param mixed $themeCode
     * @return GetActiveTheme
     */
    public function setCode($themeCode)
    {
        $this->themeCode = $themeCode;

        return $this;
    }
}
