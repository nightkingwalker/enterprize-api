<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $model;
    protected $resource;
    protected $collectionResource;
    protected $rules = [];

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    protected function validateRequest(Request $request, array $rules = null)
    {
        return $request->validate($rules ?? $this->rules);
    }
}
