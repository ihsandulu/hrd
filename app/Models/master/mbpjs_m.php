<?php

namespace App\Models\master;

use App\Models\core_m;

class mbpjs_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek bpjs
        if ($this->request->getVar("bpjs_id")) {
            $bpjsd["bpjs_id"] = $this->request->getVar("bpjs_id");
        } else {
            $bpjsd["bpjs_id"] = -1;
        }
        $us = $this->db
            ->table("bpjs")
            ->getWhere($bpjsd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "bpjs_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $bpjs) {
                foreach ($this->db->getFieldNames('bpjs') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $bpjs->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('bpjs') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $bpjs_id =   $this->request->getPost("bpjs_id");
            $this->db
                ->table("bpjs")
                ->delete(array("bpjs_id" =>  $bpjs_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'bpjs_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'bpjs_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('bpjs');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $bpjs_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'bpjs_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'bpjs_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('bpjs')->update($input, array("bpjs_id" => $this->request->getPost("bpjs_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
