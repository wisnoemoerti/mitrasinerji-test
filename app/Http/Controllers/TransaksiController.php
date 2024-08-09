<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Define Module
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\View;

use Carbon\Carbon;
use PDF;

//Define Model
use App\Transaksi;
use App\TransaksiDetail;
use App\Barang;
use App\Sales;
use App\SalesDetail;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $table = DB::table('sales as s')
            ->join('customers as c', 's.cust_id', '=', 'c.id')
            ->join('sales_details as sd', 's.id', '=', 'sd.sales_id')
            ->select(
                's.kode',
                's.tgl',
                'c.name',
                's.diskon',
                's.ongkir',
                's.subtotal',
                's.total_bayar',
                DB::raw('SUM(sd.qty) as jumlah_barang')
            )
            ->groupBy(
                's.kode',
                's.tgl',
                'c.name',
                's.diskon',
                's.ongkir',
                's.subtotal',
                's.total_bayar'
            );
        $datatable = Datatables::of($table);


        $datatable->addIndexColumn();
        $datatable->editColumn('tgl', function ($value) {
            $tanggal_transaki = date('d F Y', strtotime($value->tgl));
            return $tanggal_transaki;
        });
        // $datatable->editColumn('diskon', function ($value) {
        //     $diskon = "Rp " . number_format($value->diskon, 2, ',', '.');
        //     return $diskon;
        // });
        // $datatable->editColumn('ongkir', function ($value) {
        //     $ongkir = "Rp " . number_format($value->ongkir, 2, ',', '.');
        //     return $ongkir;
        // });
        // $datatable->editColumn('subtotal', function ($value) {
        //     $subtotal = "Rp " . number_format($value->subtotal, 2, ',', '.');
        //     return $subtotal;
        // });
        // $datatable->editColumn('total_bayar', function ($value) {
        //     $total_bayar = "Rp " . number_format($value->total_bayar, 2, ',', '.');
        //     return $total_bayar;
        // });
        // $datatable->rawColumns(['actions']);
        return $datatable->make(true);
    }

    public function postTransaction(Request $request)
    {
        DB::beginTransaction();
        try {
            $db = new Sales();
            $tahun = now()->format('Y'); // Ambil tahun 4 digit
            $bulan = now()->format('m'); // Ambil bulan 2 digit

            $nomor_urut = Sales::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count() + 1;
            $nomor_urut_formatted = sprintf('%04d', $nomor_urut);

            $kode = "{$tahun}{$bulan}-{$nomor_urut_formatted}";

            $db->kode = $kode;
            $db->cust_id       = $request->cust_id;
            $db->tgl  = $request->tgl;
            $db->subtotal   = $request->sub_total;
            $db->diskon              = $request->diskon;
            $db->ongkir          = $request->ongkir;
            $db->total_bayar          = $request->total_bayar;

            $saved = $db->save();

            if ($saved) {
                foreach ($request->barang as $id => $item) {
                    $db2 = new SalesDetail();
                    $db2->sales_id       = $db->id;
                    $db2->barang_id       = $id;
                    $db2->harga_bandrol         = $item['harga_bandrol'];
                    $db2->qty  = $item['qty'];
                    $db2->diskon_pct   = $item['diskon_persen'];
                    $db2->diskon_nilai   = ($item['harga_bandrol'] * $item['diskon_persen']) / 100;
                    $db2->harga_diskon   = $item['harga_bandrol'] - (($item['harga_bandrol'] * $item['diskon_persen']) / 100);
                    $db2->total   = $item['qty'] * $item['harga_bandrol'] - (($item['harga_bandrol'] * $item['diskon_persen']) / 100);
                    $save = $db2->save();
                }
            }
            DB::commit();
            $responseData = 'Data barang berhasil disimpan';
            return response()->json(['message' => $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
            return response()->json(['message' => 'failed', 'data' => $responseData], 400);
        }
    }


    public function struk()
    {
        $dataTransaksi = DB::table('transaksis')->orderBy('created_at', 'desc')->first();
        $dataListBarang = DB::table('transaksi_details')
            ->join('barangs', 'transaksi_details.id_barang', '=', 'barangs.id')
            ->select('transaksi_details.id_barang', 'transaksi_details.id_transaksi', 'transaksi_details.jumlah_barang', 'transaksi_details.harga', 'barangs.nama')
            ->where('transaksi_details.id_transaksi', '=', $dataTransaksi->id)
            ->get();
        return view('pages.penjualan.struk', ['dataTransaksi' => $dataTransaksi, 'dataListBarang' => $dataListBarang]);
    }
}
