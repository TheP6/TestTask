<?php

namespace Domain\Layers\Services\Request\Contracts;

interface Request
{
    public function replace(array $values);

    public function set(string $key, $value);

    public function get(string $key = null);
}