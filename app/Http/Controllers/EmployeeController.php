<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(){

        $data = Employee::all();
        // dd($data);
        return view('datapegawai',compact('data'));
    }
}