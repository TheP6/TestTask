<?php

namespace Domain\Layers\Services\Request\Contracts;

interface Validator
{
    public function validate(array $rules, array $data);
}