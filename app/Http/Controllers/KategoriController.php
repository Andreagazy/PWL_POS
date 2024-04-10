<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    // public function index(KategoriDataTable $dataTable){

    //     return $dataTable->render('kategori.index');
    // }

    // public function create(){
    //     return view('kategori.create');
    // }

    // public function store(StorePostRequest $request): RedirectResponse
    // {
    //     $validated = $request->validated();
    //     $validated = $request->safe()->only(['kodeKategori', 'namaKategori']);
    //     KategoriModel::create([
    //         'kategori_kode'=>$request->kodeKategori,
    //         'kategori_nama'=>$request->namaKategori
    //     ]);
    //     // $validated = $request->safe()->except(['kodeKategori', 'namaKategori']);

    //     return redirect('/kategori');


    //     // $validated = $request->validate([
        //     //         'kategori_kode'=> 'bail|required',
        //     //         'kategori_nama'=>'required'

        //     // ]);
        //     //     'kategori_kode'=>$request->kodeKategori,
        //     //     'kategori_nama'=>$request->namaKategori
        //     // KategoriModel::create([
    //     // ]);
    // }
    // public function edit($id)
    // {
        //     $data = KategoriModel::findOrFail($id);
        //     return view('kategori.edit', ['data' => $data]);
        // }
    // public function update(Request $request, $id)
    // {
    //     KategoriModel::where('kategori_id', $id)->update([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama' => $request->namaKategori
    //     ]);
    //     return redirect('/kategori');
    // }
    // public function destroy(Request $request)
    // {
        //     KategoriModel::where('kategori_id', $request->id)->delete();
        //     return redirect('/kategori');
    // }
    //     // $data =[
        //         //     'kategori_kode' => 'SNK',
        //         //     'kategori_nama' => 'Snack/Makanan Ringan',
        //         //     'created_at' => now()
        //         // ];
        //         // DB::table('m_kategori')->insert($data);
        //         // return 'Insert Data Baru Berhasil';

        //         // $row = DB::table('m_kategori')->where('kategori_kode','SNK')->update(['kategori_nama'=>'Camilan']);
        //         // return 'Update data berhasil. Jumlah data diupdate : '. $row .' baris';

        //         // $row = DB::table('m_kategori')->where('kategori_kode','SNK')->delete();
        //         // return 'Delete data berhasil. Jumlah data dihapus : '. $row .' baris';

        //         // $data = DB::table('m_kategori')->get();
        //         // return view('kategori',['data'=>$data]);


    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori Barang'
        ];

        $activeMenu = 'Kategori';
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page,  'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategoris)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);

        }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Baru'
        ];

        $activeMenu = 'Kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
}

public function show(string $id)
{
    $kategori = KategoriModel::find($id);

    $breadcrumb = (object) [
        'title' => 'Detail Kategori',
        'list' => ['Home', 'Kategori', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Kategori',
    ];

    $activeMenu = 'Kategori';

    return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);

}
public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);


        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'Kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
