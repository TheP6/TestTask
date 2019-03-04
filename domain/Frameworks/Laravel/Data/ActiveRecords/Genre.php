<?php

namespace Domain\Frameworks\Laravel\Data\ActiveRecords;

class Genre extends BaseActiveRecord
{
    protected $table = 'genres';

    public $timestamps = false;
}