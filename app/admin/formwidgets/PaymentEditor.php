<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\PaymentGateways;
use Exception;

/**
 * Payment Editor
 *
 * @package Admin
 */
class PaymentEditor extends BaseFormWidget
{
    /**
     * @var string Relation column to display for the name
     */
    public $nameFrom = 'name';

    /**
     * @var string Relation column to use for the history table
     */
    public $listFrom = 'payment_logs';

    /**
     * @var string Text to display for the title of the popup list form
     */
    public $listTitle = 'Payment Activity';

    /**
     * @var string Text to display for the title of the popup list form
     */
    public $formTitle = 'Edit Payment';

    /**
     * @var string Prompt to display if no record is selected.
     */
    protected $listPrompt = 'Activity';

    protected $formPrompt = 'Edit';

    /**
     * @var int Maximum rows to display for each page.
     */
    public $pageLimit = 20;

    /**
     * @var string Use a custom scope method for the list query.
     */
    public $scope;

    /**
     * @var string Filters the relation using a raw where query statement.
     */
    public $conditions;

    protected $defaultAlias = 'paymenteditor';

    /**
     * @var PaymentGateways
     */
    protected $gatewayManager;

    protected $listWidget;

    protected $relationModel;

    protected $sortPayments;

    public function initialize()
    {
        $this->fillFromConfig([
            'listTitle',
            'formTitle',
            'listPrompt',
            'formPrompt',
            'listFrom',
            'nameFrom',
            'scope',
            'conditions',
            'pageLimit',
        ]);

        $this->listWidget = $this->makeListWidget();
        $this->listWidget->bindToController();
//        $this->gatewayManager = PaymentGateways::instance();
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('paymenteditor/paymenteditor');
    }

    public function prepareVars()
    {
        $this->relationModel = $this->getRelationModel($this->valueFrom)->first();
        $modelTraits = ['Igniter\Flame\Database\Traits\Sortable'];
        $this->sortPayments = count(array_intersect($modelTraits, class_uses($this->relationModel)));

        $this->vars['payments'] = $this->listPayments();
        $this->vars['listTitle'] = $this->listTitle;
        $this->vars['formTitle'] = $this->formTitle;
        $this->vars['listPrompt'] = $this->listPrompt;
        $this->vars['formPrompt'] = $this->formPrompt;
        $this->vars['field'] = $this->formField;
        $this->vars['value'] = $this->formField->value;
        $this->vars['title'] = $this->getTitleFromValue();

        $this->vars['listWidget'] = $this->listWidget;
    }

    public function getTitleFromValue()
    {
        if (!$this->relationModel OR !$this->relationModel->{$this->nameFrom}) {
            return null;
        }

        return $this->relationModel->{$this->nameFrom};
    }

    protected function listPayments()
    {
        $relationModel = $this->getRelationModel($this->valueFrom);
        $query = $relationModel->newQuery();

        if ($this->sortPayments)
            $query->sorted();

        return $query->get();
    }

    protected function makeListWidget()
    {
        if (!$config = $this->getConfig('list'))
            return;

        $config['model'] = $model = $this->getRelationModel($this->listFrom);
        $config['alias'] = $this->alias.'historytable';
        $config['showSetup'] = FALSE;
        $config['showCheckboxes'] = FALSE;
        $config['showSorting'] = FALSE;
        $config['pageLimit'] = $this->pageLimit;
        $widget = $this->makeWidget('Admin\Widgets\Lists', $config);

        if ($sqlConditions = $this->conditions) {
            $widget->bindEvent('list.extendQueryBefore', function ($query) use ($sqlConditions) {
                $query->whereRaw($sqlConditions);
            });
        }
        elseif ($scopeMethod = $this->scope) {
            $widget->bindEvent('list.extendQueryBefore', function ($query) use ($scopeMethod) {
                $query->$scopeMethod();
            });
        }
        else {
            $widget->bindEvent('list.extendQueryBefore', function ($query) {
                $query->where($this->model->getKeyName(), $this->model->getKey());
            });
        }

        return $widget;
    }

    public function renderPaymentForm($payment)
    {
        return $payment->renderPaymentForm($this->getController());
    }

    /**
     * Returns the model of a relation type.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationModel($attribute)
    {
        list($model, $attribute) = $this->formField->resolveModelAttribute($this->model, $attribute);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $attribute
            ));
        }

        return $model->makeRelation($attribute);
    }

    /**
     * Returns the model of a relation type.
     * @return \Admin\FormWidgets\Relation
     * @throws \Exception
     */
    protected function getRelationObject($attribute)
    {
        list($model, $attribute) = $this->formField->resolveModelAttribute($this->model, $attribute);

        if (!$model OR !$model->hasRelation($attribute)) {
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $attribute
            ));
        }

        return $model->{$attribute}();
    }
}
