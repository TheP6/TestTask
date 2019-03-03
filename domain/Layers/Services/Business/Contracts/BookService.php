<?php

namespace Domain\Layers\Services\Business\Contracts;

use Domain\Layers\Services\Request\Contracts\Request as RequestContract;

interface BookService
{
    /**
     * @param string $uuid
     * @return mixed
     * @throws \Exception
     */
    public function fetchOne(string $uuid);

    /**
     * @param RequestContract $request
     * @return mixed
     */
    public function search(RequestContract $request);

    /**
     * @param RequestContract $request
     * @return mixed
     * @throws \Exception
     */
    public function create(RequestContract $request);

    /**
     * @param string $uuid
     * @param RequestContract $request
     * @return mixed
     * @throws \Exception
     */
    public function update(string $uuid, RequestContract $request);

    /**
     * @param string $uuid
     */
    public function delete(string $uuid);
}