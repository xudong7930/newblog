<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class YoutubeDownloader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:youtube {link}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'download youtube vedio';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $link = $this->argument('link');

        // $output = "/Users/xudong7930/Desktop";
        // $filename = date('YmdHis').".file";
        // dump("wget -c -o $output/$filename $link");
        // exec("wget -c -o $output/$filename $link");
        
        $output = "/usr/local/caddy/ehd4.f3322.net/youtube";
        exec("/usr/local/bin/youtube-dl -qciw --no-playlist -o $output/\"%(title)s.%(ext)s\" $link");
    }
}
