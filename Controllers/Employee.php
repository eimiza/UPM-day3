<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Secure;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        //$writer->save(FCPATH.'uploads/hello world.xlsx');
        $writer->save("php://output");

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hello_world.xlsx"');
    }
}
