@extends('app')

@section('content')

<table class="table table-hover">
    <thead>
        <th>#</th>
        <th>文件名称</th>
        <th>日期</th>
        <th>大小</th>
        <th>操作</th>
    </thead>
    <tbody>
        @foreach ($assets as $item)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>
                @if ($item['type'] == 'folder')
                    <a href="#">{{ $item['title'] }}</a>
                @else
                    {{ $item['title'] }}
                @endif
                <div>
                    <a href="{{ config('app.url').'/'.$item['title'] }}">{{ config('app.url').'/'.$item['title'] }}</a>
                </div>
            </td>
            <td>{{ $item['date'] }}</td>
            <td>{{ $item['size'] }}</td>
            <td>
                <form id="file-{{ $loop->index + 1 }}" action="{{route('file.destroy', $item['title'])}}" method="POST" class="hide">{{ csrf_field() }} {{ method_field('DELETE') }}</form>
                <a href="#" onclick="document.getElementById('file-{{ $loop->index + 1 }}').submit()">移除</a>   
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop