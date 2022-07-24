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

    public function tambahpegawai(){
        // $dataagama = Religion::all();
        return view('tambahdata');
    }

    public function insertdata(Request $request){
        // dd($request->all());
        Employee::create($request->all());
        return redirect()->route('pegawai')->with('success', 'Data berhasil ditambahkan.');
    }

    public function tampilkandata($id){
        
        $data = Employee::find($id);
        // dd($data);

        return view('tampildata', compact('data'));
    }

    public function updatedata(Request $request, $id){
        $data = Employee::find($id);
        $data->update($request->all());
        return redirect()->route('pegawai')->with('success', 'Data berhasil diubah.');
    }
}

// Catatan:
// <td>{{ $row->created_at->diffForHumans() }}</td>
// <td>{{ $row->created_at->format('D M Y') }}</td>