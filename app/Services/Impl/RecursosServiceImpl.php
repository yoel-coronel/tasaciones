<?php

namespace App\Services\Impl;

use App\Services\RecursosService;

class RecursosServiceImpl implements RecursosService
{
    protected $url;
    protected $token;

    public function __construct()
    {
        $this->url = config('services.ser01.domain');
        $this->token = config('services.ser01.token');
    }

    public function getEmpresas()
    {
        $res = get_object_vars(json_decode(file_get_contents($this->url."/api/v1/guest/notifications/empresas?token=".$this->token)));

        if ($res['error'] === 0){
            return $res['data'];
        }
        return null;

    }
}
