<?php

namespace App\Models\master;

use App\Models\core_m;

class muserposition_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek userposition
        if ($this->request->getVar("userposition_id")) {
            $userpositiond["userposition_id"] = $this->request->getVar("userposition_id");
        } else {
            $userpositiond["userposition_id"] = -1;
        }
        $us = $this->db
            ->table("userposition")
            ->getWhere($userpositiond);
        //echo $this->db->getLastquery();
        //die;
        $larang = array("log_id", "id",  "action", "data", "userposition_id_dep", "trx_id", "trx_code", "contact_id_dep");
        if ($us->getNumRows() > 0) {
            foreach ($us->getResult() as $userposition) {
                foreach ($this->db->getFieldNames('userposition') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $userposition->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('userposition') as $field) {
                $data[$field] = "";
            }
        }

        $usernya = $this->db
        ->table("t_user")
        ->where("user_id",$this->request->getVar("user_id"))
        ->get();
        if ($usernya->getNumRows() > 0) {
            foreach ($usernya->getResult() as $t_user) {
                foreach ($this->db->getFieldNames('t_user') as $field) {
                    if (!in_array($field, $larang)) {
                        $data[$field] = $t_user->$field;
                    }
                }
            }
        } else {
            foreach ($this->db->getFieldNames('t_user') as $field) {
                $data[$field] = "";
            }
        }
        

        //delete
        if ($this->request->getPost("delete") == "OK") {
            $userposition_id=   $this->request->getPost("userposition_id");
             
                $this->db
                ->table("userposition")
                ->delete(array("userposition_id" => $this->request->getPost("userposition_id")));
                $data["message"] = "Delete Success";
                // $data["message"] = "Delete Success" . $this->request->getPost("contact_id") . "=" . $this->request->getPost("userposition_id");
            
        }

        //insert
        if ($this->request->getPost("create") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if ($e != 'create' ) {
                    $inputu[$e] = $this->request->getPost($e);
                }
            }

            //userposition
            // $inputu["password"] = password_hash($inputu["password"], PASSWORD_DEFAULT);
            // $inputu["password"] = $inputu["password"];
            $this->db->table('userposition')->insert($inputu);
            /* echo $this->db->getLastQuery();
            die; */
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->request->getPost("change") == "OK") {
            foreach ($this->request->getPost() as $e => $f) {
                if($e!='change'){
                    $inputu[$e] = $this->request->getPost($e);
                }
            }
            /* if($this->request->getPost("password")!=""){
                $pass = $this->request->getPost("password");
                $inputu["password"] = password_hash($pass, PASSWORD_DEFAULT);
            } */
            $this->db->table('userposition')
                ->where("userposition_id", $inputu["userposition_id"])
                ->update($inputu);
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }
        return $data;
    }
}
