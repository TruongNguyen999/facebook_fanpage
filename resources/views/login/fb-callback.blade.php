@php
session_start();
$fb = new Facebook\Facebook([
    'app_id' => '435930977474330',
    'app_secret' => '8faf7d2190cc66e016e3c4a07ea6fd54',
    'default_graph_version' => 'v2.10',
    ]);

    $helper = $fb->getRedirectLoginHelper();

    if (isset($_GET['state'])) {
        $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    }

    try {
        $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exception\ResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exception\SDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (! isset($accessToken)) {
        if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }

    $oAuth2Client = $fb->getOAuth2Client();

    $tokenMetadata = $oAuth2Client->debugToken($accessToken);

    $tokenMetadata->validateAppId('291068905736984');
    $tokenMetadata->validateExpiration();

    if (! $accessToken->isLongLived()) {
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (Facebook\Exception\SDKException $e) {
            echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            exit;
        }
    }

    $TestSession = (string) $accessToken;

    Session::put('fb_access_token', $TestSession);

    if(isset($accessToken)){
        echo "<script>location.href='https://localhost:8081/public/success'</script>";
    }
@endphp
