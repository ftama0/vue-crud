<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Product extends Controller
{
    use ResponseTrait;
    public function index()
    {
        echo view('product_view');
    }
    public function getProduct()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
        SELECT *
        FROM product
        WHERE DELETED_AT IS null;");;
        return $this->respond($query->getResult(), 200);
    }

    // -----------------versi json_Encode
    // public function getProduct()
    // {
    //     $model = new ProductModel();
    //     $data = $model->findAll();
    //     return json_encode($data);
    // }

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
    public function upload()
    {
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
        }
        return $this->response->setJSON($data);
    }

    public function save()
    {
        $product_name = $this->request->getVar('product_name');
        $product_price = $this->request->getVar('product_price');
        $expired = $this->request->getVar('expired');
        $filepath = $this->request->getVar('attch');
        $data = [
            'product_name' => $product_name,
            'product_price'  => $product_price,
            'expired'       => $expired,
            'attch' => $filepath,
            'CREATED_AT'  => Time::now()->format('Y-m-d H:i:s'),
        ];
        $insert_Data = array_filter($data, function ($var) {
            return $var != null;
        });
        $SaveModul = new ProductModel();
        $SaveModul->save($insert_Data);
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
}
