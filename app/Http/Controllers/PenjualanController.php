<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPenjualanModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
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
        return view('penjualan.index', ['breadcrumb' => $breadcrumb,'page' => $page,'activeMenu' => $activeMenu]);

    }

    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'penjualan_tanggal', 'user_id', 'pembeli')
            ->with('user');

        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
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
        $barangs = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')->with('kategori', 'stok');

        return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<button type="button" class="btn btn-info btn-sm" onclick="pilihBarang(\'' . $barang->barang_kode . '\', \'' . $barang->barang_nama . '\', ' . $barang->harga_jual . ',\'' . $barang->stok->stok_jumlah . '\')">Pilih</button>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

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

        return view('penjualan.create', ['breadcrumb' => $breadcrumb,'page' => $page,'activeMenu' => $activeMenu]);

    }

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
        $penjualan->pembeli = $validated['pembeli'];
        $penjualan->penjualan_tanggal = $validated['tanggal'];
        $penjualan->penjualan_kode = 'PJ' . date('md') . $this->generatePenjualanNumber();
        $penjualan->user_id = '3';
        $penjualan->save();

        for ($i = 0; $i < count($validated['barang_kode']); $i++) {
            $detail = new DetailPenjualanModel();
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
    private function generatePenjualanNumber()
    {
        // Ambil nomor urut terakhir dari database dan tambahkan dengan 1
        $lastPenjualan = PenjualanModel::latest()->first();
        $lastNumber = ($lastPenjualan) ? intval(substr($lastPenjualan->penjualan_kode, 6)) : 0;

        // Tambahkan dengan 1 dan format menjadi dua digit
        $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        return $nextNumber;
    }

    public function show(string $id)
    {
        $penjualan = PenjualanModel::with(['detail', 'user'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi Penjualan ',
            'list' => ['Home', 'Transaksi Penjualan ', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi Penjualan '
        ];

        $activeMenu = 'penjualan';

        $total = 0;

    // Hitung total dari setiap item yang dibeli
    foreach ($penjualan->detail as $detail) {
        $total += $detail->harga * $detail->jumlah;
    }
        return view('penjualan.show', ['breadcrumb' => $breadcrumb,'page' => $page,'penjualan' => $penjualan,'activeMenu' => $activeMenu, 'total' =>$total
        ]);
    }

    public function destroy(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        if (!$penjualan) {
            return redirect('/penjualan')->with('error', 'Data Transaksi tidak ditemukan');
        }
        try {
            $penjualan->detail()->delete(); // Delete related details
            $penjualan->delete(); // Delete the main record

            return redirect('/penjualan')->with('success', 'Data Transaksi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
