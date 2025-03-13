<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mjamkerja extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mjamkerja_m();
        $data = $data->data();
        return view('master/mjamkerja_v', $data);
    }
}
