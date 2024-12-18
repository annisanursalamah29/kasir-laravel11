@extends('layout.template')

<!-- START FORM -->
@section('konten')
    <form action='{{ url('produk/' . $data->kode_produk) }}' method='post'>
        @csrf
        @method('PUT')
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ url('produk') }}" class="btn btn-secondary">>> Kembali</a>
            <div class="mb-3 row">
                <label for="kode_produk" class="col-sm-2 col-form-label">Kode Produk</label>
                <div class="col-sm-10">
                    {{ $data->kode_produk }}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='nama_produk' id="nama_produk"
                        value="{{ $data->nama_produk }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori_produk" class="col-sm-2 col-form-label">Kategori Produk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='kategori_produk' id="kategori_produk"
                        value="{{ $data->kategori_produk }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name='harga_jual' id="harga_jual"
                        value="{{ $data->harga_jual }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name='harga_beli' id="harga_beli"
                        value="{{ $data->harga_beli }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name='stok' id="stok" value="{{ $data->stok }}">
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="submit" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
        </div>
    </form>
@endsection


<!-- AKHIR FORM -->
