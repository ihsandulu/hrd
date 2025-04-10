<?php

namespace App\Controllers;

use phpDocumentor\Reflection\Types\Null_;
use CodeIgniter\API\ResponseTrait;

class api extends BaseController
{
    use ResponseTrait;

    protected $sesi_user;
    protected $db;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $sesi_user = new \App\Models\global_m();
        $sesi_user->ceksesi();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        echo "Page Not Found!";
    }

    public function encrypt()
    {
        // Kunci dan metode enkripsi
        $key = "ihsandulu123456"; // Kunci rahasia (jangan hardcode di produksi)
        $method = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

        // Enkripsi
        $password = "5kali6";
        $encrypted = openssl_encrypt($password, $method, $key, 0, $iv);
        $encrypted = base64_encode($iv . $encrypted); // Gabungkan IV agar bisa didekripsi nanti
        echo "Password terenkripsi: " . $encrypted . "<br>";

        // Dekripsi
        $data = base64_decode($encrypted);
        $iv_dec = substr($data, 0, openssl_cipher_iv_length($method));
        $encrypted_data = substr($data, openssl_cipher_iv_length($method));
        $decrypted = openssl_decrypt($encrypted_data, $method, $key, 0, $iv_dec);

        echo "Password setelah didekripsi: " . $decrypted;
    }



    public function createstore()
    {
        //input store 
        $input["store_name"] = $this->request->getGET("store_name");
        $input["store_address"] = $this->request->getGET("store_address");
        $input["store_phone"] = $this->request->getGET("store_phone");
        $input["store_wa"] = $this->request->getGET("store_wa");
        $input["store_owner"] = $this->request->getGET("store_owner");
        $input["store_active"] = $this->request->getGET("store_active");
        $this->db->table('store')->insert($input);
        // echo $this->db->getLastQuery();
        $userid = $this->db->insertID();

        //input position
        $inputposition1["store_id"] = $userid;
        $inputposition1["position_name"] = "Admin";
        $inputposition2["position_administrator"] = 2;
        $this->db->table('position')->insert($inputposition1);
        $positionid1 = $this->db->insertID();
        //input position
        $inputposition2["store_id"] = $userid;
        $inputposition2["position_administrator"] = 1;
        $inputposition2["position_name"] = "Administrator";
        $this->db->table('position')->insert($inputposition2);
        $positionid2 = $this->db->insertID();

        //input user
        $inputuser1["store_id"] = $userid;
        $inputuser1["user_name"] = $this->request->getGET("user_name");
        $inputuser1["user_email "] = $this->request->getGET("user_email ");
        $inputuser1["user_password"] = password_hash($this->request->getGET("user_password"), PASSWORD_DEFAULT);
        $inputuser1["position_id"] = $positionid1;
        $this->db->table('user')->insert($inputuser1);

        //input user administrator
        $inputuser2["store_id"] = $userid;
        $inputuser2["user_name"] = "Administrator";
        $inputuser2["user_email "] = "ihsan.dulu@gmail.com";
        $inputuser2["user_password"] = "$2y$10$GjtRux7LHXpXN5JotL/J0uE1KyV5LQ.OQrapMZqbhHt84oB7WDoEa";
        $inputuser2["position_id"] = $positionid2;
        $this->db->table('user')->insert($inputuser2);
        echo $this->db->getLastQuery();
    }

    public function iswritable()
    {
        $dir = $_GET["path"];
        if (is_dir($dir)) {
            if (is_writable($dir)) {
                echo "true";
            } else {
                echo "false";
            }
        } else if (file_exists($dir)) {
            return (is_writable($dir));
        }
    }



    public function hakakses()
    {
        $crud = $this->request->getGET("crud");
        $val = $this->request->getGET("val");
        $val = json_decode($val);
        $position_id = $this->request->getGET("position_id");
        $pages_id = $this->request->getGET("pages_id");
        $where["position_id"] = $this->request->getGET("position_id");
        $where["pages_id"] = $this->request->getGET("pages_id");
        $cek = $this->db->table('positionpages')->where($where)->get()->getNumRows();
        if ($cek > 0) {
            $input1[$crud] = $val;
            $this->db->table('positionpages')->update($input1, $where);
            echo $this->db->getLastQuery();
        } else {
            $input2["position_id"] = $position_id;
            $input2["pages_id"] = $pages_id;
            $input2[$crud] = $val;
            $this->db->table('positionpages')->insert($input2);
            echo $this->db->getLastQuery();
        }
    }

    public function hakaksesandroid()
    {
        $crud = $this->request->getGET("crud");
        $val = $this->request->getGET("val");
        $val = json_decode($val);
        $position_id = $this->request->getGET("position_id");
        $android_id = $this->request->getGET("android_id");
        $where["position_id"] = $this->request->getGET("position_id");
        $where["android_id"] = $this->request->getGET("android_id");
        $cek = $this->db->table('positionandroid')->where($where)->get()->getNumRows();
        if ($cek > 0) {
            $input1[$crud] = $val;
            $this->db->table('positionandroid')->update($input1, $where);
            echo $this->db->getLastQuery();
        } else {
            $input2["position_id"] = $position_id;
            $input2["android_id"] = $android_id;
            $input2[$crud] = $val;
            $this->db->table('positionandroid')->insert($input2);
            echo $this->db->getLastQuery();
        }
    }

    public function userposition()
    {
        $user = $this->db->table("t_user")
            ->where("position_id", $this->request->getGET("position_id"))
            ->orderBy("username", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $user_id = $this->request->getGET("user_id");
?>
        <option value="" <?= ($user_id == "") ? "selected" : ""; ?>>Pilih User</option>
        <?php
        foreach ($user->getResult() as $user) { ?>
            <option value="<?= $user->user_id; ?>" <?= ($user_id == $user->user_id) ? "selected" : ""; ?>><?= $user->user_nik; ?> - <?= $user->nama; ?></option>
        <?php } ?>
        <?php
    }

    public function alluser()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');


        $user = $this->db->table("t_user")
            // ->select('t_user.*, CASE WHEN (SELECT COUNT(*) FROM placement WHERE placement.user_id = t_user.user_id) > 0 THEN GROUP_CONCAT(placement.divisi_id SEPARATOR ",") ELSE NULL END AS divisiid')
            ->select("*, t_user.user_id as user_id, placement.estate_id as estate_id, placement.divisi_id as divisi_id, placement.seksi_id as seksi_id, placement.blok_id as blok_id, placement.tph_id as tph_id, t_user.position_id as position_id, position.position_name as position_name")
            ->join('placement', 'placement.user_id = t_user.user_id', 'left')
            ->join('estate', 'estate.estate_id = placement.estate_id', 'left')
            ->join('divisi', 'divisi.divisi_id = placement.divisi_id', 'left')
            ->join('seksi', 'seksi.seksi_id = placement.seksi_id', 'left')
            ->join('blok', 'blok.blok_id = placement.blok_id', 'left')
            ->join('tph', 'tph.tph_id = placement.tph_id', 'left')
            ->join('position', 'position.position_id = t_user.position_id', 'left')
            ->orderBy("t_user.username", "ASC")
            ->groupBy('t_user.user_id')
            ->get();

        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($user->getResult() as $user) {
            $userData = array(
                "user_id" => $user->user_id,
                "user_name" => ucwords($user->username),
                "user_password" => $user->password,
                "user_nik" => $user->user_nik,
                "position_id" => $user->position_id,
                "position_name" => $user->position_name,
                "estate_id" => $user->estate_id,
                "estate_name" => $user->estate_name,
                "divisi_id" => $user->divisi_id,
                "divisi_name" => $user->divisi_name,
                "seksi_id" => $user->seksi_id,
                "seksi_name" => $user->seksi_name,
                "blok_id" => $user->blok_id,
                "blok_name" => $user->blok_name,
                "tph_id" => $user->tph_id,
                "tph_name" => $user->tph_name
            );

            $data[] = $userData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function absen()
    {
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create') {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        //cek
        $cek = $this->db->table('absen')
            ->where("absen_date", $inputu["absen_date"])
            ->where("absen_type", $inputu["absen_type"])
            ->where("absen_user", $inputu["absen_user"])
            ->get();
        if ($cek->getNumRows() == 0) {
            $this->db->table('absen')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        } else {
            $data["message"] = "Data sudah ada!";
        }
    }



    public function apisync()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("panen")
            ->where("panen.panen_card", $this->request->getGet("panen_card"))
            ->where("panen.sptbs_id", $this->request->getGet("sptbs_id"))
            ->get();
        //echo $this->db->getLastQuery();  
        foreach ($usr->getResult() as $usr) { ?>
            <div class="col-12 row">
                <div class="col-4 text-primary">Card</div>
                <div class="col-8"> : <?= $usr->panen_card; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Date</div>
                <div class="col-8"> : <?= $usr->panen_date; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Thn Tanam</div>
                <div class="col-8"> : <?= $usr->tph_thntanam; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Jumlah</div>
                <div class="col-8"> : <?= $usr->panen_jml; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Checker</div>
                <div class="col-8"> : <?= $usr->user_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Pemanen</div>
                <div class="col-8"> : <?= $usr->panen_tpname; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Estate</div>
                <div class="col-8"> : <?= $usr->estate_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Divisi</div>
                <div class="col-8"> : <?= $usr->divisi_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Seksi</div>
                <div class="col-8"> : <?= $usr->seksi_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Blok</div>
                <div class="col-8"> : <?= $usr->blok_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">TPH</div>
                <div class="col-8"> : <?= $usr->tph_name; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Brondol</div>
                <div class="col-8"> : <?= ($usr->panen_brondol == 1) ? "Ya" : "Tidak"; ?></div>
            </div>
            <div class="col-12 row">
                <div class="col-4 text-primary">Geolocation</div>
                <div class="col-8"> : <?= $usr->panen_geo; ?></div>
            </div>
            <hr />
            <div class="col-12 row">
                <div class="col-12 text-primary">
                    <?php
                    $blob_data = $usr->panen_picture;
                    if (is_numeric($blob_data)) {
                        $blob_data = base_url("images/identity_logo/no_image.png");
                    }
                    ?>
                    <img src="<?= $blob_data; ?>" class="col-12" />
                </div>
            </div>
<?php }
    }



    public function apk()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("apk")
            ->orderBy("apk.apk_id", "DESC")
            ->limit("1")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "apk_version" => $usr->apk_version
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function positionandroid()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $builder = $this->db
            ->table("positionandroid")
            ->join("android", "android.android_id=positionandroid.android_id", "left");
        if (isset($_GET["position_id"]) && $_GET["position_id"] != "null" && $_GET["position_id"] != "") {
            $builder->where("position_id", $_GET["position_id"]);
        }
        $usr = $builder->orderBy("positionandroid.positionandroid_id", "DESC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "android_name" => $usr->android_name,
                "positionandroid_read" => $usr->positionandroid_read,
                "position_id" => $usr->position_id
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function tlain()
    {
        $tlainlain = $this->request->getGet("tlainlain");
        $tunjangan = $this->db->table("tunjangan")->get();

        // Mapping ID ke nama tunjangan
        $arrayTunjangan = [
            1 => "transport",
            2 => "hadir",
            3 => "makan"
        ];

        $tunjanganData = [];
        foreach ($tunjangan->getResult() as $t) {
            if (isset($arrayTunjangan[$t->tunjangan_id])) {
                $tunjanganData[$arrayTunjangan[$t->tunjangan_id]] = $tlainlain * ($t->tunjangan_persen / 100);
            }
        }
        return $this->response->setJSON($tunjanganData);
    }

    public function tanggunganjenis()
    {
        $input["tanggungan_id"] = $this->request->getGet("tanggungan_id");
        $ter_jenis = $this->db->table("tanggungan")->where($input)->get()->getRow()->tanggungan_ter;
        $gakot = $this->request->getGet("gakot");
        $ter = $this->db->table("ter")
            ->where("ter_jenis", $ter_jenis)
            ->where("ter_gakotawal <=", $gakot)
            ->where("ter_gakotakhir >=", $gakot)
            ->get();
        $pph = 0;
        foreach ($ter->getResult() as $ter) {
            $pph = $ter->ter_persen / 100 * $gakot;
        }
        echo $pph;
    }

    public function inputabsen()
    {
        $etag = $this->request->getGet("etag");
        $edate = $this->request->getGet("edate");
        $edate = substr($edate, 0, 4) . '-' . substr($edate, 4, 2) . '-' . substr($edate, 6, 2);

        $etime = $this->request->getGet("etime");
        $etime = substr($etime, 0, 2) . ':' . substr($etime, 2, 2) . ':' . substr($etime, 4, 2);

        $cetime = \DateTime::createFromFormat('H:i:s', $etime);
        $etime = $cetime->format('H:i:s');
        $datetime = $edate . ' ' . $etime;

        $user = $this->db->table("user")
            ->join('departemen', 'departemen.departemen_id = user.departemen_id', 'left')
            ->where("user_etag", $etag)
            ->get();
        $usercount = $user->getNumRows();
        foreach ($user->getResult() as $user) {
            $input["user_id"] = $user->user_id;
            $input["departemen_id"] = $user->departemen_id;
            $input["departemen_name"] = $user->departemen_name;
            $input["user_payrolltype"] = $user->user_payrolltype;
            $input["user_lembur"] = $user->user_lembur;
            $input["user_name"] = $user->user_nama;
        }

        $input["absen_masuk"] = "";
        $input["absen_keluar"] = "";
        if ($etime === false) {
            $input["absen_type"] = "Masuk";
            $input["absen_masuk"] = $edate . ' 06:00:00';
        } else
        if ($etime > "12:00:00") {
            $input["absen_type"] = "Keluar";
            $input["absen_keluar"] = $datetime;
        } else {
            $input["absen_type"] = "Masuk";
            $input["absen_masuk"] = $datetime;
        }
        //    echo $etime;die;

        $input["user_etag"] = $etag;
        $input["absen_date"] = $edate;
        $input["absen_skd"] = 0;
        $input["cuti_id"] = 0;
        $input["absen_note"] = "";



        if ($usercount > 0) {
            //cek absen
            $cekcok["user_id"] = $input["user_id"];
            $cekcok["absen_date"] = $input["absen_date"];
            $cek = $this->db->table("absen")->where($cekcok)->get()->getNumRows();
            if ($cek > 0) {
                $data["message"] = "Insert Data Gagal! Duplikat data.";
                $status = "gagal";
                $keterangan = "Double Input Absen!";
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
                $libur = $this->db->table("libur")
                    ->where("libur_date", $input["absen_date"])
                    ->orWhere("libur_hari", date("w", strtotime($input["absen_date"])))
                    ->get();
                $liburk = 0;
                foreach ($libur->getResult() as $libur) {
                    $liburk = 1;
                }

                $input["absen_harilibur"] = $liburk;

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

                $identity = $this->db->table("identity")->get()->getRow();

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

                //Sakit, Izin, Alpha, Cuti
                if ($user_payrolltype == "harian") {
                    //sakit
                    if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti") || ($input["absen_type"] == "Normal")) {
                        //ada SKD ga dipotong
                        $input["absen_alpha"] = 0;
                        $input["absen_alphanominal"] = 0;
                    } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                        //Sakit, izin dan alpha
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = ($gapok / 30) * 1;
                    }
                } else {
                    if ($input["absen_type"] == "Normal") {
                        $input["absen_alpha"] = 0;
                        $input["absen_alphanominal"] = 0;
                        $input["absen_ptransport"] = 0;
                        $input["absen_phadir"] = 0;
                        $input["absen_pmakan"] = 0;
                    } else
        if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 1) || ($input["absen_type"] == "Cuti")) {
                        $input["absen_ptransport"] = $user_ttransport / 30;
                        $input["absen_phadir"] = $user_thadir / 30;
                        $input["absen_pmakan"] = $user_tmakan / 30;
                        $input["absen_alpha"] = 0;
                        $input["absen_alphanominal"] = 0;
                    } else if (($input["absen_type"] == "Sakit" && $input["absen_skd"] == 0) || ($input["absen_type"] == "Izin") || ($input["absen_type"] == "Alpha")) {
                        $input["absen_alpha"] = 1;
                        $input["absen_alphanominal"] = $user_gakot / 30;
                        $input["absen_ptransport"] = 0;
                        $input["absen_phadir"] = 0;
                        $input["absen_pmakan"] = 0;
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

                //pulang cepat
                $pulangcepat = 0;
                $pulangcepatmenit = 0;
                if ($input["absen_type"] == "Normal") {
                    $wpkerja["jamkerja_type"] = "normal";
                    $wpkerja["jamkerja_ramadlan"] = $ramadlan;
                    $jamkerja = $this->db->table("jamkerja")
                        ->where($wpkerja)
                        ->where("FIND_IN_SET($hari,jamkerja_hari) >", 0)
                        ->get();
                    // echo $this->db->getLastQuery();die;
                    foreach ($jamkerja->getResult() as $jamkerja) {
                        $pulangcepatmenit = (strtotime($jamkerja->jamkerja_akhir) - strtotime($input["absen_keluar"])) / 60;
                        if ($pulangcepatmenit > 0) {
                            $pulangcepat = 1;
                        }
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
                $status = "success";
                $keterangan = "Insert Data Success!";
            }
        } else {
            $status = "gagal";
            $keterangan = "User Tidak Ditemukan!";
        }

        // echo $this->db->getLastQuery();

        return $this->response->setJSON(['status' => $status, 'keterangan' => $keterangan]);
    }

    public function tarikabsen()
    {
        $basePath = realpath(APPPATH . '../Debug/MDBReaderApp.exe');
        if (!$basePath) {
            echo "Path tidak ditemukan.";
            return;
        }

        $command = 'cmd /c start "" "' . $basePath . '"';
        shell_exec($command);

        echo "Aplikasi dijalankan.";
    }



    public function rubahstatustarikdata()
    {
        $input["statustarikdata_status"] = $this->request->getGet("status");
        $where["statustarikdata_id"] = 1;
        $this->db->table("statustarikdata")->where($where)->update($input);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function statustarikdata()
    {
        $statustarikdata = $this->db->table("statustarikdata")->get();
        foreach ($statustarikdata->getResult() as $statustarikdata) {
            $status = $statustarikdata->statustarikdata_status;
        }
        echo $status;
    }
}
