<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Testing2 extends Controller
{
    use ResponseTrait;

    public function index()
    {
        echo view('testing2');
    }
}
