<?php

namespace App\Console\Parsers;

use App\Models\PageLink;
use App\Models\SitePhrase;


class Pages extends AbstractParser
{

    public $type = 'pages';
    protected $signature = 'scrape:pages {url : site url} {options : options list} {--pack= : pack id}';
    protected $description = 'advertising-useful-donate-blog-guest';
    
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        $types = explode('-', $this->argument('options'));
        
        foreach ($types as $type) {
            $this->onType($type);
        }
    } // end exec
    
    private function onType($type)
    {
        $phrases = PageLink::type($type)->get();
        $id_type = PageLink::getTypeID($type);
        $found = array();
        $parse_url = parse_url($this->url);

        foreach ($phrases as $p) {
            $phrase = $p['phrase'];

            if ($p['anchor']) {
                $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>{$phrase}(!|)<\/a>";
                $res_by_phrase = $this->findByPhrase($regexp, 2);
                if ($res_by_phrase) {
                    $url = $this->getFullUrlByPart($res_by_phrase, $parse_url);
                    $found[$id_type][] = mb_strtolower($url, "utf-8");
                }
            }

            if ($p['url']) {
                //$regexp = "href=\"(.*?{$phrase}(\/|))\"";
                $phrase = addcslashes($phrase, "/");
                $regexp = "href=\"(\S*{$phrase}(\/|))\"";
                $res_by_phrase = $this->findByPhrase($regexp, 1);
                if ($res_by_phrase) {                                    
                    $url = $this->getFullUrlByPart($res_by_phrase, $parse_url);                                    
                    $found[$id_type][] = mb_strtolower($url, "utf-8");
                }
            }

            if ($p['content']) {
                $regexp = "{$phrase}";
                $res_by_phrase = $this->findByPhrase($regexp, 0);
                if ($res_by_phrase) {
                    $found[$id_type][] = $res_by_phrase;
                } 
            }
        }


        $found = array_filter($found);

        if ($found) {
            $data = [];
            foreach ($found as $idType => $value) {
                $data[] = [
                    'id_site' => $this->id,
                    'id_type_phrase' => $idType,
                    'value' => json_encode(array_values($value))
                ];
            }
            SitePhrase::where('id_site', $this->id)->delete();
            SitePhrase::insert($data);
        }
    } // end onType
    
    private function findByPhrase($regexp, $order) 
    {
        $result = "";
    
        if (preg_match("/$regexp/U", $this->request->getResponseText(), $matches)) {
            $result = $matches[$order];
        }
        
        return $result;
    } // end 
    
    private function getFullUrlByPart($res_by_phrase, $parse_url) 
    {
        $parse_contact_url = parse_url($res_by_phrase);
    
        $search_remove = array('..\/', '\/\/');
        if (count($search_remove)) {
            foreach ($search_remove as $s) {
                if (preg_match("/^{$s}/", $res_by_phrase)) {
                    $res_by_phrase = preg_replace("/^{$s}/", "", $res_by_phrase);
                }
            }
        }  
    
        //check full link for contact page
        if (isset($parse_contact_url['host']) && ($parse_contact_url['host'] == $parse_url['host'])) {
            //get full page's link
            $url = $res_by_phrase;
        } else {
            //concat full link from short page's link
            $slash = (((substr($parse_url['host'], -1) != "/") && (substr($res_by_phrase, 0, 1) != "/")) ? "/" : "");
    
            if (!empty($parse_url['scheme'])) {
                $url = (strpos($res_by_phrase, '://') ? trim($res_by_phrase, "'") : "{$parse_url['scheme']}://{$parse_url['host']}{$slash}{$res_by_phrase}");
            } else {
                //$url = (strpos($res_by_phrase, '://') ? $res_by_phrase : ($request->getUrl() . $res_by_phrase));
                if (strpos($res_by_phrase, '://')) {
                    $url = $res_by_phrase;
                }
                else {
                    $first = rtrim( preg_replace('#^(.*?//.*?/).*$#', "\\1", $this->request->getUrl()), "/" );
                    $second = ltrim( $res_by_phrase, "/" );
                    $url = "{$first}/{$second}";
                }
            }
        }
        
        return $url;
    }
    
}
    