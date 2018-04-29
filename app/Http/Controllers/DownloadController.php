<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Job;
use App\Jobs\DownloadTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{   

    public function fileDestroy($title)
    {
        $file = config('app.downpath').'/'.$title;
        if (file_exists($file)) {
            if (is_dir($file)) {
                Storage::disk('youtube')->deleteDirectory($title);
            }

            if (is_file($file)) {
                Storage::disk('youtube')->delete($title);
            }
        }
        return back();
    }
    
    public function filelist()
    {
        $assets = [];
        $files = Storage::disk('youtube')->files();
        $directories = Storage::disk('youtube')->directories();
        foreach ($directories as $dir) {
            if (in_array($dir, ['.tmp'])) {
                continue;
            }
            $assets[] = [
                'title' => $dir,
                'type' => 'folder',
                'size' => null,
                'date' => null
            ];
        }

        foreach ($files as $file) {
            if (in_array($file, ['.DS_Store', '.localized'])) {
                continue;
            }
            $filePath = config('app.downpath').'/'.$file;
            $size = Storage::disk('youtube')->size($file);
            $date = Storage::disk('youtube')->lastModified($file);
            $assets[] = [
                'title' => $file,
                'type' => 'file',
                'size' => $this->humanFileSize($size, ''),
                'date' => date('Y-m-d H:i:s', $date)
            ];
        }

        return view('download.filelist', compact('assets'));
    }
    
    // 删除队列
    public function jobDestroy(Request $request, $id)
    {
        Job::destroy($id);    
        return back();
    }
    
    // 下载队列
    public function queue()
    {
        $jobs = Job::all();
        return view('download.queue', compact('jobs'));
    }
    
    public function show()
    {
        return view('download.index');
    }

    public function run(Request $request)
    {
        $links = explode("\r\n", $request->links);
        $tool = $request->tool;

        $job = (new DownloadTool($links, $tool))
            ->delay(carbon::now()->addSeconds(10))
            ->onQueue('newblog');
        dispatch($job);
        
        return redirect()->route('download.queue')->with('succss', '已经添加到下载队列');
    }

    private function humanFileSize($size, $unit = "") {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB") {
            return number_format($size / (1 << 30), 2) . "GB";
        }

        if ((!$unit && $size >= 1 << 20) || $unit == "MB") {
            return number_format($size / (1 << 20), 2) . "MB";
        }

        if ((!$unit && $size >= 1 << 10) || $unit == "KB") {
            return number_format($size / (1 << 10), 2) . "KB";
        }

        return number_format($size) . " bytes";
    }
}
