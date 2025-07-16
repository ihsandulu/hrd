<?php

namespace App\Controllers\master;


use App\Controllers\baseController;

class mworkplace extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\master\mworkplace_m();
        $data = $data->data();
        $data["title"]="Master Workplace";
        return view('master/mworkplace_v', $data);
    }
}
