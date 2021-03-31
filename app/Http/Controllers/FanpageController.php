<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Exception;
use Facebook\Facebook;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_IOFactory;
use PHPExcel;
use Illuminate\Support\Facades\Storage;

class FanpageController extends Controller
{
    public function index()
    {
        return view('login');
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
        $excel = $request->file('excel');
        $images = $request->file('images-add');

        if (isset($excel)) {
            $path = Storage::putFile('file', $request->file('excel'));
        };

        if (isset($images)) {
            $img = $images->getPathname();
        }

        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        if (isset($path)) {
            try {
                $objPHPExcel = PHPExcel_IOFactory::load(public_path('storage/app/' . $path));
                $provinceSheet = $objPHPExcel->setActiveSheetIndex(0);
                // RyjfrPvdL3S3OgPsNbR44k0ja0wxFlUWnxJWuiFi.xlsx
                // KmZYMeQPZb3DNFCNCydOaxXfUreF1LHNuX0ykgsa.xlsx
                $index = 2;
                $idExcel = array();
                $statusExcel = array();
                $linkExcel = array();

                while ($provinceSheet->getCell('A' . $index)->getValue() != '') {
                    $idExcel[] = $provinceSheet->getCell('A' . $index)->getValue();
                    $linkExcel[] = $provinceSheet->getCell('B' . $index)->getValue();
                    $statusExcel[] = $provinceSheet->getCell('C' . $index)->getValue();
                    $index++;
                }

                if (isset($img)) {
                    if (isset($fanpage)) {
                        foreach ($fanpage as $access_token) {
                            for ($i = 0; $i < count($idExcel); $i++) {

                                $param_photo = array(
                                    'message' => $statusExcel[$i],
                                    'link' => $linkExcel[$i],
                                    'source' => $fb->fileToUpload($img)
                                );

                                try {
                                    $fb->post('/me/photos', $param_photo, $access_token);
                                } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                                    echo 'Graph returned an error: ' . $e->getMessage();
                                    exit;
                                } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                    exit;
                                }
                            }
                        }
                    } else {
                        return redirect('success')->with('error', 'Bạn cần phải chọn fanpage.');
                    }
                } else {
                    if (isset($fanpage)) {
                        foreach ($fanpage as $access_token) {
                            for ($i = 0; $i < count($idExcel); $i++) {

                                $param = array(
                                    'message' => $statusExcel[$i],
                                    'link' => $linkExcel[$i]
                                );

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
                        }
                    } else {
                        return redirect('success')->with('error', 'Bạn cần phải chọn fanpage.');
                    }
                }
            } catch (\Exception $e) {
                die('Lỗi không thể đọc file "' . pathinfo($path, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
        } else {
            if (isset($status)) {
                if (isset($link)) {
                    if (isset($img)) {

                        $param_photo = array(
                            'message' => $status,
                            'link' => $link,
                            'source' => $fb->fileToUpload($images)
                        );

                        if (isset($fanpage)) {
                            foreach ($fanpage as $access_token) {
                                try {
                                    $fb->post('/me/photos', $param_photo, $access_token);
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
                    }else{
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
                    }
                } else {
                    if (isset($img)) {

                        $param_photo = array(
                            'message' => $status,
                            'source' => $fb->fileToUpload($images)
                        );

                        if (isset($fanpage)) {
                            foreach ($fanpage as $access_token) {
                                try {
                                    $fb->post('/me/photos', $param_photo, $access_token);
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
                    }else{
                        $param = array(
                            'message' => $status,
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
                }
            } else {
                return redirect('success')->with('error', 'Bạn cần phải thêm status cho bài đăng của mình. picture và link không nhất thiết phải có!');
            }
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
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
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
