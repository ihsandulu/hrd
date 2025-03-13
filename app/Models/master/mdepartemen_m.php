<?php

namespace App\Models\master;

use App\Models\core_m;

class mdepartemen_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek departemen
        if ($this->request->getVar("departemen_id")) {
            $departemend["departemen_id"] = $this->request->getVar("departemen_id");
        } else {
            $departemend["departemen_id"] = -1;
        }
        $us = $this->db
            ->table("departemen")
            ->getWhere($departemend);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "departemen_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $departemen) {
                foreach ($this->db->getFieldNames('departemen') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $departemen->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('departemen') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $departemen_id =   $this->request->getPost("departemen_id");
            $this->db
                ->table("departemen")
                ->delete(array("departemen_id" =>  $departemen_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'departemen_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('departemen');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $departemen_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'departemen_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('departemen')->update($input, array("departemen_id" => $this->request->getPost("departemen_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
