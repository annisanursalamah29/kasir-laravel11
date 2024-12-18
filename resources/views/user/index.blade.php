@extends('layout.template')

<!-- START DATA -->
@section('konten')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <!-- FORM PENCARIAN -->
        <div class="pb-3">
            <form class="d-flex" action="{{ url('user') }}" method="get">
                <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                    placeholder="Masukkan kata kunci User" aria-label="Search">
                <button class="btn btn-success" type="submit" style="transition: all 0.3s ease;"
                    onmouseover="this.style.boxShadow='0 0 10px yellow'" onmouseout="this.style.boxShadow='none'">Cari
                </button>
            </form>
        </div>

        <!-- TOMBOL TAMBAH DATA -->
        <div class="pb-3">
            <button data-bs-target="#staticBackdrop" class="btn btn-primary" id="tambah-user" data-bs-toggle="modal"
                type="button" role="tab" style="transition: all 0.3s ease;"
                onmouseover="this.style.boxShadow='0 0 10px yellow'" onmouseout="this.style.boxShadow='none'">
                + Tambah User
            </button>
        </div>


        <table class="table table-striped border-2">
            <thead>
                <tr>
                    <th class="col-md-1">No.</th>
                    <th class="col-md-2">Nama</th>
                    <th class="col-md-3">Email</th>
                    <th class="col-md-2">Peran</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @if ($data->count() > 0)
                    <?php $i = $data->firstItem(); ?>
                    @foreach ($data as $item)
                        <tr>
                            <td class="border">{{ $i }}</td>
                            <td class="border">{{ $item->name }}</td>
                            <td class="border">{{ $item->email }}</td>
                            <td class="border">{{ $item->peran }}</td>
                            <td class="border">
                                <div class="btn-group" role="group">
                                    <a href="#"
                                        onclick="editUser('{{ $item->email }}', '{{ $item->name }}', '{{ $item->peran }}')"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal"
                                        class="btn btn-warning btn-sm mx-1" style="transition: all 0.3s ease;"
                                        onmouseover="this.style.boxShadow='0 0 10px yellow'"
                                        onmouseout="this.style.boxShadow='none'">Edit</a>
                                    <form onsubmit="return false" class="d-inline" id="delete-email-{{ $item->email }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            style="transition: all 0.3s ease;"
                                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                                            onmouseout="this.style.boxShadow='none'"
                                            onclick="confirmDeleteUser('{{ $item->email }}', '{{ $item->name }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center border">Tidak ada data yang ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $data->withQueryString()->links() }}
    </div>

    <form action='{{ url('user') }}' method='post' id="userForm" onsubmit="return validateForm()">
        @csrf
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: #aee2f7;">
                    <div class="modal-header" style="background-color: #5c99af;">
                        <h1 class="modal-title fs-5 text-center w-100 text-white" id="staticBackdropLabel">TAMBAH USER</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name='name' id="name" value="{{ Session::get('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name='email' id="email" value="{{ Session::get('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name='password' id="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="peran" class="col-sm-2 col-form-label">Peran</label>
                            <div class="col-sm-10">
                                <select name='peran'
                                    class="form-select form-select-lg mb-3 @error('peran') is-invalid @enderror"
                                    aria-label="Large select example" id="peran">
                                    <option selected disabled>-- Pilih Peran --</option>
                                    <option value="Admin" {{ Session::get('peran') == 'Admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="Kasir" {{ Session::get('peran') == 'Kasir' ? 'selected' : '' }}>Kasir
                                    </option>
                                </select>
                                @error('peran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #5c99af;">
                        <button type="button" class="btn bg-danger text-white" data-bs-dismiss="modal"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">KELUAR</button>
                        <button type="submit" class="btn bg-primary text-white" name="submit"
                            onmouseover="this.style.boxShadow='0 0 10px yellow'"
                            onmouseout="this.style.boxShadow='none'">SIMPAN</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action='{{ url('user') }}' method='post' id="edit-user-form" onsubmit="return validateEdit()">
        @csrf
        @method('PUT')
        <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: #ecdba1;">
                    <div class="modal-header" style="background-color: #ac8021;">
                        <h1 class="modal-title fs-5 text-center w-100 text-white" id="editUserModalLabel">EDIT USER</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="edit_name" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name='name' id="edit_name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name='email' id="edit_email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name='password' id="edit_password"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_peran" class="col-sm-2 col-form-label">Peran</label>
                            <div class="col-sm-10">
                                <select name="peran" id="edit_peran"
                                    class="form-select form-select-lg mb-3 @error('peran') is-invalid @enderror"
                                    aria-label="Large select example">
                                    <option selected disabled>-- Pilih Peran --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Kasir">Kasir</option>
                                </select>
                                @error('peran')
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
                            onmouseout="this.style.boxShadow='none'">Simpan
                            Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
<!-- AKHIR DATA -->
