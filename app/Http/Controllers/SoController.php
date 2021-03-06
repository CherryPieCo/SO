<?php

namespace App\Http\Controllers;

use Input;
use Sentinel;
use Excel;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Models\Pack;
use App\Models\RequestLog;


class SoController extends Controller
{
    
    public function showBulk()
    {
        $bulks = Pack::byUser()
                     ->select('title', 'type', 'status', 'count', 'created_at')
                     ->orderBy('_id', 'desc')
                     ->paginate((int) session('bulks-per-page', 20));


        return view('so.bulk', compact('bulks'));
    } // end showBulk
    
    public function setBulksPerPageCount(Request $request)
    {
        session(['bulks-per-page' => $request->get('per_page')]);
        
        return response()->json([
            'status' => true
        ]);
    } // end setBulksPerPageCount
    
    public function showBulkProfiler($idPack)
    {
        $pack = Pack::byUser()->where('_id', $idPack)->first();

        return view('so.bulk_profiler', compact('pack'));
    } // end showBulkProfiler
    
    public function showApi()
    {
        $token = Sentinel::getUser()->token;
        $stats = RequestLog::getUserMonthStatisticsByDate();
        
        return view('so.api', compact('token', 'stats'));
    } // end showApi
    
    public function removeBulk(Request $request)
    {
        // TODO: remove from queue
        Pack::byUser()->where('_id', $request->get('id'))->delete();
        
        return response()->json([
            'status' => true
        ]);
    } // end removeBulk
    
    public function createBulk(Request $request)
    {
        $error = '';
        if (!Sentinel::getUser()->isCampaignAllowed($request->get('type'), $error)) {
            return response()->json([
                'status' => true,
                'error'  => $error
            ]);
        }
        
        $data = [];
        $parsers = Pack::getParsersByType(
            $request->get('type'), 
            array_unique(array_filter(explode(',', $request->get('options'))))
        );
        
        $urls = $this->getUrls($request);
        foreach ($urls as $url) {
            $url = trim($url);
            if (!$url) {
                continue;
            }
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
        
        // XXX:
        if ($request->get('type') == 'backlinks' && count($urls) > 100) {
            return response()->json([
                'status' => false,
                'error'  => 'Exceeded limit of 100 sites per request: '. count($urls)
            ]);
        }
        if (!Sentinel::getUser()->isSuperuser() && count($urls) > 500) {
            return response()->json([
                'status' => false,
                'error'  => 'Exceeded limit of 500 sites per request: '. count($urls)
            ]);
        }
        if (!$urls || !$parsers) {
            return response()->json([
                'status' => false,
                'error'  => 'There is no sites'
            ]);
        }
        
        $id = Pack::insertGetId([
            'data'       => $data,
            'status'     => 'pending',
            'id_user'    => Sentinel::getUser()->id,
            'type'       => $request->get('type', ''),
            'title'      => $request->get('title', ''),
            'count'      => [
                'complete' => 0,
                'total'    => count($data),
            ],
            'created_at' => time(),
        ]);
        
        $pattern = 'php '. base_path() .'/artisan packs:start %s > /dev/null 2>/dev/null &';
        shell_exec(sprintf($pattern, $id->__toString()));
        
        return response()->json([
            'status' => true,
            'id'     => $id->__toString(),
            'title'  => $request->get('title', ''),
            'type'   => $request->get('type', ''),
            'count'  => count($urls),
        ]);
    } // end createBulk
    
    private function getUrls(Request $request)
    {
        $urls = explode("\n", $request->get('urls'));
        
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
        if (Input::has('dr')) {
            dr($pack->getAttributes());
        }
        
        if (!$pack || !$pack->isComplete()) {
            abort(404);
        }
        
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
                    $excel->sheet('Backlinks', function($sheet) use($pack) {
                        $sheet->cells('A1:B1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray(
                            $pack->getBacklinksForXls(Input::get('type', 'all')), 
                            null, 
                            'A1', 
                            false, 
                            false
                        );
                    });
                    break;
                case Pack::MOZ_TYPE:
                    $excel->sheet('Moz & Alexa', function($sheet) use($pack) {
                        $sheet->cells('A1:E1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getMozAlexaForXls(), null, 'A1', false, false);
                    });
                    break;
                case Pack::ADVANCED_EMAILS_TYPE:
                    $excel->sheet('Email', function($sheet) use($pack) {
                        $sheet->cells('A1:G1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getAdvancedEmailsForXls(), null, 'A1', false, false);
                    });
                    $excel->sheet('Social profile', function($sheet) use($pack) {
                        $sheet->cells('A1:E1', function($cells) {
                            $cells->setFontWeight('bold');
                        });
                        $sheet->fromArray($pack->getSocialProfilesForXls(), null, 'A1', false, false);
                    });
                    break;
                default:
                    throw new \RuntimeException('Not implemented');
            }
            
        })->export('xls');
    } // end downloadBulkXls
    
    public function removeSitesFromBulk($idBulk, Request $request)
    {
        $pack = Pack::byUser()->where('_id', $idBulk)->first();
        $hashes = $request->get('hashes');
        
        $data = $pack->data;
        foreach ($data as $hash => $info) {
            if (in_array($hash, $hashes)) {
                unset($data[$hash]);
            }
        }
        $pack->data = $data;
        
        $count = $pack->getAttribute('count');
        $count['total'] = $count['total'] - count($hashes);
        $count['complete'] = $count['complete'] - count($hashes);
        $pack->setAttribute('count', $count);
        
        $pack->save();
        
        return response()->json([
            'status' => true
        ]);
    } // end removeSitesFromBulk
    
    
    
    
    
    
    
    
    
    
    
    
    
    
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