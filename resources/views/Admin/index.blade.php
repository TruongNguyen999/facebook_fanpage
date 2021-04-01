@extends('Admin.layout.main')
@section('content')
<div style="width: 100%;height:631px">
    <div style="width: 100%;height:100%; overflow-y:auto">
        @foreach($data as $status)
        <div>
            <div class="row mb-2" style="margin-left:0px;margin-right:0px">
                <div style="display:flex" class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <a href="{{$status['permalink_url']}}" style="margin-right: 4px;">{{$status['from']['name']}}</a>
                    <span>
                        {{
                    $status['status_type']=='added_photos' ? 'Đã đăng ảnh lên'
                    : ($status['status_type']=='mobile_status_update' ? 'Đã chia sẻ từ điện thoại'
                    : 'Đã chia sẻ nội dung')
                        }}
                    </span>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <p style="justify-content: flex-end;">Ngày Đăng : {{$status['created_time']}}</p>
                </div>
            </div>
            <div class="row mb-2" style="margin-left:0px;margin-right:0px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <p>
                        @if(isset($status['message']))
                        {!! nl2br(e($status['message'])) !!}
                        @elseif(isset($status['attachments']['data'][0]['title']))
                        {!! nl2br(e($status['attachments']['data'][0]['title'])) !!}
                        @elseif(isset($status['attachments']['data'][0]['description']))
                        {!! nl2br(e($status['attachments']['data'][0]['description'])) !!}
                        @endif
                    </p>
                </div>
            </div>
            <div class="row" style="margin-left:0px;margin-right:0px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="justify-content: left;text-align:left">
                    @if(isset($status['attachments']['data'][0]['subattachments']['data']))
                    @foreach($status['attachments']['data'][0]['subattachments']['data'] as $img)
                            <img src="{{$img['media']['image']['src']}}" width="350px" height="300px" alt="" style="border-radius:5px; margin: 5px; box-shadow: 3px 3px 8px 0px rgba(0,0,0,0.3)"  />
                        @endforeach
                    @else
                    @if(isset($status['full_picture']))
                    <img src="{{$status['full_picture']}}" width="350px" height="300px" alt="" style="border-radius:5px;margin: 5px; box-shadow: 3px 3px 8px 0px rgba(0,0,0,0.3)" alt="">
                    @endif
                    @endif
                </div>
            </div>
            <hr class="my-4" />
        </div>
        @endforeach

    </div>
</div>
@endsection
