<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMembershipExpiredEmail;

class CheckExpiredUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:check-expired';

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
        //
        $this->info('Check User Expiry is running');
        $expired_users = User::whereHas('memberships', function ($query) {
            $query->where('status', 'active')->where('expire_on', '<', now());


        })->get();

        $counter = 0;
        foreach ($expired_users as $expired_user) {

            Mail::to($expired_user->email)->send(new SendMembershipExpiredEmail($expired_user));
            $membership = $expired_user->memberships()->first();
            $membership->status = 'expired';
            $membership->save();

            $this->info("User {$expired_user->email} has been expired.");
            $counter++;
        }
        $this->info("{$counter} users have expired.");
    }


}
