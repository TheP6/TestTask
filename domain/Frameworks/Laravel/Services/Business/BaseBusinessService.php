<?php

namespace Domain\Frameworks\Laravel\Services\Business;

use Domain\Layers\Services\Business\Contracts\BaseService as BaseServiceContract;
use Illuminate\Support\Facades\DB;

class BaseBusinessService implements BaseServiceContract
{
    public function dbBeginTransaction()
    {
        DB::beginTransaction();
    }

    public function dbRollback()
    {
        DB::rollBack();
    }

    public function dbCommit()
    {
        DB::commit();
    }

}