<?php

namespace App\Providers\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class FortifyUITablerCommand extends Command
{
    public $signature = 'tabler:install';

    public $description = 'Install Tabler.io with views and resources';

    public function handle()
    {
        // confirm the installation
        if ($this->confirm('Do you wish to continue? Please only continue on a fresh Laravel installation since multiple files are overwritten by the installer.', false)) {
            // install fortifyUI
            \Artisan::call('fortify:ui');
            $this->info('FortifyUI has been installed. Proceeding to install Tabler.io.');
            
            // publish the assets, routes, controllers, etc.
            $this->publishAssets();

            // request information on session driver
            if(!Schema::hasTable('sessions')){
                $this->changeSessionDriver();
            }

            // create symbolic link
            \Artisan::call('storage:link');

            // Clear the Route cache
            \Artisan::call('route:clear');
            \Artisan::call('route:cache');

            // print success message
            $this->info('The Tabler.io Framework is now installed.');
            $this->newLine();
            $this->line('Please run php artisan migrate before continuing.');    
        } else {
            // print abort message
            $this->error('Installation is aborted');
        }
    }

    protected function publishAssets()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'tabler-resources', '--force' => true]);
    }

    protected function changeSessionDriver(){
        if($this->confirm('This package only works out of the box if you have set your session driver to \'database\', have you already changed it?', true)) {
            $this->line('Great! We\'ll create a new migration for the table right now.');
            \Artisan::call('session:table');
            $this->newLine();
        } else {
            $this->line('No problem! Please make sure however to change it manually according to the documentation at https://github.com/proxeuse/fortify-tabler/.');
            $this->newLine();
        }
    }
}
