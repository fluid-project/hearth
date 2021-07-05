<?php

namespace Hearth\Commands;

use Illuminate\Console\Command;

class HearthCommand extends Command
{
    public $signature = 'hearth:install';

    public $description = 'Install Hearth.';

    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'Hearth\HearthServiceProvider', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
    }
}
