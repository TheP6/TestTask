<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 22:24
 */

namespace Domain\Frameworks\Laravel\Services\Validation;


use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Domain\Layers\Services\Request\Contracts\Validator;

class ValidationAdapter implements Validator
{

    public function validate(array $rules, array $data)
    {
       $laravelValidator = ValidatorFacade::make($data, $rules);
       return $laravelValidator->validate();
    }

}