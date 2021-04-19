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
// https://facebook-app01.herokuapp.com/public/success
//https://localhost:8081/public/success
// https://localhost:8081/fb-callback
class FanpageController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function detail_fanpage($id)
    {
        $access_token =  Session::get('fb_access_token');
        $res = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '/feed?fields=id,picture,message,is_published,comments,attachments{subattachments}')->json();
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

        $ListImg = Session::get('photoIdArray');
        $total_fanpage = Session::get('count_fanpage');

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

        if (isset($ListImg)) {
            if (isset($path)) {
                try {

                    $objPHPExcel = PHPExcel_IOFactory::load(base_path('storage/app/' . $path));
                    $provinceSheet = $objPHPExcel->setActiveSheetIndex(0);

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
                } catch (\Exception $e) {
                    die('Lỗi không thể đọc file "' . pathinfo($path, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                if (isset($status)) {
                    if (isset($link)) {
                        if (isset($fanpage)) {
                            foreach ($fanpage as $access_token) {
                                $arr = array();
                                foreach ($ListImg as $idpage) {
                                    if (count($idpage) == $total_fanpage) {
                                        foreach ($idpage as $k => $img) {
                                            $id_actoken = Http::withToken($access_token)->get('https://graph.facebook.com/me?fields=id')->json();
                                            if ($k == $id_actoken['id']) {
                                                array_push($arr, $img[0]);
                                            };
                                        }
                                    }
                                }

                                $params = array("message" => $status, "link" => $link);
                                for ($i = 0; $i < count($arr); $i++) {
                                    $params["attached_media"][$i] = '{"media_fbid":"' . $arr[$i] . '"}';
                                }
                                try {
                                    $fb->post("me/feed", $params, $access_token);
                                    Session::forget('photoIdArray');
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
                        if (isset($fanpage)) {
                            foreach ($fanpage as $access_token) {
                                $arr = array();
                                foreach ($ListImg as $idpage) {
                                    if (count($idpage) == $total_fanpage) {
                                        foreach ($idpage as $k => $img) {
                                            $id_actoken = Http::withToken($access_token)->get('https://graph.facebook.com/me?fields=id')->json();
                                            if ($k == $id_actoken['id']) {
                                                array_push($arr, $img[0]);
                                            };
                                        }
                                    }
                                }
                                $params = array("message" => $status);
                                for ($i = 0; $i < count($arr); $i++) {
                                    $params["attached_media"][$i] = '{"media_fbid":"' . $arr[$i] . '"}';
                                }
                                try {
                                    $fb->post("me/feed", $params, $access_token);
                                    Session::forget('photoIdArray');
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
            }
        } else {
            if (isset($path)) {
                try {

                    $objPHPExcel = PHPExcel_IOFactory::load(base_path('storage/app/' . $path));
                    $provinceSheet = $objPHPExcel->setActiveSheetIndex(0);

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
                } catch (\Exception $e) {
                    die('Lỗi không thể đọc file "' . pathinfo($path, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
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
                } else {
                    return redirect('success')->with('error', 'Bạn cần phải thêm status cho bài đăng của mình. picture và link không nhất thiết phải có!');
                }
            }
        }

        return redirect('success')->with('success', 'Bạn đã đăng bài thành công.');
    }
    public function upload(Request $request)
    {
        $access_token =  Session::get('fb_access_token');
        $token_page = Http::withToken($access_token)->get('https://graph.facebook.com/me/accounts?fields=access_token')->json();

        $files = $request->file('upload');

        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        if (isset($files)) {
            $file = $files->getPathname();
        }

        if (isset($file)) {
            $photoIdArray = array();
            foreach ($token_page['data'] as $access_token) {
                $param = array(
                    'source' => $fb->fileToUpload($file),
                    "published" => false
                );
                try {
                    $postResponse = $fb->post('/me/photos', $param, $access_token['access_token']);
                    $photoId = $postResponse->getDecodedBody();
                    if (!empty($photoId["id"])) {
                        $photoIdArray[$access_token['id']][] = $photoId["id"];
                        Session::push('photoIdArray', $photoIdArray);
                    }
                } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            }

            $output = '';
            foreach ($photoIdArray as $k => $ids) {
                if ($k == $token_page['data'][0]['id']) {
                    foreach ($ids as $id) {
                        try {
                            $res = Http::withToken($token_page['data'][0]['access_token'])->get('https://graph.facebook.com/' . $id . '?fields=picture.width(80)')->json();
                        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                            echo 'Graph returned an error: ' . $e->getMessage();
                            exit;
                        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                            echo 'Facebook SDK returned an error: ' . $e->getMessage();
                            exit;
                        }
                    }
                    $output = "<img src=" . $res['picture'] . " />";
                    echo $output;
                }
            }
        } else {
            return redirect('success')->with('error', 'Bạn cần phải chọn file để upload.');
        }
    }
    public function edit($id)
    {
        $access_token =  Session::get('fb_access_token');
        $getEdit = Http::withToken($access_token)->get('https://graph.facebook.com/' . $id . '?fields=id,picture,message,comments,is_published,attachments{subattachments}')->json();
        return response()->json(['data' => $getEdit]);
    }
    public function edit_post(Request $request)
    {
        $status = $request->statusEdit;
        $id = $request->id;

        $access_token =  Session::get('fb_access_token');

        $fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
        ]);

        if (isset($status)) {
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
        } else {
            return redirect('success')->with('error', 'Status chưa được chỉnh sửa!');
        }

        return redirect('success')->with('success', 'Bạn đã sửa bài thành công.');
    }

    public function json_export_admin()
    {
        $access_token =  Session::get('fb_access_token');
        $endpointAdmin = 'me/feed?fields=from,permalink_url,created_time,status_type,full_picture,message,link,attachments&limit=100000';
        $admin_status = Http::withToken($access_token)->get('https://graph.facebook.com/' . $endpointAdmin)->json();

        return response()->json(["Admin"=>$admin_status]);
    }

    public function json_export_fanpage()
    {
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
