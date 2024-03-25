<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){

        return $dataTable->render('kategori.index');
    }

    public function create(){
        return view('kategori.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = $request->safe()->only(['kodeKategori', 'namaKategori']);
        KategoriModel::create([
            'kategori_kode'=>$request->kodeKategori,
            'kategori_nama'=>$request->namaKategori
        ]);
        // $validated = $request->safe()->except(['kodeKategori', 'namaKategori']);

        return redirect('/kategori');


        // $validated = $request->validate([
        //         'kategori_kode'=> 'bail|required',
        //         'kategori_nama'=>'required'

        // ]);
        //     'kategori_kode'=>$request->kodeKategori,
        //     'kategori_nama'=>$request->namaKategori
        // KategoriModel::create([
        // ]);
    }
    public function edit($id)
    {
        $data = KategoriModel::findOrFail($id);
        return view('kategori.edit', ['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        KategoriModel::where('kategori_id', $id)->update([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori
        ]);
        return redirect('/kategori');
    }
    public function destroy(Request $request)
    {
        KategoriModel::where('kategori_id', $request->id)->delete();
        return redirect('/kategori');
    }
        // $data =[
            //     'kategori_kode' => 'SNK',
            //     'kategori_nama' => 'Snack/Makanan Ringan',
            //     'created_at' => now()
            // ];
            // DB::table('m_kategori')->insert($data);
            // return 'Insert Data Baru Berhasil';

            // $row = DB::table('m_kategori')->where('kategori_kode','SNK')->update(['kategori_nama'=>'Camilan']);
            // return 'Update data berhasil. Jumlah data diupdate : '. $row .' baris';

            // $row = DB::table('m_kategori')->where('kategori_kode','SNK')->delete();
            // return 'Delete data berhasil. Jumlah data dihapus : '. $row .' baris';

            // $data = DB::table('m_kategori')->get();
            // return view('kategori',['data'=>$data]);



}
