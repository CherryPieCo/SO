<?php

namespace App\Console\Parsers;

use Illuminate\Console\Command;
use App\Models\Url;
use App\Models\Pack;
use DB;


class AbstractParser extends Command
{
    
    protected $idPack = false;
    protected $id = null;
    protected $site = null;
    protected $url = '';
    protected $request;
    protected $curl;
    
    public function handle()
    {
        $context = $this;
        $this->url = trim($this->argument('url'));
        $this->site = Url::where('url', $this->url)->first();
        if (!$this->site) {
            Url::insert([
                'url' => $this->url, 
                'hash' => md5($this->url),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $this->site = Url::where('url', $this->url)->first();
        }
        $this->id = $this->site->id;
        
        $rollingCurl = new \RollingCurl\RollingCurl();
        $rollingCurl->get($this->url);
        $rollingCurl->setSimultaneousLimit(2);
        $rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use($context) {
            $context->prepare($request, $rollingCurl);
            $context->check();
            $context->exec();
            $context->after();
        });
        $rollingCurl->execute();
    } // end __construct
    
    protected function prepare(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl)
    {
        $this->request = $request;
        $this->curl    = $rollingCurl;
    } // end prepare
    
    protected function after() 
    {
        $idPack = $this->idPack;
        if (!$idPack) {
            return false;
        }
        
        $currentHash = md5($this->url);
        $parserType = $this->type;
        DB::transaction(function() use($idPack, $currentHash, $parserType) {
            $pack = Pack::find($idPack);
            $data = $pack->getData();
            
            foreach ($data as $hash => &$info) {
                if ($currentHash == $hash) {
                    foreach ($info['parsers'] as &$parser) {
                        if ($parserType == $parser['type']) {
                            $parser['status'] = 'complete';
                            break;
                        }
                    }
                    break;
                }
            }
            
            $pack->data = json_encode($data);
            $pack->save();
        });
    } // end after
    
    protected function exec() 
    {
        throw new \Exception('Method [exec] not implemented.');
    } // end exec
    
    protected function check()
    {
        $error = $this->request->getResponseError();
        if ($error) {
            $this->site->status = 'error';
            $this->site->error .= '['. date('Y-m-d H:i:s') .']: '. $error ."\r\n";
        } else {
            $this->site->status = 'ok';
        }
        $this->site->save();
        
        return $error;
    } // end check
    
}
