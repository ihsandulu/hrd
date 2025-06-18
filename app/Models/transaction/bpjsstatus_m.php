<?php

namespace App\Models\transaction;

use App\Models\core_m;

class bpjsstatus_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";




        if ($this->request->getPost("delete") == "OK") {
            $bpjsstatus_ids = $this->request->getPost("bpjsstatus_id");
            // dd($bpjsstatus_ids);
            if ($bpjsstatus_ids) {
                $this->db->table("bpjsstatus")
                    ->whereIn("bpjsstatus_id", array_keys($bpjsstatus_ids))
                    ->delete();

                $data['message'] = 'Delete Success';
            } else {
                $data['message'] = 'Tidak ada user yang cocok dengan filter tersebut.';
            }
        }

        if ($this->request->getPost("create") == "OK") {
            $user_ids = $this->request->getPost('user_id');
            $bpjsstatus_date = date("Y-m-d");
            $bpjsstatus_statusk = $this->request->getPost('bpjsstatus_statusk');
            $bpjsstatus_statustk = $this->request->getPost('bpjsstatus_statustk');

            if ($user_ids) {  
                foreach ($user_ids as $uid) {
                    // Gunakan ON DUPLICATE KEY UPDATE (raw query)                            
                    $sql = "INSERT IGNORE INTO bpjsstatus (user_id, bpjsstatus_date, bpjsstatus_statustk, bpjsstatus_statusk) VALUES (?, ?, ?, ?)";
                    $this->db->query($sql, [$uid, $bpjsstatus_date, $bpjsstatus_statustk, $bpjsstatus_statusk]); 
                    
                    $this->db->table("user")->where("user_id", $uid)->update([
                        "user_bpjsstatustk" => $bpjsstatus_statustk,
                        "user_bpjsstatusk" => $bpjsstatus_statusk
                    ]);
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
