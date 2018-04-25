<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DownloadController extends Controller
{
    public function show()
    {
        return view('download.index');
    }

    public function run(Request $request)
    {
        $links = explode("\r\n", $request->links);
        foreach ($links as $link) {
            Artisan::call('download:youtube', [
                'link' => $link
            ]);
        }
        dump('done');
    }
}
