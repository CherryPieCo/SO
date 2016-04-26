<?php

namespace App\Console\Parsers;


class Email extends AbstractParser
{
    public $type = 'email';
    protected $signature = 'scrape:email {url : site url} {--pack= : pack id}';
    protected $description = 'scrape:email example.com';
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        
        $response = ['email' => [], 'contacts' => []]; 
        $contactForm = "";
        $signSearch  = array(' @ ', ' at ', ' [at] ', ' (at) ', ' . ', ' dot ', ' [dot] ', ' (dot) ', '"', "'");
        $signReplace = array('@', '@', '@', '@', '.', '.', '.', '.', '', '');

        $contacts = $this->getContacts();
        $response['contacts'] = $contacts;
        if ($contacts) {
            foreach ($contacts as $c) {

                //get email from contact page if it exists
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_TIMEOUT, 4);
                //check headers
                $headers = @get_headers($c, 1) ?: [];
                $headers[0] = isset($headers[0]) ? $headers[0] : 'default';
                switch ($headers[0]) {
                    case "HTTP/1.1 301 Moved Permanently":
                        $redirectLocation = is_array($headers['Location']) ? $headers['Location'][0] : $headers['Location'];
                        curl_setopt($ch, CURLOPT_URL, $redirectLocation);
                        break;
                    default:                        
                        curl_setopt($ch, CURLOPT_URL, $c);
                        break;
                }

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);

