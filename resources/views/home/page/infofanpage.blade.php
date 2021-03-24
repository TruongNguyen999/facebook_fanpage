@extends('home.layout.index')
@section('content')
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr style="text-align:center;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nodeFanpage->data as $nf)
                <tr style="text-align:center;">
                    <td>{{$nf->id}}</td>
                    <td>{{$nf->name}}</td>
                    <td>{{$nf->category}}</td>
                    <td><img src="{{$nf->picture->data->url}}" alt=""></td>
                    <td><a href="{{url('/detail_fanpage/'.$nf->id)}}">Xem chi tiet</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
