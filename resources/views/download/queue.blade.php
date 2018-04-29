@extends('app')

@section('content')

<table class="table table-hover">
    <thead>
        <th>#</th>
        <th>队列名称</th>
        <th>Payload</th>
        <th>操作</th>
    </thead>
    <tbody>
        @foreach ($jobs as $job)
        <tr>
            <td>{{ $job->id }}</td>
            <td>{{ $job->queue }}</td>
            <td>
                @foreach ($job->somepayload() as $item2)
                    <li>{{$item2}}</li>
                @endforeach
            </td>
            <td>
                <form id="job-{{$job->id}}" action="{{route('job.destroy', $job->id)}}" method="POST" class="hide">{{ csrf_field() }} {{ method_field('DELETE') }}</form>
                <a href="#" onclick="document.getElementById('job-{{$job->id}}').submit()">移除</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop