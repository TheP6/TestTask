<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 16:28
 */

namespace Domain\Layers\Data\Contracts\Repositories;

interface BookRepository extends BaseRepository
{
    //todo: filters should be its own class to enforce interface by which we can interact with them @ap
    public function getByFilters(array $filters, int $limit, int $offset = 0);
}