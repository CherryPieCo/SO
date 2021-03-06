<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Artisan;

class CommandHandler extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    public $command = '';
    
    public $parser = '';
    public $pack = '';
    public $url = '';
    public $options = '';
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($command, $parser, $url, $pack, $options)
    {
        $this->command = $command;
        
        $this->parser = $parser;
        $this->url = $url;
        $this->pack = $pack;
        $this->options = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('START: '. $this->command);
        Artisan::call('scrape:'. $this->parser, [
            'url' => $this->url, 
            'options' => $this->options,
            '--pack' => $this->pack
        ]);
        \Log::info('STOP: '. $this->command);
    }
    
    public function failed()
    {
        \Log::info('FUCK: '. $this->command);
    }
    
}
