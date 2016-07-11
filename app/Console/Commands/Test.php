<?php

namespace App\Console\Commands;

use App\Helpers\Parse;

class Test extends \Illuminate\Console\Command
{
    protected $signature = 'test';
    protected $description = 'Display an inspiring quote';

    public function handle()
    {
        $html = '';
        Parse::email($html);
    }
}
