<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }
    public function prosesFileUpload(Request $request)
    {
        // dump($request->berkas);
        // if ($request->hasFile('berkas')) {
        //     echo "path(): " . $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): " . $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): " . $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): " . $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): " . $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): " . $request->berkas->getSize();
        //     echo "<br>";
        // } else {
        //     echo "Tidak ada berkas yang diupload";
        // }
        $request->validate([
            'berkas' => 'required|file|image|max:5000',
        ]);
        // echo $request->berkas->getClientOriginalName()."lolos validasi";
        // $namaFile = $request->berkas->getClientOriginalName();
        // $path = $request->berkas->storeAs('uploads',$namaFile);
        // $extFile = $request->berkas->getClientOriginalName();
        // $namaFile = 'web-' . time() . "." . $extFile;
        // $path = $request->berkas->storeAs('public', $namaFile);
        // echo "proses upload berhasil, file berada di: $path";

        // $pathBaru = asset('storage/' . $namaFile);
        // echo "proses upload berhasil, file berada di: $path";
        // echo "<br>";
        // echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";

        $extFile = $request->berkas->getClientOriginalName();
        $namaFile = 'web-' . time() . "." . $extFile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\", "//", $path);
        echo "Variabel path berisi:$path <br>";

        $pathBaru = asset('gambar/' . $namaFile);
        echo "proses upload berhasil, file berada di: $path";
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";

    }
    public function fileUploadRename() {
        return view('file-upload-rename');
    }

    public function prosesFileUploadRename(Request $request) {
        $extFile = $request->berkas->extension();
        $nama = $request->nama . ".$extFile";
        $path = $request->berkas->move('gambar', $nama);
        $path = str_replace("\\", "//", $path);
        $pathBaru = asset('gambar/' . $nama);
        echo "Gambar berhasil di upload ke <a href='$pathBaru'>$nama</a>";
        echo "<br>";
        echo "<img src='$pathBaru'>";
    }
}
