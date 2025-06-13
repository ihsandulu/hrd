<?php

namespace App\Models\transaction;

use App\Models\core_m;

class lain_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";




        if ($this->request->getPost("delete") == "OK") {
            $user_ids = $this->request->getPost('user_id');

            if ($user_ids) {
                $this->db->table("lain")
                    ->whereIn("user_id", array_keys($user_ids))
                    ->delete(); 
                $data['message'] = 'Delete Success';
            } else {
                $data["message"] = "Tidak ada data dipilih!";
            }
        }


        if ($this->request->getPost("create") == "OK") {
            $user_ids = $this->request->getPost('user_id');
            $lain_date = $this->request->getPost('lain_date');
            $lain_nominal = $this->request->getPost('lain_nominal');
            $lain_keterangan = $this->request->getPost('lain_keterangan');
            $lain_type = $this->request->getPost('lain_type');

            if ($user_ids) {
                //cari sisa hutang
                $user = $this->db->table("user")
                    ->whereIn("user_id", $user_ids)
                    ->get();
                $cutiuser = array();
                foreach ($user->getResult() as $row) {
                    $cutiuser[$row->user_id] = $row->user_cuti;
                }
                // echo "<pre>";print_r($cutiuser);die;

                foreach ($user_ids as $uid) {
                    // Gunakan ON DUPLICATE KEY UPDATE (raw query)
                    $sql = "INSERT INTO lain (user_id, lain_date, lain_nominal, lain_keterangan, lain_type)
                            VALUES (:user_id:, :lain_date:, :lain_nominal:, :lain_keterangan:, :lain_type:)
                            ON DUPLICATE KEY UPDATE  lain_nominal = :lain_nominal:, lain_keterangan = :lain_keterangan:, lain_type = :lain_type:";

                    $this->db->query($sql, [
                        'user_id' => $uid,
                        'lain_date' => $lain_date,
                        'lain_nominal' => $lain_nominal,
                        'lain_keterangan' => $lain_keterangan,
                        'lain_type' => $lain_type,
                    ]);                   
                }
                // echo $this->db->getLastQuery();die;

                $data["message"] = "Data berhasil disimpan/diupdate!";
            } else {
                $data["message"] = "Tidak ada data dipilih!";
            }
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
