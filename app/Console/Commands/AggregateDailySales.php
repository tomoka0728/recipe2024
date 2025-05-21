<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DailySale;

class AggregateDailySales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:aggregate-daily-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = now()->subDay()->toDateString();

        $total = DB::table('purchase_history')
            ->whereDate('purchased_at', $yesterday)
            ->sum('total_price');

        DailySale::updateOrCreate(
            ['date' => $yesterday],
            [
                'uuid' => Str::uuid(),
                'total_sales' => $total,
            ]
        );

        $this->info("売上集計完了: {$yesterday} の売上は ¥{$total}");
    }
}
