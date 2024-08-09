<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Barang extends Model
{
    protected $table = 'barangs';

    public static function tambah($request)
    {
    	DB::beginTransaction();
        try {
            $db = new Barang();
			$db->nama =  $request->nama;
			$db->jumlah_stok =  $request->jumlah_stok;
			$db->harga =  $request->harga;
			$db->save();
	    	DB::commit();
			$responseData = 'Data barang berhasil disimpan';
			return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
			return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }

	public static function rubah($request)
    {
    	DB::beginTransaction();
        try {
            $db = Barang::find($request->id);
			$db->nama =  $request->nama;
			$db->jumlah_stok =  $request->jumlah_stok;
			$db->harga =  $request->harga;
			$db->save();
            DB::commit();
			$responseData = 'Data berhasil diubah';
	    	return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
			return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }

    public static function updateStokBarang($request)
    {
    	DB::beginTransaction();
        try {
            $db = Barang::find($request->id);
            if ($request->type == "Pengurangan"){
                $db->jumlah_stok =  $db->jumlah_stok-$request->jumlah_stok;
            }else{
                $db->jumlah_stok =  $db->jumlah_stok+$request->jumlah_stok;
            }
			$db->save();
            DB::commit();
			$responseData = 'Data berhasil diubah';
	    	return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
			return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }

    public static function hapus($request)
    {
    	DB::beginTransaction();
        try {
            $db = Barang::find($request->id);
			$db->delete();
            DB::commit();
			$responseData = 'Data berhasil dihapus';
	    	return response()->json(['message'=> $responseData, 'data' => $responseData], 201);
        } catch (\Exception $ex) {
            DB::rollback();
            $responseData = $ex->getMessage();
	    	return response()->json(['message'=> 'failed', 'data' => $responseData], 400);
        }
    }
}
