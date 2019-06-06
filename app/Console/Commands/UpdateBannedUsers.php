<?php

namespace App\Console\Commands;

use App\Blocked;
use Carbon\Carbon;

use Illuminate\Console\Command;

class UpdateBannedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove ban instances from database when ban has expired';

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
        $date = new Carbon;
        $bans = Blocked::all();
        
        foreach($bans as $ban)
        {
            if($date > $ban->date)
                $ban->delete();
        }
    }
}
