<?php

namespace App\Http\Controllers;

use Input;
use App\Models\Url;
use App\Models\Pack;


class DashboardController extends Controller
{
    
    public function show()
    {
        $urls = [];//Url::paginate(12);
        
        return view('dashboard.dashboard', compact('urls'));
    } // end show
    
    public function process()
    {
        $parsers = [];
        foreach (Input::get('parsers', []) as $parser => $info) {
            $parsers[$parser] = [
                'status' => 'pending',
                'options' => isset($info['options']) ? array_keys($info['options']) : [],
                'message' => '',
                'created_at' => time(),
                'finished_at' => 0,
            ];
        }
        
        $data = [];
        $urls = explode("\n", Input::get('urls'));
        $urls = array_filter(array_unique($urls));
        foreach ($urls as $url) {
            $url = trim($url);
            if (!parse_url($url, PHP_URL_SCHEME)) {
                $url = 'http://'. $url;
            }
             
            $hash = md5($url);
            $data[$hash] = [
                'url' => $url,
                'parsers' => $parsers,
                'message' => '',
            ];
        }
        
        if (!$urls || !$parsers) {
            return response()->json([
                'status' => false,
            ]);
        }
        //dr($data);
        $id = Pack::insertGetId([
            'data'       => $data,
            'status'     => 'pending',
            'created_at' => time(),
        ]);
        
        $pattern = 'php '. base_path() .'/artisan packs:start %s > /dev/null 2>/dev/null &';
        shell_exec(sprintf($pattern, $id->__toString()));
        
        return response()->json([
            'status'  => true,
            'id_pack' => $id->__toString(),
        ]);
        
        
        
        
        
        
        
        
        //
        $pattern = 'php '. base_path() .'/artisan packs:%s %s %s > /dev/null 2>/dev/null &';//
        shell_exec(sprintf($pattern, 'start', '', ''));
        //
        
        
        //$pattern = 'php '. base_path() .'/artisan scrape %s email,moz~page_authority|domain_authority,pages~advertising|useful|donate|blog|guest  2>&1 > '. base_path() .'/out-web.log';
        $pattern = 'php '. base_path() .'/artisan scrape:%s %s %s  &';//> /dev/null 2>/dev/null
        foreach ($urls as $url) {
            // FIXME:
             if (!Url::where('url', $url)->count()) {
                Url::insert([
                    'url' => $url,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            
            shell_exec(sprintf($pattern, 'email', $url, ''));
            shell_exec(sprintf($pattern, 'moz', $url, 'page_authority-domain_authority'));
            shell_exec(sprintf($pattern, 'pages', $url, 'advertising-useful-donate-blog-guest'));
        }
        
        return response()->json(compact('urls'));
    } // end 
    
}