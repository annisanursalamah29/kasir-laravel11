$(document).ready(function () {
    $("#search-produk").on("keyup", function () {
        let keyword = $(this).val();

        $.ajax({
            url: "/cari-produk",
            method: "GET",
            data: {
                keyword: keyword,
            },
            success: function (response) {
                let tableBody = $("#table-produk tbody");
                tableBody.empty(); // Kosongkan tabel terlebih dahulu

                if (response.length > 0) {
                    // Jika ada data, tampilkan dalam tabel
                    response.forEach(function (item) {
                        tableBody.append(`
                            <tr>
                                <td>${item.kode_produk}</td>
                                <td>${item.nama_produk}</td>
                                <td>${item.harga}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm pilih-produk" 
                                        data-kode="${item.kode_produk}"
                                        data-nama="${item.nama_produk}"
                                        data-harga="${item.harga}">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    // Jika tidak ada data, tampilkan pesan
                    tableBody.append(`
                        <tr>
                            <td colspan="4" class="text-center">
                                Produk tidak ditemukan
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mencari produk");
            },
        });
    });
});
