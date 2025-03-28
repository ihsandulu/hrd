<?php

namespace App\Models\transaction;

use App\Models\core_m;

class gaji_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek gaji
        if ($this->request->getVar("gaji_id")) {
            $gajid["gaji_id"] = $this->request->getVar("gaji_id");
        } else {
            $gajid["gaji_id"] = -1;
        }
        $us = $this->db
            ->table("gaji")
            ->getWhere($gajid);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "action", "data", "gaji_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $gaji) {
                foreach ($this->db->getFieldNames('gaji') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $gaji->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('gaji') as $field) {
                $data[$field] = "";
            }
        }



        //delete
        if ($this->request->getPost("delete") == "OK") {
            $gaji_id = $this->request->getPost("gaji_id");
            $this->db
                ->table("gaji")
                ->delete(array("gaji_id" =>  $gaji_id));
            $data["message"] = "Delete Success";
        }

        //submit
        if ($this->request->getPost("submit") == "OK") {
            $inpututama = $this->request->getPost("datakartu");
            $bintang = explode("*", $inpututama);

            //gaji
            $pisah = $bintang[0];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
            }
            $builder = $this->db->table('gaji');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $gaji_id = $this->db->insertID();

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

        //generate
        if ($this->request->getPost("generate") == "OK") {
            $dari = $this->request->getPost("dari");
            $ke = $this->request->getPost("ke");

            //delete periode tertentu
            $this->db
                ->table("gaji")
                ->where("gaji_date >=", $dari)
                ->where("gaji_date <=", $ke)
                ->delete();


            //potongan inventaris
            $inventarist = $this->db
                ->table("inventarist")
                ->select("*,SUM(inventarist_potongan)AS potongan")
                ->where("inventarist_date >=", $dari)
                ->where("inventarist_date <=", $ke)
                ->groupBy("user_id")->get();
            $arinventarist = array();
            foreach ($inventarist->getResult() as $inventarist) {
                $arinventarist[$inventarist->user_id] = $inventarist->potongan;
            }

            //potongan bpjs
            $bpjs = $this->db
                ->table("bpjs")->get();
            $arbpjs = array();
            foreach ($bpjs->getResult() as $bpjs) {
                $arbpjs[$bpjs->bpjs_name]["pekerja"] = $bpjs->bpjs_pekerja;
                $arbpjs[$bpjs->bpjs_name]["perusahaan"] = $bpjs->bpjs_perusahaan;
                $arbpjs[$bpjs->bpjs_name]["diskon"] = $bpjs->bpjs_discount;
            }


            //departemen
            if ($this->request->getPost("departemen_id") != "") {
                $departemen_id = $this->request->getPost("departemen_id");
                $departemen = " departemen_id = " . $departemen_id;
                $anddep = " AND";
            } else {
                $departemen = "";
                $anddep = "";
            }

            //position
            if ($this->request->getPost("position_id") != "") {
                $position_id = $this->request->getPost("position_id");
                $position = $anddep . " position_id = " . $position_id;
                $andpos = " AND";
            } else {
                $position = "";
                $andpos = "";
            }

            //user
            if ($this->request->getPost("user_id") != "") {
                $user_id = $this->request->getPost("user_id");
                $user = $andpos . " user_id = " . $user_id;
                $anduser = " AND";
            } else {
                $user = "";
                $anduser = "";
            }

            //tahun
            if ($this->request->getPost("gaji_tahun") != "") {
                $gaji_tahun = $this->request->getPost("gaji_tahun");
                $tahun = $gaji_tahun;
            } else {
                $tahun = date("Y");
            }

            //bulan
            if ($this->request->getPost("gaji_bulan") != "") {
                // $gaji_bulan = $this->request->getPost("gaji_bulan");
                // $bulan = $anduser . " SUBSTR(absen_date, 1, 7) = '" . $tahun . "-" . $gaji_bulan . "'";



                $periode = $anduser . " absen_date >='" . $dari . " AND absen_date <=" . $ke . "'";

                /* //hari libur
                $arliburhari = array();
                $arliburtanggal = array();
                $libur = $this->db->table("libur")->get();
                foreach ($libur->getResult() as $libur) {
                    if ($libur->libur_hari == 7) {
                        $arliburtanggal[] = $libur->libur_date;
                    } else {
                        $arliburhari[] = $libur->libur_hari;
                    }
                } */



                $sql = "SELECT *, 
                SUM(absen_insentif)AS insentif, 
                COUNT(absen_masuk)AS masuk, 
                COUNT(IF(absen_type = 'Cuti', 1, NULL)) AS cuti, 
                COUNT(IF(absen_type = 'Sakit', 1, NULL)) AS sakit, 
                COUNT(IF(absen_type = 'Izin', 1, NULL)) AS izin, 
                COUNT(IF(absen_type = 'Alpha', 1, NULL)) AS alpha, 
                COUNT(absen_pulangcepat) AS pulangcepat, 
                SUM(absen_ot1jam)AS gaji_ot1jam, 
                SUM(absen_ot1nominal)AS gaji_ot1nominal, 
                SUM(absen_ot2jam)AS gaji_ot2jam, 
                SUM(absen_ot2nominal)AS gaji_ot2nominal, 
                SUM(absen_ot3jam)AS gaji_ot3jam, 
                SUM(absen_ot3nominal)AS gaji_ot3nominal, 
                SUM(absen_ot4jam)AS gaji_ot4jam, 
                SUM(absen_ot4nominal)AS gaji_ot4nominal, 
                SUM(absen_alphanominal)AS gaji_alphanominal, 
                SUM(absen_ptransport)AS gaji_ptransportasi, 
                SUM(absen_phadir)AS gaji_pkehadiran, 
                SUM(absen_pmakan)AS gaji_pmakan, 
                SUM(absen_lain)AS gaji_lain, 
                user.position_id as position_id, 
                absen.user_id as user_id, 
                user.departemen_id as departemen_id 
                FROM absen 
                LEFT JOIN user ON user.user_id=absen.user_id 
                LEFT JOIN position ON position.position_id=user.position_id 
                LEFT JOIN departemen ON departemen.departemen_id=user.departemen_id 
                WHERE " . $departemen . $position
                    . $user . $periode . " GROUP BY absen.user_id";
                // echo $sql;die;
                $absen = $this->db->query($sql);
                // echo $this->db->getLastQuery();die;
                foreach ($absen->getResult() as $absen) {
                    $input["gaji_bulan"] = $this->request->getPost("gaji_bulan");
                    $input["gaji_tahun"] = $this->request->getPost("gaji_tahun");
                    $input["user_nik"] = $absen->user_nik;
                    $input["position_id"] = $absen->position_id;
                    $input["position_name"] = $absen->position_name;
                    $input["departemen_id"] = $absen->departemen_id;
                    $input["departemen_name"] = $absen->departemen_name;
                    $input["user_id"] = $absen->user_id;
                    $input["user_name"] = $absen->user_nama;
                    $input["user_masuk"] = $absen->user_masuk;


                    $input["gaji_hadir"] = $absen->masuk;
                    $input["gaji_cuti"] = $absen->cuti;
                    $input["gaji_sakit"] = $absen->sakit;
                    $input["gaji_izin"] = $absen->izin;
                    $input["gaji_alpha"] = $absen->alpha;

                    $input["gaji_pokok"] = $absen->user_gapok;

                    $transportasi = 0;
                    $kehadiran = 0;
                    $makan = 0;
                    $jabatan = 0;
                    $insentif = 0;
                    if ($absen->user_payrolltype == "bulanan") {
                        $transportasi = $absen->user_ttransport;
                        $kehadiran = $absen->user_thadir;
                        $makan = $absen->user_tmakan;
                        $jabatan = $absen->user_tjabatan;
                        $insentif = $absen->insentif;
                    }

                    $input["gaji_tjabatan"] = $jabatan;
                    $input["gaji_ttransport"] = $transportasi;
                    $input["gaji_insentive1"] = $insentif;
                    $input["gaji_insentive2"] = 0;
                    $input["gaji_tkehadiran"] = $kehadiran;
                    $input["gaji_tmakan"] = $makan;

                    $input["gaji_ot1jam"] = $absen->gaji_ot1jam;
                    $input["gaji_ot1nominal"] = $absen->gaji_ot1nominal;
                    $input["gaji_ot2jam"] = $absen->gaji_ot2jam;
                    $input["gaji_ot2nominal"] = $absen->gaji_ot2nominal;
                    $input["gaji_ot3jam"] = $absen->gaji_ot3jam;
                    $input["gaji_ot3nominal"] = $absen->gaji_ot3nominal;
                    $input["gaji_ot4jam"] = $absen->gaji_ot4jam;
                    $input["gaji_ot4nominal"] = $absen->gaji_ot4nominal;

                    //gakot
                    if ($absen->user_payrolltype == "bulanan") {
                        $gajikotor = $absen->user_gakot;
                    }
                    if ($absen->user_payrolltype == "harian") {
                        $gajikotor = $absen->user_gapok;
                        $gajikotor += $absen->gaji_ot1nominal;
                        $gajikotor += $absen->gaji_ot2nominal;
                        $gajikotor += $absen->gaji_ot3nominal;
                        $gajikotor += $absen->gaji_ot4nominal;
                    }
                    $input["gaji_kotor"] = $gajikotor;

                    $input["gaji_alphanominal"] = $absen->gaji_alphanominal;
                    $input["gaji_ptransportasi"] = $absen->gaji_ptransportasi;
                    $input["gaji_pkehadiran"] = $absen->gaji_pkehadiran;
                    $input["gaji_pmakan"] = $absen->gaji_pmakan;

                    if(isset($arinventarist[$absen->user_id])){
                        $gaji_inventaris = $arinventarist[$absen->user_id];
                    }else{
                        $gaji_inventaris = 0;
                    }
                    $input["gaji_inventaris"] = $gaji_inventaris;

                    $input["gaji_serikatburuh"] = 0;

                    //bpjs
                    //gapok+t.jabatan
                    $gbpjs = $input["gaji_pokok"] + $jabatan;
                    //kesehatan
                    if ($arbpjs["Kesehatan"]["diskon"] > 0) {
                        $dkesehatan = $arbpjs["Kesehatan"]["diskon"] / 100;
                    } else {
                        $dkesehatan = 1;
                    }
                    $input["gaji_bpjskesehatan"] = ($arbpjs["Kesehatan"]["pekerja"] / 100 * $gbpjs) * $dkesehatan;
                    //jht
                    if ($arbpjs["JHT"]["diskon"] > 0) {
                        $dJHT = $arbpjs["JHT"]["diskon"] / 100;
                    } else {
                        $dJHT = 1;
                    }
                    $input["gaji_bpjsjht"] = ($arbpjs["JHT"]["pekerja"] / 100 * $gbpjs) * $dJHT;
                    //jkk
                    if ($arbpjs["JKK"]["diskon"] > 0) {
                        $dJKK = $arbpjs["JKK"]["diskon"] / 100;
                    } else {
                        $dJKK = 1;
                    }
                    $input["gaji_bpjsjkk"] = ($arbpjs["JKK"]["pekerja"] / 100 * $gbpjs) * $dJKK;
                    //jkm
                    if ($arbpjs["JKM"]["diskon"] > 0) {
                        $dJKM = $arbpjs["JKM"]["diskon"] / 100;
                    } else {
                        $dJKM = 1;
                    }
                    $input["gaji_bpjsjkm"] = ($arbpjs["JKM"]["pekerja"] / 100 * $gbpjs) * $dJKM;
                    //pensiun
                    if ($arbpjs["JP"]["diskon"] > 0) {
                        $dJP = $arbpjs["JP"]["diskon"] / 100;
                    } else {
                        $dJP = 1;
                    }
                    $input["gaji_bpjspensiun"] = ($arbpjs["JP"]["pekerja"] / 100 * $gbpjs) * $dJP;

                    //persentase pph
                    $ter = $this->db
                        ->table("ter")
                        ->where("ter_jenis", $absen->user_tanggunganjenis)
                        ->where("ter_gakotawal <=", $input["gaji_kotor"])
                        ->where("ter_gakotakhir >", $input["gaji_kotor"])
                        ->get();
                    $pph21 = 0;
                    foreach ($ter->getResult() as $ter) {
                        $persen = $ter->ter_persen;
                        $pph21 = $input["gaji_kotor"] * $persen / 100;
                    }

                    $input["gaji_pph21"] = $pph21;

                    $input["gaji_date"] = date("Y-m-d");
                    $input["gaji_dari"] =  $this->request->getPost("dari");
                    $input["gaji_ke"] =  $this->request->getPost("ke");

                    //pulang cepat
                    $input["gaji_pulangcepat"] = $absen->pulangcepat;

                    //jika lembur sabtu atau hari libur maka dikasih makan, tapi jika Ramalan maka diganti dengan uang 8rb
                    $input["gaji_lain"] = $absen->gaji_lain;

                    //potongan lain-lain
                    $input["gaji_plain"] = 0;

                    $gaji_potongantotal = $input["gaji_alphanominal"] + $input["gaji_inventaris"] + $input["gaji_serikatburuh"] + $input["gaji_bpjskesehatan"] + $input["gaji_bpjsjht"] + $input["gaji_bpjspensiun"] + $input["gaji_pph21"] + $input["gaji_plain"];
                    $input["gaji_potongantotal"] = $gaji_potongantotal;

                    $gaji_total = $input["gaji_kotor"] - $input["gaji_potongantotal"];

                    $input["gaji_total"] = $gaji_total;

                    $input["gaji_print"] = $this->request->getPost("gaji_print");

                    $builder = $this->db->table('gaji');
                    $builder->insert($input);
                    /* echo $this->db->getLastQuery();die; */
                    $gaji_id = $this->db->insertID();

                    $data["message"] = "Insert Data Success";
                }
            } else {
                $bulan = "";
                $data["message"] = "Gagal Generate! Harap pilih bulan.";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'gaji_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $gaji_datetime = $input["gaji_datetime"];
            $date = substr($gaji_datetime, 0, 10);
            $time = substr($gaji_datetime, 12, 5);
            $input["gaji_date"] = $date;
            $input["gaji_time"] = $time;
            // echo $input["gaji_time"];die;
            $input["user_id"] = session()->get("user_id");
            $builder = $this->db->table('gaji');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $gaji_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'gaji_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $gaji_datetime = $input["gaji_datetime"];
            $date = substr($gaji_datetime, 0, 10);
            $time = substr($gaji_datetime, 12, 5);
            $input["gaji_date"] = $date;
            $input["gaji_time"] = $time;
            $this->db->table('gaji')->update($input, array("gaji_id" => $this->request->getPost("gaji_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
