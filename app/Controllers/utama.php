<?php

namespace App\Controllers;



class utama extends BaseController
{

    protected $sesi_user;
    protected $session;
    public function __construct()
    {
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();        
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        return view('utama_v');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url("?message=Silahkan Login !"));
    }

    public function login()
    {
        $data = new \App\Models\login_m();
        $data = $data->index();
        if ($data['masuk'] == 1) {
            if(session()->get("position_administrator")==1||session()->get("position_administrator")==2){
                return redirect()->to(base_url('utama?message=' . $data["hasil"]));
            }else{
                return redirect()->to(base_url('utama?message=' . $data["hasil"]));
            }
        }
        return view('login_v', $data);
    }
}
