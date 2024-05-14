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
        $request->validate([
            'berkas' => 'required|file|image|max:5000',
        ]);
        $extfile=$request->berkas->getClientOriginalName();
        $namaFile='web-'.time().".".$extfile;

        $path = $request->berkas->move('gambar',$namaFile);
        $path =str_replace("\\","//", $path);
        $pathBaru=asset('gambar/'.$namaFile);
        echo "Variabel path berisi:$path <br>";

        echo "proses upload berhasil, data disimpan pada:$path";
        echo "<br>";
        echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";




        // $extfile = $request->berkas->getClientOriginalName();
        // $namaFile = 'web-' . time() . "." . $extfile;
        // $path = $request->berkas->storeAs('public', $namaFile);

        // $pathBaru = asset('storage/' . $namaFile);
        // echo "proses upload berhasil, data disimpan pada:$path";
        // echo "<br>";
        // echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";

        // $path = $request->berkas->store('uploads');
        // $path = $request->berkas->storeAs('uploads','berkas');

        // $request->validate([
        //     'berkas' => 'required|file|image|max:5000',
        // ]);
        // echo $request->berkas->getClientOriginalName()."Lolos Validasi";
        // dump($request->berkas);
        // dump($request->file('file'));
        // return "Pemrosesan file upload disini";


        // if ($request->hasFile('berkas')) {

        //     echo "path(): " . $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): " . $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): " .
        //         $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): " . $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): " .
        //         $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): " . $request->berkas->getSize();
        // }else{
        //     echo "Tidak ada berkas yang diupload";
        // }
    }

    public function fileUploadRename() {
        return view('file-upload-2');
    }

    public function prosesFileUploadRename(Request $request) {
        $request->validate([
            'namafile'=> 'required',
            'berkas' => 'required|file|image|max:5000',
        ]);
        $extFile = $request->berkas->extension();
        $nama = $request->namafile . ".$extFile";
        $path = $request->berkas->move('gambar', $nama);
        $path = str_replace("\\", "//", $path);
        $pathBaru = asset('gambar/' . $nama);
        echo "Gambar berhasil di upload ke <a href='$pathBaru'>$nama</a>";
        echo "<br>";
        echo "Gambar : <img src='$pathBaru'>";
    }
}
