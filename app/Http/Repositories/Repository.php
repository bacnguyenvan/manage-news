<?php
namespace App\Http\Repositories;

use AppData;

class Repository implements InterfaceRepository {

	protected $modelName;

	protected $model;

	public function __construct() {
		$class = "App\\Models\\$this->modelName";
		return $this->model = new $class;
	}

	public function findAll() {
		return $this->model;
	}

	public function findByPk($pk, $relations = []) {
		$query = $this->model;
		if(!empty($relations)) {
			foreach($relations as $relation) {
				$query = $query->with($relation);
			}
		}
		return $query->find($pk);
	}

	public function findAllActive() {
		return $this->model;
	}

	public function create($data) {
		return $this->model->create($data);
	}

	public function updateByPk($pk, $data) {
		return $this->findByPk($pk)->update($data);
	}

	public function deleteByPk($pk) {
		return $this->findByPk($pk)->delete();
	}

	public function deleteByConditions($conditions)
	{
		return $this->model->where($conditions)->delete();
	}

	public function updateByConditions($conditions,$data)
	{
		return $this->model->where($conditions)->update($data);
	}

	public function softDeleteByPk($pk) {
		return $this->findByPk($pk)->update(['deleted_at' => date('Y-m-d H:i:s')]);
	}

	public function softDeleteListPk($listPk) {
		return $this->model->whereIn($this->model->getKeyName(), $listPk)
					->update(['delete_flag' => 1]);
	}

	public function updateColumnBysoftDeleteListPk($listPk,$column) {
		return $this->model->whereIn($this->model->getKeyName(), $listPk)
					->update([$column => 1]);
	}

	public function insertData($data) {
		return $this->model->insert($data);
	}

	public function searchOptions($query, $options = []) {
		if(!empty($options['select'])) {
			$query = $query->select($options['select']);
		}
		if(!empty($options['groupBy'])) {
			$query = $query->groupBy($options['groupBy']);
		}
		if(!empty($options['sort'])) {
			foreach($options['sort'] as $key => $type) {
				//$query = $query->orderBy($key, $type);
				$query = $query->orderByRaw("LENGTH($key)", $type)->orderBy($key, $type);
			}
		}
		if(!empty($options['distinct'])) {
			$query = $query->distinct($options['distinct']);
		}

		if(!empty($options['offset'])) {
			$query = $query->offset($options['offset']);
		}

		if(!empty($options['limit'])) {
			$query = $query->limit($options['limit']);
		}
		if(!empty($options['update'])) {
			$query->update($options['update']);
		}
		if(!empty($options['get'])) {
			$query = $query->get();
		} else if(!empty($options['paginate'])){
			$query = $query->paginate($options['paginate']);
		} else if(!empty($options['pluck'])) {
			$query = $query->pluck($options['pluck'], $this->model->getKeyName());
		} else if(!empty($options['count'])) {
			$query = $query->count();
		} else if(!empty($options['first'])) {
			$query = $query->first();
		} else if(!empty($options['query'])) {
			$query = $query;
		} else if(!empty($options['findByPk'])) {
			$query = $query->find($options['findByPk']);
		} else {
			$query = $query->paginate(AppData::defaultPaginate);
		}

		return $query;
	}

	public function getRelationData($repository, $item) {
		return function($q) use ($repository, $item) {
			$repository->model = $q;
			$conditions = !empty($item['conditions'])?$item['conditions']:[];
			$options = !empty($item['options'])?$item['options']:[];
			$repository->search(
				$conditions, 
				$options
			);
		};
	}
}













