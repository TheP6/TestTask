<?php

namespace Domain\Layers\Services\Request\Contracts;

//isolation from third-party libraries
interface Request
{
    public function replace(array $input);

    public function all();

    public function set(string $key, $value);

    public function get(string $key = null, $default = null);
}