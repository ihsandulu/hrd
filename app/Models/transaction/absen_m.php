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
        $larang = array("log_id", "id", "action", "data", "absen_id_dep", "trx_id", "trx_code");
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
            //cek absen
            $cekcok["user_id"] = $input["user_id"];
            $cekcok["absen_date"] = $input["absen_date"];
            $cek = $this->db->table("absen")->where($cekcok)->get()->getNumRows();
            if ($cek > 0) {
                $data["message"] = "Insert Data Gagal! Duplikat data.";
            } else {

                //cari jml jam kerja
                if ($input["absen_keluar"] != "") {
                    $masuk = new \DateTime($input["absen_masuk"]);
                    $keluar = new \DateTime($input["absen_keluar"]);
                    $diff = $masuk->diff($keluar);
                    $jml_jam = $diff->h + ($diff->i / 60);
                    $input["absen_kerjajam"] = $jml_jam;

                    /* //apakah ramadlan
                    $arramadlan = $this->db->table("ramadlan")->where("SUBSTR(ramadlan_date,1,4)", date("Y"))->get()->getResultArray();
                    if (in_array($input["absen_date"], $arramadlan)) {
                        $ramadlan = 1;
                    } else {
                        $ramadlan = 0;
                    }

                    //cek jam kerja hari itu
                    $hariAbsen = date("w", strtotime($input["absen_date"]));
                    $wkerja["jamkerja_type"] = "normal";
                    $wkerja["jamkerja_ramadlan"] = $ramadlan;
                    $jamkerja = $this->db->table("jamkerja")
                        ->where($wkerja)
                        ->where("FIND_IN_SET($hariAbsen, jamkerja_hari) > 0")
                        ->get();
                        $lembur=0;
                    foreach ($jamkerja->getResult() as $jamkerja) {
                        $masuk = new \DateTime($jamkerja->jamkerja_awal);
                        $keluar = new \DateTime($jamkerja->jamkerja_akhir);
                        $diff = $masuk->diff($keluar);
                        $jjam = $diff->h + ($diff->i / 60);                        
                        $lembur = $jml_jam-$jjam;
                    }
                    $input["absen_lemburjam"] = $lembur; */
                }

                //ambil lembur
                $wlembur["lembur_date"] = $input["absen_date"];
                $wlembur["user_id"] = $input["user_id"];
                $lembur = $this->db->table("lembur")->where()->get();
                $lemburjam = 0;
                foreach ($lembur->getResult() as $lembur) {
                    $lemburjam += $lembur->lembur_jam;
                }
                $input["absen_lemburjam"] = $lemburjam;

                $builder = $this->db->table('absen');
                $builder->insert($input);
                /* echo $this->db->getLastQuery();
            die; */
                $absen_id = $this->db->insertID();
                $data["message"] = "Insert Data Success";
            }
        }

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'absen_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            //cari jml jam kerja
            if ($input["absen_keluar"] != "") {
                $masuk = new \DateTime($input["absen_masuk"]);
                $keluar = new \DateTime($input["absen_keluar"]);
                $diff = $masuk->diff($keluar);
                $jml_jam = $diff->h + ($diff->i / 60);
                $input["absen_kerjajam"] = $jml_jam;

                /* //apakah ramadlan
                $arramadlan = $this->db->table("ramadlan")->where("SUBSTR(ramadlan_date,1,4)", date("Y"))->get()->getResultArray();
                if (in_array($input["absen_date"], $arramadlan)) {
                    $ramadlan = 1;
                } else {
                    $ramadlan = 0;
                }

                //cek jam kerja hari itu
                $hariAbsen = date("w", strtotime($input["absen_date"]));
                $wkerja["jamkerja_type"] = "normal";
                $wkerja["jamkerja_ramadlan"] = $ramadlan;
                $jamkerja = $this->db->table("jamkerja")
                    ->where($wkerja)
                    ->where("FIND_IN_SET($hariAbsen, jamkerja_hari) > 0")
                    ->get();
                    $lembur=0;
                foreach ($jamkerja->getResult() as $jamkerja) {
                    $masuk = new \DateTime($jamkerja->jamkerja_awal);
                    $keluar = new \DateTime($jamkerja->jamkerja_akhir);
                    $diff = $masuk->diff($keluar);
                    $jjam = $diff->h + ($diff->i / 60);                        
                    $lembur = $jml_jam-$jjam;
                }
                $input["absen_lemburjam"] = $lembur; */
            }

            //ambil lembur
            $wlembur["lembur_date"] = $input["absen_date"];
            $wlembur["user_id"] = $input["user_id"];
            $lembur = $this->db->table("lembur")->where($wlembur)->get();
            $lemburjam = 0;
            foreach ($lembur->getResult() as $lembur) {
                $lemburjam += $lembur->lembur_jam;
            }
            $input["absen_lemburjam"] = $lemburjam;

            $this->db->table('absen')->update($input, array("absen_id" => $this->request->getPost("absen_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
