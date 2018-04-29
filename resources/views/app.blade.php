<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>newblog</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="http://45.32.77.118/youtube/fontawesome470/css/font-awesome.min.css">
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</head>

<body>
    @include('partials.header')
    @if( $flash = session('message'))
        <div class="alert alert-danger">
            {{ $flash }}
        </div>
    @endif
    <main role="main" class="container">
        <div class="row">
            @yield('content')
            @include('partials.sidebar')
        </div>
    </main>
    @include('partials.footer')
</body>
</html>
