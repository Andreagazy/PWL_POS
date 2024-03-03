<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(){
        // DB::insert('insert into m_level(level_kode, level_nama,created_at) values(?,?,?)', ['CUS','Pelanggan',now()]);
        // return 'Insert Data Berhasil';

        // $row = DB::update('UPDATE m_level SET level_nama = ? WHERE level_kode = ?', ['Customer','CUS']);
        // return 'Update data berhasil. Jumlah data diupdate : '. $row .' baris';

        // $row = DB::delete('DELETE FROM M_level WHERE level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data dihapus : '. $row .' baris';

        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);
    }
}
