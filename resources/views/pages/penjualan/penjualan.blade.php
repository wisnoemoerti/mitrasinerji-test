@extends('template')

@section('title')
    MAPROD | List Transaksi
@endsection

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data List Transaksi</h1>
    <p class="mb-4">Ini adalah data List Transaksi.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Manajement Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered global-table" id="tablePenjualan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Nama Customer</th>
                            <th>Jumlah Barang</th>
                            <th>Sub Total</th>
                            <th>Diskon</th>
                            <th>Ongkir</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="8" style="text-align: right;">Grand Total:</th>
                            <th id="grandTotalTotalBayar">0</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>

                @component('components.modal')
                    @slot('id_modal', 'myModal')
                    @slot('id_form', 'form')
                    @slot('size_modal', 'modal_size')
                    @slot('title_modal', 'modal_title')
                    @slot('body_modal', 'modal_body')
                    @slot('footer_modal', 'modal_footer')
                @endcomponent
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#tablePenjualan').DataTable({
                ordering: false,
                responsive: true,
                processing: true,
                serverSide: true,
                saveState: true,
                ajax: '{{ route('tablePenjualan') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'tgl',
                        name: 'tgl'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'jumlah_barang',
                        name: 'jumlah_barang'
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal',
                        render: function(data, type, row) {
                            return 'Rp. ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                '$&,');
                        }
                    },
                    {
                        data: 'diskon',
                        name: 'diskon',
                        render: function(data, type, row) {
                            return 'Rp. ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                '$&,');
                        }
                    },
                    {
                        data: 'ongkir',
                        name: 'ongkir',
                        render: function(data, type, row) {
                            return 'Rp. ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                '$&,');
                        }
                    },
                    {
                        data: 'total_bayar',
                        name: 'total_bayar',
                        render: function(data, type, row) {
                            return 'Rp. ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                '$&,');
                        }
                    },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate the total for each column
                    // var totalJumlahBarang = api.column(4).data().reduce(function(a, b) {
                    //     return parseFloat(a) + parseFloat(b);
                    // }, 0);

                    // var totalSubtotal = api.column(5).data().reduce(function(a, b) {
                    //     return parseFloat(a) + parseFloat(b);
                    // }, 0);

                    // var totalDiskon = api.column(6).data().reduce(function(a, b) {
                    //     return parseFloat(a) + parseFloat(b);
                    // }, 0);

                    // var totalOngkir = api.column(7).data().reduce(function(a, b) {
                    //     return parseFloat(a) + parseFloat(b);
                    // }, 0);

                    var totalTotalBayar = api.column(8).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    // $(api.column(4).footer()).html('Rp. ' + totalJumlahBarang.toFixed(2).replace(
                    //     /\d(?=(\d{3})+\.)/g, '$&,'));
                    // $(api.column(5).footer()).html('Rp. ' + totalSubtotal.toFixed(2).replace(
                    //     /\d(?=(\d{3})+\.)/g, '$&,'));
                    // $(api.column(6).footer()).html('Rp. ' + totalDiskon.toFixed(2).replace(
                    //     /\d(?=(\d{3})+\.)/g, '$&,'));
                    // $(api.column(7).footer()).html('Rp. ' + totalOngkir.toFixed(2).replace(
                    //     /\d(?=(\d{3})+\.)/g, '$&,'));
                    $(api.column(8).footer()).html('Rp. ' + totalTotalBayar.toFixed(2).replace(
                        /\d(?=(\d{3})+\.)/g, '$&,'));
                },
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endsection
