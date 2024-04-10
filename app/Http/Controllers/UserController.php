<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdafatar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level,  'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if($request -> level_id){
            $users->where('level_id', $request ->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
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
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer',
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User',
        ];

        $activeMenu = 'User';

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);

    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $user = UserModel::find($id);

        if (!$user) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            $user->delete();
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // $data = [
    //     'username' => 'customer-1',
    //     'nama' => 'Pelanggan',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 4
    // ];
    // UserModel::insert($data);

    // $data = [
    //     'nama'=>'Pelanggan Pertama'
    // ];
    // UserModel::where('username','customer-1')->update($data);

    // $data = [
    //     'level_id' => 2,
    //     'username' => 'manager_dua',
    //     'nama' => 'Manager 2',
    //     'password' => Hash::make('12345')
    // ];
    // UserModel::create($data);

    // $data = [
    //     'level_id' => 2,
    //     'username' => 'manager_tiga',
    //     'nama' => 'Manager 3',
    //     'password' => Hash::make('12345')
    // ];
    // UserModel::create($data);

    // $user = UserModel::all();

    // $user = UserModel::find(1);

    // $user = UserModel::where('level_id',1)->first();

    // $user = UserModel::firstWhere('level_id',1);

    // $user = UserModel::findOr(1,['username','nama'], function(){
    //     abort(404);
    // });

    // $user = UserModel::findOr(20,['username','nama'], function(){
    //     abort(404);
    // });

    // $user = UserModel::findOrFail(1);

    // $user = UserModel::where('username','manager9')->firstOrFail();

    // $user = UserModel::where('level_id',2)->count();

    // $user = UserModel::firstOrCreate(
    //     [
    //         'username' => 'manager',
    //         'nama' => 'Manager'
    //     ]
    // );

    // $user = UserModel::firstOrCreate(
    //     [
    //         'username' => 'manager22',
    //         'nama' => 'Manager Dua Dua',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );

    // $user = UserModel::firstOrNew(
    //     [
    //         'username' => 'manager',
    //         'nama' => 'Manager'
    //     ]
    // );

    // $user = UserModel::firstOrNew(
    //     [
    //         'username' => 'manager33',
    //         'nama' => 'Manager Tiga Tiga',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );
    // $user->save();
    // return view('user', ['data' => $user]);


    // $user = UserModel::create(
    //     [
    //         'username' => 'manager55',
    //         'nama' => 'Manager55',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );

    // $user->username = 'manager56';

    // $user -> isDirty();
    // $user -> isDirty('username');
    // $user -> isDirty('nama');
    // $user -> isDirty('nama','username');

    // $user -> isClean();
    // $user -> isClean('username');
    // $user -> isClean('nama');
    // $user -> isClean('nama','username');

    // $user->save();

    // $user->isDirty();
    // $user->isClean();
    // dd($user->isDirty());

    //     $user = UserModel::create(
    //         [
    //             'username' => 'manager11',
    //             'nama' => 'Manager11',
    //             'password' => Hash::make('12345'),
    //             'level_id' => 2
    //         ]
    //     );
    //     $user->username = 'manager12';
    //     $user->save();

    //     $user -> wasChanged();
    //     $user -> wasChanged('username');
    //     $user -> wasChanged(['username','level_id']);
    //     $user -> wasChanged('nama');
    //     dd($user->wasChanged(['nama','username']));

    // $user=UserModel::all();
    // return view('user',['data' => $user]);

    // $user = UserModel::with('level')->get();
    // dd($user);

    // $user = UserModel::with('level')->get();
    // return view('user', ['data'=>$user]);


    // public function tambah()
    // {
    //     return view('user_tambah');
    // }
    // public function tambah_simpan(StoreUserRequest $request)
    // {

    //     $validated = $request->validated(UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id
    //     ]));

    //     return redirect('/user');
    // }

    // public function ubah($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);
    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make('$request->password');
    //     $user->level_id = $request->level_id;

    //     $user->save();
    //     return redirect('/user');
    // }

    // public function hapus($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();
    //     return redirect('/user');
    // }


}
