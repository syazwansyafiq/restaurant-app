<?php

namespace App\Console\Commands;

use App\Http\Services\Cron\CalculateSales;
use Illuminate\Console\Command;

class UpdateSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all restaurant sales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new CalculateSales)->handle();
    }
}
