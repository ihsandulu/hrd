<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class gajiprint extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
    }


    public function index()
    {
        return view('transaction/gajiprint_v');
    }
}
