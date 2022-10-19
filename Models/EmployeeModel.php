<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employee';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = ['name', 'email'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function datatables($limit, $offset, $filter){
        $this->db = \Config\Database::connect();
        $db = $this->db->table('employee');
        $db->select('employee.id as id, employee.name as name, email, employee.race as race_id, employee.religion as religion_id');
        $db->select('race.race as race');
        $db->select('religion.religion as religion');
        if($filter['name']){$db->orlike('employee.name', $filter['name']);};
        if($filter['name']){$db->orlike('employee.email', $filter['name']);};
        if($filter['religion']){$db->where('employee.religion', $filter['religion']);};
        if($filter['race']){$db->where('employee.race', $filter['race']);};
        $db->where('employee.deleted_at is null'); //if using soft delete
        $db->join('race', 'employee.race = race.code');
        $db->join('religion', 'employee.religion = religion.code');
        $db->limit($limit, $offset);
        $db->orderBy('employee.id', 'ASC');
        $data = $db->get();
        if($data){
            return $data->getResultArray();
        }else{
            return null;
        }
    }

    public function datacount($filter){
        $db = $this->db->table('employee');
        if($filter['name']){$db->orlike('employee.name', $filter['name']);};
        if($filter['name']){$db->orlike('employee.email', $filter['name']);};
        if($filter['religion']){$db->where('employee.religion', $filter['religion']);};
        if($filter['race']){$db->where('employee.race', $filter['race']);};
        $db->where('deleted_at is null'); //if using soft delete
        $count = $db->countAllResults();
        if($count){
            return $count;
        }else{
            return null;
        }
    }

}
