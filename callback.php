<?php
// BOT の Channel ID, Channel Secret, MID を入力
$channel_id = "< Channel ID >";
$channel_secret = "< Channel Secret >";
$bot_mid = "< MID >";

//ログファイル名
$log_file = "< ログファイルのパス && ファイル名 >";

// 相手からメッセージ受信
/* to: 相手の mid
   location: location
   text: 送られてきた文字列
   contenttype: 送られてきたメッセージタイプ
     1: text
     2: picture
     3: movie
     4: voice
     7: location
     8: sticker(stamp) */
$recieve_json_string = file_get_contents('php://input');
$recieve_jsonObj = json_decode($recieve_json_string);
$to = $recieve_jsonObj->{"result"}[0]->{"content"}->{"from"};
$text = $recieve_jsonObj->{"result"}[0]->{"content"}->{"text"};
$content_type = $recieve_jsonObj->{"result"}[0]->{"content"}->{"contentType"};
$location = $recieve_jsonObj->{"result"}[0]->{"content"}->{"location"};

//ユーザ情報取得
//displayName 取得のためだけに、これやる悲しみ
$user_profiles_url = curl_init("https://trialbot-api.line.me/v1/profiles?mids={$to}");
curl_setopt($user_profiles_url, CURLOPT_RETURNTRANSFER, true);
curl_setopt($user_profiles_url, CURLOPT_HTTPHEADER, array(
    "X-Line-ChannelID: $channel_id",
    "X-Line-ChannelSecret: $channel_secret",
    "X-Line-Trusted-User-With-ACL: $bot_mid"
));
$user_profiles_output = curl_exec($user_profiles_url);
$user_json_obj = json_decode($user_profiles_output);
$displayname = $user_json_obj->contacts{0}->displayName;
curl_close($user_profiles_url);

//date, mid, displayName, text, contentType, location をログ出力
date_default_timezone_set('Asia/Tokyo');
file_put_contents($log_file, date("Y/m/d H:i:s") . " " . "mid:" . $to . "," . "displayName:" . $displayname . "," . "text:" . $text . "," . "contentType:" . $content_type . "," . "location:" . $location . PHP_EOL, FILE_APPEND);

// 送信する画像をランダムで選ぶ
// glob で取得した画像総数を max に代入し、ランダムで選ばれた配列番号を num_list に代入
// パスを変換し、末尾に画像ファイル名を追加
$pic_array  = glob ("< 画像のパス >");
$max = count($array);
$num_list = array_rand(range(1,$max),1);
$pic = str_replace(< ファイル名から URL に変換する。必要に応じて書き換えて  >);

// toChannelとeventTypeは固定値なので、変更不要。
/*
// text 送信の postdata 作成
//$response_format_text = ['contentType'=>1,"toType"=>1,"text"=>"hoge"];
$post_data = [
    "to"=>[$to],
    "toChannel"=>"1383378250",
    "eventType"=>"138311608800106203",
    "content"=>$response_format_text
];
*/
// 画像送信の postdata 作成
$response_format_image = ['contentType'=>2,"toType"=>1,'originalContentUrl'=>"$pic","previewImageUrl"=>"$pic"];
$post_data = [
    "to"=>[$to],
    "toChannel"=>"1383378250",
    "eventType"=>"138311608800106203",
    "content"=>$response_format_image
];
// video, audio 等の postdata はリファレンス参照

// POST するよ
$post_url = curl_init("https://trialbot-api.line.me/v1/events");
curl_setopt($post_url, CURLOPT_POST, true);
curl_setopt($post_url, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($post_url, CURLOPT_RETURNTRANSFER, true);
curl_setopt($post_url, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($post_url, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    "X-Line-ChannelID: $channel_id",
    "X-Line-ChannelSecret: $channel_secret",
    "X-Line-Trusted-User-With-ACL: $bot_mid"
));
$result = curl_exec($post_url);
//$result に POST 時のログが出るので、必要に応じてエラー処理するよ
//file_put_contents("/var/log/line_bot/log", $result . PHP_EOL, FILE_APPEND);
curl_close($post_url);
