<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Secure;

class Employee extends BaseController
{
    public function index()
    {
        //print_r($this->session->get());
        // $secure = new Secure();
        // $id = 123;
        // $cipher = $secure->enc_session($id);
        // echo $cipher;

        // $encrypted_value = 'QNBMN6astXw3oqODy9TTehJZBML7qrTNUH0y3SeGtvEaU5wvEnd59E_r49It0QKrBRObqyLbXeB24YSmuYYIH-FlCG1nrqh5PSKHzDpRUkPut-1TVWXMliQ-hQ~~';
        // echo '<br>';
        // echo $secure->dec_session($encrypted_value);

        // exit;

        $data['title'] = 'Employee';
        $this->render('employee', $data);
    }
}
