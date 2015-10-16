<?php
include("common/functions.php");
class wechatauth {
    //高级功能-》开发者模式-》获取
    private $app_id = 'wx5f5f01b1f7070a7e';
    private $app_secret = '878b3c31a537b96faf3295f190f54732';

    public function getSignPackage($url = '') {
        session_start();
        $jsapiTicket = $this->getJsApiTicket();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        // $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if ($url == ''){
        	$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        $times = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr";

        $string = $string . '&' . "timestamp=$times&url=$url";
        // print "\"$string\"\r\n";
        $signature = sha1($string);
        // print "\"$signature\"\r\n";
        $signPackage = array(
          "appId"     => $this->app_id,
          "nonceStr"  => $nonceStr,
          "timestamp" => $times,
          "url"       => $url,
          "signature" => $signature,
          "rawString" => $string
        );
        return $signPackage;
    }

    private function getJsApiTicket() {
        if ($_SESSION['jsapi_ticket']) {
          $data = json_decode($_SESSION['jsapi_ticket']);

          if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            //$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
              $data['expire_time'] = time() + 7000;
              $data['jsapi_ticket'] = $ticket;
              $_SESSION['jsapi_ticket'] = json_encode($data);
            }
          } else {
            $ticket = $data->jsapi_ticket;
          }
        }else{
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            //$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
              $data['expire_time'] = time() + 7000;
              $data['jsapi_ticket'] = $ticket;
              $_SESSION['jsapi_ticket'] = json_encode($data);
            }
        }
        return $ticket;
    }

    private function getAccessToken() {
      $access_token = "";
      if ($_SESSION['access_token']) {
        $data = json_decode($_SESSION['access_token']);
        if ($data->expire_time < time()) {
          // 如果是企业号用以下URL获取access_token
          //$url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->app_id&corpsecret=$this->app_secret";
          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->app_id&secret=$this->app_secret";
          $res = json_decode($this->httpGet($url));
          $access_token = $res->access_token;
          if ($access_token) {
            $data['expire_time'] = time() + 7000;
            $data['access_token'] = $access_token;
            $_SESSION['access_token'] = json_encode($data);
          }
        } else {
          $access_token = $data->access_token;
        }
      }else{
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->app_id&secret=$this->app_secret";
        $res = json_decode($this->httpGet($url));
        
        $access_token = $res->access_token;
        if ($access_token) {
          $data['expire_time'] = time() + 7000;
          $data['access_token'] = $access_token;
          $_SESSION['access_token'] = json_encode($data);
        }
      }
      return $access_token;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }


    /**
     * 获取微信授权链接
     * 
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     */
    public function get_authorize_url($redirect_uri = '', $state = '')
    {
        $redirect_uri = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state={$state}#wechat_redirect";
    }
    
    /**
     * 获取授权token
     * 
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function get_access_token($app_id = '', $app_secret = '', $code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
        print $token_url;
        return $token_url;

    }
    
    /**
     * 获取授权后的微信用户信息
     * 
     * @param string $access_token
     * @param string $open_id
     */
    public function get_user_info($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
            $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->http($info_url);
            
            if($info_data[0] == 200)
            {
                return json_decode($info_data[1], TRUE);
            }
        }
        
        return FALSE;
    }
    /**
     * 验证授权
     * 
     * @param string $access_token
     * @param string $open_id
     */
    public function check_access_token($access_token = '', $open_id = '')
    {
        if($access_token && $open_id)
        {
            $info_url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->http($info_url);
            
            if($info_data[0] == 200)
            {
                return json_decode($info_data[1], TRUE);
            }
        }
        
        return FALSE;
    }
    //curl
    public function http($url, $method, $postfields = null, $headers = array(), $debug = false)
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
 
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);
 
        $response = curl_exec($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
 
        if ($debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
 
            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));
 
            echo '=====$response=====' . "\r\n";
            print_r($response);
        }
        curl_close($ci);
        return array($http_code, $response);
    }
 
 }

$Wechat = new wechatauth();
$ticket = $Wechat->getSignPackage($_GET['url']);
$str = "" . json_encode($ticket);

print $str;


// echo <<< HTML
// $str;
// wx.config({
// // debug: true,
// appId: jssdk.appId,
// timestamp: jssdk.timestamp,
// nonceStr: jssdk.nonceStr,
// signature: jssdk.signature,
//     jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','chooseImage','previewImage','uploadImage','downloadImage']
// });

// wx.ready(function () {
//     wx.onMenuShareTimeline({
//         title: descContent, 
//         link: lineLink, 
//         imgUrl: imgUrl, 
//         success: function () { 
//         	alert("share Success");
//            console.print("onMenuShareTimeline....success");
//         },
//         cancel: function () { 
//         	alert("share cancel");
//            console.print("onMenuShareTimeline....cancel");
//         }
//     });

//     wx.onMenuShareAppMessage({
//         title: sharetitle, 
//         desc: descContent,
//         link: lineLink, 
//         imgUrl: imgUrl,
//         type: 'link', 
//         dataUrl: '', 
//         success: function () { 
//         },
//         cancel: function () { 
//         }
//     });

// });
// HTML;
