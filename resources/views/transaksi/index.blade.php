@extends('layout.template')

@section('konten')
    <div class="row my-3 p-3 bg-body rounded shadow-sm">
        <!-- Kolom Kiri - Daftar Produk -->
        <div class="col-8">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Daftar Produk</h4>
                        <div class="text-end">
                            <div class="small">Tanggal: {{ now()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</div>
                            <div class="small">No. Struk: {{ 'TRX' . now()->setTimezone('Asia/Jakarta')->format('YmdHis') }}
                            </div>
                            <div class="small">Kasir: {{ Auth::user()->name }}</div>
                        </div>
                    </div>
                </div>

                <!-- Form Pencarian -->
                <div class="card-body">
                    <div class="d-flex gap-2 mb-3">
                        <form class="d-flex flex-grow-1" action="{{ url('transaksi') }}" method="get" id="searchForm">
                            <input class="form-control me-1" type="search" name="katakunci"
                                value="{{ Request::get('katakunci') }}" placeholder="Masukkan kode atau nama produk..."
                                aria-label="Search">
                            <button class="btn btn-primary" type="submit" id="searchButton">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </form>
                        <a href="{{ url('transaksi') }}" class="btn btn-secondary" onclick="batalTransaksi()">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>

                    <!-- Tabel Produk (Hasil Pencarian) -->
                    @if (Request::has('katakunci'))
                        <div class="table-responsive mb-3">
                            <h5>Hasil Pencarian</h5>
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="search-results">
                                    @if ($produk->count() > 0)
                                        @foreach ($produk as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->kode_produk }}</td>
                                                <td>{{ $item->nama_produk }}</td>
                                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                <td>{{ $item->stok }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-success tambah-ke-keranjang"
                                                        onclick="tambahKeKeranjang('{{ $item->kode_produk }}', '{{ $item->nama_produk }}', {{ $item->harga_jual }}, {{ $item->stok }})">
                                                        <i class="fas fa-cart-plus"></i> Tambah
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada produk ditemukan</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Tabel Keranjang Belanja -->
                    <div class="table-responsive">
                        <h5>Keranjang Belanja</h5>
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <tr id="empty-cart">
                                    <td colspan="7" class="text-center">Keranjang belanja kosong</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold" id="cart-total">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan - Detail Pembayaran -->
        <div class="col-4">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <!-- Total -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Total Belanja</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control text-end" id="total" value="0" readonly>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control text-end" id="bayar" placeholder="0"
                                onkeyup="hitungKembalian()">
                        </div>
                    </div>

                    <!-- Kembalian -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control text-end" id="kembalian" value="0" readonly>
                        </div>
                    </div>

                    <!-- Tombol Proses -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" id="btn-proses" onclick="prosesPembayaran()">
                            <i class="fas fa-check-circle"></i> Proses Pembayaran
                        </button>
                        <button class="btn btn-danger" id="btn-batal" onclick="batalTransaksi()">
                            <i class="fas fa-times-circle"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let keranjang = [];
        let totalBelanja = 0;

        // Load keranjang dari localStorage saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const savedKeranjang = localStorage.getItem('keranjang');
            if (savedKeranjang) {
                keranjang = JSON.parse(savedKeranjang);
                updateKeranjang();
            }
        });

        function tambahKeKeranjang(kode, nama, harga, stokTersedia) {
            // Cek apakah produk sudah ada di keranjang
            let existingItem = keranjang.find(item => item.kode === kode);

            if (existingItem) {
                if (existingItem.qty >= stokTersedia) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Mencukupi',
                        text: `Stok tersedia hanya ${stokTersedia} unit`,
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                existingItem.qty++;
                existingItem.subtotal = existingItem.qty * existingItem.harga;
            } else {
                keranjang.push({
                    kode: kode,
                    nama: nama,
                    harga: harga,
                    qty: 1,
                    subtotal: harga,
                    stokTersedia: stokTersedia
                });
            }

            // Simpan ke localStorage setiap kali ada perubahan
            localStorage.setItem('keranjang', JSON.stringify(keranjang));
            updateKeranjang();
        }

        function updateKeranjang() {
            let cartBody = document.getElementById('cart-items');
            cartBody.innerHTML = '';

            totalBelanja = 0;

            if (keranjang.length === 0) {
                cartBody.innerHTML = `
            <tr id="empty-cart">
                <td colspan="7" class="text-center">Keranjang belanja kosong</td>
            </tr>`;
                return;
            }

            keranjang.forEach((item, index) => {
                totalBelanja += item.subtotal;
                cartBody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.kode}</td>
                <td>${item.nama}</td>
                <td class="text-end">Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary" onclick="updateQty('${item.kode}', -1)">-</button>
                        <input type="number" class="form-control text-center" value="${item.qty}" min="1" max="${item.stokTersedia}" 
                            onchange="updateQtyManual('${item.kode}', this.value)">
                        <button class="btn btn-outline-secondary" onclick="updateQty('${item.kode}', 1)">+</button>
                    </div>
                </td>
                <td class="text-end">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="hapusItem('${item.kode}')">
                        <i class="fas fa-trash">Batal</i>
                    </button>
                </td>
            </tr>`;
            });

            document.getElementById('total').value = totalBelanja.toLocaleString('id-ID');
            document.getElementById('cart-total').innerHTML = `Rp ${totalBelanja.toLocaleString('id-ID')}`;
            hitungKembalian();
        }

        function updateQty(kode, perubahan) {
            let item = keranjang.find(item => item.kode === kode);
            if (item) {
                let newQty = item.qty + perubahan;
                if (newQty >= 1 && newQty <= item.stokTersedia) {
                    item.qty = newQty;
                    item.subtotal = item.qty * item.harga;
                    localStorage.setItem('keranjang', JSON.stringify(keranjang));
                    updateKeranjang();
                } else if (newQty > item.stokTersedia) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Mencukupi',
                        text: `Stok tersedia hanya ${item.stokTersedia} unit`,
                        confirmButtonText: 'OK'
                    });
                }
            }
        }

        function updateQtyManual(kode, nilai) {
            let qty = parseInt(nilai);
            let item = keranjang.find(item => item.kode === kode);
            if (item) {
                if (qty >= 1 && qty <= item.stokTersedia) {
                    item.qty = qty;
                    item.subtotal = item.qty * item.harga;
                    localStorage.setItem('keranjang', JSON.stringify(keranjang));
                    updateKeranjang();
                } else if (qty > item.stokTersedia) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Mencukupi',
                        text: `Stok tersedia hanya ${item.stokTersedia} unit`,
                        confirmButtonText: 'OK'
                    });
                    // Reset nilai input ke stok maksimal
                    item.qty = item.stokTersedia;
                    item.subtotal = item.qty * item.harga;
                    localStorage.setItem('keranjang', JSON.stringify(keranjang));
                    updateKeranjang();
                }
            }
        }

        function hapusItem(kode) {
            keranjang = keranjang.filter(item => item.kode !== kode);
            localStorage.setItem('keranjang', JSON.stringify(keranjang));
            updateKeranjang();
        }

        function hitungKembalian() {
            let bayar = parseInt(document.getElementById('bayar').value) || 0;
            let kembalian = bayar - totalBelanja;
            document.getElementById('kembalian').value = kembalian.toLocaleString('id-ID');
        }

        function prosesPembayaran() {
            if (keranjang.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Keranjang Kosong',
                    text: 'Keranjang belanja masih kosong!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            let bayar = parseInt(document.getElementById('bayar').value) || 0;
            if (bayar < totalBelanja) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Kurang',
                    text: 'Jumlah pembayaran kurang!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Tampilkan loading
            Swal.fire({
                title: 'Memproses Transaksi',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim data ke server
            let data = {
                total_harga: totalBelanja,
                jumlah_bayar: bayar,
                items: keranjang.map(item => ({
                    kode_produk: item.kode,
                    qty: item.qty,
                    harga: item.harga
                }))
            };

            fetch('/transaksi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil',
                            html: `
                                Total: Rp ${data.data.total.toLocaleString('id-ID')}<br>
                                Bayar: Rp ${data.data.bayar.toLocaleString('id-ID')}<br>
                                Kembalian: Rp ${data.data.kembalian.toLocaleString('id-ID')}
                            `,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                batalTransaksi();
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses transaksi',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function batalTransaksi() {
            keranjang = [];
            totalBelanja = 0;
            document.getElementById('bayar').value = '';
            document.getElementById('kembalian').value = '0';
            localStorage.removeItem('keranjang');
            updateKeranjang();
        }
    </script>
@endsection
