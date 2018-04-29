@extends('app')
@section('content')
    <form method="POST" action="{{route('download.run')}}">
        {{ csrf_field() }}
        <div class="checkbox">
            <label>下载工具</label>
            <div>
                <div class="radio-inline">
                    <label><input type="radio" name="tool" value="yd" checked="true"> youtube-dl</label></div>

                <div class="radio-inline">
                    <label><input type="radio" name="tool" value="ydp"> youtube-dl-playlist</label></div>

                <div class="radio-inline">
                    <label><input type="radio" name="tool" value="wget"> Wgets </label></div>

                <div class="radio-inline">
                    <label><input type="radio" name="tool" value="axel"> Axel </label></div></div>
            </div>
        </div>
        <div class="form-group">
            <label>下载地址</label>
            <textarea name="links" class="form-control" style="font-size: 140%" rows="10" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">开始下载</button>
    </form>    
@stop