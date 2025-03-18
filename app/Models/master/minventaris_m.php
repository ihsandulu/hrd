<?php

namespace App\Models\master;

use App\Models\core_m;

class minventaris_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek inventaris
        if ($this->request->getVar("inventaris_id")) {
            $inventarisd["inventaris_id"] = $this->request->getVar("inventaris_id");
        } else {
            $inventarisd["inventaris_id"] = -1;
        }
        $us = $this->db
            ->table("inventaris")
            ->getWhere($inventarisd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "inventaris_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $inventaris) {
                foreach ($this->db->getFieldNames('inventaris') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $inventaris->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('inventaris') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $inventaris_id =   $this->request->getPost("inventaris_id");
            $this->db
                ->table("inventaris")
                ->delete(array("inventaris_id" =>  $inventaris_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'inventaris_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'inventaris_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('inventaris');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $inventaris_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'inventaris_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'inventaris_hari'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('inventaris')->update($input, array("inventaris_id" => $this->request->getPost("inventaris_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
