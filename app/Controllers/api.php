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
                $tunjanganData[$arrayTunjangan[$t->tunjangan_id]] = $tlainlain*($t->tunjangan_persen/100);
            }
        }
        return $this->response->setJSON($tunjanganData);
    }
}
