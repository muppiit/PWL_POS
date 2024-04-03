<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori Barang',
            'list' => ['Home', 'Kategori Barang'],
        ];

        $page = (object) [
            'title' => 'Daftar kategori barang yang terdaftar dalam sistem',
        ];

        $activeMenu = 'kategori';
        return view('kategori.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategori)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kategori barang',
            'list' => ['Home', 'Kategori Barang', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail Kategori Barang',
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create(): View
    {
        $breadcrumb = (object) [
            'title' => 'Kategori Barang',
            'list' => ['Home', 'Kategori Barang', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Barang',
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', compact('breadcrumb', 'page', 'activeMenu'));
    }
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        KategoriModel::create($validated);
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function edit($id)
    {
        $breadcrumb = (object) [
            'title' => 'Kategori Barang',
            'list' => ['Home', 'Kategori Barang', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Barang',
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::find($id);
        return view('kategori.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ]);
        KategoriModel::find($id)->update($validated);
        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    public function destroy($id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}