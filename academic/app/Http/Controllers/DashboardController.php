<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $mahasiswa = DB::select('SELECT prodis.nama, COUNT(*) as jumlah 
FROM mahasiswas
JOIN prodis ON mahasiswas.prodi_id = prodis.id
GROUP BY prodis.nama');
        return view('dashboard')->with('mahasiswa', $mahasiswa);
    }
}
