<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 19/2/16
 * Time: 10:08 AM
 */


require_once('../Libraries/TwitterAPIExchange.php');

function get_twitter_followers($account){

    $settings = array(
        'oauth_access_token' => "57333011-JVyqzjNXtbdLs2aE943WBUN7T0tl9WVC4MgAjf2pJ",
        'oauth_access_token_secret' => "DP5eUi1Tf3MYKwqSspmjDLCef046eZssEPMFTsIq5OxuK",
        'consumer_key' => "dOY0OOp7nset9qYfu32Kkmjtu",
        'consumer_secret' => "4VylmF1XbCTroUt91gs4Bn9wxY56spi99P2G90aOLqkYj5GAbm"
    );

    $ta_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $follow_count=$twitter->setGetfield('?screen_name='.$account)
        ->buildOauth($ta_url, $requestMethod)
        ->performRequest();
    $data = json_decode($follow_count, true);
    $followers_count=$data[0]['user']['followers_count'];
    $followers = $followers_count;

    return $followers;

}

//echo twitter_followers('?screen_name='.$tcurltw, $followers);


/**
 * @param $id
 * @param $appid
 * @param $appsecret
 * @return int
 */
function fbLikeCount($id,$appid,$appsecret){
    //Construct a Facebook URL
    $json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret.'&fields=likes';
    $json = file_get_contents($json_url);
    $json_output = json_decode($json);

    //Extract the likes count from the JSON object
    if($json_output->likes){
        $likes = $json_output->likes;
        return $likes;

    }else{
        return 0;
    }
}


/**
 * @param $user_id
 * @param $access_token
 * @return string
 * @internal param $api_user
 * @internal param $acces_token
 */


function foll_ins ($user_id,$access_token){

    $followers = 'https://api.instagram.com/v1/users/'.$user_id.'/?access_token='.$access_token;
    $curl_init = curl_init ();
    curl_setopt ( $curl_init , CURLOPT_URL , $followers );
    curl_setopt ( $curl_init , CURLOPT_RETURNTRANSFER ,  1 );
    $d = curl_exec ( $curl_init );
    curl_close ( $curl_init );
    $follower =   json_decode ( $d , true );
    $data = number_format ($follower ['data']['counts']['followed_by']);

    return  $data;

}


