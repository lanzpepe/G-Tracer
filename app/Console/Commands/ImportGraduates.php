<?php

namespace App\Console\Commands;

use App\Models\Graduate;
use Illuminate\Console\Command;

class ImportGraduates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:graduates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import graduates from stored .csv files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
