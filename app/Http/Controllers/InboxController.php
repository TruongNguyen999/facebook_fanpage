<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Facebook\Facebook;

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
        Session::put('id_fanpage', $id);
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

    public function postInbox(Request $request)
    {
        $id = $request->id;
        $value = $request->valueSend;

        $access_token = Session::get('access_token_fanpage');
        $id_fanpage = Session::get('id_fanpage');

        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        $param = array(
            "recipient" => array("id" => $id),
            "message" => array("text" => $value)
        );

        try {
            $fb->post($id_fanpage."/messages",$param,$access_token);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return redirect('success')->with('success', 'Bạn đã trả lời inbox khách hàng thành công.');
    }
}
