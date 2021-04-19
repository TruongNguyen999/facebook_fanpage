<?php

namespace App\Http\Controllers;
use Facebook\Facebook;
use Illuminate\Support\Facades\Session;

class LoginFacebookController extends Controller
{
    public function index(){
        return view('login.fb-callback');
    }
    public function success(){
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        $access_token =  Session::get('fb_access_token');

        try {
            $resPage = $fb->get('/me?fields=name,id,picture', $access_token);
            $resFanPage = $fb->get('/me/accounts?fields=name,id,category,picture.width(60),access_token', $access_token);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $nodePage = json_decode($resPage->getbody());
        $nodeFanpage = json_decode($resFanPage->getbody());

        $count = count($nodeFanpage->data);

        Session::put('count_fanpage',$count);
        Session::put('nodePage',$nodePage);
        Session::put('nodefanpage',$nodeFanpage);
        Session::forget('count_comment');
        Session::forget('Name_DetailFanpage');

        return view('home.page.infofanpage', compact('nodeFanpage'));
    }
    public function logout()
    {
        Session::forget('fb_access_token');
        return redirect('/')->with('notification','you are logout success');
    }
}
