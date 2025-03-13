<?php

namespace App\Models\master;

use App\Models\core_m;

class mtanggungan_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek tanggungan
        if ($this->request->getPostGet("tanggungan_id")) {
            $tanggungand["tanggungan_id"] = $this->request->getPostGet("tanggungan_id");
        } else {
            $tanggungand["tanggungan_id"] = -1;
        }
        $us = $this->db
            ->table("tanggungan")
            ->getWhere($tanggungand);
        /* echo $this->db->getLastquery();
        die; */
        $larang = array("log_id", "id", "user_id", "action", "data", "tanggungan_id_dep", "trx_id", "trx_code");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $tanggungan) {
                foreach ($this->db->getFieldNames('tanggungan') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $tanggungan->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('tanggungan') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadtanggungan_picture'] = "";
        if (isset($_FILES['tanggungan_picture']) && $_FILES['tanggungan_picture']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('tanggungan_picture');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {    // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/tanggungan_picture'; //definisikan direktori upload            
                $tanggungan_picture = str_replace(' ', '_', $name);
                $tanggungan_picture = date("H_i_s_") . $tanggungan_picture; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $tanggungan_picture) {
                        delete_files($direktori, $tanggungan_picture); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->tanggungan($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $tanggungan_picture)) {
                    $data['uploadtanggungan_picture'] = "Upload Success !";
                    $input['tanggungan_picture'] = $tanggungan_picture;
                } else {
                    $data['uploadtanggungan_picture'] = "Upload Gagal !";
                }
            } else {
                // File Tipe Tidak Sesuai
                $data['uploadtanggungan_picture'] = "Format File Salah !";
            }
        } 

        //upload image
        $data['uploadtanggungan_surat'] = "";
        if (isset($_FILES['tanggungan_surat']) && $_FILES['tanggungan_surat']['name'] != "") {
            // $request = \Config\Services::request();
            $file = $this->request->getFile('tanggungan_surat');
            $name = $file->getName(); // Mengetahui Nama File
            $originalName = $file->getClientName(); // Mengetahui Nama Asli
            $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
            $ext = $file->getClientExtension(); // Mengetahui extensi File
            $type = $file->getClientMimeType(); // Mengetahui Mime File
            $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
            $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb


            //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

            /* if ($type == 'image/jpg'||$type == 'image/jpeg'||$type == 'image/png') //cek mime file
            {  */   // File Tipe Sesuai   
                helper('filesystem'); // Load Helper File System
                $direktori = 'images/tanggungan_surat'; //definisikan direktori upload            
                $tanggungan_surat = str_replace(' ', '_', $name);
                $tanggungan_surat = date("H_i_s_") . $tanggungan_surat; //definisikan nama fiel yang baru
                $map = directory_map($direktori, FALSE, TRUE); // List direktori

                //Cek File apakah ada 
                foreach ($map as $key) {
                    if ($key == $tanggungan_surat) {
                        delete_files($direktori, $tanggungan_surat); //Hapus terlebih dahulu jika file ada
                    }
                }
                //Metode Upload Pilih salah satu
                //$path = $this->request->getFile('uploadedFile')->tanggungan($direktori, $namabaru);
                //$file->move($direktori, $namabaru)
                if ($file->move($direktori, $tanggungan_surat)) {
                    $data['uploadtanggungan_surat'] = "Upload Success !";
                    $input['tanggungan_surat'] = $tanggungan_surat;
                } else {
                    $data['uploadtanggungan_surat'] = "Upload Gagal !";
                }
            /* } else {
                // File Tipe Tidak Sesuai
                $data['uploadtanggungan_surat'] = "Format File Salah !";
            } */
        } 

        //delete
        if ($this->request->getPost("delete") == "OK") {  
              
                $this->db
                ->table("tanggungan")
                ->delete(array("tanggungan_id" => $this->request->getPost("tanggungan_id"),"tanggungan_id" =>$this->request->getPost("tanggungan_id")));
                $data["message"] = "Delete Success";
            
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' && $e != 'tanggungan_id') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["user_id"] = $this->request->getGet("user_id");
            $input["tanggungan_id"] = $this->request->getPost("tanggungan_id");

            $builder = $this->db->table('tanggungan');
            $builder->insert($input);
            /* echo $this->db->getLastQuery();
            die; */
            $tanggungan_id = $this->db->insertID();

            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'change' && $e != 'tanggungan_picture') {
                    $input[$e] = $this->request->getPost($e);
                }
            }
            $input["user_id"] = $this->request->getGet("user_id");
            $input["tanggungan_id"] = $this->request->getPost("tanggungan_id");
            $this->db->table('tanggungan')->update($input, array("tanggungan_id" => $this->request->getPost("tanggungan_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
