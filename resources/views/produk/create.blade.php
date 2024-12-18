@extends('layout.template')

<!-- START FORM -->
@section('konten')
    <form action='{{ url('produk') }}' method='post'>
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ url('produk') }}" class="btn btn-secondary">>> Kembali</a>
            <div class="mb-3 row">
                <label for="kode_produk" class="col-sm-2 col-form-label">Kode Produk</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('kode_produk') is-invalid @enderror" name='kode_produk'
                        id="kode_produk" value="{{ Session::get('kode_produk') }}">
                    @error('kode_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name='nama_produk'
                        id="nama_produk" value="{{ Session::get('nama_produk') }}">
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kategori_produk" class="col-sm-2 col-form-label">Kategori Produk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror"
                        name='kategori_produk' id="kategori_produk" value="{{ Session::get('kategori_produk') }}">
                    @error('kategori_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" name='harga_jual'
                        id="harga_jual" value="{{ Session::get('harga_jual') }}">
                    @error('harga_jual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" name='harga_beli'
                        id="harga_beli" value="{{ Session::get('harga_beli') }}">
                    @error('harga_beli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" name='stok'
                        id="stok" value="{{ Session::get('stok') }}">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="submit" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
                </div>
            </div>
        </div>
    </form>
@endsection

<!-- AKHIR FORM -->
