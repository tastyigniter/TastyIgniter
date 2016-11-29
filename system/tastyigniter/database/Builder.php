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

use Illuminate\Database\Eloquent\Builder as BuilderModel;

/**
 * TastyIgniter Database Manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Database\Manager.php
 * @link           http://docs.tastyigniter.com
 */
class Builder extends BuilderModel
{

	/**
	 * Get an array with the values of a given column.
	 *
	 * @param  string $column
	 * @param  string|null $key
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function lists($column, $key = NULL)
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

	public function dropdown($column, $key = NULL)
	{
		$key = !is_null($key) ? $key : $this->model->getKeyName();

		return $this->lists($column, $key);
	}

	public function like($column, $value, $side = 'both')
	{
		if ($side === 'none') {
			$value = $value;
		} elseif ($side === 'before') {
			$value = "%{$value}";
		} elseif ($side === 'after') {
			$value = "{$value}%";
		} else {
			$value = "%{$value}%";
		}

		return $this->where($column, 'like', $value);
	}

	public function orLike($column, $value, $side = 'both')
	{
		if ($side === 'none') {
			$value = $value;
		} elseif ($side === 'before') {
			$value = "%{$value}";
		} elseif ($side === 'after') {
			$value = "{$value}%";
		} else {
			$value = "%{$value}%";
		}

		return $this->orWhere($column, 'like', $value);
	}

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
	 * Execute the query as a "select" statement.
	 *
	 * @param  array  $columns
	 * @return array
	 */
	public function getAsArray($columns = ['*'])
	{
		$collection = $this->get($columns);

		return $collection->isEmpty() ? [] : $collection->toArray();
	}

	/**
	 * Execute the query and get the first result.
	 *
	 * @param  array  $columns
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
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 *
	 * @throws \InvalidArgumentException
	 */
	public function paginate($perPage = NULL, $columns = ['*'], $pageName = 'page', $page = NULL)
	{
		if (!is_array($columns)) {
			$page = $columns;
			$columns = ['*'];
		}

		$config['base_url'] = $this->model->getCurrentUrl($pageName);
		$config['total_rows'] = $this->toBase()->getCountForPagination();
		$config['per_page'] = $perPage = $perPage ? : $this->model->getPerPage();

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
		$page = isset($filter['page']) ? $filter['page'] : NULL;

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

		return $this->model->newInstance(array_fill_keys(array_values($attributes), NULL))->setConnection(
			$this->query->getConnection()->getName()
		);
	}

}