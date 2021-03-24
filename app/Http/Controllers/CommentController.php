<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Facebook\Facebook;
use phpDocumentor\Reflection\DocBlock\Tags\See;

class CommentController extends Controller
{
    public function comment($id)
    {
        $access_token =  Session::get('fb_access_token');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=access_token')->json();
        $endpoint = '?fields=name,picture';
        $endpointComment = '/feed?fields=comments{message,from,created_time,comments{created_time,message,from,admin_creator}},message,picture';
        $Fanpage = Http::withToken($res['access_token'])->get('https://graph.facebook.com/' . $id . $endpoint)->json();
        $Comments = Http::withToken($res['access_token'])->get('https://graph.facebook.com/' . $id . $endpointComment)->json();

        $name = $Fanpage['name'];
        $img = $Fanpage['picture']['data']['url'];
        $total = 0;

        for ($i = 0; $i < count($Comments['data']); $i++) {
            if (isset($Comments['data'][$i]['comments'])) {
                $total += count($Comments['data'][$i]['comments']);
            }
        }

        $oke = -1;
        $i = 0;

        while ($oke === -1) {
            if (isset($Comments['data'][$i]['comments'])) {
                if (isset($Comments['data'][$i]['picture'])) {
                    $imgComment = $Comments['data'][$i]['picture'];
                };
                $mess = $Comments['data'][$i]['message'];
                $oke = 0;
            } else {
                $i++;
            }
        }

        $infComment = $Comments['data'][$i]['comments']['data'];

        Session::put('name', $name);
        Session::put('img', $img);
        Session::put('comment', $Comments);
        Session::put('total', $total);
        Session::put('token_comment', $res['access_token']);
        Session::put('id', $id);
        Session::put('defaut_Comment', $infComment[0]['id']);

        return view('comment.index', compact('infComment', 'imgComment', 'mess'));
    }
    public function detail_comment($id)
    {
        $access_token =  Session::get('token_comment');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=picture,message,comments.limit(10){comments{created_time,message,from,admin_creator},message,from,admin_creator,created_time}')->json();

        if (isset($res['picture'])) {
            $img = $res['picture'];
        } else {
            $img = '';
        }

        $mess = $res['message'];
        $comment_detail = $res['comments']['data'];

        return view('comment.index', compact('img', 'mess', 'comment_detail'));
    }
    public function postComment(Request $request)
    {
        $comment = $request->comment;
        $id = $request->id;
        $access_token =  Session::get('token_comment');
        $comment_default =  Session::get('defaut_Comment');

        $fb = new Facebook([
            'app_id' => '291068905736984',
            'app_secret' => '6e16c113b403044180cd88649dc7473e',
            'default_graph_version' => 'v2.10',
        ]);

        $param = array(
            'message' => $comment
        );

        if (isset($id)) {
            try {
                $fb->post($id . "/comments", $param, $access_token);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        } else {
            try {
                $fb->post("{{$comment_default}}./comments", $param, $access_token);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }

        return redirect('success')->with('success', 'Bạn đã trả lời comment thành công.');
    }
    public function delete_comment(Request $request)
    {
        $id = $request->id;
        $access_token =  Session::get('token_comment');

        $fb = new Facebook([
            'app_id' => '291068905736984',
            'app_secret' => '6e16c113b403044180cd88649dc7473e',
            'default_graph_version' => 'v2.10',
        ]);

        try {
            $fb->delete($id,[],$access_token);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return redirect('success')->with('success', 'Bạn đã Xóa comment thành công.');
    }
}
