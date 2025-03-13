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









    public function divisi()
    {
        $build = $this->db->table("divisi");
        if (isset($_GET["estate_id"]) && $_GET["estate_id"] != "") {
            $build->where("estate_id", $this->request->getGET("estate_id"));
        }

        $divisi = $build->orderBy("divisi_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $divisi_id = $this->request->getGET("divisi_id");
?>
        <option value="" <?= ($divisi_id == "") ? "selected" : ""; ?>>Semua Divisi</option>
        <?php
        foreach ($divisi->getResult() as $divisi) { ?>
            <option value="<?= $divisi->divisi_id; ?>" <?= ($divisi_id == $divisi->divisi_id) ? "selected" : ""; ?>><?= $divisi->divisi_name; ?></option>
        <?php } ?>
    <?php
    }

    public function seksi()
    {
        $seksi = $this->db->table("seksi")
            ->where("divisi_id", $this->request->getGET("divisi_id"))
            ->orderBy("seksi_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $seksi_id = $this->request->getGET("seksi_id");
    ?>
        <option value="" <?= ($seksi_id == "") ? "selected" : ""; ?>>Pilih Seksi</option>
        <?php
        foreach ($seksi->getResult() as $seksi) { ?>
            <option value="<?= $seksi->seksi_id; ?>" <?= ($seksi_id == $seksi->seksi_id) ? "selected" : ""; ?>><?= $seksi->seksi_name; ?></option>
        <?php } ?>
    <?php
    }

    public function blok()
    {
        $blok = $this->db->table("blok")
            ->where("seksi_id", $this->request->getGET("seksi_id"))
            ->orderBy("blok_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $blok_id = $this->request->getGET("blok_id");
    ?>
        <option value="" <?= ($blok_id == "") ? "selected" : ""; ?>>Pilih Blok</option>
        <?php
        foreach ($blok->getResult() as $blok) { ?>
            <option value="<?= $blok->blok_id; ?>" <?= ($blok_id == $blok->blok_id) ? "selected" : ""; ?>><?= $blok->blok_name; ?></option>
        <?php } ?>
    <?php
    }

    public function tph()
    {
        $tph = $this->db->table("tph")
            ->where("blok_id", $this->request->getGET("blok_id"))
            ->orderBy("tph_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();
        $tph_id = $this->request->getGET("tph_id");
    ?>
        <option value="" <?= ($tph_id == "") ? "selected" : ""; ?>>Pilih TPH</option>
        <?php
        foreach ($tph->getResult() as $tph) { ?>
            <option value="<?= $tph->tph_id; ?>" <?= ($tph_id == $tph->tph_id) ? "selected" : ""; ?>><?= $tph->tph_name; ?></option>
        <?php } ?>
    <?php
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

    public function rkhnow()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("rkh")
            ->join("t_user", "t_user.user_id=rkh.user_id", "left")
            ->join("tph", "tph.tph_id=rkh.tph_id", "left")
            ->join("blok", "blok.blok_id=tph.blok_id", "left")
            ->join("seksi", "seksi.seksi_id=blok.seksi_id", "left")
            ->join("divisi", "divisi.divisi_id=seksi.divisi_id", "left")
            ->join("estate", "estate.estate_id=divisi.estate_id", "left")
            ->orderBy("estate_name", "ASC")
            ->orderBy("divisi_name", "ASC")
            ->orderBy("seksi_name", "ASC")
            ->orderBy("blok_name", "ASC")
            ->orderBy("tph_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "rkh_id" => $usr->rkh_id,
                "rkh_rdate" => ucwords($usr->rkh_rdate),
                "rkh_job" => $usr->rkh_job,
                "estate_id" => $usr->estate_id,
                "estate_name" => $usr->estate_name,
                "divisi_id" => $usr->divisi_id,
                "divisi_name" => $usr->divisi_name,
                "seksi_id" => $usr->seksi_id,
                "seksi_name" => $usr->seksi_name,
                "blok_id" => $usr->blok_id,
                "blok_name" => $usr->blok_name,
                "blok_ha" => $usr->blok_ha,
                "tph_id" => $usr->tph_id,
                "tph_name" => $usr->tph_name,
                "rkh_masuk" => $usr->rkh_masuk,
                "rkh_tmasuk" => $usr->rkh_tmasuk,
                "rkh_date" => $usr->rkh_date,
                "username" => ucwords($usr->username)
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function cc()
    {
        $data = array();
        $userData = array(
            "user_name" => "ihsan",
            "position_id" => "1"
        );
        $data[] = $userData;
        $userData = array(
            "user_name" => "dadi",
            "position_id" => "1"
        );
        $data[] = $userData;
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    /* public function datablok(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
        ->table("blok")
        ->join("seksi","seksi.seksi_id=blok.seksi_id","left")
        ->join("divisi","divisi.divisi_id=seksi.divisi_id","left")
        ->orderBy("blok_name", "ASC")
        ->get();
        //echo $this->db->getLastQuery();  
        $data=array();      
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "divisi_id" => $usr->divisi_id,
                "seksi_id" => $usr->seksi_id,
                "blok_id" => $usr->blok_id,
                "blok_name" => $usr->blok_name
            ); 
            $data[] = $usrData;
        } 
        return $this->response->setContentType('application/json')->setJSON($data);
    } */

    public function datablok()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("blok")
            ->join("seksi", "seksi.seksi_id=blok.seksi_id", "left")
            ->join("divisi", "divisi.divisi_id=seksi.divisi_id", "left")
            ->join("estate", "estate.estate_id=divisi.estate_id", "left")
            ->orderBy("blok_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "estate_id" => $usr->estate_id,
                "estate_name" => $usr->estate_name,
                "divisi_id" => $usr->divisi_id,
                "divisi_name" => $usr->divisi_name,
                "seksi_id" => $usr->seksi_id,
                "seksi_name" => $usr->seksi_name,
                "blok_id" => $usr->blok_id,
                "blok_name" => $usr->blok_name
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datatph()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("tph")
            ->orderBy("tph_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "blok_id" => $usr->blok_id,
                "tph_id" => $usr->tph_id,
                "tph_name" => $usr->tph_name,
                "tph_thntanam" => $usr->tph_thntanam
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datavendor()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_vendor")
            ->orderBy("nama_vendor", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "vendor_id" => $usr->ID_vendor,
                "vendor_name" => $usr->nama_vendor
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datamaterial()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_material")
            ->orderBy("nama_material", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "material_id" => $usr->ID_material,
                "material_name" => $usr->nama_material
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datakecamatan()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_asal")
            ->orderBy("kecamatan", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "kecamatan_id" => $usr->id_asal,
                "kecamatan_name" => $usr->kecamatan
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function driverdumptruck()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_user")
            ->join("position", "position.position_id=t_user.position_id", "left")
            ->where("t_user.position_id", "7")
            ->orWhere("t_user.position_id", "59")
            ->orderBy("t_user.nama", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "driverdumptruck_id" => $usr->user_id,
                "driverdumptruck_name" => $usr->nama,
                "driverdumptruck_position" => $usr->position_name
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function operatortractor()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_user")
            ->where("t_user.position_id", "68")
            ->orderBy("t_user.nama", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "operatortractor_id" => $usr->user_id,
                "operatortractor_name" => $usr->nama
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function datatrukpenerimaan()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("t_trukpenerimaan")
            ->where("status", "Aktif")
            ->orderBy("no_polisi ", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "no_polisi" => $usr->no_polisi
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function tp()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("placement")
            ->join("t_user", "t_user.user_id=placement.user_id", "left")
            ->join("position", "position.position_id=placement.position_id", "left")
            // ->where("placement.position_id","4")
            ->like("position.position_name", "checker", "BOTH")
            ->orLike("position.position_name", "mandor", "BOTH")
            ->orLike("position.position_name", "tenaga panen", "BOTH")
            ->orderBy("t_user.nama", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "panen_tp" => $usr->user_id,
                "position_id" => $usr->position_id,
                "panen_tpname" => $usr->nama,
                "panen_tpnik" => $usr->user_nik,
                "divisi_id" => $usr->divisi_id,
                "panen_placement" => $usr->placement_name
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function tphnumber()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("tphnumber")
            ->orderBy("tphnumber.tphnumber_card", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "tphnumber_card" => $usr->tphnumber_card
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function sptbsnumber()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("sptbsnumber")
            ->orderBy("sptbsnumber.sptbsnumber_card", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "sptbsnumber_card" => $usr->sptbsnumber_card
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function quarrynumber()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("quarrynumber")
            ->orderBy("quarrynumber.quarrynumber_card", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "quarrynumber_card" => $usr->quarrynumber_card
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function cpaneninsert()
    {

        $bintang = explode("*", $_GET["datanya"]);
        $sptbs_id = $_GET["sptbs_id"];
        //hapus data panen
        $this->db->table("panen")->where("sptbs_id", $sptbs_id)->delete();

        //insert panen
        $panjangBintang = count($bintang);
        // echo $panjangBintang;
        for ($i = 1; $i < $panjangBintang; $i++) {
            $pisah = $bintang[$i];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $inputpanen[$data[0]] = $data[1];
                if ($data[0] == "panen_date") {
                    $ir['panen_date'] = $data[1];
                }
                if ($data[0] == "panenid") {
                    $ir['panenid'] = $data[1];
                }
                if ($data[0] == "tph_id") {
                    $wheret['tph_id '] = $data[1];
                }
                if ($data[0] == "tph_thntanam") {
                    $inputt['tph_thntanam '] = $data[1];
                }
            }
            // print_r($koma);
            // echo $i." < ".$panjangBintang;
            //cek restand
            $restand = $this->db->table("restand")
                ->where($ir)
                ->get();
            if ($restand->getNumRows() > 0) {
                foreach ($restand->getResult() as $restand) {
                    $inputpanen["panen_picture"] = $restand->panen_picture;
                    $inputpanen["restand_id"] = $restand->restand_id;
                }
            }
            //input ke table panen
            $inputpanen["sptbs_id"] = $sptbs_id;
            $builder = $this->db->table('panen');
            $builder->insert($inputpanen);
            // return $this->db->getLastQuery();

            $panen_id = $this->db->insertID();
            if ($panen_id > 0) {
                $buildert = $this->db->table('tph');
                $buildert->update($inputt, $wheret);
            }
        }
    }

    public function paneninsert($inpututama, $sptbs_id)
    {

        $bintang = explode("*", $inpututama);
        //hapus data panen
        // $this->db->table("panen")->where("sptbs_id",$sptbs_id)->delete();

        //insert panen
        $panjangBintang = count($bintang);
        $isbrondol = 0;
        $istbs = 0;
        for ($i = 1; $i < $panjangBintang; $i++) {
            $pisah = $bintang[$i];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $inputpanen[$data[0]] = $data[1];
                if ($data[0] == "panen_date") {
                    $ir['panen_date'] = $data[1];
                }
                if ($data[0] == "panenid") {
                    $ir['panenid'] = $data[1];
                }
                if ($data[0] == "tph_id") {
                    $wheret['tph_id '] = $data[1];
                }
                if ($data[0] == "tph_thntanam") {
                    $inputt['tph_thntanam '] = $data[1];
                }
                if ($data[0] == "panen_brondol") {
                    if ($data[1] == 1) {
                        $isbrondol = 1;
                    } else {
                        $istbs = 1;
                    }
                }
            }
            //cek restand
            $restand = $this->db->table("restand")
                ->where($ir)
                ->get();
            if ($restand->getNumRows() > 0) {
                foreach ($restand->getResult() as $restand) {
                    $inputpanen["panen_picture"] = $restand->panen_picture;
                    $inputpanen["restand_id"] = $restand->restand_id;
                }
            }
            //input ke table panen
            $inputpanen["sptbs_id"] = $sptbs_id;
            $builder = $this->db->table('panen');
            $builder->insert($inputpanen);
            // return $this->db->getLastQuery();

            $panen_id = $this->db->insertID();
            if ($panen_id > 0) {
                $buildert = $this->db->table('tph');
                $buildert->update($inputt, $wheret);
            }
        }

        //update total jml tandan
        $jmltandan = $this->db->table("panen")
            ->select("SUM(panen_jml)as tjtandan")
            ->where("sptbs_id", $sptbs_id)
            ->get();
        foreach ($jmltandan->getResult() as $jmltandan) {
            $inputjtan["sptbs_jmltandan"] = $jmltandan->tjtandan;
            $inputjtan["sptbs_isbrondol"] = $isbrondol;
            $inputjtan["sptbs_istbs"] = $istbs;
            $wherejtan["sptbs_id"] = $sptbs_id;
            $sptbsj = $this->db->table('sptbs');
            $sptbsj->update($inputjtan, $wherejtan);
        }
    }

    public function thitungbruto()
    {
        $sptbs_id = $_GET["sptbs_id"];
        $netto = $_GET["netto"];
        $isbrondol = $_GET["isbrondol"];
        $istbs = $_GET["istbs"];
        $this->hitungbruto($sptbs_id, $netto, $isbrondol, $istbs);
    }

    public function hitungbruto($sptbs_id, $netto, $isbrondol, $istbs)
    {
        $tonase = $this->db->table("tonasepanen")
            ->where("sptbs_id", $sptbs_id)
            ->get();
        $ttonbrondol = 0;
        $ttontbs = 0;
        $arrttonbrondol = array();
        $arrttontbs = array();
        $arrtton = array();
        $tipe = array();
        foreach ($tonase->getResult() as $tonase) {
            $ttonbrondol += $tonase->ton_brondol;
            $ttontbs += $tonase->ton_tbs;
            $arrttonbrondol[$tonase->panen_id] = $tonase->ton_brondol;
            $arrttontbs[$tonase->panen_id] = $tonase->ton_tbs;
            $tipe[$tonase->panen_id] = $tonase->panen_brondol;
            if ($tonase->panen_brondol == 1) {
                $arrtton[$tonase->panen_id] = $tonase->ton_brondol;
            } else {
                $arrtton[$tonase->panen_id] = $tonase->ton_tbs;
            }
        }

        if ($isbrondol == 0 && $istbs == 1) {
            foreach ($arrttontbs as $panenid => $ton) {
                // echo $netto." / ".$ttontbs." * ".$ton;die;
                if ($ton > 0) {
                    $a = $netto / $ttontbs * $ton;
                } else {
                    $a = 0;
                }
                $inputbrutotbs["panen_bruto"] = $a;
                $wherebrutotbs["panen_id"] = $panenid;
                $this->db->table("panen")->update($inputbrutotbs, $wherebrutotbs);
            }
        } else if ($isbrondol == 1 && $istbs == 0) {
            foreach ($arrttonbrondol as $panenid => $ton) {
                if ($ton > 0) {
                    $a = $netto / $ttonbrondol * $ton;
                } else {
                    $a = 0;
                }
                $inputbrutobrondol["panen_bruto"] = $a;
                $wherebrutobrondol["panen_id"] = $panenid;
                $this->db->table("panen")->update($inputbrutobrondol, $wherebrutobrondol);
            }
        } else if ($isbrondol == 1 && $istbs == 1) {
            $ttonbrondol = $netto - $ttontbs;
            $ttontbs = $netto - $ttonbrondol;
            foreach ($arrtton as $panenid => $ton) {
                $tipeb = $tipe[$panenid];
                if ($tipeb == 1) {
                    $tton = $ttonbrondol;
                }
                if ($tipeb == 0) {
                    $tton = $ttontbs;
                }
                if ($ton > 0) {
                    $a = $netto / $tton * $ton;
                } else {
                    $a = 0;
                }
                $inputbrutocampur["panen_bruto"] = $a;
                $wherebrutocampur["panen_id"] = $panenid;
                $this->db->table("panen")->update($inputbrutocampur, $wherebrutocampur);
            }
        }
    }
    public function thitunggrading()
    {
        $sptbs_id = $_GET["sptbs_id"];
        $this->hitunggrading($sptbs_id);
    }
    public function hitunggrading($sptbs_id)
    {
        $subpanen = $this->db->table("panen")
            ->select("SUM(panen_bruto)AS tbruto, sptbs_id")
            ->groupBy("sptbs_id")
            ->getCompiledSelect();
        $build = $this->db
            ->table("sptbs")
            ->select("sptbs.sptbs_id, sptbs.sptbsid, sptbs.sptbs_code as sptbscode, sptbs.estate_name, sptbs.divisi_name,sptbs.sptbs_timbanganmasuk, sptbs.sptbs_timbangankeluar, sptbs.sptbs_date, sptbs.sptbs_drivername, sptbs.sptbs_kgbruto, sptbs.sptbs_kgtruk, sptbs.sptbs_kgnetto, sptbs.sptbs_jmltandan,  jmlpanen.totalpanen, panen.tbruto")
            ->join("jmlpanen", "jmlpanen.sptbs_id=sptbs.sptbs_id", "left")
            ->join("($subpanen)as panen", "panen.sptbs_id=sptbs.sptbs_id", "left");

        $sptbs = $build
            ->where("sptbs.sptbs_id", $sptbs_id)
            ->get();
        // echo $this->db->getLastquery();die;
        $no = 1;
        foreach ($sptbs->getResult() as $sptbs) {
            $brutto = $sptbs->sptbs_kgbruto;
            $tarra = $sptbs->sptbs_kgtruk;
            $netto = $brutto - $tarra;
            $totalpanen = $sptbs->totalpanen;
            $sptbscode = $sptbs->sptbscode;
            // $jmlbrondol=$sptbs->jmlbrondol;
            $tbruttopanen = $sptbs->tbruto;


            $grading = $this->db->table("grading")
                ->join("gradingtype", "gradingtype.gradingtype_id=grading.gradingtype_id", "left")
                ->where("sptbsid", $sptbs->sptbsid)
                ->where("grading_date", $sptbs->sptbs_date)
                ->get();
            $tkg = 0;
            $gradingtype_name = array();
            foreach ($grading->getResult() as $grading) {
                /* 
            1 Fraksi 00
            2 Fraksi 0 
            3 Fraksi 5 
            4 Tangkai Panjang 
            5 Tandan Kosong 
            6 Tandan <3kg 
            7 Sampah 
            8 Brondolan Lepas 
            9 Fraksi 6 
            */
                $a = $grading->gradingtype_id;
                $gradingqty = $grading->grading_qty;
                $knetto = array(6, 7, 8);
                $persen = 0;
                if (in_array($a, $knetto)) {
                    $persent = $gradingqty / $netto * 100;
                    if ($persent > 0) {
                        $persen = $persent;
                    }
                } else {
                    if ($totalpanen == 0) {
                        $persen = 0;
                    } else {
                        $persent = $gradingqty / $totalpanen * 100;
                        if ($persent > 0) {
                            $persen = $persent;
                        }
                    }
                }

                $p50 = array(1, 2);
                $p25 = array(3, 9);
                $p100 = array(5);
                $p1 = array(4);
                $p30 = array(8);
                $k2 = array(7);
                $p70 = array(6);
                if (in_array($a, $p50)) {
                    $nilai = 50 / 100 * $persen / 100 * $netto;
                    $kg = round($nilai);
                } else  if (in_array($a, $p25)) {
                    if ($persen > 5) {
                        $nilai = 25 / 100 * ($persen / 100 - 5 / 100) * $netto;
                        $kg = round($nilai);
                    } else {
                        $kg = 0;
                    }
                } else  if (in_array($a, $p100)) {
                    $nilai = (100 / 100) * ($persen / 100) * $netto;
                    $kg = round($nilai);
                } else  if (in_array($a, $p1)) {
                    $nilai = (1 / 100) * ($persen / 100) * $netto;
                    $kg = round($nilai);
                } else  if (in_array($a, $p30)) {
                    if ($persen <= 0) {
                        $kg = 0;
                    } else {
                        $nilai = 30 / 100 * (12.5 / 100 - $persen / 100) * $netto;
                        if ($nilai < 0) {
                            $kg = 0;
                        } else {
                            $kg = round($nilai);
                        }
                    }
                } else if (in_array($a, $k2)) {
                    $kg = round($gradingqty * 2);
                } else if (in_array($a, $p70)) {
                    $kg = round($gradingqty * 1 * 0.70);
                }
                $tkg += $kg;

                $gradingtype_name[$grading->gradingtype_id]["qty"] = $gradingqty;
                $gradingtype_name[$grading->gradingtype_id]["persen"] = $persen;
                $gradingtype_name[$grading->gradingtype_id]["kg"] = $kg;

                // echo $grading->grading_id."=".$kg; die;

                $inputgrading["grading_persen"] = $persen;
                $inputgrading["grading_kg"] = $kg;
                $wheregrading["grading_id"] = $grading->grading_id;
                $this->db->table("grading")->update($inputgrading, $wheregrading);
            }

            $tgrading = $tkg;

            //netto diterima
            if (is_numeric($netto) && is_numeric($tgrading)) {
                $nettoditerima = $netto - $tgrading;
            } else {
                $nettoditerima = 0;
            }

            //bjr
            if (is_numeric($totalpanen) && $totalpanen != 0) {
                $bjr = $netto / $totalpanen;
            } else {
                $bjr = 0;
            }

            //% grading
            if ($netto != 0) {
                $pgrading = ($tgrading / $netto) * 100;
            } else {
                $pgrading = 0;
            }


            $inputsptbs["sptbs_kgnettostlgrading"] = $nettoditerima;
            $inputsptbs["sptbs_kgsampah"] = $tgrading;
            $inputsptbs["sptbs_pgrading"] = $pgrading;
            $inputsptbs["sptbs_bjr"] = $bjr;
            $wheresptbs["sptbs_id"] = $sptbs->sptbs_id;
            $this->db->table("sptbs")->update($inputsptbs, $wheresptbs);

            // echo $sptbs->sptbs_id;die;

            $panen = $this->db->table("panen")
                ->where("sptbs_id", $sptbs_id)
                ->get();
            foreach ($panen->getResult() as $panen) {
                $panen_grading = $tgrading / $tbruttopanen * $panen->panen_bruto;
                $panen_netto = $panen->panen_bruto - $panen_grading;
                $panen_bjr = $panen_netto / $panen->panen_jml;
                $inputpanen["panen_grading"] = $panen_grading;
                $inputpanen["panen_netto"] = $panen_netto;
                $inputpanen["panen_bjr"] = $panen_bjr;
                $wherepanen["panen_id"] = $panen->panen_id;
                $this->db->table("panen")->update($inputpanen, $wherepanen);
            }
        }
    }

    public function datasptbsmentah()
    {
        $time = date("H:i:s");
        $timbangan_name = request()->getGet("timbangan_name");
        $inpututama = request()->getGet("datanya");
        $timbangan = request()->getGet("sptbs_timbangan");
        $nokartu = request()->getGet("sptbs_nokartu");
        $bintang = explode("*", $inpututama);

        $whereu["sptbs_card"] = request()->getGet("sptbs_card");
        $whereu["sptbs_date"] = request()->getGet("sptbs_date");
        $whereu["lr_name"] = request()->getGet("lr_name");
        $usru = $this->db->table('sptbs')->where($whereu)->get();
        $rowCountu = $usru->getNumRows();
        // echo $this->db->getLastQuery();
        // echo "<br/>".$rowCountu;die;

        if ($rowCountu > 0) {
            foreach ($usru->getResult() as $usru) {
                $arnokartu = explode(",", $usru->sptbs_nokartu);
                $sptbs_id = $usru->sptbs_id;
                if (in_array($nokartu, $arnokartu)) {
                    $isbrondol = $usru->sptbs_isbrondol;
                    $istbs = $usru->sptbs_istbs;
                    $sptbs_kgbruto = $usru->sptbs_kgbruto;
                    $selisih = $sptbs_kgbruto - $timbangan;
                    if ($selisih > 250) {
                        $inputt["timbangan_name"] = $timbangan_name;
                        $inputt["sptbs_kgtruk"] = $timbangan;
                        $inputt["sptbs_kgnetto"] = $selisih;
                        $inputt["sptbs_timbangankeluar"] = $time;
                        $inputt["sptbs_created"] = date("Y-m-d H:i:s");
                        $wheret["sptbs_id"] = $sptbs_id;
                        $buildert = $this->db->table('sptbs');
                        $buildert->update($inputt, $wheret);
                        // echo $this->db->getLastQuery();


                        //////masukkan bruto per tph setelah mendapatkan netto dari timbangan////////
                        // $message["message"]= "sptbs_id=".$sptbs_id.", selisih=".$selisih.", isbrondol=".$isbrondol.", istbs=".$istbs;
                        $this->hitungbruto($sptbs_id, $selisih, $isbrondol, $istbs);
                        $this->hitunggrading($sptbs_id);


                        $message["message"] = "Netto di update!";
                        // $message["message"]=$timbangan."<".$sptbs_kgbruto;
                        $message["status"] = 2;
                    } else {
                        // $this->paneninsert($bintang,$sptbs_id);
                        $message["message"] = "SPTBS telah diinput sebelumnya!";
                        $message["status"] = 0;
                    }
                } else {
                    $this->paneninsert($inpututama, $sptbs_id);
                    $icard["sptbs_nokartu"] = $usru->sptbs_nokartu . "," . $nokartu;
                    $wcard["sptbs_id"] = $sptbs_id;
                    $this->db->table("sptbs")->update($icard, $wcard);
                    $message["message"] = "SPTBS berhasil di upload!";
                    $message["status"] = 1;
                }
            }
        } else {
            $last = $this->db->table('sptbs')->orderBy("sptbs_id", "DESC")->limit(1)->get();
            $rowlast = $last->getNumRows();
            if ($rowlast > 0) {
                $pplast = $last->getRow()->sptbs_code;
                $plast = substr($pplast, -6) + 1;
            } else {
                $plast = "000001";
            }
            $code = str_pad($plast, 6, '0', STR_PAD_LEFT);

            $pisah = $bintang[0];
            $koma = explode(",", $pisah);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                if ($data[0] != "sptbs_timbangan" && $data[0] != "sptbs_id") {
                    $input[$data[0]] = $data[1];
                }
            }
            $input["sptbs_code"] = "PAMWB/" . date("my") . "/" . $code;
            $input["sptbs_timbanganmasuk"] = $time;
            $input["timbangan_name"] = $timbangan_name;
            $input["sptbs_kgbruto"] = $timbangan;
            $input["sptbsid"] = request()->getGet("sptbsid");
            $builder = $this->db->table('sptbs');
            $builder->insert($input);
            // echo $this->db->getLastQuery();
            // die;
            $sptbs_id = $this->db->insertID();

            $message["message"] = "SPTBS berhasil di upload!";
            $message["status"] = 1;

            echo $this->paneninsert($inpututama, $sptbs_id);
        }

        $jsonResponset = json_encode($message);
        return $this->response->setContentType('application/json')->setBody($jsonResponset);
    }

    public function datagradingmentah()
    {
        $inpututama = request()->getGet("datanya");
        $bintang = explode("*", $inpututama);
        $panjangBintang = count($bintang);
        for ($i = 0; $i < $panjangBintang; $i++) {
            $pisah = $bintang[$i];
            $koma = explode(",", $pisah);
            // dd($koma);
            foreach ($koma as $isikoma) {
                $data = explode("=", $isikoma);
                $input[$data[0]] = $data[1];
                if ($data[0] == "grading_tp") {
                    $where[$data[0]] = $data[1];
                }
                if ($data[0] == "gradingtype_id") {
                    $where[$data[0]] = $data[1];
                }
                if ($data[0] == "grading_date") {
                    $where[$data[0]] = $data[1];
                }
                if ($data[0] == "sptbsid") {
                    $where[$data[0]] = $data[1];
                }
            }
            // dd($input);
            $this->db->table('grading')->delete($where);

            $this->db->table('grading')->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $panen_id = $this->db->insertID();
        }
        echo "Insert Data Success";
    }

    public function apitimbangan()
    {
        $input["sptbs_timbangan"] = request()->getGet("sptbs_timbangan");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $usr = $this->db->table('sptbs')->getWhere($where);
        $rowCount = $usr->countAllResults();
        if ($rowCount > 0) {
            foreach ($usr->getResult() as $usr) {
            }
            // $this->table("sptbs")->update($input, $where);
            $this->db->table("sptbs")->update($input, $where);
        } else {
            // $this->table("sptbs")->insert($input);
            $this->db->table("sptbs")->insert($input);
        }


        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);
    }

    public function apibrutto()
    {
        $input["sptbs_kgbruto"] = request()->getGet("sptbs_kgbruto");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $builder = $this->db->table('sptbs');
        $builder->update($input, $where);
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);
    }

    public function apinetto()
    {
        $input["sptbs_kgtruk"] = request()->getGet("sptbs_kgtruk");
        $input["sptbs_kgsampah"] = request()->getGet("sptbs_kgsampah");
        $input["sptbs_kgnetto"] = request()->getGet("sptbs_kgnetto");
        $where["sptbs_card"] = request()->getGet("sptbs_card");
        $builder = $this->db->table('sptbs');
        $builder->update($input, $where);
        $jsonResponse = json_encode($input);

        // Mengembalikan respons JSON
        return $this->response->setContentType('application/json')->setBody($jsonResponse);
        // print_r($input);

    }

    public function gradingtype()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("gradingtype")
            ->orderBy("gradingtype.gradingtype_id", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "gradingtype_id" => $usr->gradingtype_id,
                "gradingtype_name" => $usr->gradingtype_name
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }


    public function absen1()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');

        helper(['form', 'url']);

        // Validate file upload
        $file = $this->request->getFile('absen_picture');
        if ($file && $file->isValid()) {
            // Pindahkan file gambar ke direktori writable/uploads
            $direktori = 'images/absen_picture';
            $file->move(ROOTPATH . $direktori);

            // Ambil data tambahan dari request
            $divisiId = $this->request->getPost('divisi_id');
            $estateId = $this->request->getPost('estate_id');

            // Proses data tambahan jika diperlukan
            // Misalnya: Simpan data tambahan ke database

            // Berikan respons sukses
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'File uploaded successfully'
            ]);
        } else {
            // Jika validasi gagal, berikan respons error
            return $this->failValidationError('File upload failed');
        }
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

    public function uploadtph()
    {
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create') {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        //cek
        $cek = $this->db->table('panen')
            ->where("panen_date", $inputu["panen_date"])
            // ->where("tph_id",$inputu["tph_id"])
            // ->where("panen_card",$inputu["panen_card"])
            ->where("panenid", $inputu["panenid"])
            ->where("restand_id >", 0)
            ->get();
        if ($cek->getNumRows() == 0) {
            $this->db->table('restand')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        } else {
            foreach ($cek->getResult() as $cek) {
                $input["panen_picture"] = $this->request->getPost("panen_picture");
                $where["panen_id"] = $cek->panen_id;
                $this->db->table('panen')->update($input, $where);
                $data["message"] = "Update Gambar Success!";
            }
        }
    }

    public function gambarabsen()
    {
        $id = $this->request->getGet("id");
        $cek = $this->db->table('absen')
            ->where("absen_id", $id)
            ->get();
        // echo $this->db->getLastQuery(); die;
        foreach ($cek->getResult() as $cek) {
            echo $cek->absen_picture;
        }
    }

    public function wt()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("wt")
            ->orderBy("wt.wt_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "wt_id" => $usr->wt_id,
                "wt_name" => $usr->wt_name,
                "wt_vendor" => $usr->wt_vendor,
                "wt_jenis" => $usr->wt_jenis,
                "wt_sewa" => $usr->wt_sewa,
                "wt_nopol" => $usr->wt_nopol
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function quarrytype()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("quarrytype")
            ->orderBy("quarrytype.quarrytype_sumber", "ASC")
            ->orderBy("quarrytype.quarrytype_jenis", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "quarrytype_id" => $usr->quarrytype_id,
                "quarrytype_sumber" => $usr->quarrytype_sumber,
                "quarrytype_jenis" => $usr->quarrytype_jenis
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }



    public function uploadquarry()
    {
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create') {
                $inputu[$e] = $this->request->getPost($e);
            }
        }

        $this->db->table('quarry')->insert($inputu);
        //cek
        /* $cek=$this->db->table('quarry')
        ->where("quarry_date",$inputu["quarry_date"])
        ->where("quarry_card",$inputu["quarry_card"])
        ->get();
        if($cek->getNumRows()==0){
            $this->db->table('quarry')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        }else{
            foreach ($cek->getResult() as $cek) {
                $where["quarry_id"]=$cek->quarry_id;
                $this->db->table('quarry')->update($input,$where);
                $data["message"] = "Data Diupdate!";
            }
        } */
    }

    public function insertquarry_jarak()
    {
        foreach ($this->request->getGet() as $e => $f) {
            if ($e != 'create') {
                $input[$e] = $this->request->getGet($e);
            }
        }
        $where["quarry_id"] = $this->request->getGet("quarry_id");
        $this->db->table('quarry')->update($input, $where);
    }

    public function updatetimbanganvalue()
    {
        foreach ($this->request->getGet() as $e => $f) {
            if ($e != 'create') {
                $input[$e] = $this->request->getGet($e);
            }
        }
        $where["timbangan_name"] = $this->request->getGet("timbangan_name");
        $this->db->table('timbangan')->update($input, $where);
        return $this->response->setContentType('application/json')->setJSON($input);
    }

    public function timbangan()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("timbangan")
            ->orderBy("timbangan.timbangan_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "timbangan_id" => $usr->timbangan_id,
                "timbangan_name" => $usr->timbangan_name,
                "timbangan_value" => $usr->timbangan_value
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function timbanganisi()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("timbangan")
            ->where("timbangan.timbangan_name", $this->request->getGet("timbangan_name"))
            ->get();
        //echo $this->db->getLastQuery();  
        foreach ($usr->getResult() as $usr) {
            // echo $usr->timbangan_value;
            $usrData = array(
                "timbangan_value" => $usr->timbangan_value
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
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

    public function updaterspo()
    {
        $tph = $this->db->table("tph")
            ->join("blok", "blok.blok_id=tph.blok_id", "left")
            ->join("seksi", "seksi.seksi_id=blok.seksi_id", "left")
            ->join("divisi", "divisi.divisi_id=seksi.divisi_id", "left")
            ->join("estate", "estate.estate_id=divisi.estate_id", "left")
            ->get();
        foreach ($tph->getResult() as $tph) {
            $rspo = $this->db->table("t_statusrspoasli")
                ->where("estate", $tph->estate_name)
                ->where("divisi", $tph->divisi_name)
                ->where("blok", $tph->blok_name)
                ->where("tahun_tanam", $tph->tph_thntanam)
                ->limit(1)
                ->get();
            foreach ($rspo->getResult() as $rspo) {
                $update["tph_certificate"] = $rspo->status_certificate;
                $update["tph_status"] = $rspo->status_kebun;
                $where["tph_id "] = $tph->tph_id;
                $this->db->table("tph")->where($where)->update($update);
                echo $rspo->estate . " -> " . $rspo->divisi . " -> " . $rspo->blok . " -> " . $rspo->tahun_tanam . "<br/>";
            }
        }
    }

    public function printtimbangan()
    {
        $timbangan_name = $this->request->getGet("timbangan_name");
        ?>
        <?php
        date_default_timezone_set('Asia/Jakarta');
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();


        $icon = "";
        $nama = "";
        $identity = $this->db->table("identity")->get();
        foreach ($identity->getResult() as $identity) {
            $icon = $identity->identity_logo;
            $nama = $identity->identity_name;
        }
        ?>

        <?php if (isset($_GET["print"])) { ?>
            <link href="<?= base_url("css/lib/bootstrap/bootstrap.min.4.5.2.css"); ?>" rel="stylesheet">
            <link href="<?= base_url("css/helper.css"); ?>" rel="stylesheet">
            <link href="<?= base_url("css/style.css"); ?>" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <!--Custom JavaScript -->
            <script src="<?= base_url("js/custom.min.js"); ?>"></script>
            <script>
                tinymce.init({
                    selector: 'textarea'
                });
            </script>

            <style>
                .toast {
                    min-width: 300px;
                    position: fixed;
                    bottom: 50px;
                    right: 50px;
                    z-index: 1000000000 !important;
                    display: none;
                }

                .toast-header {
                    background-color: aquamarine;
                }

                .toast-body {
                    min-height: 100px;
                }

                .border {
                    border: black solid 1px !important;
                }

                th,
                td {
                    text-align: center;
                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                }

                td {
                    font-size: 14px;
                    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
                    color: black !important;
                }

                .btn-action {
                    padding: 0px;
                    margin: 2px;
                    display: inline;
                }

                .bold {
                    font-weight: bold;
                }

                .green {
                    color: olive;
                }

                .hidebar {
                    height: inherit;
                    overflow: auto;
                }

                /* Hide scrollbar for Chrome, Safari and Opera */
                .hidebar::-webkit-scrollbar {
                    display: none;
                }

                /* Hide scrollbar for IE, Edge and Firefox */
                .hidebar {
                    -ms-overflow-style: none;
                    /* IE and Edge */
                    scrollbar-width: none;
                    /* Firefox */
                }

                .hide {
                    display: none !important;
                }

                .container-fluid {
                    padding: 5px;
                    margin: 0px;
                }

                .page-titles {
                    margin-bottom: -13px;
                }

                .tunjuk {
                    cursor: pointer;
                }

                .navitem {
                    padding: 0px;
                    font-size: 30px !important;
                }

                .navlink {
                    margin: 0px !important;
                    padding: 0px !important;
                    padding-left: 10px !important;
                    font-size: 30px !important;
                }

                .navlink::after {
                    content: "Menu";
                    color: rgba(128, 128, 128, 0.6);
                    font-weight: bold;
                    font-size: 15px !important;
                    position: absolute;
                    top: 50%;
                    transform: translate(10px, -50%);
                }

                .tengah {
                    position: fixed !important;
                    right: 20px !important;
                    top: 20px !important;
                    width: 100px;
                    height: auto;
                }
            </style>
            <script>
                window.print();
                setTimeout(function() {
                    window.close();
                }, 3000);
            </script>

            </head>

            <body class="fix-header fix-sidebar">
                <style>
                    .nl1 {
                        font-size: 15px !important;
                        padding: 20px !important;
                        border: rgba(0, 0, 0, 0.2) solid 1px !important;
                    }

                    .tab-pane {
                        border: rgba(0, 0, 0, 0.2) solid 1px !important;
                        padding: 20px !important;
                        margin: 0px !important;
                    }

                    .text-bold {
                        font-weight: bold;
                    }

                    .t-10 {
                        font-size: 12px;
                    }
                </style>

            <?php } ?>
            <div class=" p-0 mt-2">
                <?php $timbangan = $this->db->table("timbangan")
                    ->where("timbangan_name", $timbangan_name)
                    ->get();
                foreach ($timbangan->getResult() as $timbangan) { ?>
                    <div id="t<?= $timbangan->timbangan_id; ?>" class="tab-pane ">

                        <?php
                        $currentDateTime = date("Y-m-d H:i:s");
                        $fiveMinutesAgo = date("Y-m-d H:i:s", strtotime("-5 minutes", strtotime($currentDateTime)));
                        $builder = $this->db->table("sptbs");
                        if (isset($_GET["sptbs_id"])) {
                            $sptbs = $builder->where("sptbs_id", $_GET["sptbs_id"])
                                ->orderBy("sptbs_id", "DESC")
                                ->limit(1)
                                ->get();
                        } else {
                            $sptbs = $builder->where("timbangan_name", $timbangan->timbangan_name)
                                ->where("sptbs_date", date("Y-m-d"))
                                ->where("sptbs_created >=", $fiveMinutesAgo)
                                ->where("sptbs_created <=", $currentDateTime)
                                ->orderBy("sptbs_id", "DESC")
                                ->limit(1)
                                ->get();
                        }
                        // echo $this->db->getLastquery();
                        foreach ($sptbs->getResult() as $sptbs) { ?>
                            <div class="row">
                                <div class="col-12 row">
                                    <div class="col-6">
                                        <h3><?= session()->get("identity_company"); ?></h3>
                                    </div>
                                    <div class="col-6 text-right">
                                        <?php if (!isset($_GET["print"])) { ?>
                                            <a target="_blank" href="<?= base_url("api/printtimbangan?print=OK&timbangan_name=" . $_GET["timbangan_name"]); ?>" class="btn btn-warning"><i class="fa fa-print"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-6 row">
                                    <div class="col-12">
                                        CPO Mill Office
                                    </div>
                                    <div class="col-12">
                                        <?= session()->get("identity_address"); ?>
                                    </div>
                                    <div class="col-5">
                                        NO POLISI
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->wt_name; ?>
                                    </div>
                                    <div class="col-5">
                                        SUPIR
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_drivername; ?>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-5 row">
                                    <div class="col-5">
                                        NO TICKET
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_code; ?>
                                    </div>
                                    <div class="col-5">
                                        SPTBS Date
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_date; ?>
                                    </div>
                                    <div class="col-5">
                                        Created Date
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_created; ?>
                                    </div>
                                    <div class="col-5">
                                        Timbangan
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->timbangan_name; ?>
                                    </div>
                                    <div class="col-5">
                                        Masuk
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_timbanganmasuk; ?>
                                    </div>
                                    <div class="col-5">
                                        Keluar
                                    </div>
                                    <div class="col-7">
                                        : <?= $sptbs->sptbs_timbangankeluar; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 row">
                                    <div class="col border text-center">
                                        Estate
                                    </div>
                                    <div class="col border text-center">
                                        Divisi
                                    </div>
                                    <div class="col border text-center">
                                        Blok
                                    </div>
                                    <div class="col border text-center">
                                        Thn Tanam
                                    </div>
                                    <div class="col border text-center">
                                        Sertifikasi
                                    </div>
                                    <div class="col border text-center">
                                        Status Kebun
                                    </div>
                                    <div class="col border text-center">
                                        Jml tandan
                                    </div>
                                    <div class="col border text-center">
                                        Loading Ramp
                                    </div>
                                </div>
                                <?php
                                $panen = $this->db->table("panen")
                                    ->select("SUM(panen_jml)As jmltandan,panen.*,tph.tph_status,tph.tph_certificate")
                                    ->join("tph", "tph.tph_id=panen.tph_id", "left")
                                    ->where("sptbs_id", $sptbs->sptbs_id)
                                    ->groupBy("tph_thntanam")
                                    ->get();
                                // echo $this->db->getLastquery();
                                $jmltandan = 0;
                                foreach ($panen->getResult() as $panen) {
                                    $jmltandan += $panen->jmltandan;
                                ?>
                                    <div class="col-12 row">
                                        <div class="col border text-center">
                                            <?= $panen->estate_name; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->divisi_name; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->blok_name; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->tph_thntanam; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->tph_certificate; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->tph_status; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->jmltandan; ?>
                                        </div>
                                        <div class="col border text-center">
                                            <?= $panen->lr_name; ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="row mt-3 mb-5">
                                <?php
                                $brutto = $sptbs->sptbs_kgbruto;
                                $tarra = $sptbs->sptbs_kgtruk;
                                $netto = $brutto - $tarra;
                                ?>
                                <div class="col-6 row">
                                    <div class="col-12">
                                        <h5 class="text-center">GRADING</h5>
                                    </div>
                                    <?php
                                    $grading = $this->db->table("grading")
                                        ->join("gradingtype", "gradingtype.gradingtype_id=grading.gradingtype_id", "left")
                                        ->where("sptbsid", $sptbs->sptbsid)
                                        ->where("grading_date", $sptbs->sptbs_date)
                                        ->get();
                                    $tkg = 0;
                                    foreach ($grading->getResult() as $grading) {
                                        /* 
                                1 Fraksi 00
                                2 Fraksi 0 
                                3 Fraksi 5 
                                4 Tangkai Panjang 
                                5 Tandan Kosong 
                                6 Tandan <3kg 
                                7 Sampah 
                                8 Brondolan Lepas 
                                9 Fraksi 6 
                                */
                                        $a = $grading->gradingtype_id;
                                        $gradingqty = $grading->grading_qty;
                                        $knetto = array(6, 7, 8);
                                        $persen = 0;
                                        if (in_array($a, $knetto)) {
                                            $persent = $gradingqty / $netto * 100;
                                            if ($persent > 0) {
                                                $persen = $persent;
                                            }
                                        } else {
                                            $persent = $gradingqty / $jmltandan * 100;
                                            if ($persent > 0) {
                                                $persen = $persent;
                                            }
                                        }

                                        $p50 = array(1, 2);
                                        $p25 = array(3, 9);
                                        $p100 = array(5);
                                        $p1 = array(4);
                                        $p30 = array(8);
                                        $k2 = array(7);
                                        $p70 = array(6);
                                        if (in_array($a, $p50)) {
                                            $nilai = 50 / 100 * $persen / 100 * $netto;
                                            $kg = round($nilai);
                                        } else  if (in_array($a, $p25)) {
                                            if ($persen > 5) {
                                                $nilai = 25 / 100 * ($persen / 100 - 5 / 100) * $netto;
                                                $kg = round($nilai);
                                            } else {
                                                $kg = 0;
                                            }
                                        } else  if (in_array($a, $p100)) {
                                            $nilai = (100 / 100) * ($persen / 100) * $netto;
                                            $kg = round($nilai);
                                        } else  if (in_array($a, $p1)) {
                                            $nilai = (1 / 100) * ($persen / 100) * $netto;
                                            $kg = round($nilai);
                                        } else  if (in_array($a, $p30)) {
                                            if ($persen <= 0) {
                                                $kg = 0;
                                            } else {
                                                $nilai = 30 / 100 * (12.5 / 100 - $persen / 100) * $netto;
                                                if ($nilai < 0) {
                                                    $kg = 0;
                                                } else {
                                                    $kg = round($nilai);
                                                }
                                            }
                                        } else if (in_array($a, $k2)) {
                                            $kg = round($gradingqty * 2);
                                        } else if (in_array($a, $p70)) {
                                            $kg = round($gradingqty * 1 * 0.70);
                                        }
                                        $tkg += $kg;
                                    ?>
                                        <div class="col-3 text-bold t-10">
                                            <?= $grading->gradingtype_name; ?>
                                        </div>
                                        <div class="col-3  t-10">
                                            = <?= $gradingqty; ?> <?= $grading->gradingtype_unit; ?>
                                        </div>
                                        <div class="col-3  t-10">
                                            = <?php
                                                echo number_format($persen, 2, ",", ".");
                                                ?> %
                                        </div>
                                        <div class="col-3  t-10">
                                            = <?= number_format($kg, 0, ",", "."); ?> Kg
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                $tgrading = $tkg;

                                //netto diterima
                                if (is_numeric($netto) && is_numeric($tgrading)) {
                                    $nettoditerima = $netto - $tgrading;
                                } else {
                                    $nettoditerima = 0;
                                }

                                //bjr
                                if (is_numeric($jmltandan) && $jmltandan != 0) {
                                    $bjr = $netto / $jmltandan;
                                } else {
                                    $bjr = 0;
                                }

                                //% grading
                                if ($netto != 0) {
                                    $pgrading = ($tgrading / $netto) * 100;
                                } else {
                                    $pgrading = 0;
                                }
                                ?>
                                <div class="col-1">&nbsp;</div>
                                <div class="col-5 row">
                                    <div class="col-12 mb-2">
                                        <h5 class="text-center">INFORMASI TIMBANGAN</h5>
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        Berat Brutto
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($brutto, 0, ",", ".");
                                            ?> Kg
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        Berat Tarra
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($tarra, 0, ",", ".");
                                            ?> Kg
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        Berat Netto
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($netto, 0, ",", ".");
                                            ?> Kg
                                    </div>
                                    <div class="col-6 t-10 mb-2 text-bold">
                                        Jumlah Grading
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?= number_format($tgrading, 0, ",", "."); ?> Kg
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        Netto Diterima
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?= number_format($nettoditerima, 0, ",", "."); ?> Kg
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        Jumlah Tandan
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($jmltandan, 0, ",", ".");
                                            ?> Tdn
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        BJR
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($bjr, 0, ",", ".");
                                            ?> Kg
                                    </div>
                                    <div class="col-6 t-10 text-bold">
                                        % Grading
                                    </div>
                                    <div class="col-6 t-10">
                                        : <?php
                                            echo number_format($pgrading, 2, ",", ".");
                                            ?> %
                                    </div>
                                </div>

                            </div>





                            <div class="row mt-5 pt-5">
                                <div class="col-4 row">
                                    <div class="col-12 text-center text-bold"><?= session()->get("nama"); ?></div>
                                    <div class="col-12 pl-4 pr-4">
                                        <div class="border-top text-center">Opt.Timbangan</div>
                                    </div>
                                </div>
                                <div class="col-4 row">
                                    <div class="col-12 text-center text-bold"><?= $sptbs->sptbs_drivername; ?></div>
                                    <div class="col-12 pl-4 pr-4">
                                        <div class="border-top text-center">DRIVER/SUPIR</div>
                                    </div>
                                </div>
                                <div class="col-4 row">
                                    <div class="col-12 text-center text-bold">SUYANTI</div>
                                    <div class="col-12 pl-4 pr-4">
                                        <div class="border-top text-center">KTU MILL</div>
                                    </div>
                                </div>
                            </div>



                        <?php } ?>
                    </div>
                    <div>
                        <?php
                        if (isset($_GET["sptbs_id"])) {
                            $image = "copy.png";
                        } else {
                            $image = "original.png";
                        }
                        ?>
                        <img src="<?= base_url("images/" . $image); ?>" class="tengah" />
                    </div>

                    <?php if (isset($_GET["print"])) { ?>
            </body>

            </html>
        <?php } ?>
    <?php
                } ?>
    </div>

<?php }

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

    public function lr()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("lr")
            ->orderBy("lr.lr_name", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "lr_name" => $usr->lr_name,
                "lr_geo" => $usr->lr_geo,
                "lr_tipebuah" => $usr->lr_tipebuah
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function wtnumber()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("wtnumber")
            ->orderBy("wtnumber.wtnumber_card", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "wtnumber_card" => $usr->wtnumber_card
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function pruningc()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $usr = $this->db
            ->table("pruningc")
            ->orderBy("pruningc_id", "ASC")
            ->get();
        //echo $this->db->getLastQuery();  
        $data = array();
        foreach ($usr->getResult() as $usr) {
            $usrData = array(
                "pruningc_id" => $usr->pruningc_id,
                "pruningc_name" => $usr->pruningc_name
            );
            $data[] = $usrData;
        }
        return $this->response->setContentType('application/json')->setJSON($data);
    }

    public function uploadpruning()
    {
        foreach ($this->request->getPost() as $e => $f) {
            if ($e != 'create') {
                $inputu[$e] = $this->request->getPost($e);
            }
        }
        $this->db->table('pruning')->insert($inputu);
        //cek
        /* $cek=$this->db->table('quarry')
        ->where("quarry_date",$inputu["quarry_date"])
        ->where("quarry_card",$inputu["quarry_card"])
        ->get();
        if($cek->getNumRows()==0){
            $this->db->table('quarry')->insert($inputu);
            // echo $this->db->getLastQuery(); die;
            $data["message"] = "Insert Data Success!";
        }else{
            foreach ($cek->getResult() as $cek) {
                $where["quarry_id"]=$cek->quarry_id;
                $this->db->table('quarry')->update($input,$where);
                $data["message"] = "Data Diupdate!";
            }
        } */
    }



    public function gambarpruning()
    {
        $id = $this->request->getGet("id");
        $cek = $this->db->table('pruning')
            ->where("pruning_id", $id)
            ->get();
        // echo $this->db->getLastQuery(); die;
        foreach ($cek->getResult() as $cek) {
            echo $cek->pruning_picture;
        }
    }
}
