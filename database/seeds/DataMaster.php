<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataMaster extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::insert('INSERT INTO pasiens (nik,nama,umur,jenis_kelamin,alamat,odp_date,status) values '.$values.' ');


        // Insert data into 'barangs' table
        DB::table('barangs')->insert([
            ['kode' => 'A001', 'nama' => 'Barang A', 'harga' => 200000],
            ['kode' => 'C025', 'nama' => 'Barang B', 'harga' => 350000],
            ['kode' => 'A102', 'nama' => 'Barang C', 'harga' => 125000],
            ['kode' => 'A301', 'nama' => 'Barang D', 'harga' => 350000],
            ['kode' => 'B221', 'nama' => 'Barang E', 'harga' => 125000],
        ]);

        // Insert data into 'customers' table
        DB::table('customers')->insert([
            ['kode' => 'C01', 'name' => 'Cust A', 'telp' => '088888888'],
            ['kode' => 'C02', 'name' => 'Cust B', 'telp' => '088888888'],
            ['kode' => 'C03', 'name' => 'Cust C', 'telp' => '088888888'],
            ['kode' => 'C04', 'name' => 'Cust D', 'telp' => '088888888'],
            ['kode' => 'C05', 'name' => 'Cust E', 'telp' => '088888888'],
        ]);
    }
}
