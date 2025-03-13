<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class muserposition extends BaseController
{

    protected $sesi_userposition;
    public function __construct()
    {
        $sesi_userposition = new \App\Models\global_m();
        $sesi_userposition->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\muserposition_m();
        $data = $data->data();
        return view('master/muserposition_v', $data);
    }
}
