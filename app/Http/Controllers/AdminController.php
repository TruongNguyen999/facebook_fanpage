<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function status_admin()
    {
        $access_token =  Session::get('fb_access_token');
        $endpoint = 'me/feed?fields=from,permalink_url,created_time,status_type,full_picture,message,link,attachments&limit=100000';
        $admin_status = Http::withToken($access_token)->get('https://graph.facebook.com/' . $endpoint)->json();

        $data = $admin_status['data'];

        return view('Admin.index',compact('data'));
    }
    public function album_admin()
    {
        $access_token =  Session::get('fb_access_token');
        $endpoint = 'me/feed?fields=attachments&limit=10000000';
        $album_admin = Http::withToken($access_token)->get('https://graph.facebook.com/' . $endpoint)->json();

        $data = $album_admin['data'];

        return view('Admin.album', compact('data'));
    }
    public function detail_album($id)
    {
        $access_token =  Session::get('fb_access_token');
        $endpoint = '/attachments';
        $detail_album = Http::withToken($access_token)->get('https://graph.facebook.com/'. $id . $endpoint)->json();

        if(isset($detail_album['data'][0]['subattachments'])){
            return response()->json(['img' => $detail_album['data'][0]['subattachments']['data'][0]['media']['image']['src']]);
        }

        return response()->json(['img' => $detail_album['data'][0]['media']['image']['src']]);
    }
}
