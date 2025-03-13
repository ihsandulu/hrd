<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Config\Database;

class Core_m extends Model
{

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($validation);

        if (is_null($db)) {
            $this->db = Database::connect($this->DBGroup);
        } else {
            $this->db = &$db;
        }
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
        $this->db = Database::connect("default");
        /*if ($this->db) {
			// check if db exists:
			if ($this->db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='default'")) {
				//db connection initialized
				echo $this->db->getLastQuery();
				die;
			} else {
				echo "waduh";
				die;
			}
		} else {
			echo "Et dah";
			die;
		}*/
    }
}
