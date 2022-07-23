<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        
        // return 'Sukses';
        $data = Employee::all();
        // dd($data);
        return view('datapegawai', compact('data'));
    }
}