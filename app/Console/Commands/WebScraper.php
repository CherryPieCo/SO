<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ScrapeCallback as Callback;
use App\Models\Url;


class WebScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape
                            {url : site url}
                            {parsers : parsers list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrape example.com email,pages~advertisement|donate';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');
        if (!Url::where('url', $url)->count()) {
            Url::insert([
                'url' => $url,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $parsers = explode(',', $this->argument('parsers'));
        
        foreach ($parsers as $parser) {
            $args = explode('~', $parser);
            $parser = $args[0];
            $options = isset($args[1]) ? $args[1] : '';
            
            
            $command = 'php '. base_path() .'/artisan scrape:'. $parser .' '. $url .' '. $options .' 2>&1 > '. base_path() .'/out.log';
            shell_exec($command);
        }
    } // end handle
}
