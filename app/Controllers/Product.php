<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\CompanyModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Product extends Controller
{
    use ResponseTrait;
    public function index()
    {
        // $company = new CompanyModel();
        // $company = $company->builder();
        // $company->select("*");
        // $data['company'] = $company->get()->getResultArray();
        // d($data);
        $db = \Config\Database::connect();
        $query = $db->query("SELECT ABS(SUM(finance.profit)) as profit,MONTH(finance.transaction) AS bulan, c.code_comp, finance.code_comp,  finance.transaction AS month
        FROM company c
        INNER JOIN finance ON c.code_comp=finance.code_comp
        GROUP BY bulan, c.code_comp
        ORDER BY c.code_comp;");
        $data['company'] = $query->getResult();
        d($data);
        echo view('product_view', $data);
    }
    public function getProduct()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
        SELECT *
        FROM product
        WHERE DELETED_AT IS null;");
        // $data['company'] = $query->getResult();
        return $this->respond($query->getResult(), 200);
    }
    public function download_pdf()
    {
        $data = $this->request->getJSON();
        $path = $data->path;
        return $this->response->download($path, null)->setFileName('report.pdf');
    }
    // -----------------versi json_Encode
    // public function getProduct()
    // {
    //     $model = new ProductModel();
    //     $data = $model->findAll();
    //     return json_encode($data);
    // }
    
    public function upload()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            //  'file' => 'uploaded[file]|max_size[file,30720]|ext_in[file,jpeg,jpg,docx,pdf,geojson,GEOJSON,PNG],'
            'file' => 'uploaded[file]|max_size[file,50000],'
        ]);
        if ($validation->withRequest($this->request)->run() == FALSE) {

            $data['success'] = 0;
            $data['error'] = $validation->getError('file'); // Error response
        } else {
            if ($file = $this->request->getFile('file')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Get att name and extension
                    $name = $file->getName();
                    $ext = $file->getClientExtension();
                    $filepath = WRITEPATH . 'uploads/' . $file->store();

                    // Response
                    $data['success'] = 1;
                    $data['message'] = 'Uploaded Successfully!';
                    $data['name'] = $name;
                    $data['filepath'] = $filepath;
                    $data['extension'] = $ext;
                } else {
                    // Response
                    $data['success'] = 2;
                    $data['message'] = 'File not uploaded.';
                }
            } else {
                // Response
                $data['success'] = 2;
                $data['message'] = 'File not uploaded.';
            }
        }
        return $this->response->setJSON($data);
    }

    public function save()
    {
        $model = new ProductModel();
        $json = $this->request->getJSON();
        $json->CREATED_AT = Time::now()->format('Y-m-d H:i:s');
        $model->insert($json);
    }


    public function update($id)
    {
        $model = new ProductModel();
        $json = $this->request->getJSON();
        $json->UPDATED_AT = Time::now()->format('Y-m-d H:i:s');
        $model->update($id, $json);
    }
    
    
    public function delete($id)
    {
        $model = new ProductModel();
        $Delete = $model->find($id);
        $Delete['DELETED_AT'] = Time::now()->format('Y-m-d H:i:s');
        var_dump($Delete);
        $model->save($Delete);
    }

    // fungsi save yang json tapi nested
    // public function save()
    // {
    //     $model = new ProductModel();
    //     $json = $this->request->getJSON();
    //     // $data = [
    //     //     'product_name' => $json->product_name,
    //     //     'product_price' => $json->product_price
    //     // ];

    //     $Delete['CREATED_AT'] = Time::now()->format('Y-m-d H:i:s');
    //     $model->insert($json);
    // }
    
    // fungsi save yang panjang karena menggunakan getVar
    // public function save()
    // {
    //     $product_name = $this->request->getVar('product_name');
    //     $product_price = $this->request->getVar('product_price');
    //     $expired = $this->request->getVar('expired');
    //     $filepath = $this->request->getVar('attch');
    //     $data = [
        //         'product_name' => $product_name,
        //         'product_price'  => $product_price,
        //         'expired'       => $expired,
        //         'attch' => $filepath,
        //         'CREATED_AT'  => Time::now()->format('Y-m-d H:i:s'),
        //     ];
        //     $insert_Data = array_filter($data, function ($var) {
            //         return $var != null;
            //     });
    //     $SaveModul = new ProductModel();
    //     $SaveModul->save($insert_Data);
    // }
}
