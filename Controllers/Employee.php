<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Secure;

class Employee extends BaseController
{
    public function __construct(){
        $this->mod = model('App\Models\EmployeeModel');
    }

    public function index()
    {
        $data['title'] = 'Employee';
        $this->render('employee', $data);
       
    }

    public function download_pdf(){
        $data['data'] = $this->mod->findAll();
        $html = view('emp_pdf',$data);
        //return $html;
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        
        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=downloaded.pdf");
    }

    public function download_excel(){
        echo 'download excel';
    }
}
