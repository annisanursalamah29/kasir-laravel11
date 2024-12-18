@extends('layout.template')

<!-- START DATA -->
@section('konten')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <!-- FORM PENCARIAN -->
        <div class="pb-3">
            <form class="d-flex" action="{{ url('produk') }}" method="get">
                <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                    placeholder="Masukkan kata kunci Produk" aria-label="Search">
                <button class="btn btn-secondary" type="submit"
                    style="transition: all 0.3s ease; border: 2px solid transparent;"
                    onmouseover="this.style.boxShadow='0 0 10px yellow'; this.style.borderColor='yellow';"
                    onmouseout="this.style.boxShadow='none'; this.style.borderColor='transparent';">Cari
                </button>
            </form>
        </div>

        <!-- TOMBOL TAMBAH DATA -->
        <div class="pb-3">
            <button class="btn btn-success" id="tambah-produk" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                type="button" role="tab" style="transition: all 0.3s ease;"
                onmouseover="this.style.boxShadow='0 0 10px yellow'" onmouseout="this.style.boxShadow='none'">
                + Tambah Produk
            </button>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">No.</th>
                    <th class="col-md-2">Kode</th>
                    <th class="col-md-2">Nama</th>
                    <th class="col-md-2">Kategori</th>
                    <th class="col-md-2">Harga Jual</th>
                    <th class="col-md-2">Harga Beli</th>
                    <th class="col-md-2">Stok</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>


            <tbody>
                <?php $i = $data->firstItem(); ?>
                @foreach ($data as $item)
                    <tr>
                        {{-- <input type="hidden" class="delete_id" value="{{ $item->id }}"> --}}
                        <td>{{ $i }}</td>
                        <td>{{ $item->kode_produk }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->kategori_produk }}</td>
                        <td>{{ $item->harga_jual }}</td>
                        <td>{{ $item->harga_beli }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="#"
                                    onclick="editProduk('{{ $item->kode_produk }}', '{{ $item->nama_produk }}', '{{ $item->kategori_produk }}', '{{ $item->harga_jual }}', '{{ $item->harga_beli }}', '{{ $item->stok }}')"
                                    data-bs-toggle="modal" data-bs-target="#editProdukModal"
                                    class="btn btn-warning btn-sm mx-1"
                                    style="width: 60px; height: 31px; transition: all 0.3s ease;"
                                    onmouseover="this.style.boxShadow='0 0 10px yellow'"
                                    onmouseout="this.style.boxShadow='none'">Edit</a>
                                <form onsubmit="return false" class="d-inline" id="delete-produk-{{ $item->kode_produk }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        style="width: 60px; height: 31px; transition: all 0.3s ease;"
                                        onmouseover="this.style.boxShadow='0 0 10px yellow'"
                                        onmouseout="this.style.boxShadow='none'"
                                        onclick="confirmDeleteProduk('{{ $item->kode_produk }}', '{{ $item->nama_produk }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </tbody>
        </table>
        {{ $data->withQueryString()->links() }}
    </div>

    <form action='{{ url('produk') }}' method='post' id="produkForm" onsubmit="return validateFormProduk()">
        @csrf
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: #aef7c6;">
                    <div class="modal-header" style="background-color: #5caf67;">
                        <h1 class="modal-title fs-5 text-center w-100 text-white" id="staticBackdropLabel">TAMBAH PRODUK
                        </h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="kode_produk" class="col-sm-2 col-form-label">Kode Produk</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('kode_produk') is-invalid @enderror"
                                    name='kode_produk' id="kode_produk" value="{{ Session::get('kode_produk') }}">
                                @error('kode_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                    name='nama_produk' id="nama_produk" value="{{ Session::get('nama_produk') }}">
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="kategori_produk" class="col-sm-2 col-form-label">Kategori Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror"
                                    name='kategori_produk' id="kategori_produk"
                                    value="{{ Session::get('kategori_produk') }}">
                                @error('kategori_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                    name='harga_jual' id="harga_jual" value="{{ Session::get('harga_jual') }}">
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                    name='harga_beli' id="harga_beli" value="{{ Session::get('harga_beli') }}">
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    name='stok' id="stok" value="{{ Session::get('stok') }}">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #5caf67;">
                        <button type="button" class="btn bg-danger text-white" data-bs-dismiss="modal"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">KELUAR</button>
                        <button type="submit" class="btn bg-success text-white" name="submit"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">SIMPAN</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action='{{ url('produk') }}' method='post' id="edit-produk-form" onsubmit="return validateEditProduk()">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editProdukModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editProdukModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: #ecdba1;">
                    <div class="modal-header" style="background-color: #ac8021;">
                        <h1 class="modal-title fs-5 text-center w-100 text-white" id="editProdukModalLabel">EDIT PRODUK
                        </h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="edit_kode_produk" class="col-sm-2 col-form-label">Kode Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kode_produk') is-invalid @enderror"
                                    name='kode_produk' id="edit_kode_produk">
                                @error('kode_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                    name='nama_produk' id="edit_nama_produk">
                                @error('nama_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_kategori_produk" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror"
                                    name='kategori_produk' id="edit_kategori_produk">
                                @error('kategori_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                    name='harga_jual' id="edit_harga_jual">
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                    name='harga_beli' id="edit_harga_beli">
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_stok" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    name='stok' id="edit_stok">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #ac8021;">
                        <button type="button" class="btn bg-danger text-white" data-bs-dismiss="modal"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">Batal</button>
                        <button type="submit" class="btn bg-warning text-black" name="submit"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection


@include('komponen.pesan')
<!-- AKHIR DATA -->
