<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 16:28
 */

namespace Domain\Layers\Data\Contracts\Repositories;

interface GenreRepository extends BaseRepository
{
    public function getByNames(array $genreNames);

    public function getByName(string $genreName);
}