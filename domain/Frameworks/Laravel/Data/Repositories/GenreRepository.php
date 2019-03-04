<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 21:56
 */

namespace Domain\Frameworks\Laravel\Data\Repositories;

use Domain\Frameworks\Laravel\Data\ActiveRecords\Genre;
use Domain\Layers\Data\Contracts\Repositories\GenreRepository as GenreRepositoryContract;

class GenreRepository extends BaseRepository implements GenreRepositoryContract
{
    public function getByUuid(string $uuid)
    {
        return Genre::find($uuid);
    }

    public function getByUuidOrFail(string $uuid)
    {
        return Genre::findOrFail($uuid);
    }

    public function makeEmptyEntity()
    {
        return new Genre();
    }

    public function makeNewEntity()
    {
        $genre = new Genre();
        $genre->setUuid();

        return $genre;
    }

    public function getByNames(array $genreNames)
    {
        return Genre::whereIn('name', $genreNames)->get();
    }

    public function getByName(string $genreName)
    {
        return Genre::where('name', '=', $genreName)->first();
    }

}