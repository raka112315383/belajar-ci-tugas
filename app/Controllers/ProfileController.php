<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FaqController extends BaseController
{
    public function index()
    {
        return view('v_profile');
    }
}
