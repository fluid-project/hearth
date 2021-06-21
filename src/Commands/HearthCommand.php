<?php

namespace InclusiveDesign\Hearth\Commands;

use Illuminate\Console\Command;

class HearthCommand extends Command
{
    public $signature = 'hearth';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
