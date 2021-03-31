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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="justify-content: center;text-align:center">
                    @if(isset($status['full_picture']))
                    <img src="{{$status['full_picture']}}" alt="">
                    @endif
                </div>
            </div>
            <hr />
        </div>
        @endforeach

    </div>
</div>
@endsection
