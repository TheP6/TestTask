<?php

namespace Domain\Layers\Services\Validation\Contracts;

//isolation from third-party libraries
interface Validator
{
    public function validate(array $rules, array $data);
}