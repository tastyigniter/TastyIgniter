<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Closure;

/**
 * List Columns definition
 * A translation of the list column configuration
 *
 * Adapted from october\backend\classes\ListColumn
 */
class ListColumn
{
    /** Display mode. Text, number */
    public string $type = 'text';

    /** Specifies if this column can be searched. */
    public bool $searchable = false;

    /** Specifies if this column is hidden by default. */
    public bool $invisible = false;

    /** Specifies if this column can be sorted. */
    public bool $sortable = true;

    /** Specifies if this column can be edited. */
    public bool $editable = false;

    /** Model attribute to use for the display value, this will override any $sqlSelect definition. */
    public ?string $valueFrom = null;

    /** Specifies a default value when value is empty. */
    public mixed $defaults = null;

    /** Custom SQL for selecting this record display value, the @ symbol is replaced with the table name.
     */
    public ?string $sqlSelect = null;

    /** Relation name, if this column represents a model relationship. */
    public ?string $relation = null;

    /** sets the column width, can be specified in percents (10%) or pixels (50px).
     * There could be a single column without width specified, it will be stretched to take the
     * available space.
     */
    public ?string $width = null;

    /** Specify a CSS class to attach to the list cell element. */
    public ?string $cssClass = null;

    /** Contains a list of attributes specified in the list configuration used by button type. */
    public array $attributes = [];

    /** Specify a format or style for the column value, such as a Date. */
    public ?string $format = null;

    /** Specifies a path for partial-type fields. */
    public ?string $path = null;

    /** Specifies a icon cssClass */
    public ?Closure $formatter = null;

    /** Specifies a icon cssClass */
    public ?string $iconCssClass = null;

    /** Raw field configuration. */
    public array $config = [];

    public function __construct(public string $columnName, public ?string $label = null) {}

    /**
     * Specifies a list column rendering mode. Supported modes are:
     * - text - text column, aligned left
     * - number - numeric column, aligned right
     *
     * @param string $type Specifies a render mode as described above
     */
    public function displayAs(?string $type, array $config = []): self
    {
        $this->type = strtolower($type ?: $this->type);
        $this->config = $this->evalConfig($config);

        return $this;
    }

    /**
     * Process options and apply them to this object.
     */
    protected function evalConfig(array $config): array
    {
        if (isset($config['width'])) {
            $this->width = $config['width'];
        }

        if (isset($config['cssClass'])) {
            $this->cssClass = $config['cssClass'];
        }

        if (isset($config['searchable'])) {
            $this->searchable = $config['searchable'];
        }

        if (isset($config['sortable'])) {
            $this->sortable = $config['sortable'];
        }

        if (isset($config['editable'])) {
            $this->editable = $config['editable'];
        }

        if (isset($config['invisible'])) {
            $this->invisible = $config['invisible'];
        }

        if (isset($config['valueFrom'])) {
            $this->valueFrom = $config['valueFrom'];
        }

        if (isset($config['default'])) {
            $this->defaults = $config['default'];
        }

        if (isset($config['select'])) {
            $this->sqlSelect = $config['select'];
        }

        if (isset($config['relation'])) {
            $this->relation = $config['relation'];
        }

        if (isset($config['attributes'])) {
            $this->attributes = $config['attributes'];
        }

        if (isset($config['format'])) {
            $this->format = $config['format'];
        }

        if (isset($config['path'])) {
            $this->path = $config['path'];
        }

        if (isset($config['formatter'])) {
            $this->formatter = $config['formatter'];
        }

        if (isset($config['iconCssClass'])) {
            $this->iconCssClass = $config['iconCssClass'];
        }

        return $config;
    }

    /**
     * Returns a HTML valid name for the column name.
     */
    public function getName(): string
    {
        return name_to_id($this->columnName);
    }

    /**
     * Returns a value suitable for the column id property.
     */
    public function getId(?string $suffix = null): string
    {
        $id = 'column';

        $id .= '-'.$this->columnName;

        if ($suffix) {
            $id .= '-'.$suffix;
        }

        return name_to_id($id);
    }
}
