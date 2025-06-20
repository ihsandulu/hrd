<?php

namespace App\Models\transaction;

use App\Models\core_m;

class bpjsdata_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";




        if ($this->request->getPost("delete") == "OK") {
            $bpjsdata_ids = $this->request->getPost("bpjsdata_id");
            // dd($bpjsdata_ids);
            if ($bpjsdata_ids) {
                $this->db->table("bpjsdata")
                    ->whereIn("bpjsdata_id", array_keys($bpjsdata_ids))
                    ->delete();

                $data['message'] = 'Delete Success';
            } else {
                $data['message'] = 'Tidak ada user yang cocok dengan filter tersebut.';
            }
        }

        if ($this->request->getPost("create") == "OK") {
            $user_id = $this->request->getPost('user_id');
            $user_nik = $this->request->getPost('user_nik');
            $user_ktp = $this->request->getPost('user_ktp');


            $this->db->table("user")->where("user_id", $user_id)->update([
                "user_ktp" => $user_ktp,
                "user_nik" => $user_nik
            ]);

            // echo $this->db->getLastQuery();die;
            $data["message"] = "Data berhasil disimpan/diupdate!";
        }
        //echo $_POST["create"];die;     
        return $data;
    }
}
