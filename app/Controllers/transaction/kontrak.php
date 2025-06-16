<?php

namespace App\Controllers\transaction;


use App\Controllers\baseController;

class kontrak extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\transaction\kontrak_m();
        $data = $data->data();
        $data["title"]="Kontrak";
        return view('transaction/kontrak_v', $data);
    }
}
