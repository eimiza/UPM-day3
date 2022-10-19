<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Secure;

class Employee extends BaseController
{
    public function index()
    {
        $data['title'] = 'Employee';
        $this->render('employee', $data);
    }

    public function download_pdf(){
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output();
        
        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=downloaded.pdf");
    }

    public function download_excel(){
        echo 'download excel';
    }
}
