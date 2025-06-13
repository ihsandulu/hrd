<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class lain extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\lain_m();
        $data = $data->data();
        $data["title"]="Lain-lain";
        return view('transaction/lain_v', $data);
    }
}
