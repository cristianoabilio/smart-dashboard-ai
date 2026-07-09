<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleCommission extends Model
{
    protected $table = 'sales_commission_view';
    public $timestamps = false;
    public $incrementing = false;

    public function ScopeGetColumns()
    {
        return [
            'company',
            'seller',
            'client',
            'sold_at',
            'total_amount',
            'status',
            'city',
            'state',
            'commission',
        ];
    }
}
