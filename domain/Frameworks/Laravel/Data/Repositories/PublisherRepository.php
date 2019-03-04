<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 21:56
 */

namespace Domain\Frameworks\Laravel\Data\Repositories;

use Domain\Frameworks\Laravel\Data\ActiveRecords\Publisher;
use Domain\Layers\Data\Contracts\Repositories\PublisherRepository as PublisherRepositoryContract;

class PublisherRepository extends BaseRepository implements PublisherRepositoryContract
{
    public function getByUuid(string $uuid)
    {
        return Publisher::find($uuid);
    }

    public function getByUuidOrFail(string $uuid)
    {
        return Publisher::findOrFail($uuid);
    }

    public function makeEmptyEntity()
    {
        return new Publisher();
    }

    public function makeNewEntity()
    {
        $publisher = new Publisher();
        $publisher->setUuid();

        return $publisher;
    }

    public function getByName(string $name)
    {
        return Publisher::where('name', '=', $name)->first();
    }

}