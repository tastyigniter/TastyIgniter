<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
namespace TastyIgniter\Database;

defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as EloquentModel;
use \TastyIgniter\Database\Manager as DatabaseManager;
use \TastyIgniter\Database\Builder;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use InvalidArgumentException;
use Illuminate\Support\Str;

/**
 * TastyIgniter Model Class
 *
 * Uses code from OctoberCMS\Model to handle relationships using array properties
 *
 * @category       Libraries
 * @package        TastyIgniter\Database\Model.php
 * @author         SamPoyigi
 * @author         Alexey Bobkov, Samuel Georges
 * @link           http://docs.tastyigniter.com
 */
class Model extends EloquentModel
{

//	protected $controller;
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
	 *
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
	 * The name of the "created at" column.
	 *
	 * @var string
	 */
	const CREATED_AT = NULL;

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string
	 */
	const UPDATED_AT = NULL;

	public function __construct(array $attributes = [])
	{
		DatabaseManager::init();

		$this->setPerPage($this->config->item('page_limit'));

		parent::__construct($attributes);
	}

	//--------------------------------------------------------------------------
	// OBSERVERS
	//--------------------------------------------------------------------------

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

	//--------------------------------------------------------------------------
	// PAGINATION
	//--------------------------------------------------------------------------

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
	public function getCurrentUrl($url = NULL)
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

	public function tablePrefix($tableName = NULL)
	{
		return $this->queryBuilder()->getTablePrefix() . $tableName;
	}

	public function hasTable($tableName = NULL)
	{
		return $this->queryBuilder()->getSchemaBuilder()->hasTable($tableName);
	}

	public function escape($string = NULL)
	{
		return $this->queryBuilder()->getPdo()->quote($string);
	}

	/**
	 * Fill the model with an array of attributes.
	 *
	 * @param  array $attributes
	 *
	 * @return $this
	 *
	 * @throws \Illuminate\Database\Eloquent\MassAssignmentException
	 */
	public function fill(array $attributes)
	{
		unset($attributes['save_close']);

		return parent::fill($attributes);
	}

	/**
	 * Determine if the model or given attribute(s) have been modified.
	 *
	 * @param  array|string|null $attributes
	 *
	 * @return bool
	 */
	public function isDirty($attributes = NULL)
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
	 * @return \TastyIgniter\Database\Builder|static
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
		return $this->getRelationDefinition($name) !== NULL ? TRUE : FALSE;
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
		if (($type = $this->getRelationType($name)) !== NULL) {
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
				$relation[$key] = NULL;
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