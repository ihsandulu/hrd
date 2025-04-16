<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class cutihutang extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\cutihutang_m();
        $data = $data->data();
        return view('transaction/cutihutang_v', $data);
    }
}
