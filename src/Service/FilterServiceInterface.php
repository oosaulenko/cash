<?php


namespace App\Service;


interface FilterServiceInterface {

    /**
     * @param $query
     * @param $params
     * @return mixed
     */
    public function setSort($query, $params);

}