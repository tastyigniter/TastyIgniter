<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
namespace Igniter\Database;

defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Igniter\Database\Manager as DatabaseManager;

/**
 * TastyIgniter Model Class
 *
 * Uses code from OctoberCMS\Model to handle relationships using array properties
 *
 * @category       Libraries
 * @package        Igniter\Database\Model.php
 * @author         SamPoyigi
 * @author         Alexey Bobkov, Samuel Georges
 * @link           http://docs.tastyigniter.com
 */
class Model extends EloquentModel
{

	public $timestamps = FALSE;

	protected $guarded = [];

	/**
	 * The loaded relationships for the model.
	 *
	 * It should be declared with keys as the relation name, and value being a mixed array.
	 * The relation type $morphTo does not include a classname as the first value.
	 *
	 * ex:
	 * 1. string $table_name table name value mode, model_name, foreign key is auto-generated,
	 * by appending _id to the singular table_name
	 * $hasOne = [$relation => $model) associative array mode
	 * $hasMany = [$relation => [$model]] associative array mode
	 * $belongsTo = [$relation, [$model, 'foreignKey' => $foreignKey]] custom key/value mode
	 * $hasMany = [$relation, [$model, 'foreignKey' => $foreignKey, 'localKey' => $localKey]] custom key/value mode
	 * $belongsToMany = [$relation, [$model, 'foreignKey' => $foreignKey, 'localKey' => $localKey]] custom key/value
	 * mode
	 * $morphOne = [$relation, [$model, 'name' => 'name']] custom key/value mode
	 * $morphMany = [$relation, [$model, 'table' => 'table_name', 'name' => 'name']] custom key/value mode
	 */
	public $hasMany = [];
	public $hasOne = [];
	public $belongsTo = [];
	public $belongsToMany = [];
	public $morphTo = [];
	public $morphOne = [];
	public $morphMany = [];
	public $morphToMany = [];
	public $morphedByMany = [];
	public $attachOne = [];
	public $attachMany = [];
	public $hasManyThrough = [];

