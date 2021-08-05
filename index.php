<?php
function phpencode($url) {
class PddUrlGen{
public $type="pdd.ddk.goods.zs.unit.url.gen";
public $customParameters;
public $pid;
public $sourceUrl;
public $apiParas=array();
public function __construct($type=""){
$this->apiParas["type"]=$this->type;
}
public function setCustomParameters($customParameters)
{
$this->customParameters = $customParameters;
$this->apiParas["custom_parameters"]=$customParameters;
}
public function setPid($pid)
{
$this->pid = $pid;
$this->apiParas["pid"]=$pid;
}
public function setSourceUrl($sourceUrl)
{
$this->sourceUrl = $sourceUrl;
$this->apiParas["source_url"]=$sourceUrl;
}
}
class PddGoodSearch{
public $type="pdd.ddk.goods.search";
public $customParameters;
public $pid;
public $sourceUrl;
public $apiParas=array();
public function __construct($type=""){
$this->apiParas["type"]=$this->type;
}
public function setPid($pid)
{
$this->pid = $pid;
$this->apiParas["pid"]=$pid;
}
public function setkeyword($keyword)
{
$this->keyword = $keyword;
$this->apiParas["keyword"]=$keyword;
}
}
class PddGoodGen{
public $type="pdd.ddk.goods.promotion.url.generate";
public $customParameters;
public $pid;
public $sourceUrl;
public $apiParas=array();
public function __construct($type=""){
$this->apiParas["type"]=$this->type;
}
public function setPid($pid)
{
$this->pid = $pid;
$this->apiParas["p_id"]=$pid;
}
public function setgoods_sign_list($goods_sign_list)
{
$this->goods_sign_list = $goods_sign_list;
$this->apiParas["goods_sign_list"]=$goods_sign_list;
}
}
class TopClient{ 
public $client_id;
public $client_secret;
public $access_token; 
public $data_type="JSON";
public $url="https://gw-api.pinduoduo.com/api/router";
public function execute($req){ 
$param=$req->apiParas; 
$param["client_id"]=$this->client_id; 
$param["data_type"]=$this->data_type; 
$param["timestamp"]=time(); 
if(isset($this->access_token)) $param["access_token"]=$this->access_token;
ksort($param);
$str = '';
foreach ($param as $k => $v) $str .= $k . $v;
$sign = strtoupper(md5($this->client_secret. $str . $this->client_secret));
$param["sign"] = $sign;
$url=$this->url;
return $this->curl_post($url, $param);
}
function curl_post($url, $postdata){ 
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url); 
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_TIMEOUT, 60); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_POST, 1); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
$data = curl_exec($curl); 
curl_close($curl); 
return $data;
}
}
$c=new TopClient;
$c->client_id="3585eef171e943ca8fbe50fb5c0bdb5b";
$c->client_secret="5b600e8dd6e33c64d3246d1cdb300d73ee76195e";
$req=new PddUrlGen;
$req->setCustomParameters("");
$req->setPid("23759023_216008895");
$req->setSourceUrl($url);
$json = $c->execute($req);
$data = json_decode($json, true);
$data1 = $data['goods_zs_unit_generate_response']['mobile_short_url'];
$req=new PddGoodSearch;
$req->setPid("23759023_216008895");
$req->setkeyword($data1);
$data = $c->execute($req);
$data1 = json_decode($data, true);
$quan = $data1["goods_search_response"]["goods_list"][0]["coupon_discount"];
$goodid = $data1["goods_search_response"]["goods_list"][0]["goods_sign"];
$name = $data1["goods_search_response"]["goods_list"][0]["goods_name"];
$jiage = $data1["goods_search_response"]["goods_list"][0]["min_group_price"];
$req=new PddGoodGen;
$req->setPid("23759023_216008895");
$req->setgoods_sign_list("['".$goodid."']");
$data = $c->execute($req);
$data1 = json_decode($data, true);
$lianjie = $data1["goods_promotion_url_generate_response"]["goods_promotion_url_list"][0]["mobile_short_url"];
$quan = strval(intval($quan) / 100);
$jiage = strval(intval($jiage) / 100);
$wenzi = $name."\n"."【拼团价】".$jiage."元"."\n"."【优惠券】".$quan."元"."\n"."【抢购链接】".$lianjie;
if (empty($lianjie)) return '链接转换失败，请转换单个拼多多链接！';
return $wenzi;
}
?>
<html lang="zh-cn"><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="shortcut icon" href="http://mp.qq.com/img/fav.ico" type="image/x-icon" />
<title>拼多多一键免拼优惠价链接转换工具</title>
<meta name="Keywords" content="拼多多，拼多多转链，拼多多商城，拼多多免拼，免拼单，多多客，多多进宝" />
<meta name="Description" content="拼多多小工具转换链接为免拼单链接。" />
<link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.css" rel="stylesheet">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style>
body{
margin: 0 auto;
text-align: center;
}
.container {
max-width: 580px;
padding: 15px;
margin: 0 auto;
}
</style>
</head>
<body>
<body style="background-image: url(http://www.pptbz.com/pptpic/UploadFiles_6909/201406/2014061415430467.jpg);background-attachment: fixed;background-repeat: no-repeat;background-size: cover;-moz-background-size: cover;">
<div class="container">
<div class="header">
<ul class="nav nav-pills pull-right" role="tablist">
<li role="presentation" class="active"><a href="index.php">首页</a></li>
</ul>
<h3 class="text-muted" align="left">转链网</h3>
</div>
<hr>
<div class="panel panel-primary" style="margin:1% 1% 1% 1%;background: rgba(255, 251, 251, 0.7)">
<div class="panel-heading bk-bg-primary">
<h6><span class="panel-title">拼多多优惠免拼链接在线转换</span></h6>
</div>
<div class="panel-body">
<form method='post'>
<div class="form-group">
<label>输入您想要转换的商品链接</label>
<textarea class="form-control" rows="1" name="source"></textarea>
</div>
<input class="btn btn-primary btn-block bk-margin-top-10" type="submit" name="btn" value="点击转换"></form>
<div class="form-group">
<label>转换后的内部优惠免拼链接</label>
<textarea class="form-control" rows="6"><?php
if(!empty($_POST['source'])) {
echo htmlspecialchars(phpencode(stripcslashes($_POST['source'])));
}
?>
</textarea>
</div>
<?php
if(@$_POST['source']==NULL){}else{
echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign"></span> <strong>提示</strong>：链接转换完成！</div>';
}
?>
<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign"></span> <strong>提示</strong>:输入要进行免拼链接转换的商品链接点击转换即可生成内部优惠价格且免拼单商品链接。</div>
<div class="alert alert-warning" role="alert"> <i class="glyphicon glyphicon-bullhorn"></i> <strong>公告</strong>:本站永久免费提供拼多多免拼链接转换服务。</div>
<hr><div class="container-fluid">
</div>
<p style="text-align:center">&copy; Powered by haru1ca</p></div>
</body>
</html>