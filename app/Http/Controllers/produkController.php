<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if (strlen($katakunci)) {
            $data = produk::where(function ($query) use ($katakunci) {
                $query->where('kode_produk', 'like', "%$katakunci%")
                    ->orWhere('nama_produk', 'like', "%$katakunci%")
                    ->orWhere('kategori_produk', 'like', "%$katakunci%")
                    ->orWhere('harga_jual', 'like', "%$katakunci%")
                    ->orWhere('harga_beli', 'like', "%$katakunci%")
                    ->orWhere('stok', 'like', "%$katakunci%");
            })->paginate($jumlahbaris);

            if ($data->isEmpty()) {
                return redirect()->back()->with('info', 'Data tidak ditemukan');
            }
        } else {
            $data = produk::orderBy('kode_produk', 'desc')
                ->paginate($jumlahbaris);
        }
        return view('produk.index')->with('data', $data);
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
            'kode_produk' => 'required|numeric|unique:produk',
            'nama_produk' => 'required',
            'kategori_produk' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric|min:0'
        ], [
            'kode_produk.required' => 'Kode Produk Harus Diisi',
            'kode_produk.unique' => 'Kode Produk Sudah Ada Dalam Database',
            'kode_produk.numeric' => 'Kode Produk Harus Dalam Angka',
            'nama_produk.required' => 'Nama Produk Harus Diisi',
            'kategori_produk.required' => 'Kategori Produk Harus Diisi',
            'harga_jual.required' => 'Harga Jual Produk Harus Diisi',
            'harga_jual.numeric' => 'Harga Jual Produk Harus Berupa Angka',
            'harga_beli.required' => 'Harga Beli Produk Harus Diisi',
            'harga_beli.numeric' => 'Harga Beli Produk Harus Berupa Angka',
            'stok.required' => 'Jumlah Stok Produk Harus Diisi',
            'stok.numeric' => 'Jumlah Stok Produk Harus Berupa Angka',
            'stok.min' => 'Jumlah Stok Produk Tidak Boleh Negatif'
        ]);

        $data = [
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'kategori_produk' => $request->kategori_produk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok
        ];

        produk::create($data);
        return redirect()->route('produk.index')->with('tambah', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = produk::where('kode_produk', $id)->firstOrFail();
        return view('produk.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = produk::where('kode_produk', $id)->firstOrFail();
        return view('produk.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_produk' => 'required',
            'harga_jual' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric|min:0'
        ], [
            'nama_produk.required' => 'Nama Produk Harus Diisi',
            'kategori_produk.required' => 'Kategori Produk Harus Diisi',
            'harga_jual.required' => 'Harga Jual Produk Harus Diisi',
            'harga_jual.numeric' => 'Harga Jual Produk Harus Berupa Angka',
            'harga_beli.required' => 'Harga Beli Produk Harus Diisi',
            'harga_beli.numeric' => 'Harga Beli Produk Harus Berupa Angka',
            'stok.required' => 'Jumlah Stok Produk Harus Diisi',
            'stok.numeric' => 'Jumlah Stok Produk Harus Berupa Angka',
            'stok.min' => 'Jumlah Stok Produk Tidak Boleh Negatif'
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'kategori_produk' => $request->kategori_produk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok
        ];

        produk::where('kode_produk', $id)->update($data);
        return redirect()->route('produk.index')->with('ubah', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            produk::where('kode_produk', $id)->delete();
            return redirect()->route('produk.index')
                ->with('success', 'Berhasil menghapus data PRODUK.');
        } catch (\Exception $e) {
            return redirect()->route('produk.index')
                ->with('error', 'Gagal menghapus data PRODUK.');
        }
    }


    public function checkKodeProduk(Request $request)
    {
        $exists = produk::where('kode_produk', $request->kode_produk)->exists();
        return response()->json(['exists' => $exists]);
    }
}
