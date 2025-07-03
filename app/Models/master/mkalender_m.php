<?php

namespace App\Models\master;

use App\Models\core_m;

class mkalender_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek kalender
        if ($this->request->getVar("kalender_id")) {
            $kalenderd["kalender_id"] = $this->request->getVar("kalender_id");
        } else {
            $kalenderd["kalender_id"] = -1;
        }
        $us = $this->db
            ->table("kalender")
            ->getWhere($kalenderd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "kalender_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $kalender) {
                foreach ($this->db->getFieldNames('kalender') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $kalender->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('kalender') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $kalender_id =   $this->request->getPost("kalender_id");
            $this->db
                ->table("kalender")
                ->delete(array("kalender_id" =>  $kalender_id));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            $where["kalender_bulan"] = $this->request->getPost("kalender_bulan");
            $where["kalender_year"] = date("Y");
            $jkalender = $this->db->table('kalender')->where("kalender_bulan", $where["kalender_bulan"])->get()->getNumRows();
            // echo $this->db->getLastQuery(); die;
            if ($jkalender == 0) {
                $tahun = date('Y'); // bisa diganti sesuai kebutuhan, misal $tahun = 2025;
                $bulan = $this->request->getPost("kalender_bulan");
                $jhari = [
                    0  => 0,    // Tidak digunakan
                    1  => 31,   // Januari
                    2  => (date('L', strtotime("$tahun-01-01")) ? 29 : 28), // Deteksi kabisat
                    3  => 31,   // Maret
                    4  => 30,   // April
                    5  => 31,   // Mei
                    6  => 30,   // Juni
                    7  => 31,   // Juli
                    8  => 31,   // Agustus
                    9  => 30,   // September
                    10 => 31,   // Oktober
                    11 => 30,   // November
                    12 => 31,   // Desember
                ];
                for ($x = 1; $x <= $jhari[$bulan]; $x++) {
                    $input["kalender_bulan"] = $bulan;
                    $input["kalender_tgl"] = $x;
                    $hari = date("l", mktime(0, 0, 0, $bulan, $x, $tahun));
                    $input["kalender_hari"] = $hari;
                    $libur = 0;
                    $liburk = "";
                    if ($hari === "Sunday" || $hari === "Saturday") {
                        $libur = 1;
                        $liburk = "Week Day";
                    }
                    $input["kalender_libur"] =  $libur;
                    $input["kalender_liburk"] =  $liburk;
                    $input["kalender_year"] = date("Y");

                    $tgl = $tahun . "-" . $bulan . "-" . $x;
                    $xx = date('w', strtotime($tgl));

                    //cari di table jamkerja
                    $build = $this->db->table("jamkerja")
                        ->where("jamkerja_type", "normal")
                        ->where("jamkerja_hari !=", "")
                        ->where("jamkerja_ramadlan", "0")
                        ->where("FIND_IN_SET('" . $xx . "', jamkerja_hari)", null, false);
                    $jamkerja = $build->get();
                    $input["kalender_tipe"] = "";
                    $input["kalender_table"] = "";
                    foreach ($jamkerja->getResult() as $row) {
                        $input["kalender_tipe"] = $row->jamkerja_id;
                        $input["kalender_table"] = "jamkerja";
                        $input["kalender_name"] = $row->jamkerja_name;
                    }

                    //cari di table libur
                    $build = $this->db->table("libur")
                        ->where("libur_date", "0000-00-00")
                        ->where("libur_hari", $xx);
                    $libur = $build->get();
                    foreach ($libur->getResult() as $row) {
                        $input["kalender_tipe"] = $row->libur_id;
                        $input["kalender_table"] = "libur";
                        $input["kalender_name"] = $row->libur_name;
                    }
                    $input["kalender_nhari"] = $xx;

                    /* if ($xx == 6) {
                        dd($input);
                    } */
                    $builder = $this->db->table('kalender');
                    $builder->insert($input);
                    // echo $this->db->getLastQuery(); die;
                    $kalender_id = $this->db->insertID();
                }
            }
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'kalender_picture') {
                    $input[$e] = $this->request->getPost($e);
                    if ($e == 'kalender_hari') {
                        $input[$e] = is_array($f) ? implode(",", $f) : $f;
                    }
                }
            }
            // print_r($input);die;
            $this->db->table('kalender')->update($input, array("kalender_id" => $this->request->getPost("kalender_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
