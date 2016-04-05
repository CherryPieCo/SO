<?php

namespace App\Http\Controllers;

use Input;
use Sentinel;
use Excel;
use JWTAuth;
use App\Models\Url;
use App\Models\Pack;


class SoController extends Controller
{
    
    public function showBulk()
    {
        $bulks = Pack::byUser()->paginate(1);

        return view('so.bulk', compact('bulks'));
    } // end showBulk
    
    public function showApi()
    {
        $token = JWTAuth::fromUser(Sentinel::getUser());
        
        return view('so.api', compact('token'));
    } // end showApi
    
    public function createBulk()
    {
        $data = [];
        $parsers = Pack::getParsersByType(Input::get('type'));
        
        $urls = $this->getUrls();
        foreach ($urls as $url) {
            $url = trim($url);
            if (!parse_url($url, PHP_URL_SCHEME)) {
                $url = 'http://'. $url;
            }
             
            $hash = md5($url);
            $data[$hash] = [
                'url' => $url,
                'parsers' => $parsers,
                'status'  => 'pending',
                'message' => '',
            ];
        }
        
        if (!$urls || !$parsers) {
            return response()->json([
                'status' => false,
            ]);
        }
        
        $id = Pack::insertGetId([
            'data'       => $data,
            'status'     => 'pending',
            'id_user'    => Sentinel::getUser()->id,
            'type'       => Input::get('type', ''),
            'title'      => Input::get('title', ''),
            'created_at' => time(),
        ]);
        
        $pattern = 'php '. base_path() .'/artisan packs:start %s > /dev/null 2>/dev/null &';
        shell_exec(sprintf($pattern, $id->__toString()));
        
        return response()->json([
            'status' => true,
            'id_pack' => $id->__toString(),
        ]);
    } // end createBulk
    
    private function getUrls()
    {
        $urls = explode("\n", Input::get('urls'));
        
        if (Input::hasFile('file')) {
            $file = Input::file('file');
            //$file = $file->move(storage_path('files'));
            $path = $file->getRealPath();
            $fileUrls = explode("\n", file_get_contents($path));
            
            $urls = array_merge($urls, $fileUrls);
        }
        
        $urls = array_filter(array_unique($urls));
        
        return $urls;
    } // end getUrls
    
    public function downloadBulkXls($id)
    {
        $pack = Pack::byUser()->where('_id', $id)->first();
        $title = urlify($pack->title) .'_'. date('Y-m-d', $pack->created_at);
        
        Excel::create($title, function($excel) use($pack) {
            
            switch ($pack->type) {
                case Pack::EMAILS_TYPE:
                    $excel->sheet('Email', function($sheet) use($pack) {
                        $sheet->cells('A1:C1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getEmailsForXls(), null, 'A1', false, false);
                    });
                    break;
                case Pack::NOT_FOUND_TYPE:
                    $excel->sheet('Email', function($sheet) use($pack) {
                        $sheet->cells('A1:C1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getEmailsForXls(), null, 'A1', false, false);
                    });
                    $excel->sheet('Broken link', function($sheet) use($pack) {
                        $sheet->cells('A1:B1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getBrokenLinksForXls(), null, 'A1', false, false);
                    });
                    break;
                case Pack::BACKLINKS_TYPE:
                    throw new \Exception("not implemented yet");
            }
            
        })->export('xls');
    } // end downloadBulkXls
    
    
    
    
    
    
    
    
    
    public function getPackInfo()
    {
        $pack = Pack::find(Input::get('id'));
        
        return response()->json([
            'is_complete'  => $pack->isComplete(),
            'info'         => print_r($pack->getAttributes(), true),
        ]);
    } // end getPackInfo
    
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
                'status'  => 'pending',
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
            'id_user'    => Sentinel::getUser()->id,
            'type'       => '',
            'title'      => '',
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