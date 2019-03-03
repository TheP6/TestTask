<?php

use Domain\Layers\Services\Business\Contracts\BookService as BookServiceContract;

use Domain\Layers\Services\Business\Contracts\BaseService as BaseServiceContract;

use Domain\Layers\Services\Request\Contracts\Request as RequestContract;
use Domain\Layers\Services\Request\Contracts\Validator as ValidatorContract;

use Domain\Layers\Data\Contracts\Repositories\BookRepository as BookRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\PublisherRepository as PublisherRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\GenreRepository as GenreRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\AuthorRepository as AuthorRepositoryContract;


class BookService implements BookServiceContract
{
    const MAX_LIMIT = 20; //should move to config file

    protected $baseService;

    protected $bookRepository;
    protected $publisherRepository;
    protected $genreRepository;
    protected $authorRepository;
    protected $validator;

    public function __construct(
        BaseServiceContract $baseService,
        ValidatorContract $validator,
        BookRepositoryContract $bookRepository,
        PublisherRepositoryContract $publisherRepository,
        AuthorRepositoryContract $authorRepository,
        GenreRepositoryContract $genreRepository
    ){
        $this->baseService = $baseService;

        $this->bookRepository = $bookRepository;
        $this->publisherRepository = $publisherRepository;
        $this->genreRepository = $genreRepository;
        $this->authorRepository = $authorRepository;

        $this->validator = $validator;
    }

    /**
     * @param string $uuid
     * @return mixed
     * @throws Exception
     */
    public function fetchOne(string $uuid)
    {
        $book = $this->bookRepository->getByUuidOrFail($uuid);
        return $book;
    }

    /**
     * @param RequestContract $request
     * @return mixed
     */
    public function search(RequestContract $request)
    {
        $input = $request->get();
        $this->validator->validate([
            'filters' => 'array',
            'filters.genres' => 'array',
            'filters.genres.*' => 'string|min:2',
            'filters.author' => 'array',
            'filters.author.name' => 'string|min:2',
            'filters.author.surname' => 'string|min:2',
            'filters.title' => 'string|min:2',
        ], $input);

        return $this->bookRepository->getByFilters(
            $input['filters'] ?? [],
            $input['limit'],
            $input['offset'] ?? 0
        );
    }

    /**
     * @param RequestContract $request
     * @return mixed
     * @throws Exception
     */
    public function create(RequestContract $request)
    {
        $input = $request->get();
        $this->validator->validate([
            'title' => 'required|string|min:2',
            'averagePrice' => 'required|numeric',
            'wordCount' => 'required|integer|min:0',
            'firstPublished' => 'required|date_format:Y',
            'author' => 'required',
            'publisher' => 'required',
            'genre' => 'required',
        ], $input);

        $author = $this->getOrMakeAuthor($input['author']);
        $publisher = $this->getOrMakePublisher($input['publisher']);
        $genre = $this->getOrMakeGenre($input['genre']);

        $newBook = $this->bookRepository->makeNewEntity();
        $newBook->title = $input['title'];
        $newBook->authorUuid = $author->uuid;
        $newBook->publiserUuid = $publisher->uuid;
        $newBook->genreUuid = $genre->uuid;
        $newBook->firstPublished = $input['firstPublished'];
        $newBook->wordCount = $input['wordCount'];
        $newBook->averagePrice = $input['averagePrice'];

        $this->saveAll($newBook, $genre, $publisher, $author);
        return $newBook;
    }

    /**
     * @param string $uuid
     * @param RequestContract $request
     * @return mixed
     * @throws Exception
     */
    public function update(string $uuid, RequestContract $request)
    {
        $book = $this->bookRepository->getByUuidOrFail($uuid); //I should make more clear that method throws exception if entity is not found

        $input = $request->get();
        $this->validator->validate([
            'title' => 'string|min:2',
            'averagePrice' => 'numeric',
            'wordCount' => 'integer|min:0',
            'firstPublished' => 'date_format:Y',
        ], $input);

        //it probably would count as side effect, should've avoided it, no means to reliably test
        //generated related entities
        $author = $this->getOrMakeAuthor($input['author'] ?? []);
        $publisher = $this->getOrMakePublisher($input['publisher'] ?? '');
        $genre = $this->getOrMakeGenre($input['genre'] ?? '');

        $book->title = $input['title'] ?? $book->title;
        $book->authorUuid = $author->uuid ?? $book->authorUuid;
        $book->publiserUuid = $publisher->uuid ?? $book->publiserUuid;
        $book->genreUuid = $genre->uuid ?? $book->genreUuid;
        $book->firstPublished = $input['firstPublished'] ?? $book->firstPublished;
        $book->wordCount = $input['wordCount'] ?? $book->wordCount;
        $book->averagePrice = $input['averagePrice'] ?? $book->averagePrice;

        $this->saveAll($book, $genre, $publisher, $author);
        return $book;
    }

    /**
     * @param string $uuid
     */
    public function delete(string $uuid)
    {
        $book = $this->bookRepository->getByUuid($uuid);
        $this->bookRepository->delete($book);
    }

    protected function saveAll($newBook, $genre, $publisher, $author)
    {
        $this->baseService->dbBeginTransaction();

        //to helper method
        try {

            $this->publisherRepository->persist($publisher, true);
            $this->genreRepository->persist($genre, true);
            $this->authorRepository->persist($author, true);
            $this->bookRepository->persist($newBook);

        } catch (\Exception $e) {
            $this->baseService->dbRollback();
            throw $e;
        }

        $this->baseService->dbCommit();
    }

    //ideally - should delegate such functions to according services
    protected function getOrMakeGenre(string $genreName)
    {
        if (empty($genreName)) {
            return $this->genreRepository->makeEmptyEntity();
        }

        $genre = $this->genreRepository->getByName($genreName);

        if (is_null($genre)) {
            $this->validator->validate([
                'name' => 'min:2',
            ], [ 'name' => $genreName ]);

            $genre = $this->genreRepository->makeNewEntity();
            $genre->name = $genreName;
            return $genre;
        }

        return $genre;
    }

    protected function getOrMakePublisher(string $publisherName)
    {
        if (empty($publisherName)) {
            return $this->publisherRepository->makeEmptyEntity();
        }

        $publisher = $this->publisherRepository->getByName($publisherName);

        if (is_null($publisher)) {
            $this->validator->validate([
                'name' => 'min:2',
            ], [ 'name' => $publisher ]);

            $publisher = $this->publisherRepository->makeNewEntity();
            $publisher->name = $publisher;
            return $publisher;
        }

        return $publisher;
    }

    protected function getOrMakeAuthor($authorUuidOrData)
    {
        if (empty($authorUuidOrData)) {
            return $this->authorRepository->makeEmptyEntity();
        }

        if (is_string($authorUuidOrData)) {
            $author = $this->authorRepository->getByUuidOrFail($authorUuidOrData);
            return $author;
        }

        $this->validator->validate([
            'name' => 'min:2',
            'surname' => 'min:2',
        ], $authorUuidOrData);

        $author = $this->genreRepository->makeNewEntity();
        $author->name = $authorUuidOrData['name'];
        $author->surname = $authorUuidOrData['surname'];

        return $author;
    }
}