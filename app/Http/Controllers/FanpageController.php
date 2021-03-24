<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Facebook\Facebook;

class FanpageController extends Controller
{
    public function index()
    {
        $response = Http::withToken('EAAEIucK7SxgBAKR9TNmalie7FDNnvZCZAqBk7fmX7yznGymYCFVa2gZCYmmKD6UkUgAvpOqWQZCUweAJSt6dZAZAES2eEd4qGdMY4v4PjKUl4ryRkIH3YmLvqmofE9jInZB10KFADig8g7brZAiZA2NPPCfqjpbdq31UDHY7EW9RGyOVVZBVjbQaZBdkxkZA2UD2WxEZD')->get('https://graph.facebook.com/me/accounts')->json();
        $data = $response['data'];
        return view('test', compact('data'));
    }
    public function detail_fanpage($id)
    {
        $access_token =  Session::get('fb_access_token');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '/feed?fields=id,picture,message,is_published,comments')->json();
        $resName = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id)->json();

        $data = $res['data'];
        $count = count($res['data']);

        Session::put('count_comment', $count);
        Session::put('Name_DetailFanpage', $resName['name']);

        return view('home.page.detail_fanpage', compact('data'));
    }
    public function poststatus(Request $request)
    {
        $status = $request->status;
        $fanpage = $request->fanpage;
        $link = $request->link;

        $fb = new Facebook([
            'app_id' => '291068905736984',
            'app_secret' => '6e16c113b403044180cd88649dc7473e',
            'default_graph_version' => 'v2.10',
        ]);

        if (isset($status)) {
            if (isset($link)) {
                $param = array(
                    'message' => $status,
                    'link' => $link
                );

                if (isset($fanpage)) {
                    foreach ($fanpage as $access_token) {
                        try {
                            $fb->post('/me/feed', $param, $access_token);
                        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                            echo 'Graph returned an error: ' . $e->getMessage();
                            exit;
                        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                            echo 'Facebook SDK returned an error: ' . $e->getMessage();
                            exit;
                        }
                    }
                } else {
                    return redirect('success')->with('error', 'Bạn cần phải chọn fanpage.');
                }
            } else {
                $param = array(
                    'message' => $status
                );

                if (isset($fanpage)) {
                    foreach ($fanpage as $access_token) {
                        try {
                            $fb->post('/me/feed', $param, $access_token);
                        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                            echo 'Graph returned an error: ' . $e->getMessage();
                            exit;
                        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                            echo 'Facebook SDK returned an error: ' . $e->getMessage();
                            exit;
                        }
                    }
                } else {
                    return redirect('success')->with('error', 'Bạn cần phải chọn fanpage.');
                }
            }
        } else {
            return redirect('success')->with('error', 'Bạn cần phải thêm status cho bài đăng của mình. picture và link không nhất thiết phải có!');
        }

        return redirect('success')->with('success', 'Bạn đã đăng bài thành công.');
    }
    public function edit($id)
    {
        $access_token =  Session::get('fb_access_token');
        $getEdit = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=id,picture,message,comments,is_published')->json();
        return response()->json(['data' => $getEdit]);
    }
    public function edit_post(Request $request)
    {
        $status = $request->statusEdit;
        $id = $request->id;
        $link = $request->linkEdit;

        $access_token =  Session::get('fb_access_token');

        $fb = new Facebook([
            'app_id' => '291068905736984',
            'app_secret' => '6e16c113b403044180cd88649dc7473e',
            'default_graph_version' => 'v2.10',
        ]);

        if (isset($status)) {
            if (isset($link)) {
                $param = array(
                    'message' => $status,
                    'link' => $link
                );

                try {
                    $fb->post($id, $param, $access_token);
                } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            } else {
                $param = array(
                    'message' => $status
                );

                try {
                    $fb->post($id, $param, $access_token);
                } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            }
        } else {
            return redirect('success')->with('error', 'Bạn cần phải thêm status cho bài đăng của mình. picture và link không nhất thiết phải có!');
        }

        return redirect('success')->with('success', 'Bạn đã sửa bài thành công.');
    }

}
