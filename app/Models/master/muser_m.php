<?php

namespace App\Models\master;

use App\Models\core_m;
use PhpOffice\PhpSpreadsheet\IOFactory;

class muser_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek user
        if ($this->request->getVar("user_id")) {
            $userd["user_id"] = $this->request->getVar("user_id");
        } else {
            $userd["user_id"] = -1;
        }
        $us = $this->db
            ->table("user")
            ->getWhere($userd);
        //echo $this->db->getLastquery();
        //die;
        $larang = array("log_id", "id",  "action", "data", "user_id_dep", "trx_id", "trx_code", "contact_id_dep");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $user) {
                foreach ($this->db->getFieldNames('user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $user->$field;
                    }
                }
                // Kunci dan metode enkripsi
                $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
                $method = "AES-256-CBC";
                // Dekripsi
                $datak = base64_decode($user->user_password);
                $iv_dec = substr($datak, 0, openssl_cipher_iv_length($method));
                $encrypted_data = substr($datak, openssl_cipher_iv_length($method));
                $decrypted = openssl_decrypt($encrypted_data, $method, $key, 0, $iv_dec);
                $data["user_password"] = $decrypted;
            }
        } else {
            foreach ($this->db->getFieldNames('user') as $field) {
                $data[$field] = "";
            }
        }

        //export excel karyawan
        if (isset($_FILES['excelkaryawan'])) {
            $file = $this->request->getFile('excelkaryawan');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $spreadsheet = IOFactory::load($file->getTempName());
                $dataSheet = $spreadsheet->getActiveSheet()->toArray();

                //departemen
                $departemen = $this->db->table("departemen")->get();
                $adepartemen = array();
                foreach ($departemen->getResult() as $d) {
                    $adepartemen[$d->departemen_name] = $d->departemen_id;
                }


                //position
                $position = $this->db->table("position")->get();
                $aposition = array();
                foreach ($position->getResult() as $d) {
                    $aposition[$d->position_name] = $d->position_id;
                }

                $insertData = [];
                $updateData = [];

                for ($i = 3; $i < count($dataSheet); $i++) {
                    $iddepartemen = $dataSheet[$i][5];
                    $idposition = $dataSheet[$i][26];
                    $status = ($dataSheet[$i][27] == "Working now") ? "1" : "0";
                    $iadepartemen = isset($adepartemen[$iddepartemen]) ? $adepartemen[$iddepartemen] : 0;
                    $iaposition = isset($aposition[$idposition]) ? $aposition[$idposition] : 0;

                    $user_masuk = $dataSheet[$i][3];
                    $user_masuk = \DateTime::createFromFormat('d-m-Y', $user_masuk);
                    $user_masuk = $user_masuk->format('Y-m-d');

                    $user_borndate = $dataSheet[$i][19];
                    $user_borndate = \DateTime::createFromFormat('d-m-Y', $user_borndate);
                    $user_borndate = $user_borndate->format('Y-m-d');

                    $data1 = [
                        'user_nik' => $dataSheet[$i][1],
                        'user_nama' => $dataSheet[$i][2],
                        'user_masuk' => $user_masuk,
                        'departemen_id' => $iadepartemen,
                        'user_wa' => $dataSheet[$i][7],
                        'user_bpjstk' => $dataSheet[$i][9],
                        'user_ktp' => $dataSheet[$i][10],
                        'user_kk' => $dataSheet[$i][11],
                        'user_bpjskesehatan' => $dataSheet[$i][12],
                        'user_norek' => $dataSheet[$i][13],
                        'user_npwp' => $dataSheet[$i][14],
                        'user_etag' => $dataSheet[$i][15],
                        'user_ibu' => $dataSheet[$i][16],
                        'user_pendidikan' => $dataSheet[$i][17],
                        'user_borncity' => $dataSheet[$i][18],
                        'user_borndate' => $user_borndate,
                        'user_gender' => $dataSheet[$i][20],
                        'user_address' => $dataSheet[$i][22],
                        'user_payrolltype' => $dataSheet[$i][23],
                        'user_tanggungan' => $dataSheet[$i][25],
                        'position_id' => $iaposition,
                        'user_status' => $status
                    ];

                    // Cek apakah sudah ada
                    $cekdata = $this->db->table("user")->where("user_nik", $dataSheet[$i][1])->get();

                    if ($cekdata->getNumRows() > 0) {
                        $updateData[] = $data1; // Data untuk di-update
                    } else {
                        $insertData[] = $data1; // Data untuk disisipkan
                    }
                }

                // Proses Batch Insert
                if (!empty($insertData)) {
                    $this->db->table("user")->insertBatch($insertData);
                }

                // Proses Batch Update
                if (!empty($updateData)) {
                    $this->db->table("user")->updateBatch($updateData, 'user_nik');
                }
            }

            $data["message"] = "Import Success";
        }

        //export excel sisa cuti
        if (isset($_FILES['excelcuti'])) {
            $file = $this->request->getFile('excelcuti');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $spreadsheet = IOFactory::load($file->getTempName());
                $dataSheet = $spreadsheet->getActiveSheet()->toArray();

                $updateData = [];
                for ($i = 1; $i < count($dataSheet); $i++) {
                    $data1 = [
                        'user_nik'  => $dataSheet[$i][3],
                        'user_cuti' => $dataSheet[$i][5]
                    ];

                    // Cek apakah sudah ada
                    $cekdata = $this->db->table("user")->where("user_nik", $dataSheet[$i][3])->get();
                    if ($cekdata->getNumRows() > 0 && $dataSheet[$i][5] != "") {
                        $updateData[] = $data1; // Data untuk di-update
                    }
                }

                // Proses Batch Update
                if (!empty($updateData)) {
                    $this->db->table("user")->updateBatch($updateData, 'user_nik');
                    // echo $this->db->getLastQuery();die;
                }
            }
            $data["message"] = "Import Success";
        }


        //delete
        if ($this->request->getPost("delete") == "OK") {
            $user_id = $this->request->getPost("user_id");
            $cek = $this->db->table("placement")
                ->where("user_id", $user_id)
                ->get()
                ->getNumRows();
            if ($cek > 0) {
                $data["message"] = "User masih dipakai di data 'Placement'!";
            } else {
                $this->db
                    ->table("user")
                    ->delete(array("user_id" =>  $user_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create') {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }

            // Kunci dan metode enkripsi
            $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
            $method = "AES-256-CBC";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

            // Enkripsi
            $password = $inputu["user_password"];
            $encrypted = openssl_encrypt($password, $method, $key, 0, $iv);
            $encrypted = base64_encode($iv . $encrypted); // Gabungkan IV agar bisa didekripsi nanti
            $inputu["user_password"] = $encrypted;
            $this->db->table('user')->insert($inputu);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change') {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }
            // Kunci dan metode enkripsi
            $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
            $method = "AES-256-CBC";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            // Enkripsi
            $password = $inputu["user_password"];
            $encrypted = openssl_encrypt($password, $method, $key, 0, $iv);
            $encrypted = base64_encode($iv . $encrypted); // Gabungkan IV agar bisa didekripsi nanti
            $inputu["user_password"] = $encrypted;
            $this->db->table('user')
                ->where("user_id", $inputu["user_id"])
                ->update($inputu);
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }

        //revisi cuti
        if ($this->request->getPost("revisicuti") == "OK") {
            $identity_cuti = $this->db->table("identity")->get()->getRow()->identity_cuti;
            $user = $this->db->table("user")
                ->where("user_status", "1")
                ->get();
            foreach ($user->getResult() as $u) {
                $user_id = $u->user_id;
                $user_nama = $u->user_nama;
                $user_cuti = $u->user_cuti;
                $user_cutitambahdate = $u->user_cutitambahdate;
                $user_masuk = $u->user_masuk;
                $tanggal_masuk = new \DateTime($user_masuk);
                $tanggal_sekarang = new \DateTime(); // hari ini
                $selisih = $tanggal_masuk->diff($tanggal_sekarang);
                if ($selisih->y >= 1) {

                    //rentang tahun
                    $bulan = $tanggal_masuk->format('m');
                    $tanggal = $tanggal_masuk->format('d');
                    $tahun_sekarang = $tanggal_sekarang->format('Y');
                    $tanggal_mulai = \DateTime::createFromFormat('Y-m-d', $tahun_sekarang . '-' . $bulan . '-' . $tanggal);
                    $tanggal_selesai = (clone $tanggal_mulai)->modify('+1 year')->modify('-1 day');

                    // Jika tanggal sekarang lebih kecil dari tanggal mulai, mundurkan rentang ke tahun sebelumnya
                    if ($tanggal_sekarang < $tanggal_mulai) {
                        $tahun_sekarang--;
                        $tanggal_mulai = \DateTime::createFromFormat('Y-m-d', $tahun_sekarang . '-' . $bulan . '-' . $tanggal);
                        $tanggal_selesai = (clone $tanggal_mulai)->modify('+1 year')->modify('-1 day');
                    }

                    // Menampilkan rentang yang sesuai dalam format Y-m-d
                    // echo "Rentang yang dipakai: " . $tanggal_mulai->format('Y-m-d') . " s/d " . $tanggal_selesai->format('Y-m-d');

                    
                    if ($user_cutitambahdate < $tanggal_mulai->format('Y-m-d')) {
                        if($user_cuti<0){
                            $cuti = $identity_cuti + $user_cuti;
                        }else{
                            $cuti = $identity_cuti;
                        }
                        
                        // Update user_cuti
                        $this->db->table("user")
                            ->where("user_id", $user_id)
                            ->update(array(
                                "user_cuti" => $cuti,
                                "user_cutitambahdate" => date("Y-m-d H:i:s")
                            ));
                    }
                } else {
                    // echo "User ID $user_id belum 1 tahun<br>";
                }
            }
        }
        return $data;
    }
}
