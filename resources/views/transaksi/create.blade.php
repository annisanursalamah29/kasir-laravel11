@extends('layout.template')

<!-- START FORM -->
@section('konten')
    <form action='{{ url('user') }}' method='post'>
        @csrf
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <a href="{{ url('user') }}" class="btn btn-secondary">>> Kembali</a>
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='name' id="name"
                        value="{{ Session::get('name') }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='email' id="email"
                        value="{{ Session::get('email') }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name='password' id="password"
                        value="{{ Session::get('password') }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="peran" class="col-sm-2 col-form-label">Peran</label>
                <div class="col-sm-10">
                    <select name='peran' class="form-select form-select-lg mb-3" aria-label="Large select example">
                        <option>-- Pilih Peran --</option>
                        <option value="{{ Session::get('peran') }}">Admin</option>
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
