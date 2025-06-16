<?php

namespace App\Models\master;

use App\Models\core_m;

class mpassword_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek user
        if ($this->request->getVar("user_id")) {
            $userd["user_id"] = $this->request->getVar("user_id");
        } else {
            $userd["user_id"] = 0;
        }
        $us = $this->db
            ->table("user")
            ->getWhere($userd);
        //echo $this->db->getLastquery();
        //die;
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    $data[$field] = $user->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }



        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'user_password') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            // password yang diketik user di form
            $plain_password = $this->request->getPost("user_password");

            // Key dan metode
            $key = "ihsandulu123456"; // Simpan ini di .env di produksi
            $method = "AES-256-CBC";
            $iv_length = openssl_cipher_iv_length($method);

            // Buat IV acak sepanjang 16 byte
            $iv = openssl_random_pseudo_bytes($iv_length);

            // Enkripsi password
            $encrypted = openssl_encrypt($plain_password, $method, $key, 0, $iv);

            // Gabungkan IV + encrypted string
            $final_password = base64_encode($iv . $encrypted); // ← Simpan ini ke database

            // Simpan ke database, misalnya:
            $input["user_password"] = $final_password;
            $this->db->table('user')->update($input, array("user_id" => $this->request->getPost("user_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
