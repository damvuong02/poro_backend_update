<?php
namespace App\Repositories;

interface RepositoryInterface{
    function getAll();
    function create($data=[]);
    function show($id);
    function update($data=[],$id);

    function findById($id);
    function delete($id);

    function search(string $column,$value);
}