                //curl_close($ch);
                if (preg_match("/[a-z0-9!#$%&;'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&;'*+=?^_`{|}~-]+)*( at | \(at\) | \[at\] |@| @ )(?:[a-z0-9!#$%&;'*+=?^_`{|}~-](?:[a-z0-9-!#$%&;'*+=?^_`{|}~-]*[a-z0-9!#$%&;'*+=?^_`{|}~-])?(\.| \. | dot | \(dot\) | \[dot\] ))+[a-z0-9!#$%&;'*+=?^_`{|}~-](?![png])(?:[a-z0-9-!#$%&;'*+=?^_`{|}~-]*[a-z0-9!#$%&;'*+=?^_`{|}~-])?/i", $output, $matches)) {
                    $parsedEmail = str_replace($signSearch, $signReplace, $matches[0]);
                    $parsedEmail = $this->htmlNumberEncoder($parsedEmail);
                    $parsedEmail = strtok($parsedEmail, '?');
                    $parsedEmail = (preg_match('/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/', $parsedEmail) ? $parsedEmail : null);
                    $parsedEmail = (preg_match('/\.(png)(?:[\?\#].*)?$/i', $parsedEmail) ? null : $parsedEmail);
                    $response['email'][] = $parsedEmail;
                    //$response['contact_form'] = $c;
                    //if (!empty($response['email'])) break;
                } elseif (preg_match('/<a.*?prefix=(["\'])(.*?)\1.*?href=(["\'])mailto:(.*?)\1.*/', $output, $matches)) {
                    $response['email'][] = "{$matches[2]}@{$matches[4]}";
                    //$response['contact_form'] = $c;
                    //if (!empty($response['email'])) break;
                } elseif (strpos($output,'username + "@" + hostname') !== false) {
                    $username_pattern = '/var username = "(.*?)";/';
                    $hostname_pattern = '/var hostname = "(.*?)";/';
                    if (preg_match($username_pattern, $output, $username_matches) && preg_match($hostname_pattern, $output, $hostname_matches)) {
                        $response['email'][] = "{$username_matches[1]}@{$hostname_matches[1]}";
                        //$response['contact_form'] = $c;
                        //if (!empty($response['email'])) break;
                    }
                }
            }
        } else {
            //get email from target page if contact page not exists
            if (preg_match("/[a-z0-9!#$%&;'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&;'*+=?^_`{|}~-]+)*( at | \(at\) | \[at\] |@| @ )(?:[a-z0-9!#$%&;'*+=?^_`{|}~-](?:[a-z0-9-!#$%&;'*+=?^_`{|}~-]*[a-z0-9!#$%&;'*+=?^_`{|}~-])?(\.| \. | dot | \(dot\) | \[dot\] ))+[a-z0-9!#$%&;'*+=?^_`{|}~-](?![png])(?:[a-z0-9-!#$%&;'*+=?^_`{|}~-]*[a-z0-9!#$%&;'*+=?^_`{|}~-])?/i", $this->request->getResponseText(), $matches)) {
                $parsedEmail = str_replace($signSearch, $signReplace, $matches[0]);
                $parsedEmail = $this->htmlNumberEncoder($parsedEmail);
                $parsedEmail = strtok($parsedEmail, '?');
                $parsedEmail = (preg_match('/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/', $parsedEmail) ? $parsedEmail : null);
                $parsedEmail = (preg_match('/\.(png)(?:[\?\#].*)?$/i', $parsedEmail) ? null : $parsedEmail);
                $response['email'][] = $parsedEmail;
            } elseif (preg_match('/<a.*?prefix=(["\'])(.*?)\1.*?href=(["\'])mailto:(.*?)\1.*/', $this->request->getResponseText(), $matches)) {
                $response['email'][] = "{$matches[2]}@{$matches[4]}";
            } elseif (strpos($this->request->getResponseText(),'username + "@" + hostname') !== false) {
                $username_pattern = '/var username = "(.*?)";/';
                $hostname_pattern = '/var hostname = "(.*?)";/';
                if (preg_match($username_pattern, $this->request->getResponseText(), $username_matches) && preg_match($hostname_pattern, $this->request->getResponseText(), $hostname_matches)) {
                    $response['email'][] = "{$username_matches[1]}@{$hostname_matches[1]}";
                }
            }
        }

        $emails = [];
        foreach (array_unique(array_filter($response['email'])) as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $email;
            }
        }
        
        $parsers = $this->site->parsers;
        $parsers['email'] = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
            'updated_at' => time(),
        ];
        $this->site->parsers = $parsers;
        $this->site->save();
        
        
        $this->data = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
        ];
    } // end exec
    
    private function getEmail($regexp, $order) 
    {
        $parse_url = parse_url($this->url);
        $url = "";
        
        if (preg_match("/$regexp/iU", $this->request->getResponseText(), $matches)) {
            
            $parse_contact_url = parse_url($matches[$order]);

            //check full link for contact page
            if (isset($parse_contact_url['host']) && ($parse_contact_url['host'] == $parse_url['host'])) {
                //get full page's link
                $url = $matches[$order];
            } else {
                //concat full link from short page's link
                $slash = (((substr($parse_url['host'], -1) != "/") && (substr($matches[$order], 0, 1) != "/")) ? "/" : "/");
                $matches[$order] = ltrim($matches[$order], "\.\./");
                if (!empty($parse_url['scheme'])) {
                    $url = (strpos($matches[$order], '://') ? trim($matches[$order], "'") : "{$parse_url['scheme']}://{$parse_url['host']}{$slash}{$matches[$order]}");
                } else {
                    $url = (strpos($matches[$order], '://') ? $matches[$order] : ($this->request->getUrl() . $matches[$order]));
                }
            }
            
        }
        
        $url = mb_strtolower($url, "utf-8");
        
        return $url;
    } // end getEmail
    
    private function htmlNumberEncoder($input) 
    {
        return preg_replace_callback("/(&#[0-9]+;)/", function($m) {
             return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); 
        }, $input);
    } // end htmlNumberEncoder

    private function getContacts()
    {
        $contacts = array();
    
        // FIXME:
        $phrases = \DB::table('links')->where('id_type', 1)->lists('phrase');
        if (!$phrases) {
            return false;
        }

        $contacts1 = [];
        $contacts2 = [];
        $contacts3 = [];

        foreach ($phrases as $phrase) {
            $phrase = preg_quote($phrase);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>( |){$phrase}(!| |)<\/a>";
            $contacts1[] = $this->getEmail($regexp, 2);

            $regexp = "href=\"(\S*{$phrase}(\/|))\"";                            
            $contacts2[] = $this->getEmail($regexp, 1);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*><img.*?alt=\".*?{$phrase}.*?\".*><\/a>";
            $contacts3[] = $this->getEmail($regexp, 2);
        }

        $contacts = array_merge($contacts1, $contacts2, $contacts3);
        $contacts = array_filter($contacts);
        $contacts = array_unique($contacts);
        
        return $contacts;
    } // end getContacts
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data['emails']) && !empty($this->data['emails']);
    } // end isApiRequestSuccessful
    
}
