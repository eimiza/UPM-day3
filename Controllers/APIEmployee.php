<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Secure;

class APIEmployee extends ResourceController
{
    public function __construct(){
        $this->mod = model('App\Models\EmployeeModel');
        $this->dam = model('App\Models\DeptAssignModel');
        $this->secure = new Secure();
    }

    public function listing(){
        helper('function'); 

        //filter
        $filter['name'] = $this->request->getPost('search');
        $filter['email'] = $this->request->getPost('email');
        $filter['religion'] = $this->request->getPost('religion');
        $filter['race'] = $this->request->getPost('race');

        $page = $this->request->getPost('page');
        $limit = 10;
        $offset = pagingOffset($page,$limit);
        
        $data = $this->mod->datatables($limit, $offset, $filter);
        $data = array_map(function ($arr){
            $arr['secure_id'] = $this->secure->enc_session($arr['id']);
            return $arr;
        },$data);

        $total_data = $this->mod->datacount($filter);
        $page_count = pagingTotalPage($total_data,$limit);

        $data = [
            'data' => $data,
            'total_data' => $total_data,
            'total_page' => $page_count,
        ];

        return $this->respond($data);
    }

    public function insert_data(){
        //$validation = \Config\Services::validation();
        $validation = service('validation');
        if(!$this->validate([
            'name' => 'required',
            'email' => 'required|valid_email',
            'race' => 'required',
            'religion' => 'required',
        ])){
            
            $error['name'] = $validation->getError('name');
            $error['email'] = $validation->getError('email');
            $error['race'] = $validation->getError('race');
            $error['religion'] = $validation->getError('religion');

            return $this->respond($error);

        }else{

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'race' => $this->request->getPost('race'),
                'religion' => $this->request->getPost('religion'),
            ];
            $this->mod->insert($data);

        }

        
    }

    public function update_data($id){
        //$validation = \Config\Services::validation();
        $validation = service('validation');
        if(!$this->validate([
            'name' => 'required',
            'email' => 'required|valid_email'
        ])){
            
            $error['name'] = $validation->getError('name');
            $error['email'] = $validation->getError('email');

            return $this->respond($error);

        }else{

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];
            $this->mod->update($id,$data);

        }
    }

    public function delete_data($id){
        $this->mod->delete($id);

        $this->dam->where('emp_id',$id);
        $this->dam->delete();
    }
}
