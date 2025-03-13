<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mwtnumber extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mwtnumber_m();
        $data = $data->data();
        // dd($data);
        return view('master/mwtnumber_v', $data);
    }
}
