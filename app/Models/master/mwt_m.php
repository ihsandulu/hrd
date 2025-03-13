<?php

namespace App\Models\master;

use App\Models\core_m;

class mwt_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek wt
        if ($this->request->getVar("wt_id")) {
            $wtd["wt_id"] = $this->request->getVar("wt_id");
        } else {
            $wtd["wt_id"] = -1;
        }
        $us = $this->db
            ->table("wt")
            ->getWhere($wtd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "wt_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $wt) {
                foreach ($this->db->getFieldNames('wt') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $wt->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('wt') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $wt_id=   $this->request->getPost("wt_id");  
                $this->db
                ->table("wt")
                ->delete(array("wt_id" =>  $wt_id));
                $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'wt_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('wt');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $wt_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'wt_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('wt')->update($input, array("wt_id" => $this->request->getPost("wt_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
