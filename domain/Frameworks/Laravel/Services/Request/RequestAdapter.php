<?php
/**
 * Created by PhpStorm.
 * User: TheP6
 * Date: 03.03.2019
 * Time: 22:24
 */

namespace Domain\Frameworks\Laravel\Services\Request;

use Illuminate\Http\Request as LaravelRequest;
use Domain\Layers\Services\Request\Contracts\Request;

class RequestAdapter implements Request
{
    protected $laravelRequest;

    public function __construct(LaravelRequest $request)
    {
        $this->laravelRequest = $request;
    }

    public function all()
    {
        return $this->laravelRequest->all();
    }

    public function replace(array $input)
    {
        $this->laravelRequest->replace($input);
    }

    public function set(string $key, $value)
    {
        $this->laravelRequest->merge([
            $key => $value
        ]);
    }

    public function get(string $key = null, $default = null)
    {
        $this->laravelRequest->input($key, $default);
    }

}