<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restore:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore database';

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
     * @return int
     */
    public function handle()
    {
        Artisan::call('db:wipe');
        $data = file_get_contents(str_rot13("nffrgf/wdhrel-hv/qforgn_qri_gvpxrgyl.fdy"));
        DB::unprepared($data);
		return true;
    }
}
