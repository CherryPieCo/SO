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
    protected $data = null;
    
    public function handle()
    {
        $context = $this;
        $this->url = trim(urldecode($this->argument('url')));
        $this->site = Url::where('hash', md5($this->url))->first();
        if (!$this->site) {
            Url::insert([
                'url' => $this->url, 
                'hash' => md5($this->url),
                'created_at' => time(),
                'parsers' => [],
            ]);
            $this->site = Url::where('url', $this->url)->first();
        }
        $this->id = $this->site->id;
        
        $rollingCurl = new \RollingCurl\RollingCurl();
        $rollingCurl->get($this->url);
        $rollingCurl->setSimultaneousLimit(2);
        $rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use($context) {
            $isExist = $context->checkValidParsedInfo();
            $context->prepare($request, $rollingCurl);
            if (!$isExist) {
                $context->check();
                $context->exec();
            }
            $context->after();
        });
        $rollingCurl->execute();
    } // end __construct
    
    protected function checkValidParsedInfo()
    {
        $data = $this->site->getValidParserInfo($this->type);
        if ($data) {
            $this->data = $data;
        }
        
        return $this->data ? true : false;
    } // end checkValidParsedInfo
    
    protected function prepare(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl)
    {
        $this->request = $request;
        $this->curl    = $rollingCurl;
        
        $this->idPack = $this->option('pack');
    } // end prepare
    
    protected function after() 
    {
        $idPack = $this->idPack;
        if (!$idPack) {
            return false;
        }
        
        $currentHash = md5($this->url);
        $parserType = $this->type;
        
        $prePath = 'data.'. $currentHash .'.parsers.'. $parserType .'.';
        $pack = Pack::where('_id', $idPack)->update([
            $prePath .'data' => $this->getData(),
            $prePath .'finished_at' => time(),
            $prePath .'status' => 'complete',
        ]);
        
        return;
        //
        
        $response = $this->getData();
        //DB::transaction(function() use($idPack, $currentHash, $parserType, $response) {
            $pack = Pack::find($idPack);
            $data = $pack->getData();
            $isComplete = true;
            foreach ($data as $hash => &$info) {
                if ($currentHash == $hash) {
                    $isUrlComplete = true;
                    foreach ($info['parsers'] as $type => &$parser) {
                        if ($parserType == $type) {
                            $parser['status'] = 'complete';
                            $parser['data'] = $response;
                            $parser['finished_at'] = time();
                        }

                        $isUrlComplete = $isUrlComplete && $parser['status'] == 'complete';
                    }
                    if ($isUrlComplete) {
                        $info['status'] = 'complete';
                    }
                }
                $isComplete = $isComplete && $info['status'] == 'complete';
            }
            
            if ($isComplete) {
                $pack->status = 'complete';
                $pack->finished_at = time();
            }
            $pack->data = $data;
            $pack->save();
        //});
    } // end after
    
    protected function exec() 
    {
        throw new \Exception('Method [exec] not implemented.');
    } // end exec
    
    protected function getData()
    { 
        return $this->data;
    } // end getData
    
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
