<?php

namespace App\Models\master;

use App\Models\core_m;

class mter_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek ter
        if ($this->request->getVar("ter_id")) {
            $terd["ter_id"] = $this->request->getVar("ter_id");
        } else {
            $terd["ter_id"] = -1;
        }
        $us = $this->db
            ->table("ter")
            ->getWhere($terd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "ter_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $ter) {
                foreach ($this->db->getFieldNames('ter') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $ter->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('ter') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $ter_id =   $this->request->getPost("ter_id");
            $this->db
                ->table("ter")
                ->delete(array("ter_id" =>  $ter_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'ter_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'ter_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('ter');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $ter_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'ter_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'ter_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('ter')->update($input, array("ter_id" => $this->request->getPost("ter_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
