@extends('inbox.layout.main')
@section('content')
<div class="chat" style="width: 75%; height: 550px">
    <div class="chat-header clearfix">
        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg" alt="avatar" />
        <div class="chat-about">
            <div class="chat-with" id="name-chat">
                @if(isset($sender))
                {{$sender['data'][0]['name']}}
                @else
                {{$inforCustomer[0]['senders']['data'][0]['name']}}
                @endif
            </div>
            <div class="chat-num-messages" id='messages_chat'>
                @if(isset($mess))
                {{count($mess['data'])}} tin nhắn
                @else
                {{count($inforCustomer[0]['messages']['data'])}} tin nhắn
                @endif
            </div>
        </div>
        <i class="fa fa-star"></i>
    </div> <!-- end chat-header -->
    <div class="chat-history" style="height: 350px">
        <ul id="list_chat">
            @if(isset($mess))
            @foreach(array_reverse($mess['data']) as $inf)
            <li class="clearfix" style="list-style: none;">
                @if($inf['from']['name'] == 'Đồng hồ giá rẻ' || $inf['from']['name'] == 'ThucTap_Optimus')
                <div class="message-data align-right">
                    <span class="message-data-time">
                        {{$inf['created_time']}}
                    </span> &nbsp; &nbsp;
                    <span class="message-data-name">
                        {{$inf['from']['name']}}
                    </span>
                    <i class="fa fa-circle me"></i>
                </div>
                <div class="message other-message float-right">
                    @if(isset($inf['attachments']['data'][0]))
                    <img width="50%" src="{{$inf['attachments']['data'][0]['image_data']['url']}}" alt='' />
                    @else
                    {{$inf['message']}}
                    @endif
                </div>
                @else
                <div class="message-data">
                    <span class="message-data-name">
                        <i class="fa fa-circle online"></i>
                        {{$inf['from']['name']}}
                    </span>
                    <span class="message-data-time">
                        {{$inf['created_time']}}
                    </span>
                </div>
                <div class="message my-message">
                    @if(isset($inf['attachments']['data'][0]))
                    <img src="{{$inf['attachments']['data'][0]['image_data']['url']}}" alt='' />
                    @else
                    {{$inf['message']}}
                    @endif
                </div>
                @endif
            </li>
            @endforeach
            @else
            @foreach(array_reverse($inforCustomer[0]['messages']['data']) as $inf)
            <li class="clearfix" style="list-style: none;">
                @if($inf['from']['name'] == 'Đồng hồ giá rẻ' || $inf['from']['name'] == 'ThucTap_Optimus')
                <div class="message-data align-right">
                    <span class="message-data-time">
                        {{$inf['created_time']}}
                    </span> &nbsp; &nbsp;
                    <span class="message-data-name">
                        {{$inf['from']['name']}}
                    </span>
                    <i class="fa fa-circle me"></i>
                </div>
                <div class="message other-message float-right">
                    @if(isset($inf['attachments']['data'][0]))
                    <img width="50%" src="{{$inf['attachments']['data'][0]['image_data']['url']}}" alt='' />
                    @else
                    {{$inf['message']}}
                    @endif
                </div>
                @else
                <div class="message-data">
                    <span class="message-data-name">
                        <i class="fa fa-circle online"></i>
                        {{$inf['from']['name']}}
                    </span>
                    <span class="message-data-time">
                        {{$inf['created_time']}}
                    </span>
                </div>
                <div class="message my-message">
                    @if(isset($inf['attachments']['data'][0]))
                    <img src="{{$inf['attachments']['data'][0]['image_data']['url']}}" alt='' />
                    @else
                    {{$inf['message']}}
                    @endif
                </div>
                @endif
            </li>
            @endforeach
            @endif

        </ul>
    </div> <!-- end chat-history -->
    <div class="chat-message clearfix d-flex" style="height: 130px">
        <form action="{{url('/postInbox')}}" method="POST" role="form" enctype="multipart/form-data" style="display: flex;width:100%">
            @csrf
            @if(isset($mess))
            @if($mess['data'][0]['from']['name'] == 'Đồng hồ giá rẻ' || $mess['data'][0]['from']['name'] == 'ThucTap_Optimus')
            <input type="text" name="id" style="display: none;" value="{{$mess['data'][0]['to']['data'][0]['id']}}">
            <input style="outline: none;border:none;height:60px;width:100%" name="valueSend" id="message-to-send" placeholder="Nhập tin nhắn" />
            <button type="submit">Gửi</button>
            @else
            <input type="text" name="id" style="display: none;" value="{{$mess['data'][0]['from']['id']}}">
            <input style="outline: none;border:none;height:60px;width:100%" name="valueSend" id="message-to-send" placeholder="Nhập tin nhắn" />
            <button type="submit">Gửi</button>
            @endif
            @else
            <input type="text" name="id" style="display: none;" value="{{$inforCustomer[0]['senders']['data'][0]['id']}}">
            <input style="outline: none;border:none;height:60px;width:100%" name="valueSend" id="message-to-send" placeholder="Nhập tin nhắn" />
            <button type="submit">Gửi</button>
            @endif
        </form>
    </div> <!-- end chat-message -->
</div> <!-- end chat -->
@endsection
