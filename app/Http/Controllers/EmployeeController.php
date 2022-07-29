<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Session;
// use App\Models\Religion;

class EmployeeController extends Controller
{
    public function index(Request $request){

        if($request->has('search')){
            $data = Employee::where('nama','LIKE','%' .$request->search.'%')->paginate(5);
            Session::put('halaman_url', request()->fullUrl());
        } else {
            $data = Employee::paginate(5);
            // dd($data);
            // Session::put('halaman_url', request()->fullUrl());
        }

        // $data = Employee::all();
        return view('datapegawai', compact('data'));
    }

    public function tambahpegawai(){
        $dataagama = Religion::all();
        return view('tambahdata', compact('dataagama'));
    }

    public function insertdata(Request $request){
        $this->validate($request,[
                'nama' => 'required|min:7|max:20',
                'notelepon' => 'required|min:11|max:12',
        ]);

        $data = Employee::create($request->all());
        if($request->hasFile('foto')){
            $request->file('foto')->move('../img/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
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
        if(session('halaman_url')){
            return Redirect(session('halaman_url'))->with('success', 'Data berhasil diupdate.');
        }
        
        return redirect()->route('pegawai')->with('success', 'Data berhasil diupdate.');
    }

    public function delete($id){
        $data = Employee::find($id);
        $data->delete();
        return redirect()->route('pegawai')->with('success', 'Data berhasil dihapus.');;
    }

    public function exportpdf(){
        $data = Employee::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('datapegawai-pdf');
        return $pdf->download('data.pdf');
    }

    public function exportexcel(){
        return Excel::download(new EmployeeExport, 'datapegawai.xlsx');
    }
}