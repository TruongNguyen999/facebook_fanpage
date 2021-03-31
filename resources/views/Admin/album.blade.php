@extends('Admin.layout.main')
@section('content')
<div style="width: 100%;height:631px">
    <div style="width: 100%;height:100%; overflow-y:auto">
        <div style="display: flex; flex-direction:row;flex-wrap: wrap;align-items: flex-start;" id="img-opacity">
            @if(isset($data))
            @foreach($data as $image)
            @if(isset($image['attachments']['data'][0]['subattachments']))
            @foreach($image['attachments']['data'][0]['subattachments']['data'] as $img)
            <button data-url="{{url('/detail_album/' .$image['id'])}}" class="detail_album" style="border: none; outline: none; background: none;">
                <img src="{{$img['media']['image']['src']}}" height="220px" width="350px" style="margin: 10px;border: 3px solid #000; box-shadow: 3px 3px 8px 0px rgba(0,0,0,0.3); " alt="">
            </button>
            @endforeach
            @else
            @if(isset($image['attachments']['data'][0]['media']))
            <button data-url="{{url('/detail_album/' .$image['id'])}}" class="detail_album" style="border: none; outline: none; background: none;">
                <img src="{{$image['attachments']['data'][0]['media']['image']['src']}}" height="220px" width="350px" style="margin: 10px;border: 3px solid #000; box-shadow: 3px 3px 8px 0px rgba(0,0,0,0.3); " alt="">
            </button>
            @endif
            @endif
            @endforeach
            @endif
        </div>
        <div id="model_img_display" onclick="display_album()" style="position: fixed;left: 0;top: 0;width: 100%;height: 100%;display:none">
            <div id="model_img" style="position: absolute;background-position: center;object-fit: cover;top: 50%;left: 50%;transform: translate(-50%, -50%);width: 600px;height: 400px">
            </div>
        </div>
    </div>
</div>
@endsection
