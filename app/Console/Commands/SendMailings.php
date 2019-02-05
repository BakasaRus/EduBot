<?php

namespace App\Console\Commands;

use App\Mailing;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMailings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailings:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Try to send Mailings according to their schedule';

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
     */
    public function handle()
    {
        $mailings = Mailing::whereNotNull('send_at')->get();
        $now = Carbon::now()->startOfMinute();

        if ($mailings->isEmpty()) {
            $this->line("Nothing to check");
            return 0;
        }

        foreach ($mailings as $mailing) {
            if ($mailing->send_at->startOfMinute()->eq($now)) {
                $success = $mailing->send();
                if ($success)
                    $this->info("Mailing \"{$mailing->name}\" has been sent successfully");
                else
                    $this->error("Mailing \"{$mailing->name}\" has been sent with errors");
            }
            else
                $this->line("Mailing \"{$mailing->name}\" is not ready to be sent");
        }
    }
}
