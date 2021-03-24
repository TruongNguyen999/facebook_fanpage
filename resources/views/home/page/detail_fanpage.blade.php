@extends('home.layout.index')
@section('content')
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr style="text-align:center;">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Message</th>
                    <th>Comments/Created_time</th>
                    <th>is_published</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $detail)
                <tr style="text-align:center;">
                    <td style="line-height: 5;">{{$detail['id']}}</td>
                    <td>
                        @if(isset($detail['picture']))
                                <img src="{{$detail['picture']}}" alt="" />
                            @else
                                <span class="text-danger">{{('null')}}</span>
                        @endif
                    </td>
                    <td style="line-height: 5;">
                        @if(isset($detail['message']))
                                <span>{{$detail['message']}}</span>
                            @else
                                <span class="text-danger">{{('null')}}</span>
                        @endif
                    </td>
                    <td>
                        @if(isset($detail['comments']))
                                <span>
                                    @foreach($detail['comments']['data'] as $mes)
                                        <p class="text-success">{{$mes['message']}} / {{$mes['created_time']}}</p>
                                    @endforeach
                                </span>
                            @else
                                <span class="text-danger">{{('null')}}</span>
                        @endif
                    </td>
                    <td style="line-height: 5;">{{$detail['is_published']}}</td>
                    <td style="line-height: 5;">
                        <button type="button" data-url="{{url('/edit/'.$detail['id'])}}" class="btn btn-primary edit">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
