<?php

namespace App\Models\master;

use App\Models\core_m;

class mapk_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek apk
        if ($this->request->getVar("apk_id")) {
            $apkd["apk_id"] = $this->request->getVar("apk_id");
        } else {
            $apkd["apk_id"] = -1;
        }
        $us = $this->db
            ->table("apk")
            ->getWhere($apkd);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "apk_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $apk) {
                foreach ($this->db->getFieldNames('apk') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $apk->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('apk') as $field) {
                $data[$field] = "";
            }
        }


        //upload image
        $data['uploadapk_file'] = "";
        if (isset($_FILES['apk_file']) && $_FILES['apk_file']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('apk_file');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($ext === 'apk') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/apk_file'; //definisikan direktori upload            
                $apk_file = str_replace(' ', '_', $name);
                $apk_file = date("H_i_s_") . $apk_file; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $apk_file) {
                        delete_files($direktori, $apk_file); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->identity($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $apk_file)) {
                    $data['uploadapk_file'] = "Upload Success !";
                    $input['apk_file'] = $apk_file;
                } else {
                    $data['uploadapk_file'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadapk_file'] = "Format File Salah !";
            }
        } 

        

        //delete
        if ($this->request->getPost("delete") == "OK") { 
            $apk_id=   $this->request->getPost("apk_id");
            $cek=$this->db->table("divisi")
            ->where("apk_id", $apk_id) 
            ->get()
            ->getNumRows();
            if($cek>0){
                $data["message"] = "apk masih dipakai di data Divisi!";
            } else{    
                $this->db
                ->table("apk")
                ->delete(array("apk_id" =>  $apk_id));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'apk_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }

            $builder = $this->db->table('apk');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $apk_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'apk_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $this->db->table('apk')->update($input, array("apk_id" => $this->request->getPost("apk_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
