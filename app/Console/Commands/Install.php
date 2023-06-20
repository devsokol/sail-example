<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--refresh : refresh database migrations.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install: migrations, seeds';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') !== 'production') {
            if ($this->option('refresh')) {
                $this->call('migrate:refresh');
            } else {
                $this->call('migrate');
            }

            $this->call('db:seed', ['--class' => 'RolesSeeder']);
        } else {
            $this->warn('You cannot run this operation in production mode!');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
