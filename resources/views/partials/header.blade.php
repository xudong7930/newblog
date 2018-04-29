<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false"> 
                <span class="sr-only">Toggle Navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }} </a> 
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('download.queue') }}">
                    <i class="fa fa-hourglass-half" aria-hidden="true"></i> 下载队列</a></li>
                <li><a href="{{ route('download.filelist') }}">
                    <i class="fa fa-folder" aria-hidden="true"></i> 文件列表</a></li>
                <li><a href="{{ route('download.show') }}">
                    <i class="fa fa-download" aria-hidden="true"></i> 新建下载</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div>
    </div>
</nav>