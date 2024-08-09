<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $table = 'sales_details';
    protected $fillable = ['sales_id', 'barang_id', 'harga_bandrol', 'qty', 'diskon_pct', 'diskon_nilai', 'harga_diskon', 'total'];
}
