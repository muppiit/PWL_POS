<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Stok Barang',
            'list' => ['Home', 'Daftar Stok Barang'],
        ];

        $page = (object) [
            'title' => 'Daftar Stok Barang',
        ];

        $activeMenu = 'stok';

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $stok = StokModel::select('stock_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')->with('barang');

        return DataTables::of($stok)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Stok Barang',
            'list' => ['Home', 'Daftar Stok Barang', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail Stok Barang',
        ];

        $activeMenu = 'stok';

        $stok = StokModel::with('barang', 'user')->find($id);
        // dd($stok->toArray());
        return view('stok.show', compact('breadcrumb', 'page', 'activeMenu', 'stok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Stok Barang',
            'list' => ['Home', 'Daftar Stok Barang', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Stok Barang',
        ];

        $activeMenu = 'stok';
        $stok = StokModel::with('barang', 'user')->find($id);
        return view('stok.edit', compact('breadcrumb', 'page', 'activeMenu', 'stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        $stok = StokModel::find($id);
        $stok->update($validated);
        return redirect('stok')->with('success', 'Data stok berhasil diubah');
    }
}