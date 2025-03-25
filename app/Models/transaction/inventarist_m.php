<?php

namespace App\Models\transaction;

use App\Models\core_m;

class inventarist_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek inventarist
        if ($this->request->getVar("inventarist_id")) {
            $inventaristd["inventarist_id"] = $this->request->getVar("inventarist_id");
        } else {
            $inventaristd["inventarist_id"] = -1;
        }
        $us = $this->db
            ->table("inventarist")
            ->getWhere($inventaristd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "action", "data", "inventarist_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $inventarist) {
                foreach ($this->db->getFieldNames('inventarist') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $inventarist->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('inventarist') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $inventarist_id =   $this->request->getPost("inventarist_id");
            $this->db
                ->table("inventarist")
                ->delete(array("inventarist_id" =>  $inventarist_id));
            $data["message"] = "Delete Success";
        }

        //generate
        if ($this->request->getPost("generate") == "OK") {
            $dari = $this->request->getPost("dari");
            $ke = $this->request->getPost("ke");

            $builder = $this->db->table('inventarist');

            // Ubah string tanggal menjadi format DateTime
            $start = new \DateTime($dari);
            $end = new \DateTime($ke);

            // Loop dari tanggal awal ke tanggal akhir
            while ($start <= $end) {
                $input = [
                    'inventarist_date' => $start->format('Y-m-d') // Format YYYY-MM-DD
                ];
                $builder->insert($input);

                // Tambahkan 1 hari
                $start->modify('+1 day');
            }

            $inventarist_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'inventarist_id') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'inventarist_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('inventarist');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $inventarist_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'inventarist_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'inventarist_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('inventarist')->update($input, array("inventarist_id" => $this->request->getPost("inventarist_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
