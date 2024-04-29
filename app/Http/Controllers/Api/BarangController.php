<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\StokModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::with('stok')->get();
    }
    public function store(Request $request)
    {
        $barang = BarangModel::create($request->all());
        $stok = StokModel::create([
            'barang_id' => $barang->barang_id,
            'user_id' => auth('api')->user()->user_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah
        ]);
        $data = [
            'barang' => $barang,
            'stok' => $stok
        ];
        return response()->json($data, 201);
    }
    public function show(BarangModel $barang)
    {
        return BarangModel::with('stok')->find($barang->barang_id);
    }
    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return $barang;
    }
    public function destroy(BarangModel $barang)
    {
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}