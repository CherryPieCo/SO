<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ScrapeCallback as Callback;
use App\Models\Url;
use App\Models\Pack;
use App\Helpers\Balancer;


class Packs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packs:start
                            {id : id_pack}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start pending packs';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pack = Pack::find($this->argument('id'));
        $data = $pack->getData();
        
        //$hashes = array_keys($data);
        //Url::whereIn('hash', $hashes)->delete();
        
        $pack->status = 'process';
        $pack->save();
        
        foreach ($data as $hash => $info) {
            $url = $info['url'];
            $urlEntity = Url::where('hash', md5($url))->first();
            if (!$urlEntity) {
                Url::insert([
                    'url' => $url,
                    'hash' => md5($url),
                    'created_at' => time(),
                    'parsers' => [],
                ]);
            }
            
            
            foreach ($info['parsers'] as $type => $parser) {
                $options = implode('-', $parser['options']);
                //$pattern = 'php '. base_path() .'/artisan scrape:%s %s %s %s > /dev/null 2>/dev/null &';
                $pattern = 'php '. base_path() .'/artisan scrape:%s %s %s %s';
                
                Balancer::queue(
                    sprintf($pattern, $type, urlencode($url), $options, '--pack='. $this->argument('id')),
                    $type, 
                    urlencode($url), 
                    $this->argument('id'),
                    $options
                );
                //shell_exec('"'.sprintf($pattern, $type, urlencode($url), $options, '--pack='. $this->argument('id')) .'" >> '. base_path() .'/ohhai.log');
                //$this->dispatch(new SendReminderEmail($user));
                //shell_exec(sprintf($pattern, $type, urlencode($url), $options, '--pack='. $this->argument('id')));
                \Log::info('ADD: '. sprintf($pattern, $type, urlencode($url), $options, '--pack='. $this->argument('id')));
            }
        }
        
        return;
        
        
        //
        //
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
