@extends('comment.layout.main')
@section('content')
<div class="chat" style="width: 75%; height: 550px; background: #343a40; color: white">
    <div class="chat-header clearfix">
        @if(isset($img))
        <img src="{{$img}}" width="55px" height="55px" style="border-radius: 50%;" alt="avatar" />
        @else
        <img src="{{$imgComment}}" width="55px" height="55px" style="border-radius: 50%;" alt="avatar" />
        @endif
        <div class="chat-about">
            <div class="chat-with" id="name-chat">
                Status bài đăng của fanpage
            </div>
            <div class="chat-num-messages" id='messages_chat'>
                @if(isset($mess))
                {{$mess}}
                @else
                {{$mess}}
                @endif
            </div>
        </div>
        <i class="fa fa-star"></i>
    </div> <!-- end chat-header -->
    <div class="chat-history" style="height: 453px;border-bottom:none">
        <ul id="list_chat">
            @if(isset($comment_detail))
            @foreach($comment_detail as $inf)
            <li class="clearfix" style="list-style: none;margin-bottom: 30px">
                <div class="message my-message" style="margin-bottom: 0px;background:#414640">
                    @if(isset($inf['from']))
                    <img height="12" alt="" class="cgat1ltu cogppd1a" referrerpolicy="origin-when-cross-origin" src="https://static.xx.fbcdn.net/rsrc.php/v3/yw/r/8iuTX4LlGZO.png">
                    <a href="" style="color: white">Tác giả</a><br />
                    <a href="" style="color: white">{{$inf['from']['name']}}</a><br />
                    <span>{{$inf['message']}}</span>
                    @else
                    <span>{{$inf['message']}}</span>
                    @endif
                </div>
                <div class="message-data">
                    @if(isset($inf['from']))
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Người bình luận: &nbsp;&nbsp;&nbsp; {{$inf['admin_creator']['name']}}</span>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @else
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Nhắn tin</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @endif
                </div>
            </li>
            @if(isset($inf['comments']))
            @foreach($inf['comments']['data'] as $inf)
            <li class="clearfix" style="list-style: none; margin-left: 50px; margin-bottom: 30px">
                <div class="message my-message" style="margin-bottom: 0px;background:#414640">
                    @if(isset($inf['from']))
                    <img height="12" alt="" class="cgat1ltu cogppd1a" referrerpolicy="origin-when-cross-origin" src="https://static.xx.fbcdn.net/rsrc.php/v3/yw/r/8iuTX4LlGZO.png">
                    <a href="" style="color: white">Tác giả</a><br />
                    <a href="" style="color: white">{{$inf['from']['name']}}</a><br />
                    <span>{{$inf['message']}}</span>
                    @else
                    <span>{{$inf['message']}}</span>
                    @endif
                </div>
                <div class="message-data">
                    @if(isset($inf['from']) && isset($inf['admin_creator']))
                    <span class="message-data-name" style="display: flex;">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Người bình luận: &nbsp;&nbsp;&nbsp; {{$inf['admin_creator']['name']}}</span>&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @else
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Nhắn tin</span> &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @endif
                </div>
            </li>
            @endforeach
            @endif
            <li class="clearfix" id="{{$inf['id']}}" style="list-style: none; margin-left: 50px; margin-bottom: 30px">
                <form action="{{url('/postComment')}}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; width: max-content; background:#bdd6b1;padding:7px;border-radius:20px; background:#0000009e">
                        <input name="comment" type="text" style="margin-right:5px;border: none;outline:none;background:none;color:black" placeholder='gửi tin nhắn ...'>
                        <input name="id" style="display: none;" value="{{$inf['id']}}" />
                        <span href="" style="margin-right: 5px;"><img src="img/smiling.png" alt="Chèn một biểu tượng cảm xúc"></span>
                        <span href="" style="margin-right: 5px;"><img src="img/photo-camera.png" alt="Đính kèm một ảnh hoặc video"></span>
                        <span href="" style="margin-right: 5px;"><img src="img/gif.png" alt="Bình luận bằng file GIF"></span>
                        <span href="" style="margin-right: 10px;"><img src="img/stickers.png" alt="Đăng nhãn dán"></span>
                        <button type="submit" style='font-weight: bold;background:none;border:none;color:blue'>Gửi</button>
                    </div>
                </form>
            </li>
            @endforeach
            @else
            @foreach($infComment as $inf)
            <li class="clearfix" style="list-style: none;margin-bottom: 30px">
                <div class="message my-message" style="margin-bottom: 0px;background:#414640">
                    @if(isset($inf['from']))
                    <img height="12" alt="" class="cgat1ltu cogppd1a" referrerpolicy="origin-when-cross-origin" src="https://static.xx.fbcdn.net/rsrc.php/v3/yw/r/8iuTX4LlGZO.png">
                    <a href="" style="color: white">Tác giả</a><br />
                    <a href="" style="color: white">{{$inf['from']['name']}}</a><br />
                    <span>{{$inf['message']}}</span>
                    @else
                    <span>{{$inf['message']}}</span>
                    @endif
                </div>
                <div class="message-data">
                    @if(isset($inf['from']) && isset($inf['admin_creator']))
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Người bình luận: &nbsp;&nbsp;&nbsp;{{$inf['admin_creator']['name']}}</span> &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @else
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Nhắn tin</span>&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span>&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @endif
                </div>
            </li>
            @if(isset($inf['comments']))
            @foreach($inf['comments']['data'] as $inf)
            <li class="clearfix" style="list-style: none; margin-left: 50px;margin-bottom:30px">
                <div class="message my-message" style="margin-bottom: 0px;background:#414640">
                    @if(isset($inf['from']))
                    <img height="12" alt="" class="cgat1ltu cogppd1a" referrerpolicy="origin-when-cross-origin" src="https://static.xx.fbcdn.net/rsrc.php/v3/yw/r/8iuTX4LlGZO.png">
                    <a href="" style="color: white">Tác giả</a><br />
                    <a href="" style="color: white">{{$inf['from']['name']}}</a><br />
                    <span>{{$inf['message']}}</span>
                    @else
                    <span>{{$inf['message']}}</span>
                    @endif
                </div>
                <div class="message-data">
                    @if(isset($inf['from']) && isset($inf['admin_creator']))
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Người bình luận: &nbsp;&nbsp;&nbsp;{{$inf['admin_creator']['name']}}</span> &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @else
                    <span class="message-data-name" style="display: flex">
                        <a href="">Thích</a> -
                        <a href="">Trả lời</a> -
                        <span>Nhắn tin</span> &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
                        <span>{{$inf['created_time']}}</span> &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;
                        <span>
                            <form action="{{url('/delete_comment')}}" method="POST" role="form" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="id" style="display: none;" value="{{$inf['id']}}">
                                <button type="submit" style="background: none; border:none;outline:none;color:white">Xóa</button>
                            </form>
                        </span>
                    </span>
                    @endif
                </div>
            </li>
            @endforeach
            @endif
            <li class="clearfix" id="{{$inf['id']}}" style="list-style: none; margin-left: 50px; margin-bottom: 30px">
                <form action="{{url('/postComment')}}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; width: max-content; background:#bdd6b1;padding:7px;border-radius:20px;background:#0000009e">
                        <input name="comment" type="text" style="margin-right:5px;border: none;outline:none;background:none;color:black" placeholder='gửi tin nhắn ...'>
                        <input name="id" style="display: none;" value="{{$inf['id']}}" />
                        <span href="" style="margin-right: 5px;"><img src="img/smiling.png" alt="Chèn một biểu tượng cảm xúc"></span>
                        <span href="" style="margin-right: 5px;"><img src="img/photo-camera.png" alt="Đính kèm một ảnh hoặc video"></span>
                        <span href="" style="margin-right: 5px;"><img src="img/gif.png" alt="Bình luận bằng file GIF"></span>
                        <span href="" style="margin-right: 10px;"><img src="img/stickers.png" alt="Đăng nhãn dán"></span>
                        <button type="submit" style='font-weight: bold;background:none;border:none;color:blue'>Gửi</button>
                    </div>
                </form>
            </li>
            @endforeach
            @endif
        </ul>
    </div> <!-- end chat-history -->
</div> <!-- end chat -->
@endsection
