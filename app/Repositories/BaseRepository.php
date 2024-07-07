<?php
namespace App\Repositories;

use Exception;

abstract class BaseRepository implements RepositoryInterface{
    //model muốn tương tác
    protected $model;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->setModel();

    }

    //lấy model tương ứng
    abstract function getModel();
    function setModel() {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    function getAll(){
        return $this->model->latest()->get();
    }

    public function findOrFail( $attributes =[])
    {
        $result = $this->model->firstOrCreate($attributes);
        if($result){
            return false;
        }
        return true;
    }

    function create($data = []){
        $result = $this->model->create($data);
        if($result){
            return $result;
        }
        return false;
    }

    function show($id){
        $result = $this->model->find($id);
        return $result;
    }

    function update($data = [],$id){
        $result = $this->model->find($id);
        if($result){
            $result->update($data);
            return $result;
        }
        return false;
    }
    function findById($id){
        $result = $this->model->find($id);
        if($result){
            return $result;
        }
        return false;
    }
    function delete($id){
        try{

            $result = $this->model->find($id);
            if($result){
                $result->delete($id);
                return true;
            }
            return false;
        }catch(Exception $ex){
            return false;
        }
    }
    function search(string $column,$value)
    {
        $result = $this->model->where($column,'like','%'.$value.'%')->paginate(10000);
        return $result;
    }


}
