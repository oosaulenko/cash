<?php


namespace App\Repository;


interface CategoryRepositoryInterface {

    /**
     * @return object
     */
    public function isDefault(): object;

    /**
     * @param $ids
     */
    public function getCategories(array $ids);

//    public function getCategories()

}