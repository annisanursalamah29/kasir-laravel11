@if (Session::has('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Data Tidak Ditemukan',
            text: 'Silakan coba kata kunci pencarian yang lain',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (Session::has('tambah'))
    <script>
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Data Berhasil Disimpan",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (Session::has('ubah'))
    <script>
        Swal.fire({
            position: "top-end",
            title: "Data Berhasil Diubah",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

<!-- untuk produk -->
<script>
    function validateFormProduk() {
        const kode_produk = document.getElementById('kode_produk');
        const nama_produk = document.getElementById('nama_produk');
        const kategori_produk = document.getElementById('kategori_produk');
        const harga_jual = document.getElementById('harga_jual');
        const harga_beli = document.getElementById('harga_beli');
        const stok = document.getElementById('stok');

        if (!kode_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Kode Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    kode_produk.focus();
                }
            });
            return false;
        }

        let isValid = true;
        $.ajax({
            url: '/check-kode-produk',
            type: 'POST',
            data: {
                kode_produk: kode_produk.value,
                _token: '{{ csrf_token() }}'
            },
            async: false,
            success: function(response) {
                if (response.exists) {
                    kode_produk.value = '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Kode Produk Sudah Ada, Silakan Gunakan Kode Lain',
                        showConfirmButton: false,
                        timer: 2000,
                        didClose: () => {
                            kode_produk.focus();
                        }
                    });
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            return false;
        }

        if (!nama_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Nama Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    nama_produk.focus();
                }
            });
            return false;
        }

        if (!kategori_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Kategori Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    kategori_produk.focus();
                }
            });
            return false;
        }

        if (!harga_jual.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Harga Jual Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    harga_jual.focus();
                }
            });
            return false;
        }

        if (!harga_beli.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Harga Beli Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    harga_beli.focus();
                }
            });
            return false;
        }

        if (!stok.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Stok Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    stok.focus();
                }
            });
            return false;
        }

        return true;
    }

    function validateEditProduk() {
        const edit_kode_produk = document.getElementById('edit_kode_produk');
        const edit_nama_produk = document.getElementById('edit_nama_produk');
        const edit_kategori_produk = document.getElementById('edit_kategori_produk');
        const edit_harga_jual = document.getElementById('edit_harga_jual');
        const edit_harga_beli = document.getElementById('edit_harga_beli');
        const edit_stok = document.getElementById('edit_stok');

        if (!edit_kode_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Kode Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_kode_produk.focus();
                }
            });
            return false;
        }

        if (!edit_nama_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Nama Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_nama_produk.focus();
                }
            });
            return false;
        }

        if (!edit_kategori_produk.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Kategori Produk Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_kategori_produk.focus();
                }
            });
            return false;
        }

        if (!edit_harga_jual.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Harga Jual Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_harga_jual.focus();
                }
            });
            return false;
        }

        if (!edit_harga_beli.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Harga Beli Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_harga_beli.focus();
                }
            });
            return false;
        }

        if (!edit_stok.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Stok Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    edit_stok.focus();
                }
            });
            return false;
        }

        return true;
    }

    function editProduk(kode_produk, nama_produk, kategori_produk, harga_jual, harga_beli, stok) {
        document.getElementById('edit_kode_produk').value = kode_produk;
        document.getElementById('edit_nama_produk').value = nama_produk;
        document.getElementById('edit_kategori_produk').value = kategori_produk;
        document.getElementById('edit_harga_jual').value = harga_jual;
        document.getElementById('edit_harga_beli').value = harga_beli;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit-produk-form').action = `{{ url('produk') }}/${kode_produk}`;
    }

    function confirmDeleteProduk(kode_produk, nama_produk) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Akan menghapus produk ${nama_produk}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim form
                const form = document.getElementById(`delete-produk-${kode_produk}`);
                form.action = `{{ url('produk') }}/${kode_produk}`;
                form.method = 'POST';
                form.submit();
            }
        });
    }
</script>

<!-- untuk user -->
<script>
    function validateForm() {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const peran = document.getElementById('peran');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!name.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Nama Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    name.focus();
                }
            });
            return false;
        }

        if (!email.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Email Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    email.focus();
                }
            });
            return false;
        }

        if (!emailRegex.test(email.value)) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Format Email Tidak Valid',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    email.focus();
                }
            });
            return false;
        }

        if (!password.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Password Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    password.focus();
                }
            });
            return false;
        }

        if (password.value.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Password minimal 6 karakter',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    password.focus();
                }
            });
            return false;
        }

        if (peran.value === "-- Pilih Peran --") {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Peran Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    peran.focus();
                }
            });
            return false;
        }

        // Cek email sudah ada atau belum menggunakan AJAX
        $.ajax({
            url: '/check-email',
            type: 'POST',
            data: {
                email: email.value,
                _token: '{{ csrf_token() }}'
            },
            async: false,
            success: function(response) {
                if (response.exists) {
                    email.value = '';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Email Sudah Terdaftar, Silakan Gunakan Email Lain',
                        showConfirmButton: false,
                        timer: 2000,
                        didClose: () => {
                            email.focus();
                        }
                    });
                    isValid = false;
                } else {
                    isValid = true;
                }
            }
        });

        return isValid;
    }

    function validateEdit() {
        const name = document.getElementById('edit_name');
        const email = document.getElementById('edit_email');
        const password = document.getElementById('edit_password');
        const peran = document.getElementById('edit_peran');
        let isValid = true;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!name.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Nama Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    name.focus();
                }
            });
            return false;
        }

        if (!email.value) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Email Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    email.focus();
                }
            });
            return false;
        }

        if (!emailRegex.test(email.value)) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Format Email Tidak Valid',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    email.focus();
                }
            });
            return false;
        }

        if (password.value && password.value.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Password minimal 6 karakter',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    password.focus();
                }
            });
            return false;
        }

        if (peran.value === "-- Pilih Peran --") {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Peran Harus Diisi',
                showConfirmButton: false,
                timer: 1500,
                didClose: () => {
                    peran.focus();
                }
            });
            return false;
        }

        return isValid;
    }

    function editUser(email, name, peran) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_peran').value = peran;
        document.getElementById('edit-user-form').action = `{{ url('user') }}/${email}`;
    }

    function confirmDeleteUser(email, name) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Akan menghapus user ${name}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim form
                const form = document.getElementById(`delete-email-${email}`);
                form.action = `{{ url('user') }}/${email}`;
                form.method = 'POST';
                form.submit();
            }
        });
    }
</script>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 1500
            });
        });
    </script>
@endif
