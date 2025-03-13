<?php

namespace App\Models\master;

use App\Models\core_m;

class mpositionpages_m extends core_m
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


        //cek positionpages
        if ($this->request->getVar("positionpages_id")) {
            $positionpagesd["positionpages_id"] = $this->request->getVar("positionpages_id");
            $us = $this->db
                ->table("positionpages")
                ->getWhere($positionpagesd);
            // echo $this->db->getLastquery();
            // die;
            $larang = array("log_id", "id", "user_id", "action", "data", "positionpages_id_dep", "trx_id", "trx_code");
            if ($us->getNumRows() > 0) {
                foreach ($us->getResult() as $positionpages) {
                    foreach ($this->db->getFieldNames('positionpages') as $field) {
                        if (!in_array($field, $larang)) {
                            $data[$field] = $positionpages->$field;
                        }
                    }
                }
            } else {
                foreach ($this->db->getFieldNames('positionpages') as $field) {
                    $data[$field] = "";
                }
            }
        } 

        return $data;
    }
}
