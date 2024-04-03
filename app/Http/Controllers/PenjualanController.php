<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Penjualan',
            'list' => ['Home', 'Daftar Penjualan'],
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan',
        ];

        $activeMenu = 'penjualan';
        return view('penjualan.index', compact('page', 'breadcrumb', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with('user')->orderBy('penjualan_id', 'desc');

        return DataTables::of($penjualan)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function list_barang(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')->with('kategori', 'stok');

        return DataTables::of($barang)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<button type="button" class="btn btn-info btn-sm" onclick="pilihBarang(\'' . $barang->barang_kode . '\', \'' . $barang->barang_nama . '\', ' . $barang->harga_jual . ',\'' . $barang->stok->stok_jumlah . '\')">Pilih</button>';
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
            'title' => 'Penjualan',
            'list' => ['Home', 'Tambah Penjualan'],
        ];

        $page = (object) [
            'title' => 'Tambah Penjualan',
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.create', compact('page', 'breadcrumb', 'activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembeli' => 'required',
            'tanggal' => 'required',
            'barang_kode' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ]);
        $penjualan = new PenjualanModel();
        $penjualan->user_id = '4';
        $penjualan->pembeli = $validated['pembeli'];
        $penjualan->penjualan_kode = 'JL' . date('YmdHis');
        $penjualan->penjualan_tanggal = $validated['tanggal'];
        $penjualan->save();

        for ($i = 0; $i < count($validated['barang_kode']); $i++) {
            $detail = new PenjualanDetailModel();
            $detail->penjualan_id = $penjualan->penjualan_id;
            $detail->barang_id = BarangModel::where('barang_kode', $validated['barang_kode'][$i])->first()->barang_id;
            $detail->harga = $validated['harga'][$i];
            $detail->jumlah = $validated['jumlah'][$i];
            $detail->save();
            // update stok
            $barang = BarangModel::where('barang_kode', $validated['barang_kode'][$i])->first();
            $barang->stok->stok_jumlah -= $validated['jumlah'][$i];
            $barang->stok->save();
        }
        return redirect('/penjualan')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Penjualan',
            'list' => ['Home', 'Daftar Penjualan', 'Detail Penjualan'],
        ];

        $page = (object) [
            'title' => 'Detail Penjualan',
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::find($id);
        $penjualan_detail = PenjualanDetailModel::with('barang')->where('penjualan_id', $id)->get();
        $penjualan->detail = $penjualan_detail;
        $total = $penjualan->detail->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });
        // dd($penjualan->detail->toArray());
        return view('penjualan.show', compact('page', 'breadcrumb', 'activeMenu', 'penjualan', 'total'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $penjualan->delete();
        return redirect('/penjualan')->with('success', 'Data berhasil dihapus.');
    }
}