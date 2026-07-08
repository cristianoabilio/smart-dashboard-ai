<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $query = DB::table('sales AS s')
            ->join('sellers AS se', 's.seller_id', '=', 'se.id')
            ->join('clients AS cl', 's.client_id', '=', 'cl.id')
            ->join('addresses AS a', 'cl.address_id', '=', 'a.id')
            ->join('companies AS c', 'se.company_id', '=', 'c.id')
            ->join('users AS u', 'se.user_id', '=', 'u.id')
            ->join('users as uc', 'cl.user_id', '=', 'uc.id')
            ->selectRaw(
                's.id AS sale_id,
                    u.name as sellers,
                    uc.name as client,
                    a.city,
                    a.state,
                    s.sold_at,
                    s.status,
                    s.total_amount,
             round(s.total_amount * c.commission_rate / 100) AS commission_amount')
             ->toSql();

        DB::statement( 'CREATE MATERIALIZED VIEW sales_commission_view AS ' . $query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP MATERIALIZED VIEW sales_commission_view");
    }
};
