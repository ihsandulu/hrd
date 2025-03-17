<?php

namespace App\Models\master;

use App\Models\core_m;

class mtunjangan_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tunjangan
        if ($this->request->getVar("tunjangan_id")) {
            $tunjangand["tunjangan_id"] = $this->request->getVar("tunjangan_id");
        } else {
            $tunjangand["tunjangan_id"] = -1;
        }
        $us = $this->db
            ->table("tunjangan")
            ->getWhere($tunjangand);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "tunjangan_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tunjangan) {
                foreach ($this->db->getFieldNames('tunjangan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tunjangan->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('tunjangan') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $tunjangan_id =   $this->request->getPost("tunjangan_id");
            $this->db
                ->table("tunjangan")
                ->delete(array("tunjangan_id" =>  $tunjangan_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tunjangan_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'tunjangan_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('tunjangan');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $tunjangan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tunjangan_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'tunjangan_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('tunjangan')->update($input, array("tunjangan_id" => $this->request->getPost("tunjangan_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
