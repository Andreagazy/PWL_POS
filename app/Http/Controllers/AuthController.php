<?php

namespace App\Http\Controllers;

use App\Models\m_user;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        // ambil data user dan menyimpan pada variabel
        $user = Auth::user();

        // kondisi jika ada user
        if ($user) {
            // jika level user admin
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            // jika level user manager
            if ($user->level_id == '2') {
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request){
        // buat validasi pada saat tombol login di klik
        // username & password wajib diisi
        $request -> validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // ambil data req username dan password saja
        $credential = $request->only('username','password');
        // cek jika data username dan password valid dgn data
        if(Auth::attempt($credential)){

            // jika berhasil simpan data di variabel $user
            $user = Auth::user();


            // jika level user admin diarahkan ke halaman admin
            if ($user->level_id == '1') {
                return redirect()->intended('admin');
            }
            // jika level user manager diarahkan ke halaman manager
            else if ($user->level_id == '2') {
                return redirect()->intended('manager');
            }
            // jika tidak memiliki role maka ke halaman '/'
            return redirect()->intended('/');
        }
        // jika tidak ada data yang valid dikembalikan ke halaman login
        return redirect('login')
            ->withinput()
            ->withErrors(['login_gagal' => 'Pastikan username dan password yang dimasukkan sudah benar']);
    }

    public function register(){
        return view('register');
    }

    public function proses_register(Request $request){
        // membuat validasi untuk register
        // username harus unique
        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required',
        ]);

        // jika gagal kembali ke halaman register dan menampilkan pesan error
        if ($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }
        // jika berhasil isi level dan lakukan hash password
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);
    // memasukkan ke tabel user
                UserModel::create($request->all());

        // jika berhasil diarahkan ke halaman login
        return redirect()->route('login');
    }

    public function logout(Request $request){
        // logout harus menghapus seluruh session
        $request->session()->flush();

        // jalankan fungsi logout
        Auth::logout();
        // kembali ke halaman login
        return redirect('login');
    }

}

