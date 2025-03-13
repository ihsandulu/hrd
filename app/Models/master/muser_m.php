<?php

namespace App\Models\master;

use App\Models\core_m;

class muser_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek user
        if ($this->request->getVar("user_id")) {
            $userd["user_id"] = $this->request->getVar("user_id");
        } else {
            $userd["user_id"] = -1;
        }
        $us = $this->db
            ->table("user")
            ->getWhere($userd);
        //echo $this->db->getLastquery();
        //die;
        $larang = array("log_id", "id",  "action", "data", "user_id_dep", "trx_id", "trx_code", "contact_id_dep");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $user->$field;
                    }
                }
                // Kunci dan metode enkripsi
                $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
                $method = "AES-256-CBC";
                // Dekripsi
                $datak = base64_decode($user->user_password);
                $iv_dec = substr($datak, 0, openssl_cipher_iv_length($method));
                $encrypted_data = substr($datak, openssl_cipher_iv_length($method));
                $decrypted = openssl_decrypt($encrypted_data, $method, $key, 0, $iv_dec);
                $data["user_password"] = $decrypted;
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $user_id = $this->request->getPost("user_id");
            $cek = $this->db->table("placement")
                ->where("user_id", $user_id)
                ->get()
                ->getNumRows();
            if ($cek > 0) {
                $data["message"] = "User masih dipakai di data 'Placement'!";
            } else {
                $this->db
                    ->table("user")
                    ->delete(array("user_id" =>  $user_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create') {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }

            // Kunci dan metode enkripsi
            $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
            $method = "AES-256-CBC";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

            // Enkripsi
            $password = $inputu["user_password"];
            $encrypted = openssl_encrypt($password, $method, $key, 0, $iv);
            $encrypted = base64_encode($iv . $encrypted); // Gabungkan IV agar bisa didekripsi nanti
            $inputu["user_password"] = $encrypted;
            $this->db->table('user')->insert($inputu);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change') {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }
            // Kunci dan metode enkripsi
            $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
            $method = "AES-256-CBC";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            // Enkripsi
            $password = $inputu["user_password"];
            $encrypted = openssl_encrypt($password, $method, $key, 0, $iv);
            $encrypted = base64_encode($iv . $encrypted); // Gabungkan IV agar bisa didekripsi nanti
            $inputu["user_password"] = $encrypted;
            $this->db->table('user')
                ->where("user_id", $inputu["user_id"])
                ->update($inputu);
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
