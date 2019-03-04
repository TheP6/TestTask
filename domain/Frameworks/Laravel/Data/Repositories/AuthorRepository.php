<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 21:56
 */

namespace Domain\Frameworks\Laravel\Data\Repositories;

use Domain\Frameworks\Laravel\Data\ActiveRecords\Author;
use Domain\Layers\Data\Contracts\Repositories\AuthorRepository as AuthorRepositoryContract;

class AuthorRepository extends BaseRepository  implements AuthorRepositoryContract
{
    public function getByUuid(string $uuid)
    {
        return Author::find($uuid);
    }

    public function getByUuidOrFail(string $uuid)
    {
        return Author::findOrFail($uuid);
    }

    public function makeEmptyEntity()
    {
        return new Author();
    }

    public function makeNewEntity()
    {
        $author = new Author();
        $author->setUuid();

        return $author;
    }
}