<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Panggil model Mahasiswa
        $result = Mahasiswa::all();

        // Kirim data $result ke views mahasiswa/index.blade.php
        return view('mahasiswa.index')->with('mahasiswa', $result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::all();
        return view('mahasiswa.create')->with('prodi', $prodi);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        // validasi input
        $input = $request->validate([
            "npm"           => "required|unique:mahasiswas",
            "nama"          => "required",
            "tempat_lahir"  => "required",
            "tanggal_lahir" => "required",
            "alamat"        => "required",
            "email"         => "required",
            "hp"            => "required",
            "prodi_id"      => "required"
        ]);

        // simpan
        Mahasiswa::create($input);

        // redirect beserta pesan success
        return redirect()->route('mahasiswa.index')->with('success', $request->nama . ' berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($mahasiswa)
    {
        // dd($mahasiswa);
        //return view('mahasiswa.show')->with('mahasiswa', $mahasiswa);
        $mahasiswa = Mahasiswa::find($mahasiswa);
        $data['success'] = true;
        $data['message'] = "Detail data mahasiswa";
        $data['result'] = $mahasiswa;
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMahasiswa($id)
    {
        // cari data di tabel fakultas berdasarkan "id" fakultas
        $mahasiswa = Mahasiswa::find($id);
        // dd($fakultas);
        $hasil = $mahasiswa->delete();
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Mahasiswa berhasil dihapus";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Mahasiswa gagal dihapus";
            return response()->json($response, 400);
        }
    }

    public function getMahasiswa()
    {
        $response['data'] = Mahasiswa::with('prodi.fakultas')->get();
        $response['message'] = 'List data mahasiswa';
        $response['success'] = true;

        return response()->json($response, 200);
    }

    public function storeMahasiswa(Request $request)
    {
        $input = $request->validate([
            "npm"           => "required|unique:mahasiswas",
            "nama"          => "required",
            "tempat_lahir"  => "required",
            "tanggal_lahir" => "required",
            "alamat"        => "required",
            "email"         => "required",
            "hp"            => "required",
            "prodi_id"      => "required",
            "foto"          => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048"
        ]);

        // Cek apakah ada file foto yang diupload
        if ($request->hasFile('foto')) {
            // Upload foto ke folder 'images'
            $fotoPath = $request->file('foto')->store('images', 'public');
            // Menambahkan path foto ke input data
            $input['foto'] = $fotoPath;
        }

        $hasil = Mahasiswa::create($input); // simpan
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = $request->nama . " berhasil disimpan";
            return response()->json($response, 201); // 201 Created
        } else {
            $response['success'] = false;
            $response['message'] = $request->nama . " gagal disimpan";
            return response()->json($response, 400); // 400 Bad Request
        }
    }
}
