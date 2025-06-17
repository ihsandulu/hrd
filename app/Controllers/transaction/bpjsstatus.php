<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class bpjsstatus extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\bpjsstatus_m();
        $data = $data->data();
        $data["title"]="Status BPJS";
        return view('transaction/bpjsstatus_v', $data);
    }
}
