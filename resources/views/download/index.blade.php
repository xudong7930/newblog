<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>newblog</title>
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form method="POST" action="{{route('download.run')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Download Links</label>
                        <textarea name="links" class="form-control" rows="10" required></textarea>
                        <p class="help-block">一行一个下载地址</p>
                    </div>
                    <button type="submit" class="btn btn-primary">download youtube</button>
                </form>
            </div>
        </div>
    </body>
</html>
