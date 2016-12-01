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

use Illuminate\Database\Eloquent\Builder as BuilderBase;

/**
 * TastyIgniter Database Manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Database\Manager.php
 * @link           http://docs.tastyigniter.com
 */
class Builder extends BuilderBase
{

	/**
	 * Get an array with the values of a given column.
	 *
	 * @param  string $column
	 * @param  string|null $key
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function lists($column, $key = null)
	{
		$results = $this->query->pluck($column, $key);

		if ($this->model->hasGetMutator($column)) {
			foreach ($results as $key => &$value) {
				$fill = [$column => $value];

				$value = $this->model->newFromBuilder($fill)->$column;
			}
		}

		return $results;
	}

	/**
	 * Get an array with the values of a given column.
	 *
	 * @param  string $column
	 * @param  string|null $key
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function dropdown($column, $key = null)
	{
		$key = !is_null($key) ? $key : $this->model->getKeyName();

		return $this->lists($column, $key);
	}

	/**
	 * Perform a search on this query for term found in columns.
	 *
	 * @param  string $term   Search query
	 * @param  array $columns Table columns to search
	 * @param  string $mode   Search mode: all, any, exact.
	 *
	 * @return self
	 */
	public function search($term, $columns = [], $mode = 'all')
	{
		return $this->searchInternal($term, $columns, $mode, 'and');
	}

	/**
	 * Add an "or search where" clause to the query.
	 *
	 * @param  string $term   Search query
	 * @param  array $columns Table columns to search
	 * @param  string $mode   Search mode: all, any, exact.
	 *
	 * @return self
	 */
	public function orSearch($term, $columns = [], $mode = 'all')
	{
		return $this->searchInternal($term, $columns, $mode, 'or');
	}

	/**
	 * Convenient method for where like clause
	 *
	 * @param  string $column
	 * @param $value
	 * @param string $side
	 * @param string $boolean
	 *
	 * @return \TastyIgniter\Database\Builder
	 */
	public function like($column, $value, $side = 'both', $boolean = 'and')
	{
		return $this->likeInternal($column, $value, $side, $boolean);
	}

	/**
	 * Convenient method for or where like clause
	 *
	 * @param  string $column
	 * @param $value
	 * @param string $side
	 *
	 * @return self
	 */
	public function orLike($column, $value, $side = 'both')
	{
		return $this->likeInternal($column, $value, $side, 'or');
	}

	/**
	 * Internal method to apply a search constraint to the query.
	 * Mode can be any of these options:
	 * - all: result must contain all words
	 * - any: result can contain any word
	 * - exact: result must contain the exact phrase
	 *
	 * @param $term
	 * @param array $columns
	 * @param $mode
	 * @param $boolean
	 *
	 * @return $this
	 */
	protected function searchInternal($term, $columns = [], $mode, $boolean)
	{
		if (!is_array($columns))
			$columns = [$columns];

		if (!$mode)
			$mode = 'all';

		if ($mode === 'exact') {
			$this->where(function($query) use ($columns, $term) {
				foreach ($columns as $field) {
					if (!strlen($term)) continue;
					$query->orLike($field, $term, 'both');
				}
			}, null, null, $boolean);
		}
		else {
			$words = explode(' ', $term);
			$wordBoolean = $mode === 'any' ? 'or' : 'and';

			$this->where(function($query) use ($columns, $words, $wordBoolean) {
				foreach ($columns as $field) {
					$query->orWhere(function($query) use ($field, $words, $wordBoolean) {
						foreach ($words as $word) {
							if (!strlen($word)) continue;
							$query->like($field, $word, 'both', $wordBoolean);
						}
					});
				}
			}, null, null, $boolean);
		}

		return $this;
	}

	protected function likeInternal($column, $value, $side = null, $boolean = 'and')
	{
		$column = $this->query->raw(sprintf("lower(%s)", $column));
		$value = trim(mb_strtolower($value));

		if ($side === 'none') {
			$value = $value;
		} elseif ($side === 'before') {
			$value = "%{$value}";
		} elseif ($side === 'after') {
			$value = "{$value}%";
		} else {
			$value = "%{$value}%";
		}

		return $this->where($column, 'like', $value, $boolean);
	}

	/**
	 * Get an array with the values of dates.
	 *
	 * @param  string $column
	 * @param string $keyFormat
	 * @param string $valueFormat
	 *
	 * @return array
	 */
	public function pluckDates($column, $keyFormat = '%Y-%m', $valueFormat = '%F %Y')
	{
		$dates = [];

		$collection = $this->selectRaw("{$column}, MONTH({$column}) as month, YEAR({$column}) as year")
						   ->groupBy('month')->groupBy('year')->getAsArray();

		if ($collection) {
			foreach ($collection as $date) {
				$key = mdate($keyFormat, strtotime($date['year'] . '-' . $date['month']));
				$value = mdate($valueFormat, strtotime($date['date_added']));
				$dates[$key] = $value;
			}
		}

		return $dates;
	}

	/**
	 * Execute the query as a "select" statement as array.
	 *
	 * @param  array $columns
	 *
	 * @return array
	 */
	public function getAsArray($columns = ['*'])
	{
		$collection = $this->get($columns);

		return $collection->isEmpty() ? [] : $collection->toArray();
	}

	/**
	 * Execute the query and get the first result as array.
	 *
	 * @param  array $columns
	 *
	 * @return array
	 */
	public function firstAsArray($columns = ['*'])
	{
		$model = $this->first($columns);

		return $model->exists() ? [] : $model->toArray();
	}

	/**
	 * Paginate the given query.
	 *
	 * @param  int $perPage
	 * @param  array $columns
	 * @param  string $pageName
	 * @param  int|null $page
	 *
	 * @return \stdClass
	 *
	 * @throws \InvalidArgumentException
	 */
	public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
	{
		if (!is_array($columns)) {
			$page = $columns;
			$columns = ['*'];
		}

		$config['base_url'] = $this->model->getCurrentUrl($pageName);
		$config['total_rows'] = $this->toBase()->getCountForPagination();
		$config['per_page'] = $perPage = $perPage ?: $this->model->getPerPage();

		$result = new \stdClass;
		$result->list = $this->forPage($page, $perPage)->get()->toArray();
		$result->pagination = $this->model->buildPaginateHtml($config);

		return $result;
	}

	public function paginateWithFilter($filter = [])
	{
		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$query = $this->orderBy($filter['sort_by'], $filter['order_by']);
		} else {
			$query = $this->orderBy($this->getModel()->getKeyName());
		}

		if (method_exists($this->model, 'scopeFilter'))
			$query = $query->filter($filter);

		$this->model->setFilterQuery($query);

		$perPage = isset($filter['limit']) ? $filter['limit'] : $this->model->getPerPage();
		$page = isset($filter['page']) ? $filter['page'] : null;

		return $query->paginate($perPage, $page);
	}

	/**
	 * Find a model by its primary key or return fresh model instance
	 * with filled attributes to use with forms.
	 *
	 * @param  mixed $id
	 * @param  array $columns
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function findOrNew($id, $columns = ['*'])
	{
		if (!is_null($model = $this->find($id, $columns))) {
			return $model;
		}

		$attributes = $this->query->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());

		return $this->model->newInstance(array_fill_keys(array_values($attributes), null))->setConnection(
			$this->query->getConnection()->getName()
		);
	}
}