<?php

namespace Domain\Layers\Services\Business\Contracts;

interface BaseService
{
    public function dbBeginTransaction();

    public function dbRollback();

    public function dbCommit();
}