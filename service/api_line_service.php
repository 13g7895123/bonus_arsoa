<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api_line_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
       $messages 參考 https://developers.line.biz/en/reference/messaging-api/#message-objects
       回覆訊息
       https://developers.line.biz/en/reference/messaging-api/#send-reply-message
    */
    public function reply($replyToken, $messages)
    {
        $request_api = '/bot/message/reply';
        $post_data = array(
            'replyToken' => $replyToken,
            'messages'   => $messages
        );

        return self::_api_post($request_api, $post_data);
    }
    
    
     /* 查可推送額度
     */
    public function quota()
    {
        $request_api = '/bot/message/quota';
        $quota = '';
        $quota_data = self::_api_get($request_api);
        if ($quota_data){
            $quota = $quota_data['value'];
        }
        return $quota;
    }
    
     /* 查已發訊息數
     */
    public function consumption()
    {
        $request_api = '/bot/message/quota/consumption';
        $consumption = '';
        $consumption_data = self::_api_get($request_api);
        if ($consumption_data){
            $consumption = $consumption_data['totalUsage'];
        }
        return $consumption;
    }

    /* 推送訊息
     */
    public function push($to, $messages, $notificationDisabled = false)
    {
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試                              
             $to = 'U1f8c9566bd3519855409230932767d38';
        }
                   
        $request_api = '/bot/message/push';
        $post_data   = array(
            'to'       => $to,
            'messages' => $messages,
            'notificationDisabled' => $notificationDisabled
        );

        return self::_api_post($request_api, $post_data);
    }

    /* 推送-群發
     * https://developers.line.biz/en/reference/messaging-api/#send-multicast-message
     */
    public function multicast($to, $messages, $notificationDisabled = false)
    {
        $to = array_unique($to);
        if(is_array($to) && count($to) <= 150) {
            $request_api = '/bot/message/multicast';
            $post_data   = array(
                'to'       => $to,
                'messages' => $messages,
                'notificationDisabled' => $notificationDisabled
            );

            return self::_api_post($request_api, $post_data);
        }
        else {
            return false;
        }
    }

    /* 
        取得使用者資料        
    */
    public function get_profile($userId)
    {
        $request_api = '/bot/profile/' . $userId;

        return self::_api_get($request_api);
    }

    /* 
        取得使用者帳號綁定linkToken     
    */
    public function get_linkToken($userId)
    {
        $request_api = '/bot/user/' . $userId . '/linkToken';

        $_link_token = self::_api_post($request_api, array(), false);
        if($_link_token['http_code'] == 200) {
            $_link_token = json_decode($_link_token['result'], true);
            return $_link_token['linkToken'];
        }
        else {
            return '';
        }
    }

    /* 
      設定使用者richmenu
      https://developers.line.biz/en/reference/messaging-api/#rich-menu
    */
    public function richmenu_show($userId, $richmenuId)
    {
        switch ($richmenuId) {
            case 'default':
                $request_api = '/bot/user/' . $userId . '/richmenu';
                return self::_api_delete($request_api);
                break;
            
            default:
                $request_api = '/bot/user/' . $userId . '/richmenu/' . $richmenuId;
                return self::_api_post($request_api, array(), false);
                break;
        }

    }

    /* 替換 - Line專屬emoji
     *
     */
    public function get_line_emoji_cont($str)
    {
        $regex = '/\(0x([0-9A-Z]{6})\)/';
        preg_match_all($regex, $str, $line_emoji_code);
        if(!empty($line_emoji_code)) {
            foreach($line_emoji_code[1] as $code) {
                $bin  = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
                $emoticon = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
                $str = str_replace('(0x'.$code.')', $emoticon, $str);
            }
        }
        return $str;
    }

    /* 取得Line訊息內容 - bubble樣式
     * 參考 https://developers.line.biz/console/fx-beta/
     */
    public function get_bubble_cont($data, $template)
    {
        $result = array();
        switch($template) {
            // 會員卡
            case 'member_card':       
                 $cont_json = '{
                                "type": "bubble",
                                "body": {
                                  "type": "box",
                                  "layout": "vertical",
                                  "contents": [
                                    {
                                      "type": "image",
                                      "url": "https://www.arsoa.tw/public/images/acard01.png",
                                      "size": "full",
                                      "aspectMode": "cover",
                                      "aspectRatio": "13:8",
                                      "gravity": "center"
                                    },
                                    {
                                      "type": "box",
                                      "layout": "horizontal",
                                      "contents": [
                                        {
                                          "type": "text",
                                          "text": "會員編號：000000",
                                          "color": "#FFFFFFBB",
                                          "offsetTop": "10px",
                                          "offsetStart": "5px",
                                          "size": "xs"
                                        }
                                      ],
                                      "position": "absolute",
                                      "offsetBottom": "0px",
                                      "offsetStart": "0px",
                                      "offsetEnd": "0px",
                                      "paddingAll": "20px"
                                    }
                                  ],
                                  "paddingAll": "0px"
                                }
                              }';
                $result = json_decode($cont_json, true);
                
                if (isset($data['c_no'])){
                    $result['body']['contents']['1']['contents']['0']['text'] = "會員編號：".$data['c_no'];
                }else{
                	  // 索取試用組沒有會員編號去除
                	  unset($result['body']['contents']['1']); 
                }
                
                break;
            case 'question_prd' :
                $cont_json = '{
                               "type": "bubble",
                               "size": "mega",
                               "header": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "box",
                                     "layout": "vertical",
                                     "contents": [
                                       {
                                         "type": "text",
                                         "text": "肌能調理滿意體驗",
                                         "color": "#EAEDED",
                                         "size": "xl",
                                         "align": "center",
                                         "weight": "bold",
                                         "decoration": "none"
                                       },
                                       {
                                         "type": "text",
                                         "text": "第 ? 次問卷",
                                         "color": "#EAEDED",
                                         "align": "center",
                                         "margin": "md",
                                         "size": "lg"
                                       }
                                     ]
                                   }
                                 ],
                                 "paddingAll": "20px",
                                 "backgroundColor": "#e5004a",
                                 "spacing": "md",
                                 "paddingTop": "22px"
                               },
                               "body": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "text",
                                     "text": "親愛的 OXOX 會員您好",
                                     "weight": "bold",
                                     "align": "start",
                                     "wrap": true,
                                     "size": "lg"
                                   },
                                   {
                                     "type": "text",
                                     "text": "感謝您簽訂肌能調理宅配訂單，為了提升會員服務及產品使用滿意度。\n\n想請您撥冗填寫問卷，讓我們更了解您的使用狀況及肌膚現況，給予您專屬的服務。",
                                     "wrap": true,
                                     "align": "start",
                                     "weight": "bold",
                                     "margin": "xxl",
                                     "size": "lg",
                                     "lineSpacing": "8px"
                                   }
                                 ]
                               },
                               "footer": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "box",
                                     "layout": "vertical",
                                     "contents": [
                                       {
                                         "type": "button",
                                         "action": {
                                           "type": "uri",
                                           "label": "來去填寫",
                                           "uri": "uri"
                                         },
                                         "style": "primary",
                                         "height": "sm",
                                         "margin": "sm",
                                         "color": "#e5004a"
                                       }
                                     ]
                                   }
                                 ],
                                 "paddingBottom": "20px"
                               }
                             }';       
                             
                $result = json_decode($cont_json, true); 
                
                $result['header']['contents']['0']['contents']['0']['text'] = $data['line_title'];
                $result['header']['contents']['0']['contents']['1']['text'] = $data['line_num'];
                
                $result['body']['contents']['0']['text'] = $data['name'];
                $result['body']['contents']['1']['text'] = $data['line_msg'];
                
                $result['footer']['contents']['0']['contents']['0']['action']['uri'] = $data['liff_url'];
                
                
                if (isset($data['record_url']) && $data['record_url'] > ''){
                     $childer_json = '
                                     {
                                      "type": "image",
                                      "url": "",
                                      "size": "0px",
                                      "position": "absolute"
                                     }';
                    $childer_cont   = json_decode($childer_json, true);                  
                    $childer_cont['url'] = $data['record_url'];
                    $result['footer']['contents'][] = $childer_cont;
                }   
                
                /* 
                echo "<pre>".print_r($result,true)."</pre>";
                echo "<pre>".json_encode($result)."</pre>";
                exit;
                */
                break;    
            case 'activity_prd' :
                $cont_json = '{
                               "type": "bubble",
                               "size": "mega",
                               "header": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "box",
                                     "layout": "vertical",
                                     "contents": [
                                       {
                                         "type": "text",
                                         "text": "活動名稱",
                                         "color": "#EAEDED",
                                         "size": "xl",
                                         "align": "center",
                                         "weight": "bold",
                                         "decoration": "none"
                                       }
                                     ]
                                   }
                                 ],
                                 "paddingAll": "20px",
                                 "backgroundColor": "#e5004a",
                                 "spacing": "md",
                                 "paddingTop": "22px"
                               },
                               "body": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "text",
                                     "text": "親愛的 OXOX 會員您好",
                                     "weight": "bold",
                                     "align": "start",
                                     "wrap": true,
                                     "size": "lg"
                                   },
                                   {
                                     "type": "text",
                                     "text": "感謝您參加此活動，為了提升會員服務及產品使用滿意度。\n\n想請您撥冗填寫問卷，讓我們更了解您的使用狀況及肌膚現況，給予您專屬的服務。",
                                     "wrap": true,
                                     "align": "start",
                                     "weight": "bold",
                                     "margin": "xxl",
                                     "size": "lg",
                                     "lineSpacing": "8px"
                                   }
                                 ]
                               },
                               "footer": {
                                 "type": "box",
                                 "layout": "vertical",
                                 "contents": [
                                   {
                                     "type": "box",
                                     "layout": "vertical",
                                     "contents": [
                                       {
                                         "type": "button",
                                         "action": {
                                           "type": "uri",
                                           "label": "來去填寫",
                                           "uri": "uri"
                                         },
                                         "style": "primary",
                                         "height": "sm",
                                         "margin": "sm",
                                         "color": "#e5004a"
                                       }
                                     ]
                                   }
                                 ],
                                 "paddingBottom": "20px"
                               }
                             }';       
                             
                $result = json_decode($cont_json, true); 
                
                $result['header']['contents']['0']['contents']['0']['text'] = $data['line_title'];
                
                $result['body']['contents']['0']['text'] = $data['name'];
                $result['body']['contents']['1']['text'] = $data['line_msg'];
                
                $result['footer']['contents']['0']['contents']['0']['action']['uri'] = $data['liff_url'];
                
                
                if (isset($data['record_url']) && $data['record_url'] > ''){
                     $childer_json = '
                                     {
                                      "type": "image",
                                      "url": "",
                                      "size": "0px",
                                      "position": "absolute"
                                     }';
                    $childer_cont   = json_decode($childer_json, true);                  
                    $childer_cont['url'] = $data['record_url'];
                    $result['footer']['contents'][] = $childer_cont;
                }   
                
                /* 
                echo "<pre>".print_r($result,true)."</pre>";
                echo "<pre>".json_encode($result)."</pre>";
                exit;
                */
                break;                         
            case 'question_msg' :
                  $cont_json = '{
                                  "type": "bubble",
                                  "size": "mega",
                                  "header": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": [
                                          {
                                            "type": "text",
                                            "text": "肌能調理滿意體驗",
                                            "color": "#EAEDED",
                                            "size": "lg",
                                            "align": "center",
                                            "weight": "bold",
                                            "decoration": "none"
                                          },
                                          {
                                            "type": "text",
                                            "text": "問卷發送通知",
                                            "color": "#EAEDED",
                                            "align": "center",
                                            "margin": "md",
                                            "size": "md"
                                          }
                                        ]
                                      }
                                    ],
                                    "paddingAll": "20px",
                                    "backgroundColor": "#e5004a",
                                    "spacing": "md",
                                    "paddingTop": "22px"
                                  },
                                  "body": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "text",
                                        "text": "親愛的 OXX 會員您好",
                                        "weight": "bold",
                                        "align": "start",
                                        "wrap": true,
                                        "size": "lg"
                                      },
                                      {
                                        "type": "text",
                                        "text": "今日發出問卷清單如下",
                                        "wrap": true,
                                        "align": "start",
                                        "weight": "regular",
                                        "margin": "xxl",
                                        "size": "lg",
                                        "lineSpacing": "8px"
                                      }
                                    ]
                                  },
                                  "footer": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": []
                                      }
                                    ],
                                    "paddingBottom": "20px"
                                  }
                                }';       
                             
                $result = json_decode($cont_json, true); 
                
                $result['header']['contents']['0']['contents']['0']['text'] = $data['line_title'];
                $result['header']['contents']['0']['contents']['1']['text'] = $data['line_title2'];                
                $result['body']['contents']['0']['text'] = $data['name'];
                $result['body']['contents']['1']['text'] = $data['line_msg'];
                                
                $childer_json1 =      '{
                                        "type": "text",
                                        "text": "第 2 次問卷：\n 張OO、陳OO、陳OO",
                                        "align": "start",
                                        "lineSpacing": "8px",
                                        "margin": "xxl",
                                        "size": "lg",
                                        "wrap": true
                                      }';
                                      
               $childer_json2 =      '{
                                        "type": "button",
                                        "action": {
                                          "type": "uri",
                                          "label": "問卷內容",
                                          "uri": "http://linecorp.com/"
                                        },
                                        "color": "#e5004a",
                                        "style": "primary",
                                        "height": "sm",
                                        "margin": "lg"
                                      }';                                      
                $n = 0;
                foreach($data['amsg'] as $key => $item) {
                        $n++;
                        $childer_cont1   = json_decode($childer_json1, true);
                        $childer_cont2   = json_decode($childer_json2, true);
                        
                        $childer_cont1['text'] = $item['msg'];
                        $childer_cont2['action']['uri'] = str_replace(array("\r", "\n", "\r\n", "\n\r"),'',$item['qurl']);
                        
                        $result['body']['contents'][] = $childer_cont1;
                        $result['body']['contents'][] = $childer_cont2;
                
                }
                
                if (isset($data['record_url']) && $data['record_url'] > ''){
                     $childer_json = '
                                     {
                                      "type": "image",
                                      "url": "",
                                      "size": "0px",
                                      "position": "absolute"
                                     }';
                    $childer_cont   = json_decode($childer_json, true);                  
                    $childer_cont['url'] = $data['record_url'];
                    $result['footer']['contents'][] = $childer_cont;
                }   
                
                /* 
                echo "<pre>".json_encode($result)."</pre>";                
                echo "<pre>".print_r($result,true)."</pre>";                
                exit;
                */
                break;
            case 'sample_msg' :
                  $cont_json = '{
                                  "type": "bubble",
                                  "size": "mega",
                                  "header": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": [
                                          {
                                            "type": "text",
                                            "text": "滿意體驗",
                                            "color": "#EAEDED",
                                            "size": "lg",
                                            "align": "center",
                                            "weight": "bold",
                                            "decoration": "none"
                                          }
                                        ]
                                      }
                                    ],
                                    "paddingAll": "20px",
                                    "backgroundColor": "#e5004a",
                                    "spacing": "md",
                                    "paddingTop": "22px"
                                  },
                                  "body": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "text",
                                        "text": "親愛的 OXX 會員您好",
                                        "weight": "bold",
                                        "align": "start",
                                        "wrap": true,
                                        "size": "lg"
                                      },
                                      {
                                        "type": "text",
                                        "text": "今日發出問卷清單如下",
                                        "wrap": true,
                                        "align": "start",
                                        "weight": "regular",
                                        "margin": "xxl",
                                        "size": "lg",
                                        "lineSpacing": "8px"
                                      }
                                    ]
                                  },
                                  "footer": {
                                    "type": "box",
                                    "layout": "vertical",
                                    "contents": [
                                      {
                                        "type": "box",
                                        "layout": "vertical",
                                        "contents": []
                                      }
                                    ],
                                    "paddingBottom": "20px"
                                  }
                                }';       
                             
                $result = json_decode($cont_json, true); 
                
                $result['header']['contents']['0']['contents']['0']['text'] = $data['line_title'];                
                $result['body']['contents']['0']['text'] = $data['name'];
                $result['body']['contents']['1']['text'] = $data['line_msg'];
                
                if (isset($data['line_title2']))
                {
                	  $childer_json = '{
                                         "type": "text",
                                         "text": "通知",
                                         "color": "#EAEDED",
                                         "align": "center",
                                         "margin": "md",
                                         "size": "lg"
                                     } ';
                    $childer_cont   = json_decode($childer_json, true);                                      
                    $result['header']['contents']['0']['contents'][] = $childer_cont;                    
                    $result['header']['contents']['0']['contents']['1']['text'] = $data['line_title2'];
                }
                
                // 試用確認按鈕
                if (isset($data['button']))
                {
                	  $childer_json = '{
                                      "type": "button",
                                      "action": {
                                        "type": "message",
                                        "label": "'.$data['button'].'",
                                        "text": "'.$data['button_txt'].'"
                                      },
                                      "color": "#e5004a",
                                      "style": "primary"
                                    }';
                    $childer_cont   = json_decode($childer_json, true);                                      
                    $result['footer']['contents'][] = $childer_cont;    
                }
                                      
                if (isset($data['record_url']) && $data['record_url'] > ''){
                     $childer_json = '
                                     {
                                      "type": "image",
                                      "url": "",
                                      "size": "0px",
                                      "position": "absolute"
                                     }';
                    $childer_cont   = json_decode($childer_json, true);                  
                    $childer_cont['url'] = $data['record_url'];
                    $result['footer']['contents'][] = $childer_cont;
                }   
                /*
                echo "<pre>".json_encode($result)."</pre>";      
                exit;
                */
                break;    
            default: 
                # code...
                break;
        }

        return $result;
    }

    // 呼叫line api - post 模式
    private function _api_post($request_api, $post_data, $save_log = true)
    {
        $line_config = $this->config->item('line_config');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $line_config['api_root'] . $request_api);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $line_config['channel_access_token']
        ]);

        $result    = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if(curl_errno($ch)) { //出錯則顯示錯誤信息
            print curl_error($ch);
        }
        curl_close($ch);

        $result = array(
            'http_code' => $http_code,
            'result'    => $result
        );
        return $result;
    }

    // 呼叫line api - get 模式
    private function _api_get($request_api)
    {
        $line_config = $this->config->item('line_config');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $line_config['api_root'] . $request_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $line_config['channel_access_token']
        ]);

        $result    = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch)) { //出錯則顯示錯誤信息
            print curl_error($ch);
        }
        curl_close($ch);

        $result = $http_code == 200 ? json_decode($result, true) : false;
        return $result;
    }

    // 呼叫line api - delete 模式
    private function _api_delete($request_api)
    {
        $line_config = $this->config->item('line_config');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $line_config['api_root'] . $request_api);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $line_config['channel_access_token']
        ]);

        $result    = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch)) { //出錯則顯示錯誤信息
            print curl_error($ch);
        }
        curl_close($ch);

        $result = $http_code == 200 ? json_decode($result, true) : false;
        return $result;
    }
    
}