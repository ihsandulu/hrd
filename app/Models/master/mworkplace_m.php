<?php

namespace App\Models\master;

use App\Models\core_m;

class mworkplace_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek workplace
        if ($this->request->getVar("workplace_id")) {
            $workplaced["workplace_id"] = $this->request->getVar("workplace_id");
        } else {
            $workplaced["workplace_id"] = -1;
        }
        $us = $this->db
            ->table("workplace")
            ->getWhere($workplaced);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "workplace_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $workplace) {
                foreach ($this->db->getFieldNames('workplace') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $workplace->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('workplace') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $workplace_id =   $this->request->getPost("workplace_id");
            $this->db
                ->table("workplace")
                ->delete(array("workplace_id" =>  $workplace_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'workplace_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('workplace');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $workplace_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'workplace_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('workplace')->update($input, array("workplace_id" => $this->request->getPost("workplace_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
