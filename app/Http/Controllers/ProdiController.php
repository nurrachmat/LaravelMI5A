<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Panggil model Prodi
        $result = Prodi::all();

        // Kirim data $result ke views prodi/index.blade.php
        return view('prodi.index')->with('prodi', $result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fakultas = Fakultas::all();
        return view('prodi.create')->with('fakultas', $fakultas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $input = $request->validate([
            "nama"          => "required|unique:prodis",
            "kaprodi"       => "required",
            "singkatan"     => "required",
            "fakultas_id"   => "required"
        ]);

        // simpan
        Prodi::create($input);

        // redirect beserta pesan success
        return redirect()->route('prodi.index')->with('success', $request->nama . ' berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($prodi)
    {
        $prodi = Prodi::with('fakultas')->find($prodi);
        if ($prodi) {
            $data['success'] = true;
            $data['message'] = "Data prodi berhasil ditemukan";
            $data['result'] = $prodi;
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data['success'] = false;
            $data['message'] = "Data prodi tidak ditemukan";
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prodi = Prodi::find($id);
        $fakultas = Fakultas::all();
        return view('prodi.edit')
            ->with('prodi', $prodi)
            ->with('fakultas', $fakultas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prodi = Prodi::find($id);

        // validasi input
        $input = $request->validate([
            "nama"          => "required",
            "kaprodi"       => "required",
            "singkatan"     => "required",
            "fakultas_id"   => "required"
        ]);

        // simpan
        $prodi->update($input);

        // redirect beserta pesan success
        return redirect()->route('prodi.index')->with('success', $request->nama . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyProdi($id)
    {
        // cari data di tabel fakultas berdasarkan "id" fakultas
        $prodi = Prodi::find($id);
        // dd($fakultas);
        $hasil = $prodi->delete();
        if ($hasil) { // jika data berhasil disimpan
            $response['success'] = true;
            $response['message'] = "Prodi berhasil dihapus";
            return response()->json($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = "Prodi gagal dihapus";
            return response()->json($response, 400);
        }
    }

    public function getProdi()
    {
        // $response['data'] = Prodi::all();
        $response['data'] = Prodi::with('fakultas')->get();
        $response['message'] = 'List data program studi';
        $response['success'] = true;

        return response()->json($response, 200);
    }

    public function storeProdi(Request $request)
    {
        // validasi input
        $input = $request->validate([
            "nama"          => "required|unique:prodis",
            "kaprodi"       => "required",
            "singkatan"     => "required",
            "fakultas_id"   => "required"
        ]);

        // simpan
        $hasil = Prodi::create($input);
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
