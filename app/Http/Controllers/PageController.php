<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function pageDashboard()
    {
        return view('pages.dashboard.dashboard');
    }

    public function pageBarang()
    {
        return view('pages.barang.barang');
    }

    public function pagePersediaan()
    {
        return view('pages.barang.persediaan');
    }

    public function pagePembelian()
    {
        return view('pages.pembelian.pembelian');
    }

    public function pagePenjualan()
    {
        return view('pages.penjualan.penjualan');
    }

    public function pageTransaksi()
    {
        $customers = Customer::all();
        return view('pages.penjualan.transaksi', compact('customers'));
    }
}