	/**
	 * @var array Excepted relationship types, used to cycle and verify relationships.
	 */
	protected static $relationTypes = ['hasOne', 'hasMany', 'belongsTo', 'belongsToMany', 'morphTo', 'morphOne',
		'morphMany', 'morphToMany', 'morphedByMany', 'attachOne', 'attachMany', 'hasManyThrough'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * New Custom types: serialize, time
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = null;

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = null;

	public function __construct(array $attributes = [])
	{
		DatabaseManager::init();

		$this->setPerPage($this->config->item('page_limit'));

		parent::__construct($attributes);
	}

	public function setUpdatedAt($value)
	{
		if (!is_null(static::UPDATED_AT)) $this->{static::UPDATED_AT} = $value;

		return $this;
	}

	public function setCreatedAt($value)
	{
		if (!is_null(static::CREATED_AT)) $this->{static::CREATED_AT} = $value;

		return $this;
	}

	public function getCount($filter = [])
	{
		$filterQuery = $this->getFilterQuery();

		if (!empty($filter))
			$filterQuery = $this->filter($filter);

		return $filterQuery ? $filterQuery->count() : 0;
	}

	public function getList($filter = [])
	{
		$filterQuery = $this->getFilterQuery();

		if (!empty($filter))
			$filterQuery = $this->filter($filter);

		return $filterQuery ? $filterQuery->paginate($filter)->list : [];
	}

	public function setFilterQuery(Builder $query)
	{
		$this->filterQuery = $query;

		return $this;
	}

	public function getFilterQuery()
	{
		return $this->filterQuery;
	}

	public function buildPaginateHtml($config = [])
	{
		if (!isset($this->pagination)) {
			$this->load->library('pagination');
		}

		$this->pagination->initialize($config);

		return [
			'info'  => $this->pagination->create_infos(),
			'links' => $this->pagination->create_links(),
		];
	}

	/**
	 * Return the pagination links base url
	 *
	 * @param $url
	 *
	 * @return string
	 */
	public function getCurrentUrl($url = null)
	{
		$current_url = ($url != 'page') ? $url : current_url();

		if (strpos($current_url, '?') !== FALSE) {
			$current_url = explode('?', $current_url);
			parse_str($current_url[1], $get_data);
			unset($get_data['page']);
			$current_url = $current_url[0] . '?' . http_build_query($get_data);
		}

		return $current_url;
	}

	public function queryBuilder()
	{
		return $this->getConnection();
	}

	public function tablePrefix($tableName = null)
	{
		return $this->queryBuilder()->getTablePrefix() . $tableName;
	}

	public function hasTable($tableName = null)
	{
		return $this->queryBuilder()->getSchemaBuilder()->hasTable($tableName);
	}

	public function escape($string = null)
	{
		return $this->queryBuilder()->getPdo()->quote($string);
	}

	/**
	 * Fill the model with an array of attributes.
	 *
	 * @param  array $attributes
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 *
	 * @throws \Illuminate\Database\Eloquent\MassAssignmentException
	 */
	public function fill(array $attributes)
	{
		unset($attributes['save_close']);

		return parent::fill($attributes);
	}

	/**
	 * Cast an attribute to a native PHP type.
	 * Cast an attribute to a native PHP type.
	 *
	 * @param  string $key
	 * @param  mixed $value
	 *
	 * @return mixed
	 */
	protected function castAttribute($key, $value)
	{
		if (is_null($value)) {
			return $value;
		}

		switch ($this->getCastType($key)) {
			case 'int':
			case 'integer':
				return (int)$value;
			case 'real':
			case 'float':
			case 'double':
				return (float)$value;
			case 'string':
				return (string)$value;
			case 'bool':
			case 'boolean':
				return (bool)$value;
			case 'object':
				return $this->fromJson($value, TRUE);
			case 'array':
			case 'json':
				return $this->fromJson($value);
			case 'collection':
				return new BaseCollection($this->fromJson($value));
			case 'date':
			case 'datetime':
				return $this->asDateTime($value);
			case 'timestamp':
				return $this->asTimeStamp($value);
			case 'time':
				return $this->asTime($value);
			case 'serialize':
				return $this->fromSerialized($value);
			default:
				return $value;
		}
	}

	/**
	 * Set a given attribute on the model.
	 *
	 * @param  string $key
	 * @param  mixed $value
	 *
	 * @return self
	 */
	public function setAttribute($key, $value)
	{
		// First we will check for the presence of a mutator for the set operation
		// which simply lets the developers tweak the attribute as it is set on
		// the model, such as "json_encoding" an listing of data for storage.
		if ($this->hasSetMutator($key)) {
			$method = 'set' . Str::studly($key) . 'Attribute';

			return $this->{$method}($value);
		}

		// If an attribute is listed as a "date", we'll convert it from a DateTime
		// instance into a form proper for storage on the database tables using
		// the connection grammar's date format. We will auto set the values.
		elseif ($value && (in_array($key, $this->getDates()) || $this->isDateCastable($key))) {
			$value = $this->fromDateTime($value);
		} elseif ($value && $this->isTimeCastable($key)) {
			$value = $this->fromTime($value);
		}

		if ($value && $this->isSerializedCastable($key)) {
			$value = $this->asSerialized($value);
		}

		if ($this->isJsonCastable($key) && !is_null($value)) {
			$value = $this->asJson($value);
		}

		// If this attribute contains a JSON ->, we'll set the proper value in the
		// attribute's underlying array. This takes care of properly nesting an
		// attribute in the array's value in the case of deeply nested items.
		if (Str::contains($key, '->')) {
			return $this->fillJsonAttribute($key, $value);
		}

		$this->attributes[$key] = $value;

		return $this;
	}

	protected function asSerialized($value)
	{
		return isset($value) ? serialize($value) : null;
	}

	public function fromSerialized($value)
	{
		return isset($value) ? @unserialize($value) : null;
	}

	protected function isSerializedCastable($key)
	{
		return $this->hasCast($key, ['serialize']);
	}

	protected function asTime($value)
	{
		// If this value is already a Carbon instance, we shall just return it as is.
		// This prevents us having to re-instantiate a Carbon instance when we know
		// it already is one, which wouldn't be fulfilled by the DateTime check.
		if ($value instanceof Carbon) {
			return $value;
		}

		// If the value is already a DateTime instance, we will just skip the rest of
		// these checks since they will be a waste of time, and hinder performance
		// when checking the field. We will just return the DateTime right away.
		if ($value instanceof DateTimeInterface) {
			return new Carbon(
				$value->format('Y-m-d H:i:s.u'), $value->getTimezone()
			);
		}

		// If this value is an integer, we will assume it is a UNIX timestamp's value
		// and format a Carbon object from this timestamp. This allows flexibility
		// when defining your date fields as they might be UNIX timestamps here.
		if (is_numeric($value)) {
			return Carbon::createFromTimestamp($value);
		}

		// If the value is in simply year, month, day format, we will instantiate the
		// Carbon instances from that format. Again, this provides for simple date
		// fields on the database, while still supporting Carbonized conversion.
		if (preg_match('/^(\d{1,2}):(\d{2}):(\d{2})$/', $value)) {
			return Carbon::createFromFormat('H:i:s', $value);
		}

		// Finally, we will just assume this date is in the format used by default on
		// the database connection and use that format to create the Carbon object
		// that is returned back out to the developers after we convert it here.
		return Carbon::createFromFormat($this->getTimeFormat(), $value);
	}

	/**
	 * Convert a Carbon Time to a storable string.
	 *
	 * @param  \Carbon\Carbon|int $value
	 *
	 * @return string
	 */
	public function fromTime($value)
	{
		$format = $this->getTimeFormat();

		$value = $this->asTime($value);

		return $value->format($format);
	}

	/**
	 * Determine whether a value is Time castable for inbound manipulation.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	protected function isTimeCastable($key)
	{
		return $this->hasCast($key, ['time']);
	}

	/**
	 * Get the format for database stored times.
	 *
	 * @return string
	 */
	protected function getTimeFormat()
	{
//		return $this->timeFormat ?: $this->getConnection()->getQueryGrammar()->getTimeFormat();
		return $this->timeFormat ?: 'h:i:s';
	}

	/**
	 * Set the time format used by the model.
	 *
	 * @param  string $format
	 *
	 * @return self
	 */
	public function setTimeFormat($format)
	{
		$this->timeFormat = $format;

		return $this;
	}

	/**
	 * Determine if the model or given attribute(s) have been modified.
	 *
	 * @param  array|string|null $attributes
	 *
	 * @return bool
	 */
	public function isDirty($attributes = null)
	{
		$dirty = $this->getDirty();

		if (is_null($attributes)) {
			return count($dirty) > 0;
		}

		if (!is_array($attributes)) {
			$attributes = func_get_args();
		}

		foreach ($attributes as $attribute) {
			if (array_key_exists($attribute, $dirty) AND !is_null($dirty[$attribute])) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Create a new Eloquent query builder for the model.
	 *
	 * @param  \Illuminate\Database\Query\Builder $query
	 *
	 * @return \Igniter\Database\Builder
	 */
	public function newEloquentBuilder($query)
	{
		return new Builder($query);
	}

	/**
	 * Get the default foreign key name for the model.
	 *
	 * @return string
	 */
	public function getForeignKey()
	{
		return Str::snake(Str::singular(str_replace('_model', '', class_basename($this)))) . '_id';
	}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param    string $key
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		if (isset(get_instance()->$key)) {
			return get_instance()->$key;
		} else {

			$parent = get_parent_class();
			if ($parent !== FALSE AND method_exists($parent, '__get')) {
				return parent::__get($key);
			}
		}
	}

	/**
	 * Handle dynamic method calls into the model.
	 *
	 * @param  string $method
	 * @param  array $parameters
	 *
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		if ($this->hasRelation($method))
			return $this->handleRelation($method);

		$parent = get_parent_class();
		if ($parent !== FALSE && method_exists($parent, '__call')) {
			return parent::__call($method, $parameters);
		}
	}

	public function hasRelation($name)
	{
		return $this->getRelationDefinition($name) !== null ? TRUE : FALSE;
	}

	/**
	 * Returns relationship details from a supplied name.
	 *
	 * @param string $name Relation name
	 *
	 * @return array
	 */
	public function getRelationDefinition($name)
	{
		if (($type = $this->getRelationType($name)) !== null) {
			return $this->getRelationArray($name, $type);
		}
	}

	/**
	 * Get the joining table/model name for relation.
	 * array('categories')
	 * array('categories' => 'Category_model')
	 * array('categories' => array('Category_model', 'foreignKey', 'primaryKey'))
	 *
	 * @param string $relationName
	 * @param $relationType
	 *
	 * @return string
	 */
	public function getRelationArray($relationName, $relationType)
	{
		$defaults = ['model', 'foreignKey', 'primaryKey'];
		$options = (array)$this->{$relationType}[$relationName];

		if (is_array($options) AND isset($options[0])) {
			$count = min(count($defaults), count($options));
			$options = array_combine(array_slice($defaults, 0, $count), array_slice($options, 0, $count));
//		} else if (is_string($options) AND strpos($options, '_model') === FALSE) {
//			$relationName = $options;
//			$options = ['model' => ucfirst($relationName) . '_model'];
		} else if (is_string($options)) {
			$options = ['model' => ucfirst($options)];
		}

		return $options + $this->getRelationDefaults($relationType);
	}

	/**
	 * Returns a relationship type based on a supplied name.
	 *
	 * @param string $name Relation name
	 *
	 * @return string
	 */
	public function getRelationType($name)
	{
		foreach (static::$relationTypes as $type) {
			if (isset($this->{$type}[$name])) {
				return $type;
			}
		}
	}

	/**
	 * Returns default relation arguments for a given type.
	 *
	 * @param string $type Relation type
	 *
	 * @return array
	 */
	protected function getRelationDefaults($type)
	{
		switch ($type) {
			case 'attachOne':
			case 'attachMany':
				return ['order' => 'sort_order', 'delete' => TRUE];

			default:
				return [];
		}
	}

	public function handleRelation($relationName)
	{
		$relationType = $this->getRelationType($relationName);
		$relation = $this->getRelationDefinition($relationName);

		if (!isset($relation['model']) && $relationType != 'morphTo')
			throw new InvalidArgumentException(sprintf(
				"Relation '%s' on model '%s' should have at least a classname.", $relationName, get_called_class()
			));

		if (isset($relation['model']) && $relationType == 'morphTo')
			throw new InvalidArgumentException(sprintf(
				"Relation '%s' on model '%s' is a morphTo relation and should not contain additional arguments.", $relationName, get_called_class()
			));

		switch ($relationType) {
			case 'hasOne':
			case 'hasMany':
				$relation = $this->validateRelationArgs($relationName, ['key', 'otherKey']);
				$relationObj = $this->$relationType($relation['model'], $relation['key'], $relation['otherKey'], $relationName);
				break;

			case 'belongsTo':
				$relation = $this->validateRelationArgs($relationName, ['key', 'otherKey']);
				$relationObj = $this->$relationType($relation['model'], $relation['key'], $relation['otherKey'], $relationName);
				break;

			case 'belongsToMany':
				$relation = $this->validateRelationArgs($relationName, ['table', 'key', 'otherKey', 'pivot', 'timestamps']);
				$relationObj = $this->$relationType($relation['model'], $relation['table'], $relation['key'], $relation['otherKey'], $relationName);
				break;

			case 'morphTo':
				$relation = $this->validateRelationArgs($relationName, ['name', 'type', 'id']);
				$relationObj = $this->$relationType($relation['name'] ?: $relationName, $relation['type'], $relation['id']);
				break;

			case 'morphOne':
			case 'morphMany':
				$relation = $this->validateRelationArgs($relationName, ['type', 'id', 'key'], ['name']);
				$relationObj = $this->$relationType($relation['model'], $relation['name'], $relation['type'], $relation['id'], $relation['key'], $relationName);
				break;

			case 'morphToMany':
				$relation = $this->validateRelationArgs($relationName, ['table', 'key', 'otherKey', 'pivot', 'timestamps'], ['name']);
				$relationObj = $this->$relationType($relation['model'], $relation['name'], $relation['table'], $relation['key'], $relation['otherKey'], FALSE, $relationName);
				break;

			case 'morphedByMany':
				$relation = $this->validateRelationArgs($relationName, ['table', 'key', 'otherKey', 'pivot', 'timestamps'], ['name']);
				$relationObj = $this->$relationType($relation['model'], $relation['name'], $relation['table'], $relation['key'], $relation['otherKey'], $relationName);
				break;

			case 'attachOne':
			case 'attachMany':
				$relation = $this->validateRelationArgs($relationName, ['public', 'key']);
				$relationObj = $this->$relationType($relation['model'], $relation['public'], $relation['key'], $relationName);
				break;

			case 'hasManyThrough':
				$relation = $this->validateRelationArgs($relationName, ['key', 'throughKey', 'otherKey'], ['through']);
				$relationObj = $this->$relationType($relation['model'], $relation['through'], $relation['key'], $relation['throughKey'], $relation['otherKey']);
				break;

			default:
				throw new InvalidArgumentException(sprintf("There is no such relation type known as '%s' on model '%s'.", $relationType, get_called_class()));
		}

		return $relationObj;
	}

	/**
	 * Validate relation supplied arguments.
	 */
	protected function validateRelationArgs($relationName, $optional, $required = [])
	{
		$relation = $this->getRelationDefinition($relationName);

		// Query filter arguments
		$filters = ['scope', 'conditions', 'order', 'pivot', 'timestamps', 'push', 'count'];

		foreach (array_merge($optional, $filters) as $key) {
			if (!array_key_exists($key, $relation)) {
				$relation[$key] = null;
			}
		}

		$missingRequired = [];
		foreach ($required as $key) {
			if (!array_key_exists($key, $relation)) {
				$missingRequired[] = $key;
			}
		}

		if ($missingRequired) {
			throw new InvalidArgumentException(sprintf('Relation "%s" on model "%s" should contain the following key(s): %s',
				$relationName,
				get_called_class(),
				implode(', ', $missingRequired)
			));
		}

		return $relation;
	}

}
