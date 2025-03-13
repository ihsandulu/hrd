<?php

namespace App\Models\master;

use App\Models\core_m;

class mpositionandroid_m extends core_m
{
    public function data()
    {
        $data = array();
        $data["message"] = "";
        $positiond["position.position_id"] = $this->request->getVar("position_id");
        $position = $this->db
            ->table("position")
            ->getWhere($positiond);

        if ($position->getNumRows() > 0) {
            foreach ($position->getResult() as $position) {
                foreach ($this->db->getFieldNames('position') as $field) {
                    $data[$field] = $position->$field;
                }
            }
        } else {
            foreach ($this->db->getFieldNames('position') as $field) {
                $data[$field] = "";
            }
        }


        //cek positionandroid
        if ($this->request->getVar("positionandroid_id")) {
            $positionandroidd["positionandroid_id"] = $this->request->getVar("positionandroid_id");
            $us = $this->db
                ->table("positionandroid")
                ->getWhere($positionandroidd);
            // echo $this->db->getLastquery();
            // die;
            $larang = array("log_id", "id", "user_id", "action", "data", "positionandroid_id_dep", "trx_id", "trx_code");
            if ($us->getNumRows() > 0) {
                foreach ($us->getResult() as $positionandroid) {
                    foreach ($this->db->getFieldNames('positionandroid') as $field) {
                        if (!in_array($field, $larang)) {
                            $data[$field] = $positionandroid->$field;
                        }
                    }
                }
            } else {
                foreach ($this->db->getFieldNames('positionandroid') as $field) {
                    $data[$field] = "";
                }
            }
        } 

        return $data;
    }
}
