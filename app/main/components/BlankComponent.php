<?php

namespace Main\Components;

use System\Classes\BaseComponent;

class BlankComponent extends BaseComponent
{
    /**
     * @var bool This component is hidden from the admin UI.
     */
    public $isHidden = true;

    /**
     * @var string Error message that is shown with this error component.
     */
    protected $errorMessage;

    /**
     * {@inheritdoc}
     */
    public function __construct($cmsObject, $properties, $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        $this->componentCssClass = 'blank-component';

        parent::__construct($cmsObject, $properties);
    }

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'Blank component',
        ];
    }

    public function onRender()
    {
        return $this->errorMessage;
    }
}
