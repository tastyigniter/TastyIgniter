<?php namespace Main\Components;

use System\Classes\BaseComponent;

class BlankComponent extends BaseComponent
{
    /**
     * @var boolean This component is hidden from the admin UI.
     */
    public $isHidden = TRUE;

    /**
     * @var string Error message that is shown with this error component.
     */
    protected $errorMessage;

    /**
     * @inheritDoc
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
