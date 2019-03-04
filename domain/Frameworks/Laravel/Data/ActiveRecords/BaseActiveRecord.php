<?php

namespace Domain\Frameworks\Laravel\Data\ActiveRecords;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class BaseActiveRecord extends Model
{
    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    public function setUuid()
    {
        if (empty($this->{$this->primaryKey})) {
            $this->uuid = Uuid::uuid1();
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->{$this->primaryKey});
    }
}