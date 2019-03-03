<?php

namespace Domain\Layers\Data\Contracts\Repositories;

interface BaseRepository
{
    /**
     * @param string $uuid
     * @return mixed
     */
    public function getByUuid(string $uuid);

    /**
     * @param string $uuid
     * @throws \Exception when entity does not exist
     * @return mixed
     */
    public function getByUuidOrFail(string $uuid);

    public function persist($entity, bool $onlyIfNew = false);

    public function delete($entity);

    public function makeEmptyEntity(); //without uuid generation

    public function makeNewEntity(); //with generated uuid

}