<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        return view('admin.mata-kuliah.index');
    }
}
