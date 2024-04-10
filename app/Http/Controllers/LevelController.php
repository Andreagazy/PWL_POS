<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLevelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // public function index()
    // {
    //     // DB::insert('insert into m_level(level_kode, level_nama,created_at) values(?,?,?)', ['CUS','Pelanggan',now()]);
    //     // return 'Insert Data Berhasil';

    //     // $row = DB::update('UPDATE m_level SET level_nama = ? WHERE level_kode = ?', ['Customer','CUS']);
    //     // return 'Update data berhasil. Jumlah data diupdate : '. $row .' baris';

    //     // $row = DB::delete('DELETE FROM M_level WHERE level_kode = ?', ['CUS']);
    //     // return 'Delete data berhasil. Jumlah data dihapus : '. $row .' baris';

    //     $data = DB::select('select * from m_level');
    //     return view('level', ['data' => $data]);
    // }

    // public function tambah()
    // {
    //     return view('level_tambah');
    // }
    // public function store(StoreLevelRequest $request)
    // {
    //     $validated = $request->validated(LevelModel::create([
    //         'level_kode' => $request->kodeLevel,
    //         'level_nama' => $request->namaLevel
    //     ]));


    //     return redirect('/level');
    // }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level Pengguna'
        ];

        $activeMenu = 'Level';
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page,  'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
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
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'Level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
}

public function show(string $id)
{
    $level = LevelModel::find($id);

    $breadcrumb = (object) [
        'title' => 'Detail Level',
        'list' => ['Home', 'Level', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Level',
    ];

    $activeMenu = 'Level';

    return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);

}
public function edit(string $id)
    {
        $level = LevelModel::find($id);


        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'Level';

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,'.$id.',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function destroy(string $id)
    {
        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            $level->delete();
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
