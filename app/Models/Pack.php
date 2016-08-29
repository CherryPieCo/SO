<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Sentinel;


class Pack extends Eloquent
{
    
    const EMAILS_TYPE    = 'emails';
    const NOT_FOUND_TYPE = 'not_found';
    const BACKLINKS_TYPE = 'backlinks';
    const MOZ_TYPE       = 'moz';
    
    
    protected $collection = 'packs';
    protected $connection = 'mongodb';
    public $timestamps = false;
    
    
    public function getData()
    {
        return $this->data;
    } // end getData
    
    public function isBacklinksType()
    {
        return $this->type == self::BACKLINKS_TYPE;
    } // end isBacklinksType
    
    public function isEmailsType()
    {
        return $this->type == self::EMAILS_TYPE;
    } // end isEmailsType
    
    public function getCompletedUrlsCount()
    {
        // FIXME:
        return isset($this->count['complete']) ? $this->count['complete'] : 0;
        
        $count = 0;
        foreach ($this->data as $info) {
            if (isset($info['status']) && $info['status'] == 'complete') {
                $count++;
            }
        }
        
        return $count;
    } // end getCompletedUrlsCount
    
    public function getUrlsCount()
    {
        return $this->count['total'];
    } // end getUrlsCount
    
    public function isComplete()
    {
        return isset($this->status) && $this->status == 'complete';
    } // end isComplete
    
    public function scopeByUser($query, $idUser = false)
    {
        $idUser = $idUser ?: Sentinel::getUser()->id;
        
        return $query->where('id_user', $idUser); // (int) 
    } // end byUser
    
    public function scopeComplete($query, $idPack, $hash, $parserType, $data)
    {
        $prePath = 'data.'. $hash .'.parsers.'. $parserType .'.';
        
        $query->where('_id', $idPack)->increment('count.complete');
        
        $result = $query->where('_id', $idPack)->update([
            $prePath .'data' => $data,
            $prePath .'finished_at' => time(),
            $prePath .'status' => 'complete',
        ]);
        
        $this->recheckParsersStatus($query, $idPack, $hash);
        
        return $result;
    } // end complete
    
    public function recheckParsersStatus($query, $idPack, $hash)
    {
        $class = __CLASS__;
        
        $entity = $class::where('_id', $idPack)->first();
        $info = $entity->data[$hash];
        
        $isCompleted = true;
        foreach ($info['parsers'] as $parser) {
            $isCompleted = $isCompleted && $parser['status'] == 'complete';
        }
        
        if (!$isCompleted) {
            return;
        }
        
        $prePath = 'data.'. $hash .'.';
        $query->where('_id', $idPack)->update([
            $prePath .'finished_at' => time(),
            $prePath .'status' => 'complete',
        ]);
        
        $this->recheckStatus($query, $idPack);
    } // end recheckParsersStatus
    
    public function recheckStatus($query, $idPack)
    {
        $class = __CLASS__;
        
        $entity = $class::where('_id', $idPack)->first();
        
        $isCompleted = true;
        foreach ($entity->data as $hash => $info) {
            $isCompleted = $isCompleted && $info['status'] == 'complete';
        }
        
        if (!$isCompleted) {
            return;
        }
        
        $query->where('_id', $idPack)->update([
            'finished_at' => time(),
            'status' => 'complete',
        ]);
    } // end recheckStatus
    
    public static function getParsersByType($type, $options = [])
    {
        $parsers = [];
        $emailsParser = [
            'status' => 'pending',
            'options' => $options,
            'message' => '',
            'created_at' => time(),
            'finished_at' => 0,
        ];
        
        switch ($type) {
            case self::EMAILS_TYPE:
                $parsers['email'] = $emailsParser;
                break;
            case self::NOT_FOUND_TYPE:
                $parsers['email'] = $emailsParser;
                $parsers['not_found'] = [
                    'status' => 'pending',
                    'options' => $options,
                    'message' => '',
                    'created_at' => time(),
                    'finished_at' => 0,
                ];
                break;
            case self::BACKLINKS_TYPE:
                $parsers['backlinks'] = [
                    'status' => 'pending',
                    'options' => $options,
                    'message' => '',
                    'created_at' => time(),
                    'finished_at' => 0,
                ];
                break;
            case self::MOZ_TYPE:
                $parsers['moz'] = [
                    'status' => 'pending',
                    'options' => $options,
                    'message' => '',
                    'created_at' => time(),
                    'finished_at' => 0,
                ];
                break;
            
            default:
                throw new \Exception("what the fuck is parser type: ". $type);
        }
        
        return $parsers;
    } // end getParsersByType
    
    public function getEmailsForXls()
    {
        $data = [
            ['Domain name', 'Url', 'E-mail']
        ];
        foreach ($this->data as $info) {
            $url = $info['url'];
            $urlInfo = parse_url($url);
            $domain = $urlInfo['scheme'] .'://'. $urlInfo['host'];
            
            $emails = [];
            if (isset($info['parsers']['email']['data']['emails'])) {
                $emails = $info['parsers']['email']['data']['emails'];
            }
            
            // show urls even if there is no result
            if (!$emails) {
                $emails[] = '';
            }
            
            foreach ($emails as $email) {
                $data[] = [
                    $domain, $url, $email
                ];
            }
        }
        
        return $data;
    } // end getEmailsForXls
    
    public function getBrokenLinksForXls()
    {
        $data = [
            ['Page URL', 'Broken Link']
        ];
        foreach ($this->data as $info) {
            $url = $info['url'];
            
            $brokenLinks = [];
            if (isset($info['parsers']['not_found']['data'])) {
                $brokenLinks = $info['parsers']['not_found']['data'];
            }
            
            // show urls even if there is no result
            if (!$brokenLinks) {
                $brokenLinks[] = '';
            }

            foreach ($brokenLinks as $link) {
                $data[] = [
                    $url, $link
                ];
            }
        }
        
        return $data;
    } // end getBrokenLinksForXls
    
    public function getBacklinksForXls($type)
    {
        $data = [
            ['Page URL', 'Backlink']
        ];
        foreach ($this->data as $info) {
            $url = $info['url'];
            
            $backlinks = [];
            if (isset($info['parsers']['backlinks']['data'])) {
                $backlinks = $info['parsers']['backlinks']['data'];
            }
            
            // show urls even if there is no result
            if (!$backlinks) {
                $backlinks['fcuk'][] = '';
            }
            
            if ($type == 'one') {
                $domains = [];
                foreach ($backlinks as $backlinkType) {
                    foreach ($backlinkType as $link) {
                        $domain = parse_url($link, PHP_URL_HOST);
                        if (array_key_exists($domain, $domains)) {
                            continue;
                        }
                        
                        $data[] = [
                            $url, $link
                        ];
                        $domains[$domain] = 'dummy';
                    }
                }
            }
            
            foreach ($backlinks as $backlinkType) {
                foreach ($backlinkType as $link) {
                    $data[] = [
                        $url, $link
                    ];
                }
            }
        }
        
        return $data;
    } // end getBacklinksForXls
    
}


