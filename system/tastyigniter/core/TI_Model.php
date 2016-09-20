<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Model Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Model.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Model extends CI_Model
{
	/**
	 * @var string Error messagess that can be used in UI error reporting.
	 */
	public $error = '';

	/**
	 * Your database table, if not set the name will be guessed
	 */
	protected $tables = array();

	/**
	 * Your database table, if not set the name will be guessed
	 */
	protected $table_name = NULL;

	/**
	 * The primary key name, by default set to 'id'
	 */
	protected $primary_key = NULL;

	/**
	 * @var boolean Enable/Disable soft deletes.
	 *
	 * If false, the delete() method will perform a delete of that row.
	 * If true, the value in $deleted_field will be set to 1.
	 */
	protected $soft_delete = FALSE;
	protected $temp_with_deleted = FALSE;
	protected $temp_only_deleted = FALSE;

	/**
	 * @var string Field name to use for the deleted column in the DB table if
	 * $soft_deletes is enabled.
	 */
	protected $deleted_field = 'date_deleted';

	/**
	 * @var bool Whether to auto-fill the $timestamps on inserts/updates.
	 */
	protected $timestamps = array(); // OR
//    protected $timestamps = array('created', 'updated');  //OR
//    protected $timestamps = array('created' => 'date_added', 'updated' => 'date_updated');

	/**
	 * @var string The date/time format to use when converting.
	 *
	 * Valid values are 'int', 'datetime', 'date'.
	 */
	protected $date_format = 'datetime';

	/**
	 * @var string The fields that should be converted to dates.
	 */
	protected $dates = array();

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = array();

	/**
	 * The attributes to append to the model array.
	 *
	 * @var array
	 */
	protected $appends = array();

	/**
	 * The database table fields, used for filtering data arrays before inserting and updating
	 * If not set, an additional query will be made to fetch these fields
	 */
	protected $fields = array();

	/**
	 * Callbacks, should contain an array of methods
	 */
	protected $before_create = array();
	protected $after_create = array();
	protected $before_update = array();
	protected $after_update = array();
	protected $before_save = array();
	protected $after_save = array();
	protected $before_get = array();
	protected $after_get = array();
	protected $before_delete = array();
	protected $after_delete = array();

	/** @var string[] Protected, non-modifiable attributes. */
	protected $protected_attributes = array();

	/**
	 * The loaded relationships for the model. Relationship arrays has 4 modes:
	 * 1. string $table_name table name value mode, model_name, foreign key is auto-generated,
	 * by appending _id to the singular table_name
	 * 2. array($relation => array($model)) associative array mode
	 * 3. array($relation, array($model, $foreign_key, $primary_key)) custom key/value mode
	 * 3. array($relation, array('model' => $model, 'foreign_key' => $foreign_key, 'primary_key'
	 * => $primary_key)) custom key/value mode
	 *
	 */
	protected $belongs_to = array();
	protected $belongs_to_many = array();
	protected $has_one = array();
	protected $has_many = array();
	protected $with = array();

	/**
	 * Database result mode, choose between object and array
	 * Depending on this value result() or result_array() will be used internally
	 */
	protected $return_type = 'array';

	/**
	 * @var string Holds the return type temporarily
	 */
	protected $temp_return_type = 'array';

	/**
	 * Validation rules, should contain validation arrays like the form validation
	 *
	 * @see http://www.codeigniter.com/user_guide/libraries/form_validation.html#validationrulesasarray
	 */
	protected $rules = array();

	/**
	 * Skip the validation
	 */
	protected $skip_validation = FALSE;

	public function __construct($config = array()) {
		// When loading the model, make sure the db class is loaded.
		if (!isset($this->db)) {
			$this->load->database();
		}

		// Always convert attributes.
		array_unshift($this->after_get, 'convert_attributes');

		// Always protect attributes.
		array_unshift($this->before_create, 'protect_attributes');
		array_unshift($this->before_update, 'protect_attributes');

		// Check the auto-set features and make sure they are loaded into the
		// observer system.
		if (isset($this->get_timestamps()['created'])) {
			array_unshift($this->before_create, 'created_on');
		}

		if (isset($this->get_timestamps()['updated'])) {
			array_unshift($this->before_update, 'updated_on');
		}

		$class = str_replace($this->config->item('subclass_prefix'), '', get_class($this));
		log_message('info', $class . '  Model Class Initialized');
	}

	/**
	 * Magic function that passes unrecognized method calls to the database class for chaining
	 *
	 * @param string $method
	 * @param array  $params
	 *
	 * @return $this
	 */
	public function __call($method, $params) {
		if (method_exists($this, $method)) {
			call_user_func_array(array($this, $method), $params);

			return $this;
		} else if (method_exists($this->db, $method)) {
			call_user_func_array(array($this->db, $method), $params);

			return $this;
		}
	}

	/**
	 * Find a single record with matching optional WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 *
	 * @return bool|array
	 */
	public function find() {
		$where = func_get_args();

		if ($this->soft_delete AND $this->temp_with_deleted !== TRUE) {
			$this->db->where($this->get_deleted_field(), (bool)$this->temp_only_deleted);
		}

		$this->_set_where($where);

		$this->trigger('before_get');

		$query = $this->db->get($this->table_name);

		if (!$query->num_rows()) return FALSE;

		$result = $query->{$this->_return_type()}();

		$result = $this->trigger('after_get', array($result));

		if ($this->temp_return_type == 'json') {
			$result = json_encode($result);
		}

		$this->temp_return_type = $this->return_type;

		return $result;
	}

	/**
	 * Find all records from the database
	 *
	 * @return bool|array
	 */
	public function find_all() {
		$where = func_get_args();

		if ($this->soft_delete AND $this->temp_with_deleted !== TRUE) {
			$this->db->where($this->get_deleted_field(), (bool)$this->temp_only_deleted);
		}

		$this->_set_where($where);

		$this->trigger('before_get');

		$query = $this->db->get($this->table_name);

		$result = $query->{$this->_return_type(TRUE)}();

		foreach ($result as &$row) {
			$row = $this->trigger('after_get', array($row));
		}

		if ($this->temp_return_type == 'json') {
			$result = json_encode($result);
		}

		$this->temp_return_type = $this->return_type;

		return $result;
	}

	/**
	 * Runs the select query based on the other functions called
	 *
	 * @param string $table_name
	 *
	 * @return bool|array
	 */
	public function get($table_name = '') {
		$this->trigger('before_get');

		$query = $this->db->get($table_name);

		$result = $query->{$this->_return_type()}();

		$result = $this->trigger('after_get', array($result));

		if ($this->temp_return_type == 'json') {
			$result = json_encode($result);
		}

		$this->temp_return_type = $this->return_type;

		return $result;
	}

	/**
	 * Runs the select query based on the other functions called
	 *
	 * @param string $table_name
	 *
	 * @return bool|array
	 */
	public function get_many($table_name = '') {
		$this->trigger('before_get');

		$query = $this->db->get($table_name);

		$result = $query->{$this->_return_type(TRUE)}();

		foreach ($result as &$row) {
			$row = $this->trigger('after_get', array($row));
		}

		if ($this->temp_return_type == 'json') {
			$result = json_encode($result);
		}

		$this->temp_return_type = $this->return_type;

		return $result;
	}

	/**
	 * Insert a new record into the database
	 * Returns the insert ID
	 *
	 * @param array $data
	 * @param bool  $skip_validation
	 *
	 * @return integer
	 */
	public function insert($data, $skip_validation = FALSE) {
		$valid = TRUE;

		if ($skip_validation === FALSE) {
			$valid = $this->validate($data);
		}

		if ($valid === FALSE) {
			return FALSE;
		}

		$data = $this->trigger('before_create', $data);

		$this->fill($data);

		$this->db->insert($this->table_name);
		$result = $this->db->insert_id();

		$this->trigger('after_create', array($data, $result));

		if ($result === FALSE) {
			$this->error = sprintf(lang('ti_model_db_error'), $this->get_db_error_message());
		}

		return $result;
	}

	/**
	 * Perform a batch insert of data into the database.
	 *
	 * @param array $data an array of key/value pairs to insert.
	 *
	 * @return bool True on success, or false on failure.
	 */
	public function insert_batch($data = NULL) {
		if (is_null($data)) {
			return FALSE;
		}

		$set = array();

		if (!empty($set)) {
			foreach ($data as $key => &$record) {
				$record = $this->trigger('before_create', $record);
				$data[$key] = array_merge($set, $data[$key]);
			}
		}

		$result = $this->db->insert_batch($this->table_name, $data);

		if ($result === FALSE) {
			$this->error = sprintf(lang('ti_model_db_error'), $this->get_db_error_message());
		}

		return $result;
	}

	/**
	 * Insert a new record into the specified database table
	 * Returns the insert ID
	 *
	 * @param string $table_name
	 * @param array  $data
	 *
	 * @return int
	 */
	public function insert_into($table_name, $data) {
		return $this->db->insert($table_name, $data);
	}

	/**
	 * Update a record, specified by an ID.
	 *
	 * @param mixed $where
	 * @param array $data
	 * @param bool  $skip_validation
	 *
	 * @return int
	 */
	public function update($where = NULL, $data, $skip_validation = FALSE) {
		$valid = TRUE;

		if ($skip_validation === FALSE) {
			$valid = $this->validate($data);
		}

		if ($valid === FALSE) {
			return FALSE;
		}

		$this->_set_where(isset($where[0]) ? $where : array($where));
//		$this->_set_where(array($where));

		$data = $this->trigger('before_update', $data);

		$this->fill($data);

		$result = $this->db->update($this->table_name);

		$this->trigger('after_update', array($data, $result));

		if ($result === FALSE) {
			$this->error = sprintf(lang('ti_model_db_error'), $this->get_db_error_message());
		}

		return $result;
	}

	/**
	 * Update a batch of existing rows in the database.
	 *
	 * @param array  $data  An array of key/value pairs to update.
	 * @param string $index The name of the db column to use as the where key.
	 *
	 * @return boolean True on successful update, else false.
	 */
	public function update_batch($data = NULL, $index = NULL) {
		if (is_null($index) OR is_null($data)) {
			return FALSE;
		}

		$set = array();
		if (!empty($set)) {
			foreach ($data as $key => &$record) {
				$record = $this->trigger('before_update', $record);
				$data[$key] = array_merge($set, $data[$key]);
			}
		}

		$result = $this->db->update_batch($this->table_name, $data, $index);

		if ($result === FALSE) {
			$this->error = sprintf(lang('ti_model_db_error'), $this->get_db_error_message());

			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Update a record, specified by a table and an ID.
	 *
	 * @param string $table_name
	 * @param mixed  $where
	 * @param array  $data
	 *
	 * @return int
	 */
	public function update_into($table_name, $where = NULL, $data) {
		return $this->db->update($table_name, $data, $where);
	}

	/**
	 * Save a record, insert or update.
	 *
	 * @param       $where $id
	 * @param array $data
	 * @param bool  $skip_validation
	 *
	 * @return int
	 */
	public function save($data = NULL, $where = NULL, $skip_validation = FALSE) {

		$data = $this->trigger('before_save', array($data, $where));

		if (!is_array($where)) {
			$where = array($this->primary_key => $where);
		}

		if ($original_data = $this->find($where)) {
			$result = $this->update($where, $data, $skip_validation);
		} else {
			$result = $this->insert($data, $skip_validation);
		}

		$this->trigger('after_save', array($data, $where, $result));

		if ($result === FALSE) {
			return FALSE;
		} else if (is_numeric($result)) {
			return $result;
		} else if ($result AND isset($where[$this->primary_key])) {
			return $where[$this->primary_key];
		} else {
			return $result;
		}
	}

	/**
	 * Delete a row from the database based on a WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 *
	 * @return bool
	 */
	public function delete() {
		$where = func_get_args();

		$where = $this->trigger('before_delete', array($where));

		$this->_set_where($where);

		if ($this->soft_delete === TRUE) {
			$result = $this->db->update($this->table_name, array($this->deleted_field => $this->set_date(NULL, 'datetime')));
		} else {
			$result = $this->db->delete($this->table_name);
		}

		$this->trigger('after_delete', array($where, $result));

		if (!$result) {
			$this->error = sprintf(lang('ti_model_db_error'), $this->get_db_error_message());
		}

		return $this->db->affected_rows();
	}

	/**
	 * Delete a row from the specified database based on a WHERE parameters
	 *
	 * @param string $table
	 * @param array  $where
	 *
	 * @return bool
	 */
	public function delete_from($table, $where = array()) {
		return $this->db->delete($table, $where);
	}

	//--------------------------------------------------------------------------
	// HELPER METHODS
	//--------------------------------------------------------------------------

	/**
	 * Check whether a field/value pair exists within the table.
	 *
	 * @param string $field The name of the field to search
	 * @param string $value The value to match $field against.
	 *
	 * @return boolean True if the value does not exist, else false.
	 */
	public function is_unique() {
		$where = func_get_args();

		if (count($where) > 0) {
			$this->_set_where($where);
		}

		$query = $this->db->get($this->table_name);

		if ($query AND $query->num_rows() == 0) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Count the number of rows based on a WHERE parameters
	 *
	 * @param string $key
	 * @param string $val
	 *
	 * @return integer
	 */
	public function count() {
		$where = func_get_args();

		if ($this->soft_delete AND $this->temp_with_deleted !== TRUE) {
			$this->db->where($this->get_deleted_field(), (bool)$this->temp_only_deleted);
		}

		$where = $this->trigger('before_get', array($where));

		$this->_set_where($where);

		return $this->db->count_all_results($this->table_name);
	}

	/**
	 * Return a count of every row in the table
	 *
	 * @return integer
	 */
	public function count_all() {
		if ($this->soft_delete AND $this->temp_with_deleted !== TRUE) {
			$this->db->where($this->get_deleted_field(), (bool)$this->temp_only_deleted);
		}

		return $this->db->count_all($this->table_name);
	}

	/**
	 * Determine if the model table exists
	 *
	 * @param string $table
	 *
	 * @return bool
	 */
	public function table_exists($table = '') {
		return array_key_exists($table, $this->list_tables());
	}

	/**
	 * An easier limit function
	 *
	 * @param integer $limit
	 * @param integer $offset
	 *
	 * @return $this
	 */
	public function limit($limit = NULL, $offset = NULL) {
		if (is_numeric($limit) AND is_numeric($offset)) {
			$this->db->limit($limit, ($offset - 1) * $limit);
		} elseif (is_numeric($limit)) {
			$this->db->limit($limit);
		}

		return $this;
	}

	/**
	 * An easier order_by function
	 *
	 * @param string|array $sort_by
	 * @param string       $order_by
	 *
	 * @return $this
	 */
	public function order_by($sort_by = NULL, $order_by = 'ASC') {
		if (is_string($sort_by)) {
			$this->db->order_by($sort_by, $order_by);
		} elseif (is_array($sort_by)) {
			foreach ($sort_by as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		return $this;
	}

	/**
	 * An easier escape function
	 *
	 * @param string $escape
	 *
	 * @return string
	 */
	public function escape($escape = NULL) {
		return $this->db->escape($escape);
	}

	/**
	 * An easier database table prefix function
	 *
	 * @param string $table
	 *
	 * @return string
	 */
	public function table_prefix($table = NULL) {
		$table = ($table === NULL) ? $this->table_name : $table;

		return $this->db->dbprefix($table);
	}

	/**
	 * List all table fields
	 *
	 * @return array $fields
	 */
	public function list_fields() {
		return $this->db->list_fields($this->table_name);
	}

	/**
	 * List all table
	 *
	 * @return array $fields
	 */
	public function list_tables() {
		if (empty($this->tables)) $this->tables = $this->db->list_tables();

		return $this->tables;
	}

	/**
	 * A convenience method to return only a single field of the specified row.
	 *
	 * @param mixed  $where The key/value pair to match against.
	 * @param string $field The field to search for.
	 *
	 * @return bool|mixed The value of the field.
	 */
	public function get_field($where = NULL, $field = '') {
		$this->db->select($field);

		$this->_set_where($where);

		$query = $this->db->get($this->table_name);

		if ($query AND $query->num_rows() > 0) {
			return $query->row()->$field;
		}

		return FALSE;
	}

	/**
	 * Retrieve and generate a dropdown-friendly array of the data
	 * in the table based on a key and a value.
	 *
	 * @param string $key
	 * @param string $value
	 *
	 * @return array $options
	 */
	public function dropdown() {
		$args = func_get_args();

		if (count($args) == 2) {
			list($key, $value) = $args;
		} else {
			$key = $this->primary_key;
			$value = $args[0];
		}

		$this->trigger('before_get', array($key, $value));

		if ($this->soft_delete AND $this->temp_with_deleted !== TRUE) {
			$this->db->where($this->get_deleted_field(), NULL);
		}

		$result = $this->db->select(array($key, $value))->get($this->table_name)->result_array();

		$options = array();
		foreach ($result as $row) {
			$row = $this->trigger('after_get', array($row));
			$options[$row[$key]] = $row[$value];
		}

		return $options;
	}

	//--------------------------------------------------------------------------
	// RELATIONSHIPS
	// ------------------------------------------------------------

	/**
	 * Build relations to join on the modal.
	 *
	 * @param string|array $relations
	 *
	 * @return $this
	 */
	public function with($relations) {
		$relations = is_string($relations) ? func_get_args() : $relations;

		$this->relate($relations);

		return $this;
	}

	/**
	 * Join relations on the model.
	 *
	 * @param array $relations
	 *
	 * @return mixed
	 */
	public function relate($relations) {
		if (empty($relations)) {
			return $this;
		}

		foreach ($this->belongs_to as $key => $value) {
			list($relation, $options) = $this->get_relation($key, $value);

			if (in_array($relation, $relations)) {
				$this->_relate($options);
			}
		}

		foreach ($this->has_one as $key => $value) {
			list($relation, $options) = $this->get_relation($key, $value);

			if (in_array($relation, $relations)) {
				$this->_relate($options);
			}
		}

		foreach ($this->has_many as $key => $value) {
			list($relation, $options) = $this->get_relation($key, $value);

			if (in_array($relation, $relations)) {
				$this->_relate($options);
			}
		}

		return $this;
	}

	/**
	 * Get the joining table/model name for relation.
	 * array('categories')
	 * array('categories' => 'Category_model')
	 * array('categories' => array('Category_model', 'foreign_key', 'primary_key'))
	 *
	 * @param  string $relation
	 * @param array   $options
	 *
	 * @return string
	 */
	public function get_relation($relation, $options = array()) {
		$defaults = array('model', 'foreign_key', 'primary_key');

		if (is_array($options) AND isset($options[0])) {
			$count = min(count($defaults), count($options));
			$options = array_combine(array_slice($defaults, 0, $count), array_slice($options, 0, $count));
		} else if (is_string($options) AND strpos($options, '_model') === FALSE) {
			$relation = $options;
			$options = array('model' => ucfirst($relation) . '_model');
		} else if (is_string($options)) {
			$options = array('model' => ucfirst($options));
		}


		return array($relation, $options);
	}

	public function load_relation($options = array(), $join_type = 'left') {
		$this->load->model($options['model']);

		if (!isset($options['table'])) {
			$options['table'] = $this->{$options['model']}->get_table();
		}

		if (!isset($options['foreign_key'])) {
			$options['foreign_key'] = ($join_type !== 'left') ? $this->get_key() : $this->{$options['model']}->get_key();
		}

		if (!isset($options['primary_key'])) {
			$options['primary_key'] = ($join_type !== 'left') ? $this->get_key() : $this->{$options['model']}->get_key();
		}

		return $options;
	}

	/**
	 * Join relation
	 *
	 * @param array  $relation
	 *
	 * @param string $join_type
	 *
	 * @return string
	 */
	public function _relate($relation = array(), $join_type = 'left') {
		$relation = $this->load_relation($relation, $join_type);

		$this->join($relation['table'], $relation['table'] . '.' . $relation['primary_key'] . ' = ' .
			$this->table_name . '.' . $relation['foreign_key'], 'left'
		);
	}

	//--------------------------------------------------------------------------
	// Scope Methods
	//--------------------------------------------------------------------------

	/**
	 * Set the value of the soft deletes flag.
	 *
	 * <code>
	 *     $this->my_model->soft_delete(true)->delete($id);
	 * </code>
	 *
	 * @param  boolean $value If true, will temporarily use soft_deletes.
	 *
	 * @return TI_Model An instance of this class to allow method chaining.
	 */
	public function soft_delete($value = TRUE) {
		$this->soft_deletes = (bool)$value;

		return $this;
	}

	/**
	 * Temporarily set the return type to an array, object or json.
	 *
	 * @param string $mode
	 *
	 * @return \TI_Model An instance of this class to allow method chaining.
	 */
	public function return_type($mode = 'array') {
		$this->return_type = $mode;

		return $this;
	}

	/**
	 * Temporarily set the return type to an array.
	 *
	 * @return $this
	 */
	public function as_array() {
		$this->temp_return_type = 'array';

		return $this;
	}

	/**
	 * Temporarily set the return type to an object.
	 *
	 * @return $this
	 */
	public function as_object() {
		$this->temp_return_type = 'object';

		return $this;
	}

	/**
	 * Temporarily set the object return to a json object.
	 *
	 * @return $this
	 */
	public function as_json() {
		$this->temp_return_type = 'json';

		return $this;
	}

	/**
	 * Encode the given value as JSON.
	 *
	 * @param string $value
	 * @param bool   $as_object
	 *
	 * @return $this
	 */
	public function from_json($value, $as_object = FALSE) {
		return json_decode($value, $as_object);
	}

	/**
	 * Skip the insert/update validation for future calls
	 *
	 * @param bool $bool
	 *
	 * @return $this
	 */
	public function skip_validation($bool = TRUE) {
		$this->skip_validation = $bool;

		return $this;
	}

	/**
	 * Don't care about soft deleted rows on the next call
	 */
	public function with_deleted() {
		$this->temp_with_deleted = TRUE;

		return $this;
	}

	/**
	 * Only get deleted rows on the next call
	 */
	public function only_deleted() {
		$this->temp_only_deleted = TRUE;

		return $this;
	}

	//--------------------------------------------------------------------------
	// OBSERVERS
	//--------------------------------------------------------------------------

	/**
	 * Set the created date for the row.
	 *
	 * @param array $row The array of data to be inserted or updated.
	 *
	 * @return array The row data.
	 */
	public function created_on($row) {
		$created_field = $this->get_timestamp_field('created');
		if (!empty($created_field) AND !array_key_exists($created_field, $row)) {
			$row[$created_field] = $this->set_date();
		}

		return $this->updated_on($row);
	}

	/**
	 * Set the updated date for the row.
	 *
	 * @param array $row The array of data to be inserted or updated.
	 *
	 * @return array The row data.
	 */
	public function updated_on($row) {
		$updated_field = $this->get_timestamp_field('updated');
		if (!empty($updated_field) AND !array_key_exists($updated_field, $row)) {
			$row[$updated_field] = $this->set_date();
		}

		return $row;
	}

	//--------------------------------------------------------------------------
	// UTILITY FUNCTIONS
	//--------------------------------------------------------------------------

	/**
	 * Run the specific callbacks, each callback taking a $data
	 * variable and returning it
	 *
	 * @param string $event The name of the event to trigger.
	 * @param array  $data
	 *
	 * @return bool|mixed
	 */
	public function trigger($event, $data = array()) {
		$data = (isset($data[0])) ? $data[0] : $data;

		if (!empty($this->$event)) {
			foreach ($this->$event as $method) {
				$data = call_user_func_array(array($this, $method), array($data));
			}
		}

		return $data;
	}

	/**
	 * Set the validation rules for the model.
	 *
	 * @param array $rules
	 *
	 * @return $this
	 */
	public function set_rules($rules = array()) {
		foreach ($rules as $rule) {
			$temp_rule = array();

			if (isset($rule['field'])) {
				$temp_rule = $rule;
			} else {
				if (isset($rule[0]))
					$temp_rule['field'] = $rule[0];
				if (isset($rule[1]))
					$temp_rule['label'] = $rule[1];
				if (isset($rule[2]))
					$temp_rule['rules'] = $rule[2];
			}

			$this->rules[] = $temp_rule;
		}

		return $this;
	}

	/**
	 * Runs validation on the passed data.
	 *
	 * @param array $data
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function validate($data = array()) {
		if ($this->skip_validation) {
			return $data;
		}

		if ($rules = $this->rules) {
			$rules = $this->trigger('before_validate', array($rules));

			if ($data) {
				foreach ($data as $key => $val) {
					$_POST[$key] = $val;
				}
			}

			if (is_array($rules)) {
				$this->form_validation->set_rules($rules);

				$validate = $this->form_validation->run();
			} else {
				$validate = $this->form_validation->run($rules);
			}

			$this->trigger('after_validate', array($rules, $validate));
		} else {
			$validate = TRUE;
		}

		return $validate;
	}

	/**
	 * Returns the validation error messages as an array.
	 *
	 * @return bool array
	 */
	public function validation_errors() {
		return $this->form_validation->error_array();
	}

	/**
	 * Sets WHERE depending on the number of parameters, has 4 modes:
	 * 1. ($id) primary key value mode
	 * 2. (array("name"=>$name)) associative array mode
	 * 3. ("name", $name) custom key/value mode
	 * 4. ("id", array(1, 2, 3)) where in mode
	 *
	 * @param $params
	 */
	protected function _set_where($params) {
		if (count($params) == 1) {
			if (!is_array($params[0]) AND !strstr($params[0], "'")) {
				$this->db->where($this->table_name . '.' . $this->primary_key, $params[0]); // 1.
			} else {
				$this->db->where($params[0]); // 2.
			}
		} elseif (count($params) == 2) {
			if (is_array($params[1])) {
				$this->db->where_in($params[0], $params[1]); // 4.
			} else {
				$this->db->where($params[0], $params[1]); // 3.
			}
		}
	}

	/**
	 * Protect attributes by removing them from $row array.
	 *
	 * @param object|array $row The value pair item to remove.
	 *
	 * @return array
	 */
	public function protect_attributes($row) {
		foreach ($this->protected_attributes as $attr) {
			if (is_object($row)) {
				unset($row->$attr);
			} else {
				unset($row[$attr]);
			}
		}

		return $row;
	}

	/**
	 * Return or fetch the database fields
	 */
	protected function _fields() {
		if ($this->table_name AND empty($this->fields)) {
			$this->fields = $this->db->list_fields($this->table_name);
		}

		return $this->fields;
	}

	//--------------------------------------------------------------------------
	// PAGINATION
	//--------------------------------------------------------------------------

	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		return $this;
	}

	public function paginate_list($config = array()) {
		if (!isset($this->pagination)) {
			$this->load->library('pagination');
		}

		$this->pagination->initialize($config);

		return array(
			'info'  => $this->pagination->create_infos(),
			'links' => $this->pagination->create_links(),
		);
	}

	/**
	 * Return the pagination links base url
	 *
	 * @param $url
	 *
	 * @return string
	 */
	protected function get_paginate_url() {
		$current_url = current_url();

		if (strpos($current_url, '?') !== FALSE) {
			$current_url = explode('?', $current_url);
			parse_str($current_url[1], $get_data);
			unset($get_data['limit'], $get_data['page']);
			$current_url = $current_url[0] . '?' . http_build_query($get_data);
		}

		return $current_url;
	}

	/**
	 * Paginated list matching the filter array
	 *
	 * @param array  $filter
	 * @param string $base_url
	 *
	 * @return object An object of list and pagination array.
	 */
	public function paginate($filter = array(), $base_url = NULL) {
		$result = new stdClass;
		$result->pagination = $result->list = array();

		if (isset($filter['limit']) AND isset($filter['page'])) {
			$this->limit($filter['limit'], $filter['page']);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$this->order_by($filter['sort_by'], $filter['order_by']);
		}

		$result->list = $this->getList($filter);

		$config['base_url'] = ($base_url) ? $base_url : $this->get_paginate_url();
		$config['total_rows'] = $this->getCount($filter);
		$config['per_page'] = isset($filter['limit']) ? $filter['limit'] : $this->config->item('page_limit');

		$result->pagination = $this->paginate_list($config);

		return $result;
	}

	/**
	 * Get all of the appendable values that are arrayable.
	 *
	 * @return array
	 */
	protected function get_appends() {
		if (!count($this->appends)) {
			return array();
		}

		return array_combine($this->appends, $this->appends);
	}

	/**
	 * Convert the model's attributes to an array.
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	public function convert_attributes($attributes = array()) {
		foreach ($this->get_dates() as $key) {
			if (!isset($attributes[$key])) continue;

			$attributes[$key] = $this->set_date($attributes[$key]);
		}

		foreach ($this->get_casts() as $key => $value) {
			if (!array_key_exists($key, $attributes)) continue;

			$attributes[$key] = $this->cast_attribute($key, $attributes[$key]);

			if ($attributes[$key] AND ($value === 'date' OR $value === 'datetime' OR $value === 'time')) {
				$attributes[$key] = $this->set_date($attributes[$key], $value);
			}
		}

		foreach ($this->get_appends() as $key) {
			$attributes[$key] = $this->mutate_attribute($key, NULL);
		}

		return $attributes;
	}

	/**
	 * Return the method name for the current return type
	 *
	 * @return string The name of the method
	 */
	protected function _return_type($multi = FALSE) {
		$method = $multi ? 'result' : 'row';

		// If the type is 'array' or 'json', simply use the array version of the
		// function, since the database library doesn't support json directly.
		return $this->temp_return_type == 'array' ? "{$method}_array" : $method;
	}

	/**
	 * Retrieve error messages from the database
	 *
	 * @return string
	 */
	protected function get_db_error_message() {
		$error = $this->db->error();

		return isset($error['message']) ? $error['message'] : '';
	}

	/**
	 * Get the attributes that should be converted to dates.
	 *
	 * @return array
	 */
	public function get_dates() {
		$defaults = array($this->get_timestamp_field('created'), $this->get_timestamp_field('updated'));

		return is_array($this->timestamps) ? array_merge($this->dates, $defaults) : $this->dates;
	}

	/**
	 * Get the name of the created or updated fields
	 *
	 * @param string $timestamp
	 *
	 * @return array|string The name of the field, or an array of field names,
	 * or an empty string.
	 */
	public function get_timestamp_field($timestamp) {
		if (array_key_exists($timestamp, $this->get_timestamps())) {
			return $this->get_timestamps()[$timestamp];
		} else {
			return '';
		}
	}

	/**
	 * Get the timestamps array.
	 *
	 * @return array
	 */
	public function get_timestamps() {
		$defaults = array('created' => 'date_added', 'updated' => 'date_updated');

		return isset($this->timestamps[0]) ? array_intersect_key($defaults, array_flip($this->timestamps)) : $this->timestamps;
	}

	/**
	 * Get the value of an attribute using its mutator.
	 *
	 * @param  string $key
	 * @param  mixed  $value
	 *
	 * @return mixed
	 */
	protected function mutate_attribute($key, $value) {
		return $value;
	}

	/**
	 * Determine whether an attribute should be cast to a native type.
	 *
	 * @param  string            $key
	 * @param  array|string|null $types
	 *
	 * @return bool
	 */
	public function has_cast($key, $types = NULL) {
		if (array_key_exists($key, $this->get_casts())) {
			return $types ? in_array($this->get_cast_type($key), (array)$types, TRUE) : TRUE;
		}

		return FALSE;
	}

	/**
	 * Get the casts array.
	 *
	 * @return array
	 */
	public function get_casts() {
		return $this->casts;
	}

	/**
	 * Determine whether a value is Date / DateTime castable for inbound manipulation.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	protected function is_date_castable($key) {
		return $this->has_cast($key, ['date', 'datetime']);
	}

	/**
	 * Determine whether a value is JSON castable for inbound manipulation.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	protected function is_json_castable($key) {
		return $this->has_cast($key, ['array', 'json', 'object', 'collection']);
	}

	/**
	 * Get the type of cast for a model attribute.
	 *
	 * @param  string $key
	 *
	 * @return string
	 */
	protected function get_cast_type($key) {
		return trim(strtolower($this->get_casts()[$key]));
	}

	/**
	 * Cast an attribute to a native PHP type.
	 *
	 * @param  string $key
	 * @param  mixed  $value
	 *
	 * @return mixed
	 */
	protected function cast_attribute($key, $value) {
		if (is_null($value)) return $value;

		switch ($this->get_cast_type($key)) {
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
				return $this->from_json($value, TRUE);
			case 'array':
			case 'json':
				return $this->from_json($value);
			case 'date':
				return $this->set_date($value, 'date');
			case 'datetime':
				return $this->set_date($value, 'datetime');
			case 'time':
				return $this->set_date($value, 'time');
			case 'timestamp':
				return $this->set_date($value, 'int');
			default:
				return $value;
		}
	}

	/**
	 * Convert an attribute or dates attributes to a preferred date/time format.
	 *
	 * The available time formats are:
	 * 'int'      - Stores the date as an integer timestamp.
	 * 'datetime' - Stores the date and time in the SQL datetime format.
	 * 'date'     - Stores teh date (only) in the SQL date format.
	 *
	 * @param  string $value
	 * @param string  $format
	 *
	 * @return string
	 */
	public function set_date($value = NULL, $format = NULL) {
		$date = empty($value) ? time() : strtotime($value);
		$format = ($format) ? $format : $this->date_format;
		switch ($format) {
			case 'datetime':
				$dateFormat = '%Y-%m-%d %H:%i:%s';
				break;
			case 'date':
				$dateFormat = '%Y-%m-%d';
				break;
			case 'time':
				$dateFormat = '%H:%i:%s';
				break;
			case 'int':
			default:
				$dateFormat = '%U';
				break;
		}

		return mdate($dateFormat, $date);
	}

	/**
	 * Allow setting the table to use for all methods during runtime.
	 *
	 * @param string $table The table name to use (do not include the prefix!).
	 *
	 * @return $this
	 */
	public function set_table($table = '') {
		$this->table_name = $table;

		return $this;
	}

	/**
	 * Set the primary key for the model.
	 *
	 * @param  string $key
	 *
	 * @return $this
	 */
	public function set_key($key) {
		$this->primary_key = $key;

		return $this;
	}

	/**
	 * Get the table name.
	 *
	 * @return string $this->table_name (current model table name).
	 */
	public function get_table() {
		return $this->table_name;
	}

	/**
	 * Get the table's primary key.
	 *
	 * @return string $this->key (current model table primary key).
	 */
	public function get_key() {
		return $this->primary_key;
	}

	/**
	 * Get the name of the deleted field.
	 *
	 * @return string The name of the field if $soft_deletes is enabled, else an
	 * empty string.
	 */
	public function get_deleted_field() {
		if ($this->soft_delete) {
			return $this->table_name . '.' . $this->deleted_field;
		}

		return '';
	}

	/**
	 * Adds field/value pairs to be stored later into database
	 *
	 * @param array $attributes
	 *
	 * @return bool
	 */
	public function fill($attributes = array()) {
		foreach ($attributes as $key => $value) {
			// Remove database table name
			$key = (strpos($key, '.') !== FALSE) ? end(explode('.', $key)) : $key;

			if ($key == $this->primary_key) continue;

			if ($this->is_field($key)) {
				// If an attribute is listed as a "date", we'll convert it
				if ($value AND (in_array($key, $this->get_dates()) OR $this->is_date_castable($key))) {
					$value = $this->set_date($value);
				}

				if ($this->has_cast($key, ['time'])) {
					$value = $this->set_date($value, 'time');
				}

				if ($this->is_json_castable($key) AND !is_null($value)) {
					$value = $this->as_json($value);
				}

				$this->db->set($key, $value);
			}
		}

		return $this;

	}

	/**
	 * Determine if the given attribute may be mass assigned.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	public function is_field($key) {
		$fields = $this->_fields();
		if (in_array($key, $fields)) return TRUE;

		if ($this->is_protected($key)) return FALSE;

		return empty($fields) ? TRUE : FALSE;
	}

	/**
	 * Determine if the given key is guarded.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	public function is_protected($key) {
		return in_array($key, $this->protected_attributes) OR $this->protected_attributes == array('*');
	}
}

/* End of file TI_Model.php */
/* Location: ./system/tastyigniter/core/TI_Model.php */