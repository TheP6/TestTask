<?php

namespace Domain\Layers\Data\Contracts\Repositories;

interface BaseRepository
{
    public function getByUuid(string $uuid);

    public function persist($entity);

    public function delete($entity);

}