<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class absen extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\absen_m();
        $data = $data->data();
        return view('transaction/absen_v', $data);
    }
}
