<?php

namespace App\Models\master;

use App\Models\core_m;

class mramadlan_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek ramadlan
        if ($this->request->getVar("ramadlan_id")) {
            $ramadland["ramadlan_id"] = $this->request->getVar("ramadlan_id");
        } else {
            $ramadland["ramadlan_id"] = -1;
        }
        $us = $this->db
            ->table("ramadlan")
            ->getWhere($ramadland);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "ramadlan_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $ramadlan) {
                foreach ($this->db->getFieldNames('ramadlan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $ramadlan->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('ramadlan') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $ramadlan_id =   $this->request->getPost("ramadlan_id");
            $this->db
                ->table("ramadlan")
                ->delete(array("ramadlan_id" =>  $ramadlan_id));
            $data["message"] = "Delete Success";
        }

        //generate
        if ($this->request->getPost("generate") == "OK") {
            $dari = $this->request->getPost("dari");
            $ke = $this->request->getPost("ke");

            $builder = $this->db->table('ramadlan');

            // Ubah string tanggal menjadi format DateTime
            $start = new \DateTime($dari);
            $end = new \DateTime($ke);

            // Loop dari tanggal awal ke tanggal akhir
            while ($start <= $end) {
                $input = [
                    'ramadlan_date' => $start->format('Y-m-d') // Format YYYY-MM-DD
                ];
                $builder->insert($input);

                // Tambahkan 1 hari
                $start->modify('+1 day');
            }

            $ramadlan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'ramadlan_id') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'ramadlan_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('ramadlan');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $ramadlan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'ramadlan_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'ramadlan_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('ramadlan')->update($input, array("ramadlan_id" => $this->request->getPost("ramadlan_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
