<?php

namespace App\Models\transaction;

use App\Models\core_m;

class lembur_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek lembur
        if ($this->request->getVar("lembur_id")) {
            $lemburd["lembur_id"] = $this->request->getVar("lembur_id");
        } else {
            $lemburd["lembur_id"] = -1;
        }
        $us = $this->db
            ->table("lembur")
            ->join("user","user.user_id=lembur.user_id","left")
            ->join("position","position.position_id=user.position_id","left")
            ->join("departemen","departemen.departemen_id=user.departemen_id","left")
            ->getWhere($lemburd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "action", "data", "lembur_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $lembur) {
                foreach ($this->db->getFieldNames('lembur') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lembur->$field;
                    }
                }
                foreach ($this->db->getFieldNames('user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lembur->$field;
                    }
                }
                foreach ($this->db->getFieldNames('position') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lembur->$field;
                    }
                }
                foreach ($this->db->getFieldNames('departemen') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $lembur->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('lembur') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('position') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->getFieldNames('departemen') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $lembur_id =   $this->request->getPost("lembur_id");
            $this->db
                ->table("lembur")
                ->delete(array("lembur_id" =>  $lembur_id));
            $data["message"] = "Delete Success";
        }

        //generate
        if ($this->request->getPost("generate") == "OK") {
            $dari = $this->request->getPost("dari");
            $ke = $this->request->getPost("ke");

            $builder = $this->db->table('lembur');

            // Ubah string tanggal menjadi format DateTime
            $start = new \DateTime($dari);
            $end = new \DateTime($ke);

            // Loop dari tanggal awal ke tanggal akhir
            while ($start <= $end) {
                $input = [
                    'lembur_date' => $start->format('Y-m-d') // Format YYYY-MM-DD
                ];
                $builder->insert($input);

                // Tambahkan 1 hari
                $start->modify('+1 day');
            }

            $lembur_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'lembur_id') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'lembur_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $builder = $this->db->table('lembur');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $lembur_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'lembur_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'lembur_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('lembur')->update($input, array("lembur_id" => $this->request->getPost("lembur_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
