<?php

namespace Domain\Frameworks\Laravel\Data\ActiveRecords;

class Book extends BaseActiveRecord
{
    protected $table = 'books';

    public function author()
    {
        return $this->belongsTo(Author::class, 'authorUuid', 'uuid');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genreUuid', 'uuid');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisherUuid', 'uuid');
    }
}