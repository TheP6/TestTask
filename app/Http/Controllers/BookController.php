<?php

namespace App\Http\Controllers;

use Domain\Layers\Services\Business\Contracts\BookService as BookServiceContact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Domain\Frameworks\Laravel\Services\Request\RequestAdapter as DomainRequest;

class BookController extends BaseController {

    /**
     * @var BookServiceContact
     */
    protected $bookService;

    public function __construct(BookServiceContact $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $books = $this->bookService->search(
            $this->wrapRequest($request)
        );


        $booksArray = [];
        foreach ($books as $book) {
            $booksArray[] = $this->apifyBook($book);
        }

        return response()->json($booksArray);
    }

    /**
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show(string $uuid)
    {
        $book = $this->bookService->fetchOne($uuid);
        return response()->json($book);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $book = $this->bookService->create(
            $this->wrapRequest($request)
        );

        return response()->json($this->apifyBook($book));
    }

    /**
     * @param string $uuid
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(string $uuid, Request $request) {
        $book = $books = $this->bookService->update(
            $uuid,
            $this->wrapRequest($request)
        );

        return response()->json($this->apifyBook($book));
    }

    /**
     * @param string $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $uuid)
    {
        $this->bookService->delete($uuid);

        return response()->json([
            'message' => 'Book deleted',
        ]);
    }

    /**
     * @param Request $request
     * @return DomainRequest
     */
    protected function wrapRequest(Request $request)
    {
        return new DomainRequest($request);
    }

    //todo: move transformation to api-resource @ap
    protected function apifyBook($book)
    {
        $tmp = [];
        $tmp['uuid'] = $book->uuid;
        $tmp['title'] = $book->title;
        $tmp['publisher'] = $book->publisher->name;
        $tmp['author'] = $book->author->name." ".$book->author->surname;
        $tmp['genre'] = $book->genre->name;
        $tmp['firstPublished'] = $book->firstPublished;
        $tmp['averagePrice'] = $book->averagePrice;
        return $tmp;
    }
}