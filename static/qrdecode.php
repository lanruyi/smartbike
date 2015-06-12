<?
//author:xiang.chen            
//date:2014-04-28              
//email:xiangchen.cn@gmail.com 


//通过在线接口返回二维码信息
//@param  string $pic_url 图片的http地址
//@return string 返回信息字符串 或 NULL   
function getQrContent($pic_url){
    $url = "http://zxing.org/w/decode?u=";
    $url = $url.urlencode($pic_url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $content = curl_exec($ch);

    //如果没有返回重试两次
    if(!$content){ $content = curl_exec($ch); }
    if(!$content){ $content = curl_exec($ch); }

    $pattern = "/Parsed Result<\/td><td><pre.*?>(.*?)</";
    preg_match($pattern,$content,$matches);

    curl_close($ch);

    if(isset($matches[1])){
        return $matches[1];
    }
    return null;
}



//example
$pic_url = "http://abs03.semos-cloud.com:8988/static/qrtest.jpg";
$res = getQrContent($pic_url);
var_dump($res);






