<?php

namespace App\Models\master;

use App\Models\core_m;

class mlibur_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek libur
        if ($this->request->getVar("libur_id")) {
            $liburd["libur_id"] = $this->request->getVar("libur_id");
        } else {
            $liburd["libur_id"] = -1;
        }
        $us = $this->db
            ->table("libur")
            ->getWhere($liburd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "libur_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $libur) {
                foreach ($this->db->getFieldNames('libur') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $libur->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('libur') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $libur_id =   $this->request->getPost("libur_id");
            $this->db
                ->table("libur")
                ->delete(array("libur_id" =>  $libur_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'libur_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'libur_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('libur');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $libur_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'libur_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'libur_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('libur')->update($input, array("libur_id" => $this->request->getPost("libur_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
