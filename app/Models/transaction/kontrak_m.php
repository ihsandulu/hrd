<?php

namespace App\Models\transaction;

use App\Models\core_m;

class kontrak_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";




        if ($this->request->getPost("delete") == "OK") {
            $kontrak_ids = $this->request->getPost("kontrak_id");
            // dd($kontrak_ids);
            if ($kontrak_ids) {
                $this->db->table("kontrak")
                    ->whereIn("kontrak_id", array_keys($kontrak_ids))
                    ->delete();

                $data['message'] = 'Delete Success';
            } else {
                $data['message'] = 'Tidak ada user yang cocok dengan filter tersebut.';
            }
        }



        if ($this->request->getPost("create") == "OK") {
            $user_ids = $this->request->getPost('user_id');
            $kontrak_from = $this->request->getPost('kontrak_from');
            $kontrak_to = $this->request->getPost('kontrak_to');
            $kontrak_name = $this->request->getPost('kontrak_name');

            if ($user_ids) {
                foreach ($user_ids as $uid) {
                    // Gunakan ON DUPLICATE KEY UPDATE (raw query)                            
                    $sql = "INSERT IGNORE INTO kontrak (user_id, kontrak_from, kontrak_to, kontrak_name) VALUES (?, ?, ?, ?)";
                    $this->db->query($sql, [$uid, $kontrak_from, $kontrak_to, $kontrak_name]);                   
                }
                // echo $this->db->getLastQuery();die;
                $data["message"] = "Data berhasil disimpan/diupdate!";
            } else {
                $data["message"] = "Tidak ada data dipilih!";
            }
        }


        //echo $_POST["create"];die;
     
        return $data;
    }
}
