<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Barang',
            'list' => ['Home', 'Daftar Barang'],
        ];

        $page = (object) [
            'title' => 'Daftar Barang',
        ];

        $activeMenu = 'barang';
        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')->with('kategori', 'stok');

        return DataTables::of($barang)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
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
        $breadcrumb = (object) [
            'title' => 'Barang',
            'list' => ['Home', 'Daftar Barang', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah Barang',
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all();
        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string',
            'barang_nama' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok_jumlah' => 'required|numeric',
            'stok_tanggal' => 'required',
        ]);
        $dataBarang = [
            'kategori_id' => $validated['kategori_id'],
            'barang_kode' => $validated['barang_kode'],
            'barang_nama' => $validated['barang_nama'],
            'harga_beli' => $validated['harga_beli'],
            'harga_jual' => $validated['harga_jual'],
        ];
        $barang = BarangModel::create($dataBarang);
        $dataStok = [
            'barang_id' => $barang->barang_id,
            'user_id' => '3',
            'stok_tanggal' => $validated['stok_tanggal'],
            'stok_jumlah' => $validated['stok_jumlah'],
        ];
        StokModel::create($dataStok);
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Barang',
            'list' => ['Home', 'Daftar Barang', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail Barang',
        ];

        $activeMenu = 'barang';

        $barang = BarangModel::with('kategori', 'stok')->find($id);
        return view('barang.show', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Barang',
            'list' => ['Home', 'Daftar Barang', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Barang',
        ];

        $activeMenu = 'barang';
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();
        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string',
            'barang_nama' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        BarangModel::find($id)->update($validated);
        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            // Hapus stok terkait dengan barang
            StokModel::where('barang_id', $id)->delete();

            // Hapus barang
            $barang->delete();

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
