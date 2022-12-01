<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Testing extends Controller
{
    use ResponseTrait;

    public function index()
    {
        echo view('testing');
    }

    public function save()
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
        // $data = [
        //     'product_name' => 'HALO',
        //     'product_price'  => 123,
        //     'expired'       => 123,
        //     'attch' => $filepath,
        //     'CREATED_AT'  => Time::now()->format('Y-m-d H:i:s'),
        // ];
        // $insert_Data = array_filter($data, function ($var) {
        //     return $var != null;
        // });
        // $SaveModul = new ProductModel();
        // $SaveModul->save($insert_Data);
    }
}
