<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Sentinel;


class Pack extends Eloquent
{
    
    const EMAILS_TYPE    = 'emails';
    const ADVANCED_EMAILS_TYPE = 'advanced_emails';
    const NOT_FOUND_TYPE = 'not_found';
    const BACKLINKS_TYPE = 'backlinks';
    const MOZ_TYPE       = 'moz';
    
    
    protected $collection = 'packs';
    protected $connection = 'mongodb';
    public $timestamps = false;
    
    private $highestAlexaRank = null;
    private $lowestAlexaRank = null;
    private $highestPda = null;
    private $lowestPda = null;
    
    
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
    
    public function isAdvancedEmailsType()
    {
        return $this->type == self::ADVANCED_EMAILS_TYPE;
    } // end isAdvancedEmailsType
    
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
    
    public function scopeComplete($query, $idPack, $hash, $parserType, $data, $title = '')
    {
        $prePath = 'data.'. $hash .'.parsers.'. $parserType .'.';
        
        $update = [
            $prePath .'data'        => $data,
            $prePath .'finished_at' => time(),
            $prePath .'status'      => 'complete',
        ];
        if ($title) {
            $update['data.'. $hash .'.title'] = $title;
        }
        
        $result = $query->where('_id', $idPack)->update($update);
        
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
        $query->where('_id', $idPack)->increment('count.complete');
        
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
        // FIXME: generate options
        $parsers = [];
        $defaultParser = [
            'status' => 'pending',
            'options' => $options,
            'message' => '',
            'created_at' => time(),
            'finished_at' => 0,
        ];
        
        switch ($type) {
            case self::EMAILS_TYPE:
                $parsers['email'] = $defaultParser;
                break;
            case self::ADVANCED_EMAILS_TYPE:
                $parsers['email'] = $defaultParser;
                $parsers['moz'] = $defaultParser;
                $parsers['alexa'] = $defaultParser;
                break;
            case self::NOT_FOUND_TYPE:
                $parsers['email'] = $defaultParser;
                $parsers['not_found'] = $defaultParser;
                break;
            case self::BACKLINKS_TYPE:
                $parsers['backlinks'] = $defaultParser;
                break;
            case self::MOZ_TYPE:
                $mozOptions = array_intersect(['page_authority', 'domain_authority'], $options);
                if ($mozOptions) {
                    $parsers['moz'] = $defaultParser;
                    $parsers['moz']['options'] = $mozOptions;
                }
                
                if (in_array('alexa', $options)) {
                    $parsers['alexa'] = $defaultParser;
                }
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
    
    public function getMozAlexaForXls()
    {
        $data = [
            ['Domain', 'Page URL', 'DA', 'PA', 'Alexa']
        ];
        foreach ($this->data as $info) {
            $data[] = [
                $this->getDomain($info['url']), 
                $info['url'], 
                array_get($info, 'parsers.moz.data.pda', '-'),
                array_get($info, 'parsers.moz.data.upa', '-'),
                array_get($info, 'parsers.alexa.data.rank', '-'),
            ];
        }
        
        return $data;
    } // end getMozAlexaForXls
    
    public function getDomain($url)
    {
        $info = parse_url($url);
        
        return $info['scheme'] .'://'. $info['host'];
    } // end getDomain
    
    public function getHighestAlexaRank()
    {
        if (!is_null($this->highestAlexaRank)) {
            return $this->highestAlexaRank;
        }
        
        $rank = null;
        foreach ($this->getData() as $hash => $data) {
            $alexaRank = array_get($data, 'parsers.alexa.data.rank', 0);
            if (is_null($rank) || $alexaRank > $rank) {
                $rank = $alexaRank;
            }
        }
        
        $this->highestAlexaRank = $rank;
        
        return $rank;
    } // end getHighestAlexaRank
    
    public function getLowestAlexaRank()
    {
        if (!is_null($this->lowestAlexaRank)) {
            return $this->lowestAlexaRank;
        }
        
        $rank = null;
        foreach ($this->getData() as $hash => $data) {
            $alexaRank = array_get($data, 'parsers.alexa.data.rank', 0);
            if (is_null($rank) || $alexaRank < $rank) {
                $rank = $alexaRank;
            }
        }
        
        $this->lowestAlexaRank = $rank;
        
        return (int) $rank;
    } // end getLowestAlexaRank
    
    public function getLowestPda()
    {
        if (!is_null($this->lowestPda)) {
            return $this->lowestPda;
        }
        
        $result = null;
        foreach ($this->getData() as $hash => $data) {
            $pda = array_get($data, 'parsers.moz.data.pda', 0);
            if (is_null($result) || $pda < $result) {
                $result = $pda;
            }
        }
        
        $this->lowestPda = $result;
        
        return (float) $result;
    } // end getLowestPda
    
    public function getHighestPda()
    {
        if (!is_null($this->highestPda)) {
            return $this->highestPda;
        }
        
        $result = null;
        foreach ($this->getData() as $hash => $data) {
            $pda = array_get($data, 'parsers.moz.data.pda', 0);
            if (is_null($result) || $pda > $result) {
                $result = $pda;
            }
        }
        
        $this->highestPda = $result;
        
        return (float) $result;
    } // end getHighestPda
    
    public function getTlds()
    {
        $newData = [];
        
        $tlds = [];
        foreach ($this->data as $hash => $data) {
            preg_match('~([^\.]+)$~', $this->getDomain($data['url']), $matches);
            $data['tld'] = $matches[1];
            $tlds[] = $matches[1];
            
            $newData[$hash] = $data;
        }
        
        $this->data = $newData;
        
        return array_unique($tlds);
    } // end getTlds
    
}


