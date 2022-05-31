<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\DelayedOrder;
use Carbon\Carbon;

class DelayedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delayed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delayed orders are generated';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:i:s');

        $data = Order::where('delivery_time','<',$currentTime)->orderBy('created_at', 'desc')->get();
        if (count($data)) {
            foreach($data as $key => $val){
                $delayedOrder = new DelayedOrder;
                $delayedOrder->order_id = $val->id;
                $delayedOrder->delivery_time = $val->delivery_time;
                $delayedOrder->save();
            }
        }

        $this->info('Delayed orders created');
    }
}
