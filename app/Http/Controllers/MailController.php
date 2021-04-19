<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MailController extends Controller
{
    public function getCode(Request $request)
    {
        $id =  rand(100000,999999);
        Mail::to($request->email)->send(new SendMail($id));
        Session::put('confirm',$id);
        return response()->json(['data'=>$id]);
    }
    public function getJson_admin(Request $request)
    {
        $id = Session::get("confirm");

        if($id != $request->confirm) return response()->json(["error"=>"Sai mã bảo mật"]);

        $access_token =  Session::get('fb_access_token');
        $endpointAdmin = 'me/feed?fields=from,permalink_url,created_time,status_type,full_picture,message,link,attachments&limit=100000';
        $admin_status = Http::withToken($access_token)->get('https://graph.facebook.com/' . $endpointAdmin)->json();

        return response()->json(["Admin"=>$admin_status]);
    }

    public function getJson_fanpage(Request $request)
    {
        $id = Session::get("confirm");

        if($id != $request->confirm) return response()->json(["error"=>"Sai mã bảo mật"]);

        $access_token =  Session::get('fb_access_token');
        $endpointAccess_token_fanpage = 'me/accounts?fields=access_token';
        $access_token_fanpage = Http::withToken($access_token)->get('https://graph.facebook.com/' . $endpointAccess_token_fanpage)->json();
        $endpointComment = 'me/feed?fields=comments{message,from,created_time,comments{created_time,message,from,admin_creator}},message,picture';
        $endpoint_inbox = 'me?fields=name,picture,conversations{senders,messages.limit(10){message,from,to,attachments.limit(10){file_url,name,image_data,mime_type,size,video_data,id},created_time,id,sticker,tags,shares.limit(10){description,id,link,name,template}}}';
        $arr_Comments = array();
        $arr_Inbox = array();
        foreach($access_token_fanpage['data'] as $token){
            $Comments = Http::withToken($token['access_token'])->get('https://graph.facebook.com/' . $endpointComment)->json();
            $Inbox = Http::withToken($token['access_token'])->get('https://graph.facebook.com/' . $endpoint_inbox)->json();
            $arr_Comments[] = $Comments;
            $arr_Inbox[] = $Inbox;
        }
        return response()->json(["Comment"=>$arr_Comments,"Inbox"=>$arr_Inbox]);
    }
}
