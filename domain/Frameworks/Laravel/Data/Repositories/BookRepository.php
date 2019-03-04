<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 21:56
 */

namespace Domain\Frameworks\Laravel\Data\Repositories;

use Domain\Frameworks\Laravel\Data\ActiveRecords\Book;
use Domain\Layers\Data\Contracts\Repositories\BookRepository as BookRepositoryContract;
use Illuminate\Database\Eloquent\Builder as ModelQueryBuilder;

class BookRepository extends BaseRepository implements BookRepositoryContract
{
    public function getByUuid(string $uuid)
    {
        return Book::find($uuid);
    }

    public function getByUuidOrFail(string $uuid)
    {
        return Book::findOrFail($uuid);
    }

    public function makeEmptyEntity()
    {
        return new Book();
    }

    public function makeNewEntity()
    {
        $book = new Book();
        $book->setUuid();

        return $book;
    }

    public function getByFilters(array $filters, int $limit, int $offset = 0)
    {
        $query = $this->makeBaseQuery();
        $query = $this->applyFilters($query, $filters);
        $query->take($limit)->skip($offset);
        return $query->get();
    }

    protected function makeBaseQuery()
    {
        $query = Book::query()->select('books.*'); //hardcoded
        return $query;
    }

    protected function applyFilters(ModelQueryBuilder $query, array $filters)
    {
        //todo: remove hardcoded table names @ap
        if (!empty($filters['genres'])) {
            $query->join('genres', function ($join) use ($filters) {
                $join->on('books.genreUuid', '=', 'genres.uuid')
                    ->whereIn('genres.name', '=', $filters['genres']);
            });
        }

        if (!empty($filters['author']) && is_array($filters['author'])) {
            if (!empty($filters['author']['surname']) && !empty($filters['author']['name'])) {
                $query->join('authors', function ($join) use ($filters) {
                    $join->on('books.authorUuid', '=', 'authors.uuid');

                    if (!empty($filters['author']['surname'])) {
                        $join->where('authors.surname', '=', $filters['author']['surname']);
                    }

                    if (!empty($filters['author']['name'])) {
                        $join->where('authors.name', '=', $filters['author']['name']);
                    }

                });
            }
        }

        if (!empty($filters['title'])) {
            $title = (string)$filters['title'];
            $query->where('title', 'like', "{$title}%");
        }

        return $query;
    }
}