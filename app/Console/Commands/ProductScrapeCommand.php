<?php

namespace App\Console\Commands;

use App\Jobs\Product\ProductsListener;
use Illuminate\Console\Command;

class ProductScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ProductsListener::dispatch();

        return Command::SUCCESS;
    }
}
