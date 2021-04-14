@extends('home.layout.index')
@section('content')
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr style="text-align:center;">
                    <th>ID</th>
                    <th>Tên Trang</th>
                    <th>Thể Loại</th>
                    <th>Hình Ảnh</th>
                    <th><i class="fas fa-edit"></i></th>
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
