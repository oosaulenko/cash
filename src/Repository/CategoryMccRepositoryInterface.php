<?php


namespace App\Repository;


use App\Entity\Category;
use App\Entity\CategoryMcc;

interface CategoryMccRepositoryInterface {

    /**
     * @param $code
     * @return CategoryMcc
     */
    public function findByCode($code): ?CategoryMcc;

    /**
     * @param $code
     * @param $name
     * @param $category
     * @return mixed
     */
    public function createMccCode($code, $name, $category);

}