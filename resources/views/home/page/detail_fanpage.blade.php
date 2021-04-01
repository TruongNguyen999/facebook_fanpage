@extends('home.layout.index')
@section('content')
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr style="text-align:center;">
                    <!-- <th>ID</th> -->
                    <th>Image</th>
                    <th>Message</th>
                    <th>Comments/Created_time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $detail)
                <tr>
                    <!-- <td style="line-height: 5;">{{$detail['id']}}</td> -->
                    <td>
                        @if(isset($detail['attachments']['data'][0]['subattachments']['data']))
                        <div style="display: flex; flex-direction:row;flex-wrap: wrap;align-items: flex-start;">
                        @foreach($detail['attachments']['data'][0]['subattachments']['data'] as $img)
                            <img src="{{$img['media']['image']['src']}}" width="120px" height="100px" alt="" style="margin: 5px; box-shadow: 3px 3px 8px 0px rgba(0,0,0,0.3)"  />
                        @endforeach
                        </div>
                        @else
                        @if(isset($detail['picture']))
                        <img src="{{$detail['picture']}}" alt="" />
                        @else
                        <span class="text-danger">{{('null')}}</span>
                        @endif
                        @endif
                    </td>
                    <td>
                        @if(isset($detail['message']))
                        <span>{!! nl2br(e($detail['message'])) !!}</span>
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
                    <td>
                        <button type="button" data-url="{{url('/edit/'.$detail['id'])}}" class="btn btn-primary edit">Edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
