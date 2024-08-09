@extends('template')
@section('title')
    MAPROD | Transaksi Penjualan
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4" style="overflow-y:scroll; overflow-x:hidden; height:700px;">
            <div class="row" id="list-barang">
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transaksi Penjualan</h6>
                </div>
                <form role="form" id="form-transaksi" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Pilih Pembeli : <span
                                            style="color: red">*</span></label>
                                    <select id="cust_id" name="cust_id" class="form-control" required>
                                        <option value="">Pilih Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-nama="{{ $customer->name }}"
                                                data-telp="{{ $customer->telp }}">
                                                {{ $customer->kode }} - {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="nama" class="form-control mt-2" placeholder="Nama"
                                        readonly>
                                    <input type="text" id="telp" class="form-control mt-2" placeholder="Telp"
                                        readonly>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Tanggal : <span style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control" type="date" name="tgl" required>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered global-table" width="100%" cellspacing="0"
                                    id="belanjaan">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Harga Bandrol</th>
                                            <th>Diskon (%)</th>
                                            <th>Diskon (Rp)</th>
                                            <th>Harga Diskon</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7">Total Harga </td>
                                            <td colspan="2">
                                                <input type="hidden" name="total_pembayaran" value="0" />
                                                <div id='total-harga'>Rp 0</div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Sub Total : <span style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control bayar" type="number" name="sub_total"
                                        placeholder="Masukan Sub Total" value="0" required min="0" readonly>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Diskon : <span style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control" type="number" name="diskon"
                                        placeholder="Masukan Diskon" value="0" required min="0">
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Ongkir : <span style="color: red">*</span></label>
                                    <input autocomplete="off" class="form-control" type="number" name="ongkir"
                                        placeholder="Masukan Ongkir" value="0" required min="0">
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group has-error">
                                    <label class="form-control-label">Total Bayar : </label>
                                    <input autocomplete="off" class="form-control" type="text" name="total_bayar"
                                        placeholder="Total Bayar" readonly>
                                    <span class="has-error help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="float: right; width: 100%">
                        <button type="submit" id="btn-save-transaksi" class="btn btn-success float-right mr-10"><i
                                class="fa fa-check"></i> Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('cust_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('nama').value = selectedOption.getAttribute('data-nama');
            document.getElementById('telp').value = selectedOption.getAttribute('data-telp');
        });

        function count_all() {
            let totalHarga = 0;

            $('#belanjaan tbody tr').each(function() {
                const qty = parseInt($(this).find('input[name*="[qty]"]').val());
                const hargaBandrol = parseInt($(this).data('harga'));
                const diskonPersen = parseInt($(this).find('input[name*="[diskon_persen]"]').val());
                const diskonRupiah = (hargaBandrol * diskonPersen) / 100;
                const hargaDiskon = hargaBandrol - diskonRupiah;
                const total = qty * hargaDiskon;

                $(this).find('input[name*="[harga_diskon]"]').val(hargaDiskon);
                $(this).find('input[name*="[total]"]').val(total);
                $(this).find('.total-harga').text(formatNumber(total));
                $(this).find('.harga-diskon').text(formatNumber(hargaDiskon));
                $(this).find('.diskon-rupiah').text(formatNumber(diskonRupiah));

                totalHarga += total;
            });

            const subTotal = parseInt($('input[name="sub_total"]').val());
            const diskon = parseInt($('input[name="diskon"]').val());
            const ongkir = parseInt($('input[name="ongkir"]').val());

            const totalPembayaran = (ongkir == 0 && diskon == 0) ? totalHarga : subTotal + ongkir - diskon;
            $('input[name="total_pembayaran"]').val(totalHarga);
            $('#total-harga').text('Rp ' + formatNumber(totalHarga));
            $('input[name="total_bayar"]').val(totalPembayaran);
            $('input[name="sub_total"]').val(totalHarga);
        }

        function formatNumber(x) {
            const parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        };

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: '{{ url('/getBarang') }}',
                data: {
                    Barang: '',
                },
                success: function(data) {
                    $('#list-barang').append(data);

                },
                error: function(response) {
                    console.log(response);
                    swal({
                        icon: 'error',
                        text: 'Gagal Membuka modal.',
                        title: 'Maaf',
                    });
                },
            });
        });

        $(document).on('click', '.tambah-barang', function(e) {
            const barangId = $(this).data('id');
            const existingRow = $('#belanjaan > tbody').find('#' + barangId);

            if (existingRow.length > 0) {
                const qtyField = existingRow.find('input[name*="[qty]"]');
                qtyField.val(parseInt(qtyField.val()) + 1);
            } else {
                const namaBarang = $(this).data('nama');
                const hargaBandrol = $(this).data('harga');
                const newRow =
                    `<tr id="${barangId}" data-id="${barangId}" data-harga="${hargaBandrol}">
                        <td><input type="hidden" name="barang[${barangId}][id]" value="${barangId}" />${barangId}</td>
                        <td>${namaBarang}<input type="hidden" name="barang[${barangId}][nama]" value="${namaBarang}" /></td>
                        <td><input type="number" name="barang[${barangId}][qty]" value="1" min="1" class="form-control" /></td>
                        <td>Rp ${formatNumber(hargaBandrol)} <input type="hidden" name="barang[${barangId}][harga_bandrol]" value="${hargaBandrol}" /></td>
                        <td><input type="number" name="barang[${barangId}][diskon_persen]" value="0" min="0" class="form-control" /></td>
                        <td class="diskon-rupiah">Rp 0</td>
                        <td class="harga-diskon">Rp ${formatNumber(hargaBandrol)}</td>
                        <td class="total-harga">Rp ${formatNumber(hargaBandrol)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm btn-hapus-barang">Hapus</button>
                        </td>
                    </tr>`;

                $('#belanjaan > tbody').append(newRow);
            }

            count_all();
        });

        $(document).on('click', '.btn-hapus-barang', function(e) {
            $(this).closest('tr').remove();
            count_all();
        });

        $(document).on('input', 'input', function(e) {
            count_all();
        });
        $('#form-transaksi').submit(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            if ($('#belanjaan > tbody tr').length < 1) {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Belum ada barang yang di tambahkan !',
                });
            } else if (parseInt($('input[name ="bayar"').val()) < parseInt($('input[name ="total_pembayaran"')
                    .val())) {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Jumlah uang yang di bayar kurang !',
                });
            } else {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda tidak akan dapat merubah data ini!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, Lanjutkan!'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {
                        showLoading();
                        var formData = new FormData($("#form-transaksi")[0]);
                        $.ajax({
                            type: "POST",
                            url: '{{ url('/post/transaction') }}',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log(data);
                                hideLoading();
                                toastr.success(data.message, {
                                    timeOut: 5000
                                });
                                $('#form-transaksi').trigger("reset");
                                $('#belanjaan > tbody').find('tr').remove();
                                $('input[name ="total_pembayaran"').val(0);
                                $('#total-harga').text('Rp ' + formatNumber(0));
                                // Swal.fire({
                                //     type: 'question',
                                //     title: 'Pemberitahuan',
                                //     text: 'Apakah anda ingin mencetak nota ?',
                                //     showCancelButton: true,
                                //     confirmButtonColor: '#3085d6',
                                //     cancelButtonColor: '#d33',
                                //     cancelButtonText: 'Batal',
                                //     confirmButtonText: 'Ya, Lanjutkan!'
                                // }).then((result) => {
                                //     if (result.value) {
                                //         var APP_URL = {!! json_encode(url('/')) !!}
                                //         window.open(APP_URL + '/struk');
                                //     }
                                //     if (result.dismiss) {
                                //         $('#form-transaksi').trigger("reset");
                                //         $('#belanjaan > tbody').find('tr').remove();
                                //         $('input[name ="total_pembayaran"').val(0);
                                //         $('#total-harga').text('Rp ' + formatNumber(0));
                                //     }
                                // });
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                    }

                })
            }


        });
    </script>
@endsection
