<?php

namespace App\Models\master;

use App\Models\core_m;

class mwtnumber_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek wtnumber
        if ($this->request->getVar("wtnumber_id")) {
            $wtnumberd["wtnumber_id"] = $this->request->getVar("wtnumber_id");
        } else {
            $wtnumberd["wtnumber_id"] = -1;
        }
        $us = $this->db
            ->table("wtnumber")
            ->getWhere($wtnumberd);
        // echo $this->db->getLastquery(); die;
        $larang = array("log_id", "id", "action", "data", "wtnumber_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $wtnumber) {
                foreach ($this->db->getFieldNames('wtnumber') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $wtnumber->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('wtnumber') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $wtnumber_id = $this->request->getPost("wtnumber_id");              
            $this->db
            ->table("wtnumber")
            ->delete(array("wtnumber_id" =>  $wtnumber_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'wtnumber_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $builder = $this->db->table('wtnumber');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $wtnumber_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'wtnumber_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('wtnumber')->update($input, array("wtnumber_id" => $this->request->getPost("wtnumber_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
