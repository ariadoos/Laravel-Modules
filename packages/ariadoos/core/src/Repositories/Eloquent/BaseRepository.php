<?php
/**
 * Created by PhpStorm.
 * User: @ariadoos - Nikesh Bdr. Adhikari
 * Date: 1/10/2021
 * Time: 8:23 PM
 */
namespace Modules\Core\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Contracts\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Model instance
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function findById($id, $with = [])
    {
        if (!empty($with))
            return $this->model->with($with)->find($id);

        return $this->model->findorfail($id);
    }

    /**
     *
     * @param array $where
     * @param array $with
     * @param array $orderBy
     * @return mixed
     */
    public function findWhere($where = [], $with = [], $orderBy = ['field' => 'id', 'sort' => 'ASC'])
    {
        $result = $this->model->with($with)->where($where);

        if ($orderBy)
            $result->orderBy($orderBy['field'], $orderBy['sort']);

        return $result->get();
    }

    /**
     * @param array $where
     * @param array $with
     * @param array $orderBy
     * @return mixed
     */
    public function findOneWhere($where = [], $with = [], $orderBy = ['field' => 'id', 'sort' => 'ASC'])
    {
        $result = $this->findWhere($where, $with, $orderBy);

        return $result->first();
    }

    /**
     * @param array $where
     * @param array $with
     * @param null $limit
     * @param array $orderBy
     * @return mixed
     */
    public function findAll($where = [], $with = [], $limit = NULL, $orderBy = ['field' => 'id', 'sort' => 'ASC'])
    {
        $result = $this->model->with($with)->where($where);

        if ($orderBy)
            $result = $result->orderBy($orderBy['field'], $orderBy['sort']);

        if ($limit)
            $result = $result->limit($limit);

        return $result->get();
    }

    /**
     * @param array $where
     * @param array $with
     * @param null $limit
     * @param array $orderBy
     * @return mixed
     */
    public function findAllInArray($where = [], $with = [], $limit = NULL, $orderBy = ['field' => 'id', 'sort' => 'ASC'])
    {
        $result = $this->findAll($where, $with, $limit, $orderBy);

        return $result->toArray();
    }

    /**
     * @param array $where
     * @param array $with
     * @param null $paginate
     * @param array $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPaginateList($where = [], $with = [], $paginate = NULL, $orderBy = ['field' => 'id', 'sort' => 'ASC'])
    {
        $result = $this->model->with($with)->where($where);

        if ($orderBy)
            $result = $result->orderBy($orderBy['field'], $orderBy['sort']);

        if ($paginate)
            return $result->paginate($paginate);

        return $result->get();
    }

    /**
     * @param $data
     * @param null $id
     * @return bool
     */
    public function createOrUpdate($data, $id = NULL)
    {
        if ($id)
            return $this->model->update($data, $id);

        return $this->model->create($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        return $this->createOrUpdate($data);
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function update($data, $id)
    {
        return $this->createOrUpdate($data, $id);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete($where = [])
    {
        $model = $this->model->where($where);

        return $model->delete();
    }


}