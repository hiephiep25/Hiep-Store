<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailDiscount;

class SendDiscountEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discounts:send-emails';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send discount emails to customers for discounts starting soon';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $futureDate = $now->addDays(2);

        $discounts = Discount::with('products')
                             ->where('start', '>=', $now)
                             ->where('start', '<=', $futureDate)
                             ->get();

        if ($discounts->isEmpty()) {
            $this->info('No discounts found starting within the next 2 days.');
            return;
        }

        $users = User::where('role', User::ROLE_CUSTOMER)->get();

        foreach ($discounts as $discount) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new SendMailDiscount($discount));
            }
        }

        $this->info('Discount emails sent successfully.');
    }
}
