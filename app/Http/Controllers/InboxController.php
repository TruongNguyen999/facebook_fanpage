<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InboxController extends Controller
{
    public function inbox($id)
    {
        $access_token =  Session::get('fb_access_token');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=access_token')->json();
        $endpoint = '?fields=name,picture,conversations{senders,messages.limit(10){message,from,to,attachments.limit(10){file_url,name,image_data,mime_type,size,video_data,id},created_time,id,sticker,tags,shares.limit(10){description,id,link,name,template}}}';
        $Fanpage = Http::withToken($res['access_token'])->get('https://graph.facebook.com/' . $id . $endpoint)->json();

        $name = $Fanpage['name'];
        $img = $Fanpage['picture']['data']['url'];
        $inforCustomer = $Fanpage['conversations']['data'];

        Session::put('access_token_fanpage', $res['access_token']);
        Session::put('name', $name);
        Session::put('img', $img);
        Session::put('inforCustomer', $inforCustomer);

        return view('inbox.index',compact('inforCustomer'));
    }

    public function detail_inbox($id)
    {
        $access_token = Session::get('access_token_fanpage');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=senders,wallpaper,messages.limit(10){created_time,from,id,message,to,attachments}')->json();

        $mess = $res['messages'];
        $sender = $res['senders'];

        return view('inbox.index',compact('mess', 'sender'));
    }
}
