<?php

namespace App\Models\transaction;

use App\Models\core_m;

class absen_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek absen
        if ($this->request->getVar("absen_id")) {
            $absend["absen_id"] = $this->request->getVar("absen_id");
        } else {
            $absend["absen_id"] = -1;
        }
        $us = $this->db
            ->table("absen")
            ->getWhere($absend);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "absen_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $absen) {
                foreach ($this->db->getFieldNames('absen') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $absen->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('absen') as $field) {
                $data[$field] = "";
            }
        }

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $absen_id = $this->request->getPost("absen_id");              
            $this->db
            ->table("absen")
            ->delete(array("absen_id" =>  $absen_id));
            $data["message"] = "Delete Success";
        }

         //submit
         if ($this->request->getPost("submit") == "OK") {
            $inpututama = $this->request->getPost("datakartu");
            $bintang = explode("*", $inpututama);

            //absen
            $pisah = $bintang[0];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
            }
            $builder = $this->db->table('absen');
            $builder->insert($input);            
            /* echo $this->db->getLastQuery();
            die; */
            $absen_id = $this->db->insertID();

            //panen
            $panjangBintang = count($bintang);
            for ($i = 1; $i < $panjangBintang; $i++) {
                $pisah = $bintang[$i];
                $koma = explode(",", $pisah);
                foreach ($koma as $isikoma) {
                    $data = explode("=", $isikoma);
                    $inputpanen[$data[0]] = $data[1];
                }
                $builder = $this->db->table('panen');
                $builder->insert($inputpanen);            
                /* echo $this->db->getLastQuery();
                die; */
                $panen_id = $this->db->insertID();
            }
            




            $data["message"] = "Insert Data Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'absen_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $absen_datetime=$input["absen_datetime"];
            $date=substr($absen_datetime,0,10);
            $time=substr($absen_datetime,12,5);
            $input["absen_date"] = $date;
            $input["absen_time"] = $time;
            // echo $input["absen_time"];die;
            $input["user_id"] = session()->get("user_id");
            $builder = $this->db->table('absen');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $absen_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'absen_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $absen_datetime=$input["absen_datetime"];
            $date=substr($absen_datetime,0,10);
            $time=substr($absen_datetime,12,5);
            $input["absen_date"] = $date;
            $input["absen_time"] = $time;
            $this->db->table('absen')->update($input, array("absen_id" => $this->request->getPost("absen_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
