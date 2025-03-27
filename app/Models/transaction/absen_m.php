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
                }

                //catatan: jumlah jam kerja tidak berhubungan dengan berapa jam lembur, dikarenakan lebur sudah terjadwal di menu lembur.

                //ambil lembur
                $wlembur["lembur_date"] = $input["absen_date"];
                $wlembur["user_id"] = $input["user_id"];
                $lembur = $this->db->table("lembur")->where($wlembur)->get();
                $lemburjam = 0;
                foreach ($lembur->getResult() as $lembur) {
                    $lemburjam += $lembur->lembur_jam;
                }
                $input["absen_lemburjam"] = $lemburjam;
                // print_r($input);die;

                //libur tidak
                $wlibur["libur_date"] = $input["absen_date"];
                $libur = $this->db->table("libur")->where($wlibur)->get();
                $liburk = 0;
                foreach ($libur->getResult() as $libur) {
                    $liburk = 1;
                }

                //catatan: untuk lembur pada hari biasa dan libur pada dasarnya perhitungannya sama walapun perhitungan OT1 berbeda di hari libur namun ketika hari libur tidak mungkin lembur hanya OT 1 saja.

                $user = $this->db->table("user")->where("user_id", $input["user_id"])->get()->getRow();
                $gapok = $user->user_gapok ?? null;
                $userlembur = $user->user_lembur ?? null;
                $insentif = $user->user_insentif ?? null;
                $user_payrolltype = $user->user_payrolltype ?? null;
                $user_ttransport = $user->user_ttransport ?? null;
                $user_thadir = $user->user_thadir ?? null;
                $user_tmakan = $user->user_tmakan ?? null;
                $user_gakot = $user->user_gakot ?? null;

                //harga lembur            
                if ($userlembur == "1") {
                    $wkerja["jamkerja_type"] = "lembur";
                    $jamkerja = $this->db->table("jamkerja")->where($wkerja)->get();
                    $OT1 = 0;
                    $OT2 = 0;
                    $OT3 = 0;
                    $OT4 = 0;
                    $OTN1 = 0;
                    $OTN2 = 0;
                    $OTN3 = 0;
                    $OTN4 = 0;
                    $tipeotnya = "";
                    $arcek = array();
                    $no = 1;
                    foreach ($jamkerja->getResult() as $jamkerja) {
                        $awalot = $jamkerja->jamkerja_otawal;
                        $akhirot = $jamkerja->jamkerja_otakhir;
                        if (($lemburjam >= $awalot && $lemburjam <= $akhirot) || ($akhirot < $lemburjam)) {

                            // $arcek[$no]["awalot"] = $awalot;
                            // $arcek[$no]["akhirot"] = $akhirot;

                            $tipeotnya = $jamkerja->jamkerja_ottype;
                            $identity = $this->db->table("identity")->get()->getRow();
                            $identity_jkerjarata2 = $identity->identity_jkerjarata2;


                            if ($jamkerja->jamkerja_ottype == "OT1" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                                if ($lemburjam <= 1) {
                                    $OT1 = $lemburjam;
                                } else {
                                    $OT1 = 1;
                                }
                                $OTN1 = ((($gapok / $identity_jkerjarata2) * 1.5) / 2) * $OT1;
                            }
                            if ($jamkerja->jamkerja_ottype == "OT2" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                                $OT2 = $lemburjam - 1;
                                $OTN2 = (($gapok / $identity_jkerjarata2) * 2) * $OT2;
                            }
                            if ($jamkerja->jamkerja_ottype == "OT3" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                                $OT3 = $lemburjam - 8;
                                $OTN3 = (($gapok / $identity_jkerjarata2) * 3) * $OT3;
                            }
                            if ($jamkerja->jamkerja_ottype == "OT4" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                                $OT4 = $lemburjam - 9;
                                $OTN4 = (($gapok / $identity_jkerjarata2) * 4) * $OT4;
                            }
                            // $arcek[$no]["gapok"] = $gapok;
                            // $arcek[$no]["identity_jkerjarata2"] = $identity_jkerjarata2;
                        }
                        $no++;
                    }
                    /*  $arcek[$no]["OT1"] = $OT1;
                $arcek[$no]["OT2"] = $OT2;
                $arcek[$no]["OT3"] = $OT3;
                $arcek[$no]["OT4"] = $OT4;
                $arcek[$no]["OTN1"] = $OTN1;
                $arcek[$no]["OTN2"] = $OTN2;
                $arcek[$no]["OTN3"] = $OTN3;
                $arcek[$no]["OTN4"] = $OTN4; */

                    /* print_r($arcek);
                die; */

                    $input["absen_ot1jam"] = $OT1;
                    $input["absen_ot2jam"] = $OT2;
                    $input["absen_ot3jam"] = $OT3;
                    $input["absen_ot4jam"] = $OT4;
                    $input["absen_ot1nominal"] = $OTN1;
                    $input["absen_ot2nominal"] = $OTN2;
                    $input["absen_ot3nominal"] = $OTN3;
                    $input["absen_ot4nominal"] = $OTN4;
                } else if ($userlembur == "2") {
                    $input["absen_insentif"] = $insentif;
                }

                //Sakit
                if ($input["absen_type"] == "Sakit") {
                    if ($user_payrolltype == "harian") {
                        if ($input["absen_skd"] == 1) {
                            //ga dipotong
                        } else {
                            $input["absen_alpha"] = 1;
                            $input["absen_alphanominal"] = ($gapok / 30) * 1;
                        }
                    } else {
                        if ($input["absen_skd"] == 1) {
                            $input["absen_ttransport"] = $user_ttransport / 30;
                            $input["absen_thadir"] = $user_thadir / 30;
                            $input["absen_tmakan"] = $user_tmakan / 30;
                        } else {
                            $input["absen_alpha"] = 1;
                            $input["absen_alphanominal"] = $user_gakot / 30;
                        }
                    }
                }

                //Sakit, Izin, Alpha, Cuti
                if ($user_payrolltype == "harian") {
                    //sakit
                    if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti")) {
                        //ada SKD ga dipotong
                    } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                        //Sakit, izin dan alpha
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = ($gapok / 30) * 1;
                    }
                } else {
                    if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti")) {
                        $input["absen_ttransport"] = $user_ttransport / 30;
                        $input["absen_thadir"] = $user_thadir / 30;
                        $input["absen_tmakan"] = $user_tmakan / 30;
                    } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = $user_gakot / 30;
                    }
                }

                //pulangcepat
                //ramdlan bukan
                $cramadlan = $this->db->table("ramadlan")->where("ramadlan_date", $input["absen_date"])->get()->getRow();
                $ramadlan = 0;
                if ($cramadlan) {
                    $ramadlan = 1;
                }
                //sekarang hari apa
                $hari = date('w', strtotime($input["absen_date"]));
                // echo $hari;die;
                $wpkerja["jamkerja_type"] = "normal";
                $wpkerja["jamkerja_ramadlan"] = $ramadlan;
                $jamkerja = $this->db->table("jamkerja")
                    ->where($wpkerja)
                    ->where("FIND_IN_SET($hari,jamkerja_hari) >", 0)
                    ->get();
                $pulangcepat = 0;
                $pulangcepatmenit = 0;
                foreach ($jamkerja->getResult() as $jamkerja) {
                    $pulangcepatmenit = (strtotime($jamkerja->jamkerja_akhir) - strtotime($input["absen_keluar"])) / 60;
                    if ($pulangcepatmenit > 0) {
                        $pulangcepat = 1;
                    }
                }
                $input["absen_pulangcepat"] = $pulangcepat;
                $input["absen_pulangcepatmenit"] = $pulangcepatmenit;

                //uangmakan -- pendapatan lain-lain
            if ($liburk == 1 && $lemburjam > 0) {
                $input["absen_lain"] = $identity->identity_uanggantimakan;
            }


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
            }

            //catatan: jumlah jam kerja tidak berhubungan dengan berapa jam lembur, dikarenakan lebur sudah terjadwal di menu lembur.

            //ambil lembur
            $wlembur["lembur_date"] = $input["absen_date"];
            $wlembur["user_id"] = $input["user_id"];
            $lembur = $this->db->table("lembur")->where($wlembur)->get();
            $lemburjam = 0;
            foreach ($lembur->getResult() as $lembur) {
                $lemburjam += $lembur->lembur_jam;
            }
            $input["absen_lemburjam"] = $lemburjam;
            // print_r($input);die;
            //libur tidak
            $wlibur["libur_date"] = $input["absen_date"];
            $libur = $this->db->table("libur")->where($wlibur)->get();
            $liburk = 0;
            foreach ($libur->getResult() as $libur) {
                $liburk = 1;
            }

            //catatan: untuk lembur pada hari biasa dan libur pada dasarnya perhitungannya sama walapun perhitungan OT1 berbeda di hari libur namun ketika hari libur tidak mungkin lembur hanya OT 1 saja.

            $user = $this->db->table("user")->where("user_id", $input["user_id"])->get()->getRow();
            $gapok = $user->user_gapok ?? null;
            $userlembur = $user->user_lembur ?? null;
            $insentif = $user->user_insentif ?? null;
            $user_payrolltype = $user->user_payrolltype ?? null;
            $user_ttransport = $user->user_ttransport ?? null;
            $user_thadir = $user->user_thadir ?? null;
            $user_tmakan = $user->user_tmakan ?? null;
            $user_gakot = $user->user_gakot ?? null;

            //harga lembur            
            $user = $this->db->table("user")->where("user_id", $input["user_id"])->get()->getRow();
            $gapok = $user->user_gapok ?? null;
            $userlembur = $user->user_lembur ?? null;
            $insentif = $user->user_insentif ?? null;
            if ($userlembur == "1") {
                $wkerja["jamkerja_type"] = "lembur";
                $jamkerja = $this->db->table("jamkerja")->where($wkerja)->get();
                $OT1 = 0;
                $OT2 = 0;
                $OT3 = 0;
                $OT4 = 0;
                $OTN1 = 0;
                $OTN2 = 0;
                $OTN3 = 0;
                $OTN4 = 0;
                $tipeotnya = "";
                $arcek = array();
                $no = 1;
                foreach ($jamkerja->getResult() as $jamkerja) {
                    $awalot = $jamkerja->jamkerja_otawal;
                    $akhirot = $jamkerja->jamkerja_otakhir;
                    if (($lemburjam >= $awalot && $lemburjam <= $akhirot) || ($akhirot < $lemburjam)) {

                        // $arcek[$no]["awalot"] = $awalot;
                        // $arcek[$no]["akhirot"] = $akhirot;

                        $tipeotnya = $jamkerja->jamkerja_ottype;
                        $identity = $this->db->table("identity")->get()->getRow();
                        $identity_jkerjarata2 = $identity->identity_jkerjarata2;


                        if ($jamkerja->jamkerja_ottype == "OT1" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                            if ($lemburjam <= 1) {
                                $OT1 = $lemburjam;
                            } else {
                                $OT1 = 1;
                            }
                            $OTN1 = ((($gapok / $identity_jkerjarata2) * 1.5) / 2) * $OT1;
                        }
                        if ($jamkerja->jamkerja_ottype == "OT2" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                            $OT2 = $lemburjam - 1;
                            $OTN2 = (($gapok / $identity_jkerjarata2) * 2) * $OT2;
                        }
                        if ($jamkerja->jamkerja_ottype == "OT3" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                            $OT3 = $lemburjam - 8;
                            $OTN3 = (($gapok / $identity_jkerjarata2) * 3) * $OT3;
                        }
                        if ($jamkerja->jamkerja_ottype == "OT4" && $jamkerja->jamkerja_ottype == $tipeotnya) {
                            $OT4 = $lemburjam - 9;
                            $OTN4 = (($gapok / $identity_jkerjarata2) * 4) * $OT4;
                        }
                        // $arcek[$no]["gapok"] = $gapok;
                        // $arcek[$no]["identity_jkerjarata2"] = $identity_jkerjarata2;
                    }
                    $no++;
                }
                /*  $arcek[$no]["OT1"] = $OT1;
                $arcek[$no]["OT2"] = $OT2;
                $arcek[$no]["OT3"] = $OT3;
                $arcek[$no]["OT4"] = $OT4;
                $arcek[$no]["OTN1"] = $OTN1;
                $arcek[$no]["OTN2"] = $OTN2;
                $arcek[$no]["OTN3"] = $OTN3;
                $arcek[$no]["OTN4"] = $OTN4; */

                /* print_r($arcek);
                die; */

                $input["absen_ot1jam"] = $OT1;
                $input["absen_ot2jam"] = $OT2;
                $input["absen_ot3jam"] = $OT3;
                $input["absen_ot4jam"] = $OT4;
                $input["absen_ot1nominal"] = $OTN1;
                $input["absen_ot2nominal"] = $OTN2;
                $input["absen_ot3nominal"] = $OTN3;
                $input["absen_ot4nominal"] = $OTN4;
            } else if ($userlembur == "2") {
                $input["absen_insentif"] = $insentif;
            }

            //Sakit
            if ($input["absen_type"] == "Sakit") {
                if ($user_payrolltype == "harian") {
                    if ($input["absen_skd"] == 1) {
                        //ga dipotong
                    } else {
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = ($gapok / 30) * 1;
                    }
                } else {
                    if ($input["absen_skd"] == 1) {
                        $input["absen_ttransport"] = $user_ttransport / 30;
                        $input["absen_thadir"] = $user_thadir / 30;
                        $input["absen_tmakan"] = $user_tmakan / 30;
                    } else {
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = $user_gakot / 30;
                    }
                }
            }

            //Sakit, Izin, Alpha, Cuti
            if ($user_payrolltype == "harian") {
                //sakit
                if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti")) {
                    //ada SKD ga dipotong
                } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                    //Sakit, izin dan alpha
                    $input["absen_alpha"] = 1;
                    $input["absen_alphanominal"] = ($gapok / 30) * 1;
                }
            } else {
                if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti")) {
                    $input["absen_ttransport"] = $user_ttransport / 30;
                    $input["absen_thadir"] = $user_thadir / 30;
                    $input["absen_tmakan"] = $user_tmakan / 30;
                } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                    $input["absen_alpha"] = 1;
                    $input["absen_alphanominal"] = $user_gakot / 30;
                }
            }

            //pulangcepat
            //ramdlan bukan
            $cramadlan = $this->db->table("ramadlan")->where("ramadlan_date", $input["absen_date"])->get()->getRow();
            $ramadlan = 0;
            if ($cramadlan) {
                $ramadlan = 1;
            }
            //sekarang hari apa
            $hari = date('w', strtotime($input["absen_date"]));
            // echo $hari;die;
            $wpkerja["jamkerja_type"] = "normal";
            $wpkerja["jamkerja_ramadlan"] = $ramadlan;
            $jamkerja = $this->db->table("jamkerja")
                ->where($wpkerja)
                ->where("FIND_IN_SET($hari,jamkerja_hari) >", 0)
                ->get();
            // echo $this->db->getLastQuery();die;
            $pulangcepat = 0;
            $pulangcepatmenit = 0;
            foreach ($jamkerja->getResult() as $jamkerja) {
                $pulangcepatmenit = (strtotime($jamkerja->jamkerja_akhir) - strtotime($input["absen_keluar"])) / 60;
                if ($pulangcepatmenit > 0) {
                    $pulangcepat = 1;
                }
            }
            $input["absen_pulangcepat"] = $pulangcepat;
            $input["absen_pulangcepatmenit"] = $pulangcepatmenit;


            //uangmakan -- pendapatan lain-lain
            if ($liburk == 1 && $lemburjam > 0) {
                $input["absen_lain"] = $identity->identity_uanggantimakan;
            }


            $this->db->table('absen')->update($input, array("absen_id" => $this->request->getPost("absen_id")));
            $data["message"] = "Update Success";
            // echo $this->db->getLastQuery();die;
        }
        return $data;
    }
}
