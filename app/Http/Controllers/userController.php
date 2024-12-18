<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if (strlen($katakunci)) {
            $data = User::where(function ($query) use ($katakunci) {
                $query->where('name', 'like', "%$katakunci%")
                    ->orWhere('email', 'like', "%$katakunci%")
                    ->orWhere('peran', 'like', "%$katakunci%");
            })->paginate($jumlahbaris);

            if ($data->isEmpty()) {
                return redirect()->back()->with('info', 'Data tidak ditemukan');
            }
        } else {
            $data = User::orderBy('id', 'desc')
                ->paginate($jumlahbaris);
        }
        return view('user.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'peran' => 'required'
        ], [
            'name.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.email' => 'Email Harus Berupa Email',
            'email.unique' => 'Email Sudah Ada Dalam Database',
            'password.required' => 'Password Harus Diisi',
            'password.min' => 'Password Minimal 6 Karakter',
            'peran.required' => 'Peran Harus Diisi'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran
        ];

        User::create($data);
        return redirect()->route('user.index')->with('tambah', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::where('email', $id)->firstOrFail();
        return view('user.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::where('email', $id)->firstOrFail();
        return view('user.index', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',email',
            'peran' => 'required',
            'password' => 'nullable|min:6'
        ], [
            'name.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.unique' => 'Email Sudah Ada Dalam Database',
            'email.email' => 'Email Harus Berupa Email',
            'peran.required' => 'Peran Harus Diisi',
            'password.min' => 'Password Minimal 6 Karakter'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'peran' => $request->peran
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('email', $id)->update($data);
        return redirect()->route('user.index')->with('ubah', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            User::where('email', $id)->delete();
            return redirect()->route('user.index')
                ->with('success', 'Berhasil menghapus data USER.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                ->with('error', 'Gagal menghapus data USER.');
        }
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
