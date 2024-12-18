<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\detailTransaksi;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('katakunci')) {
            $katakunci = $request->katakunci;
            $produk = Produk::where('kode_produk', 'like', "%$katakunci%")
                ->orWhere('nama_produk', 'like', "%$katakunci%")
                ->where('stok', '>', 0)
                ->get();
            return view('transaksi.index', compact('produk'))->with('search', true);
        }

        $produk = Produk::where('stok', '>', 0)->get();
        return view('transaksi.index', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_harga' => 'required|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.kode_produk' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Validasi stok
            foreach ($request->items as $item) {
                $produk = Produk::where('kode_produk', $item['kode_produk'])->first();
                if (!$produk) {
                    throw new \Exception("Produk dengan kode {$item['kode_produk']} tidak ditemukan");
                }
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi");
                }
            }

            // Simpan transaksi header
            $transaksi = Transaksi::create([
                'total_harga' => $request->total_harga,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $request->total_harga,
                'tanggal' => now()->format('Y-m-d'), // Tambahkan field tanggal
            ]);

            // Proses setiap item
            foreach ($request->items as $item) {
                detailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'kode_produk' => $item['kode_produk'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['qty'] * $item['harga']
                ]);

                // Update stok
                $produk = Produk::where('kode_produk', $item['kode_produk'])->first();
                $produk->stok -= $item['qty'];
                $produk->save();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'data' => [
                    'transaksi_id' => $transaksi->id,
                    'total' => $transaksi->total_harga,
                    'bayar' => $transaksi->jumlah_bayar,
                    'kembalian' => $transaksi->kembalian
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 422);
        }
    }
}
