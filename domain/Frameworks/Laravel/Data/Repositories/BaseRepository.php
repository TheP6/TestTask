<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 22:20
 */

namespace Domain\Frameworks\Laravel\Data\Repositories;


use Domain\Frameworks\Laravel\Data\ActiveRecords\BaseActiveRecord;

abstract class BaseRepository
{
    public function persist($entity, bool $onlyIfNew = false)
    {
        /**
         * @var $entity BaseActiveRecord
         */
        if ($entity->isEmpty()) {
            return $entity; //do not save empty entities
        }

        if ($onlyIfNew)  {
            if ($entity->exists) {
                return $entity->save();
            }
            return $entity;
        }

        return $entity->save();
    }

    public function delete($entity)
    {
        /**
         * @var $entity BaseActiveRecord
         */
        $entity->delete();
    }

}