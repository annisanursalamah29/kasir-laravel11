@extends('layout.template')

<!-- START FORM -->
@section('konten')
    <form action='{{ url('user/' . $data->email) }}' method='post'>
        @csrf
        @method('PUT')
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ url('user') }}" class="btn btn-secondary">>> Kembali</a>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='name' id="name" value="{{ $data->name }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='email' id="email" value="{{ $data->email }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name='password' id="password" value="{{ $data->password }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="peran" class="col-sm-2 col-form-label">Peran</label>
            <div class="col-sm-10">
                <select value="{{ $data->peran }}" class="form-select form-select-lg mb-3"
                    aria-label="Large select example">
                    <option>-- Pilih Peran --</option>
                    <option value="Admin">Admin</option>
                    <option value="Kasir">Kasir</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="submit" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button></div>
        </div>
        </div>
    </form>
@endsection


<!-- AKHIR FORM -->
