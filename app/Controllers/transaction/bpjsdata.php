<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class bpjsdata extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\bpjsdata_m();
        $data = $data->data();
        $data["title"]="Data BPJS";
        return view('transaction/bpjsdata_v', $data);
    }
}
