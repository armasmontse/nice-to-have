<?php

namespace App\Http\Controllers\Client\MicroServices;


use App\Http\Controllers\Controller;

use App\Http\Helpers\CacheHelper;


class ServiceTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(CacheHelper::getCacheByKey("MSTypes"))
            ->header('Content-Type', "application/json");
    }

}
