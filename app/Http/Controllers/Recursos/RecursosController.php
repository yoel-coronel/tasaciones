<?php

namespace App\Http\Controllers\Recursos;

use App\Http\Controllers\Controller;
use App\Services\RecursosService;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    protected $service;
    public function __construct(RecursosService $service)
    {
        $this->service = $service;
    }


    public function getEmpresas(){
        return $this->service->getEmpresas();
    }
}
