<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class Product extends Controller
{
    use ResponseTrait;
    public function index()
    {
        echo view('product_view');
    }

    public function getProduct()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        return json_encode($data);
    }

    public function save()
    {
        $model = new ProductModel();
        $json = $this->request->getJSON();
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        $model->insert($data);
    }

    public function update($id)
    {
        $model = new ProductModel();
        $json = $this->request->getJSON();
        var_dump($json);
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        var_dump('ini data', $data);
        $model->update($id, $json);
    }


    public function delete($id = null)
    {
        $model = new ProductModel();
        $model->delete($id);
    }
}
