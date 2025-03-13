<?php

namespace App\Models\master;

use App\Models\core_m;

class mjamkerja_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek jamkerja
        if ($this->request->getVar("jamkerja_id")) {
            $jamkerjad["jamkerja_id"] = $this->request->getVar("jamkerja_id");
        } else {
            $jamkerjad["jamkerja_id"] = -1;
        }
        $us = $this->db
            ->table("jamkerja")
            ->getWhere($jamkerjad);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "jamkerja_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $jamkerja) {
                foreach ($this->db->getFieldNames('jamkerja') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $jamkerja->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('jamkerja') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $jamkerja_id =   $this->request->getPost("jamkerja_id");
            $this->db
                ->table("jamkerja")
                ->delete(array("jamkerja_id" =>  $jamkerja_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'jamkerja_id') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'jamkerja_position'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('jamkerja');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $jamkerja_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'jamkerja_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if($e == 'jamkerja_position'){
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('jamkerja')->update($input, array("jamkerja_id" => $this->request->getPost("jamkerja_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
