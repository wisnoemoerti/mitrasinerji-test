<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = ['kode', 'tgl', 'cust_id', 'subtotal', 'diskon', 'ongkir', 'total_bayar'];
}
