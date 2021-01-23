<?php
/**
 * Created by PhpStorm.
 * User: @ariadoos - Nikesh Bdr. Adhikari
 * Date: 1/10/2021
 * Time: 7:42 PM
 */
namespace Modules\Core\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function findById($id, $with = []);

    /**
     * @param array $where
     * @param array $with
     * @param array $orderBy
     * @return mixed
     */
    public function findWhere($where = [], $with = [], $orderBy = ['field' => 'id', 'sort' => 'ASC']);

    /**
     * @param array $where
     * @param array $with
     * @param array $orderBy
     * @return mixed
     */
    public function findOneWhere($where = [], $with = [], $orderBy = ['field' => 'id', 'sort' => 'ASC']);

    /**
     * @param array $where
     * @param array $with
     * @param null $limit
     * @param array $orderBy
     * @return mixed
     */
    public function findAll($where=[], $with = [], $limit = NULL ,$orderBy = ['field' => 'id', 'sort' => 'ASC']);

    /**
     * @param array $where
     * @param array $with
     * @param null $limit
     * @param array $orderBy
     * @return mixed
     */
    public function findAllInArray($where=[], $with = [], $limit = NULL ,$orderBy = ['field' => 'id', 'sort' => 'ASC']);


    /**
     * @param array $where
     * @param array $with
     * @param null $paginate
     * @param array $orderBy
     * @return mixed
     */
    public function getPaginateList($where=[], $with = [], $paginate = NULL ,$orderBy = ['field' => 'id', 'sort' => 'ASC']);

    /**
     * @param $data
     * @param null $id
     * @return mixed
     */
    public function createOrUpdate($data, $id = NULL);

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id);

    /**
     * @param array $where
     * @return mixed
     */
    public function delete($where = []);
}