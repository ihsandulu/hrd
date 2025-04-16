<?php

namespace App\Models\transaction;

use App\Models\core_m;

class lembur_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";




        if ($this->request->getPost("delete") == "OK") {
            $departemen_id = $this->request->getPost("departemen_id");
            $position_id = $this->request->getPost("position_id");
            $dari = $this->request->getPost("dari");
            $ke = $this->request->getPost("ke");

            // Step 1: Ambil semua user_id yang sesuai
            $userQuery = $this->db->table('user');

            if (!empty($departemen_id)) {
                $userQuery->where('departemen_id', $departemen_id);
            }

            if (!empty($position_id)) {
                $userQuery->where('position_id', $position_id);
            }

            $users = $userQuery->get()->getResultArray();
            $user_ids = array_column($users, 'user_id');

            // Step 2: Hapus dari lembur berdasarkan user_id dan tanggal
            if (!empty($user_ids)) {
                $this->db->table('lembur')
                    ->whereIn('user_id', $user_ids)
                    ->where('lembur_date >=', $dari)
                    ->where('lembur_date <=', $ke)
                    ->delete();

                $data['message'] = 'Delete Success';
            } else {
                $data['message'] = 'Tidak ada user yang cocok dengan filter tersebut.';
            }
        }



        if ($this->request->getPost("create") == "OK") {
            $user_ids = $this->request->getPost('user_id');
            $lembur_date = $this->request->getPost('lembur_date');
            $lembur_jam = $this->request->getPost('lembur_jam');
            $lembur_type = $this->request->getPost('lembur_type');




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
                    $sql = "INSERT INTO lembur (user_id, lembur_date, lembur_jam, lembur_type)
                            VALUES (:user_id:, :lembur_date:, :lembur_jam:, :lembur_type:)
                            ON DUPLICATE KEY UPDATE  lembur_jam = :lembur_jam:";

                    $this->db->query($sql, [
                        'user_id' => $uid,
                        'lembur_date' => $lembur_date,
                        'lembur_jam' => $lembur_jam,
                        'lembur_type' => $lembur_type,
                    ]);
                    $this->db->table("user")->where("user_id", $uid)->update([
                        "user_cuti" => $cutiuser[$uid] + 1
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
