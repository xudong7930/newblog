<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadTool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $link;
    public $tool = 'wget';
    public $downloadPath;

    public function __construct(array $links, string $tool = '')
    {
        $this->link = $links;
        $this->downloadPath = config('app.downpath');

        if ($tool) {
            $this->tool = $tool;
        }
    }

    public function handle()
    {
        $file = $this->downloadPath . "/down.txt";
        file_put_contents($file, implode("\r\n", $this->link));

        switch ($this->tool) {
            case 'wget':
                $this->wget();
                break;

            case 'axel':
                $this->axel();
                break;
            
            case 'yd':
                $this->youtubeVedio();
                break;

            case 'ydp':
                $this->youtubePlaylist();
                break;

            default:
                break;
        }
        unlink($file);
    }

    protected function wget()
    {
        shell_exec("wget -c -P ".$this->downloadPath." -i ". $this->downloadPath . "/down.txt");
    }
    
    // 使用axel下载
    protected function axel()
    {
        foreach ($this->link as $url) {
            shell_exec("axel -q -n 6 -o ".$this->downloadPath." ".$url);
        }
    }

    // 下载YouTube视频
    protected function youtubeVedio()
    {
        shell_exec('youtube-dl -ciwq -o "'.$this->downloadPath.'/%(title)s.%(ext)s" -a '. $this->downloadPath . "/down.txt");
    }

    // 下载YouTube播放列表
    protected function youtubePlaylist()
    {
        foreach ($this->link as $url) {
            shell_exec('youtube-dl -ciwq -o "'.$this->downloadPath.'/%(playlist)s/%(playlist_index)s_%(title)s.%(ext)s" '.$url);
        }
    }
}
