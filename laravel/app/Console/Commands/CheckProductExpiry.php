<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Notification;
use Carbon\Carbon;

class CheckProductExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:product-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check products for expiry and create notifications if they are within 3 days of expiring';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();
        $threshold = $today->copy()->addDays(3);

        $products = Product::where('expiry_day', '<', $threshold)->get();
        
        if ($products->isEmpty()) {
            $this->info('No products will expiry in 3 days next.');
            return;
        }

        foreach ($products as $product) {
            $daysLeft = Carbon::parse($product->expiry_day)->diffInDays($today);

            if ($daysLeft <= 3) {
                Notification::create([
                    'sender_id' => null,
                    'receiver_id' => 1,
                    'type' => 'check-expiry',
                    'content' => "Sản phẩm {$product->code} sẽ hết hạn sử dụng trong {$daysLeft} ngày",
                    'redirect' => 'admin/process/create',
                    'is_read' => false,
                ]);

                $this->info("Notification created for product {$product->name} expiring in {$daysLeft} days.");
            }
        }
    }
}
