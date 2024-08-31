<?php
namespace app\api\controller;
use app\common\controller\Api;
use think\Config;
use think\Db;

class Facebook extends Api{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = [''];
    protected $routes = null;
    public function _initialize()
    {
        parent::_initialize();
        $this->routes = require APP_PATH . '/extra/site.php';

    }
    // protected $TOKEN="EAAPSL7YbIKYBO4XVUQhPEYjIRcWaH6LwcEL6mEhmod7wzhtTlYC3QoDkc1ZBIDGVZBnHxKWT1hZCPMKO4qxWYZAQZCg8JYav4sRywVWgQvKmZCQiPhkYC99UP9fWI9oZBq3JcYG1K1qoNtnH7OsPi7ZATTsZCOgn41oJL6fguBN3ZBXZBvhPRgcm8Ri4Xfnw3x8MmY36AZDZD";
    /*
     * 在结账流程中添加支付信息时。
     * 用户点击“保存账单信息”按钮。
     */
    public function AddPaymentInfoEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            //内容详情列表
            $contents=array();
            //内容ID列表
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            //邮箱
            $em=array();
            array_push($em,strtolower(trim("ashlynjohnson36@gmail.com")));
            array_push($em,strtolower(trim("Wintersmomma2@gmail.com")));
            //电话号码
            $ph=array();
            array_push($ph,ltrim(preg_replace('/\D/', '', "+1-(573)-410-0800"),'0'));
            array_push($ph,ltrim(preg_replace('/\D/', '', "+1-(828)-319-3102"),'0'));
            //名字
            $fn=array();
            array_push($fn,strtolower("oliver"));
            array_push($fn,strtolower("William"));
            $ln=array();
            array_push($ln,strtolower("paye"));
            array_push($ln,strtolower("Tice"));
            //出生日期
            $db=array();
            $data="2021-11-25";
            $formatted_date=strftime('YYYYMMDD',$data);
            $data2="2021-11-25";
            $formatted_date2=strftime('YYYYMMDD',$data2);
            array_push($db,$formatted_date);
            array_push($db,$formatted_date2);
            //性别
            $ge=array();
            array_push($ge,"f");
            array_push($ge,"m");
            //城市
            $ct=array();
            array_push($ct,strtolower(trim("newyork")));
            array_push($ct,strtolower(trim("Coolville")));
            //州区
            $st=array();
            array_push($st,strtolower(trim("NY")));
            array_push($st,strtolower(trim("Va")));
            //邮编
            $zp=array();
            array_push($zp,strtolower(trim("94035")));
            array_push($zp,strtolower(trim("94035")));
            //国家
            $country=array();
            array_push($country,strtolower(trim("US")));
            array_push($country,strtolower(trim("US")));
            //外部编码
            $external_id=array();
            array_push($external_id,"");
            array_push($external_id,"");
            //客户信息参数
            $user_data=array(
                "em"=>hash("sha256",$em),//邮箱，字符串或 list<string>，前后去空格，全部转成小写，必须进行哈希处理
                "ph"=>hash("sha256",$ph),//电话号码，字符串或 list<string>，必须进行哈希处理
                "fn"=>hash("sha256",$fn),//名字,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "ln"=>hash("sha256",$ln),//姓氏,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "db"=>hash("sha256",$db),//出生日期,字符串或 list<string>,必须进行哈希处理。我们接受 YYYYMMDD 格式，其中涵盖各类月、日、年组合，带不带标点均可。
                "ge"=>hash("sha256",$ge),//性别,字符串或 list<string>,必须进行哈希处理。我们接受以小写首字母表示性别的做法。
                "ct"=>hash("sha256",$ct),//城市,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母字符 a 至 z。仅限小写字母，且不可包含标点符号、特殊字符和空格。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "st"=>hash("sha256",$st),//州/省/自治区/直辖市,字符串或 list<string>,必须进行哈希处理。使用 2 个字符的 ANSI 缩写代码，必须为小写字母。请使用小写字母对美国境外的州/省/自治区/直辖市名称作标准化处理，且不可包含标点符号、特殊字符和空格。
                "zp"=>hash("sha256",$zp),//邮编,字符串或 list<string>,必须进行哈希处理。使用小写字母，且不可包含空格和破折号。美国邮编只限使用前 5 位数。英国邮编请使用邮域 + 邮区 + 邮政部门格式。
                "country"=>hash("sha256",$country),//国家/地区,字符串或 list<string>,必须进行哈希处理。请按照 ISO 3166-1 二位字母代码表示方式使用小写二位字母国家/地区代码。重要提示：请始终包含客户的国家/地区代码，即使所有国家/地区代码均来自同一国家/地区亦是如此。我们会在全球范围内进行匹配，这个简单步骤将有助我们根据您的名单匹配尽可能多的账户中心账户。
                "external_id"=>hash("sha256",external_id),//外部编号,字符串或 list<string>,推荐进行哈希处理。可以是广告主提供的任何唯一编号，如会员编号、用户编号和外部 Cookie 编号。您可以为给定事件发送一或多个外部编号。如果是通过其他渠道发送外部编号，此编号的格式应与通过转化 API 发送时的格式相同。
                "client_ip_address"=> $ip,//客户端 IP 地址,字符串,无需进行哈希处理。与事件对应的浏览器 IP 地址必须是有效的 IPV4 或 IPV6 地址。若用户启用了 IPV6，请优先使用 IPV6，而非 IPV4。切勿对 client_ip_address 用户数据参数进行哈希处理。请勿包含空格。始终提供真实的 IP 地址，确保事件报告准确无误。请注意：此信息会自动添加到通过浏览器发送的事件中，但对于通过服务器发送的事件，您必须手动配置该信息。
                "client_user_agent"=> "test user agent",//客户端用户代理程序,字符串,无需进行哈希处理。与事件对应的浏览器的用户代理程序。对于使用转化 API 分享的网站事件，必须填写 client_user_agent 参数。
                "fbc"=>"",//点击编号,字符串,无需进行哈希处理。Facebook 点击编号值存储在您网域下的 _fbc 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${fbclid}。
                "fbp"=>"",//浏览器编号,字符串,无需进行哈希处理。Facebook 浏览器编号值存储在您网域下的 _fbp 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${random_number}。
                //"subscription_id"=>"",//订阅编号,无需进行哈希处理。此交易中用户的订阅编号；类似于单件商品的订单编号。
                //"fb_login_id"=>"",//Facebook 登录编号,无需进行哈希处理。在用户首次登录应用实例时，Meta 会分发此编号。此编号也称为“应用范围编号”。
                "lead_id"=>"",//线索编号,无需进行哈希处理。此编号与 Meta 线索广告生成的线索相关联。
                "anon_id"=>"",//字符串,无需进行哈希处理。您的安装编号。此字段表示唯一的应用程序安装实例。注意：此参数仅用于应用事件
                "madid"=>"",//字符串,无需进行哈希处理。您的移动广告客户编号、Android 设备中的广告编号或 Apple 设备中的广告 ID (IDFA)。注意：此参数仅用于应用事件
                "page_id"=>"",//字符串,无需进行哈希处理。您的公共主页编号。指定与事件关联的公共主页编号。使用与智能助手关联的公共主页的 Facebook 公共主页编号。
                "page_scoped_user_id"=>"",//字符串,无需进行哈希处理。指定与记录事件的 Messenger 智能助手关联的公共主页范围用户编号。使用提供给 Webhooks 的公共主页范围用户编号。
                "ctwa_clid"=>"",//字符串,无需进行哈希处理。点击 Meta 为 WhatsApp 直达广告生成的编号。
                "ig_account_id"=>"",//字符串,无需进行哈希处理。与商家关联的 Instagram 账户编号。
                "ig_sid"=>""//字符串,无需进行哈希处理。根据 Instagram 范围用户编号 (IGSID) 识别与 Instagram 互动的用户。可以从此 Webhooks 获取 IGSID。
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_category"=>"3C",
                "content_ids"=>$content_ids,
                "contents"=>$contents,
                "currency"=>"USD",
                "value"=>123.45
            );
            $data_processing_options=array();
            //服务器事件参数
            $fb=array(
                "event_id"=>"event.id.123",
                "event_name"=> "AddPaymentInfo",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            //正文参数
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 将商品加入购物车时。
     * 用户点击“加入购物车”按钮。
     */
    public function AddToCartEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_ids"=>$content_ids,
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "content_type"=>"product_group",
                "contents"=>$contents,
                "currency"=>"USD",
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "AddToCart",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 将商品添加到心愿单时。
     * 用户点击“加入心愿单”按钮。
     */
    public function AddToWishlistEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "content_category"=>"3C",
                "content_ids"=>$content_ids,
                "contents"=>$contents,
                "currency"=>"USD",
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "AddToWishlist",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 填写完注册表单时。
     * 用户提交填写完的订阅或注册表单。
     */
    public function CompleteRegistrationEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "currency"=>"USD",
                "status"=>true,
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "CompleteRegistration",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户通过电话、短信、邮件及聊天等方式与商家联系时。
     * 用户提交商品相关问题。
     */
    public function ContactEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Contact",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户定制商品时。
     * 用户选择 T 恤的颜色。
     */
    public function CustomizeProductEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "CustomizeProduct",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户向您的组织或公益事业捐款时。
     * 用户将向人道协会的捐款加入购物车。
     */
    public function DonateEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Donate",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户通过网站或应用搜索您店铺的位置，有意到访实际位置时。
     * 用户想在本地商店找到某件特定商品。
     */
    public function FindLocationEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "FindLocation",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户进入结账流程，但结账流程还未完成时。
     * 用户点击“结账”按钮。
     */
    public function InitiateCheckoutEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_category"=>"3C",
                "content_ids"=>$content_ids,
                "contents"=>$contents,
                "currency"=>"USD",
                "num_items"=>2,
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "InitiateCheckout",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 完成注册时
     * 用户点击“定价”按钮。
     */
    public function LeadEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_category"=>"3C",
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "currency"=>"USD",
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Lead",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 完成购买或结账流程时。
     * 用户已完成购买或结账流程，并登陆到感谢或确认页面。
     */
    public function PurchaseEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_ids"=>$content_ids,
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "content_type"=>"product_group",
                "contents"=>$contents,
                "currency"=>"USD",
                "num_items"=>2,
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Purchase",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户预约前往您的某一个分店。
     * 用户选择预约网球课的日期和时间。
     */
    public function ScheduleEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Schedule",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 进行搜索时。
     * 用户在您的网站上搜索商品。
     */
    public function SearchEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_category"=>"3C",
                "content_ids"=>$content_ids,
                "content_type"=>"product_group",
                "contents"=>$contents,
                "currency"=>"USD",
                "search_string"=>"iPhone",
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Search",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户开始免费试用您提供的商品或服务时。
     * 用户选择免费试玩您的游戏一个星期。
     */
    public function StartTrialEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "currency"=>"USD",
                "predicted_ltv"=>1314.520,
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "StartTrial",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户申请您提供的商品、服务或计划时。
     * 用户申请信用卡、教育计划或工作。
     */
    public function SubmitApplicationEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "SubmitApplication",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 用户申请开始付费订阅您提供的商品或服务时。
     * 用户订阅您的直播服务。
     */
    public function SubscribeEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "currency"=>"USD",
                "predicted_ltv"=>1314.520,
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "Subscribe",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    /*
     * 访问您关心的网页（例如，商品页面或落地页）。ViewContent 会告诉您是否有用户访问网页的网址，但不会告诉您用户在该页面看到的内容或进行的操作
     * 用户登陆商品详情页面。
     */
    public function ViewContentEvents(){
        if ($this->request->isPost()) {
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data=array();
            $ip=$_SERVER['REMOTE_ADDR'];
            $contents=array();
            $content_ids=array();
            array_push($content_ids,"sku123");
            array_push($content_ids,"sku456");
            $product=array(
                "id"=>"product123",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            $product2=array(
                "id"=>"product456",
                "quantity"=>1,
                "delivery_category"=>"home_delivery"
            );
            array_push($contents,$product);
            array_push($contents,$product2);
            $user_data=array(
                "client_ip_address"=> $ip,
                "client_user_agent"=> "test user agent"
            );
            //跟其它事件名称不一样的对象属性
            $custom_data=array(
                "content_ids"=>$content_ids,
                "content_category"=>"3C",
                "content_name"=>"Refurbished iPhone 14 Pro Max Unlocked",
                "content_type"=>"product_group",
                "contents"=>$contents,
                "currency"=>"USD",
                "value"=>123.45
            );
            $data_processing_options=array();
            $fb=array(
                "event_name"=> "ViewContent",
                "event_time"=>time(),
                "user_data"=>$user_data,
                "custom_data"=>$custom_data,
                "event_source_url"=> "http://jaspers-market.com/product/123",
                "action_source"=> "website",
                "data_processing_options"=>$data_processing_options
            );
            array_push($data,$fb);
            $data_post=array(
                "data"=>$data,
                "test_event_code"=>"TEST77770"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list=htmlspecialchars_decode($output);
            $arrayData = json_decode($list,true);
            $this->success($arrayData);
        }
    }
    public function testPurchaseEvents(){
        if ($this->request->isPost()) {
            $where=['orderNu'=>''];
            $ruleList=Db::name('order')->where($where)->find();
            $wherep=['order_id'=>$ruleList['id']];
            $ruleListpr=Db::name('order_products')->where($wherep)->find();
            $event_source_url=$_SERVER['HTTP_HOST']."#/checkout";
            $ip=$_SERVER['REMOTE_ADDR'];
            $client_user_agent=$_SERVER['HTTP_USER_AGENT'];
            $arrayData =$this->PurchaseEventsTEST($ruleList,$ruleListpr,$event_source_url,$ip,$client_user_agent);
            $this->success($arrayData);
        }
    }
    /*
     * 完成购买或结账流程时。
     * 用户已完成购买或结账流程，并登陆到感谢或确认页面。
     */
    public function PurchaseEventsTEST(){
        if ($this->request->isPost()) {
            $orderNu=$this->request->post('orderNu');
            $where = ['orderNu' => $orderNu];
            $order = Db::name('order')->where($where)->find();
            $wherep = ['order_id' => $order['id']];
            $orderProducts = Db::name('order_products')->where($wherep)->find();
            $event_source_url = $_SERVER['HTTP_HOST']."#/checkout";
            $ip = $_SERVER['REMOTE_ADDR'];
            $client_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $url = "https://graph.facebook.com/v19.0/446060727829346/events?access_token=".$this->routes['fbAPIToken'];
            $data = array();
            //$ip=$_SERVER['REMOTE_ADDR'];
            //内容详情列表
            $contents = array();
            //内容ID列表
            $content_ids = array();
            foreach ($orderProducts as $key => &$val) {
                array_push($content_ids, $val['goods_id']);
            }
            $content_name = "";
            foreach ($orderProducts as $key => &$val) {
                $product = array(
                    "id" => $val['goods_id'],
                    "title" => $val['goods_title'],
                    "quantity" => $val['goods_num'],
                    "price" => $val['goods_price'],
                    "delivery_category" => "home_delivery"
                );
                $content_name = $val['goods_title'];
                array_push($contents, $product);
            }
            //邮箱
            $em = strtolower(trim($order['email']));
            //电话号码
            $ph = ltrim(preg_replace('/\D/', '', $order['telephone']), '0');
            //名字
            $fn = strtolower($order['first_name']);
            $ln = strtolower($order['last_name']);
            //出生日期
//        $db=array();
//        $data="2021-11-25";
//        $formatted_date=strftime('YYYYMMDD',$data);
//        $data2="2021-11-25";
//        $formatted_date2=strftime('YYYYMMDD',$data2);
//        array_push($db,$formatted_date);
//        array_push($db,$formatted_date2);
//        //性别
//        $ge=array();
//        array_push($ge,"f");
//        array_push($ge,"m");
            //城市
            $ct = strtolower(trim($order['city']));
            //州区
            $st = strtolower(trim($order['province']));
            //邮编
            $zp = strtolower(trim($order['code']));
            //国家
            $country = strtolower(trim($order['country']));
            //外部编码
            $external_id = "";
            //客户信息参数
            $user_data = array(
                "em" => hash("sha256", $em),//邮箱，字符串或 list<string>，前后去空格，全部转成小写，必须进行哈希处理
                "ph" => hash("sha256", $ph),//电话号码，字符串或 list<string>，必须进行哈希处理
                "fn" => hash("sha256", $fn),//名字,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "ln" => hash("sha256", $ln),//姓氏,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                //"db"=>hash("sha256",$db),//出生日期,字符串或 list<string>,必须进行哈希处理。我们接受 YYYYMMDD 格式，其中涵盖各类月、日、年组合，带不带标点均可。
                //"ge"=>hash("sha256",$ge),//性别,字符串或 list<string>,必须进行哈希处理。我们接受以小写首字母表示性别的做法。
                "ct" => hash("sha256", $ct),//城市,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母字符 a 至 z。仅限小写字母，且不可包含标点符号、特殊字符和空格。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "st" => hash("sha256", $st),//州/省/自治区/直辖市,字符串或 list<string>,必须进行哈希处理。使用 2 个字符的 ANSI 缩写代码，必须为小写字母。请使用小写字母对美国境外的州/省/自治区/直辖市名称作标准化处理，且不可包含标点符号、特殊字符和空格。
                "zp" => hash("sha256", $zp),//邮编,字符串或 list<string>,必须进行哈希处理。使用小写字母，且不可包含空格和破折号。美国邮编只限使用前 5 位数。英国邮编请使用邮域 + 邮区 + 邮政部门格式。
                "country" => hash("sha256", $country),//国家/地区,字符串或 list<string>,必须进行哈希处理。请按照 ISO 3166-1 二位字母代码表示方式使用小写二位字母国家/地区代码。重要提示：请始终包含客户的国家/地区代码，即使所有国家/地区代码均来自同一国家/地区亦是如此。我们会在全球范围内进行匹配，这个简单步骤将有助我们根据您的名单匹配尽可能多的账户中心账户。
                "external_id" => hash("sha256", $external_id),//外部编号,字符串或 list<string>,推荐进行哈希处理。可以是广告主提供的任何唯一编号，如会员编号、用户编号和外部 Cookie 编号。您可以为给定事件发送一或多个外部编号。如果是通过其他渠道发送外部编号，此编号的格式应与通过转化 API 发送时的格式相同。
                "client_ip_address" => $ip,//客户端 IP 地址,字符串,无需进行哈希处理。与事件对应的浏览器 IP 地址必须是有效的 IPV4 或 IPV6 地址。若用户启用了 IPV6，请优先使用 IPV6，而非 IPV4。切勿对 client_ip_address 用户数据参数进行哈希处理。请勿包含空格。始终提供真实的 IP 地址，确保事件报告准确无误。请注意：此信息会自动添加到通过浏览器发送的事件中，但对于通过服务器发送的事件，您必须手动配置该信息。
                "client_user_agent" => $client_user_agent,//客户端用户代理程序,字符串,无需进行哈希处理。与事件对应的浏览器的用户代理程序。对于使用转化 API 分享的网站事件，必须填写 client_user_agent 参数。
                "fbc" => "",//点击编号,字符串,无需进行哈希处理。Facebook 点击编号值存储在您网域下的 _fbc 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${fbclid}。
                "fbp" => "",//浏览器编号,字符串,无需进行哈希处理。Facebook 浏览器编号值存储在您网域下的 _fbp 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${random_number}。
                //"subscription_id"=>"",//订阅编号,无需进行哈希处理。此交易中用户的订阅编号；类似于单件商品的订单编号。
                //"fb_login_id"=>"",//Facebook 登录编号,无需进行哈希处理。在用户首次登录应用实例时，Meta 会分发此编号。此编号也称为“应用范围编号”。
                "lead_id" => "",//线索编号,无需进行哈希处理。此编号与 Meta 线索广告生成的线索相关联。
                "anon_id" => "",//字符串,无需进行哈希处理。您的安装编号。此字段表示唯一的应用程序安装实例。注意：此参数仅用于应用事件
                "madid" => "",//字符串,无需进行哈希处理。您的移动广告客户编号、Android 设备中的广告编号或 Apple 设备中的广告 ID (IDFA)。注意：此参数仅用于应用事件
                "page_id" => "",//字符串,无需进行哈希处理。您的公共主页编号。指定与事件关联的公共主页编号。使用与智能助手关联的公共主页的 Facebook 公共主页编号。
                "page_scoped_user_id" => "",//字符串,无需进行哈希处理。指定与记录事件的 Messenger 智能助手关联的公共主页范围用户编号。使用提供给 Webhooks 的公共主页范围用户编号。
                "ctwa_clid" => "",//字符串,无需进行哈希处理。点击 Meta 为 WhatsApp 直达广告生成的编号。
                "ig_account_id" => "",//字符串,无需进行哈希处理。与商家关联的 Instagram 账户编号。
                "ig_sid" => ""//字符串,无需进行哈希处理。根据 Instagram 范围用户编号 (IGSID) 识别与 Instagram 互动的用户。可以从此 Webhooks 获取 IGSID。
            );
            //跟其它事件名称不一样的对象属性
            $custom_data = array(
                "content_ids" => $content_ids,
                "content_name" => $content_name,
                "content_type" => "product_group",
                "contents" => $contents,
                "currency" => "USD",
                "num_items" => $orderProducts.count(),
                "value" => $order['goodprice']
            );
            $data_processing_options = array();
            $fb = array(
                "event_name" => "Purchase",
                "event_time" => time(),
                "user_data" => $user_data,
                "custom_data" => $custom_data,
                "event_source_url" => $event_source_url,
                "action_source" => "website",
                "data_processing_options" => $data_processing_options
            );
            array_push($data, $fb);
            $data_post = array(
                "data" => $data
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list = htmlspecialchars_decode($output);
            $arrayData = json_decode($list, true);
            return $arrayData;
        }
    }
    /*
     * 前端对接后端转化API
     */
    public function EventsAll(){
        if ($this->request->isPost()) {
            $data=@file_get_contents('php://input');
            //parse_str($data,$data);
            $data=htmlspecialchars_decode($data);
            $data=json_decode($data);
            $eventname=$data->eventname;
            $customdata=$data->customdata;
            // $customdata=htmlspecialchars_decode($customdata);
            // $customdata=json_decode($customdata);
            $userdata=$data->userdata;
            // $userdata=htmlspecialchars_decode($userdata);
            // $userdata=json_decode($userdata);
            
            $event_id=$data->event_id;
            //跟其它事件名称不一样的对象属性
            $custom_data=$customdata;
            //邮箱
            $em = strtolower(trim($userdata->em));
            //电话号码
            $ph = ltrim(preg_replace('/\D/', '', $userdata->ph), '0');
            //名字
            $fn = strtolower($userdata->fn);
            $ln = strtolower($userdata->ln);
            //城市
            // 检查属性是否存在
            if (property_exists($userdata, 'ct')){
                $ct = strtolower(trim($userdata->ct));
            }
            //州区
            $st = strtolower(trim($userdata->st));
            //邮编
            $zp = strtolower(trim($userdata->zp));
            //国家
            $country = strtolower(trim($userdata->country));
            // if ($eventname=='Purchase')
            // {
            //     //内容详情列表
            //     $contents = array();
            //     //内容ID列表
            //     $content_ids = array();
            //     $content_name = "";
            //     $orderNu=$data->orderNu;
            //     $where = ['orderNu' => $orderNu];
            //     $order = Db::name('order')->where($where)->find();
            //     $wherep = ['order_id' => $order['id']];
            //     $orderProducts = Db::name('order_products')->where($wherep)->select();
            //     foreach ($orderProducts as &$val) {
            //         $goods_id=$val['goods_id'];
            //         array_push($content_ids,$goods_id);
            //     }
            //     foreach ($orderProducts as $key => &$val) {
            //         $product = array(
            //             "id" => $val['goods_id'],
            //             "title" => $val['goods_title'],
            //             "quantity" => $val['goods_num'],
            //             "price" => $val['goods_price'],
            //             "delivery_category" => "home_delivery"
            //         );
            //         $content_name = $val['goods_title'];
            //         array_push($contents, $product);
            //     }
            //     //邮箱
            //     $em = strtolower(trim($order['email']));
            //     //电话号码
            //     $ph = ltrim(preg_replace('/\D/', '', $order['telephone']), '0');
            //     //名字
            //     $fn = strtolower($order['first_name']);
            //     $ln = strtolower($order['last_name']);
            //     //城市
            //     $ct = strtolower(trim($order['city']));
            //     //州区
            //     $st = strtolower(trim($order['province']));
            //     //邮编
            //     $zp = strtolower(trim($order['code']));
            //     //国家
            //     $country = strtolower(trim($order['country']));
            //     $numitems=count($orderProducts);
            //     $value=$order['goodprice'];
            //     //跟其它事件名称不一样的对象属性
            //     $custom_data = array(
            //         "content_ids" => $content_ids,
            //         "content_name" => $content_name,
            //         "content_type" => "product_group",
            //         "contents" => $contents,
            //         "currency" => "USD",
            //         "num_items" => $numitems,
            //         "value" => $value
            //     );
            // }
            $event_source_url = $_SERVER['HTTP_HOST']."#/checkout";
            $ip = $_SERVER['REMOTE_ADDR'];
            $client_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $pixel=$data->pixel;
            $fbqToken=$data->fbqToken;//$this->routes['pixel']//$this->routes['fbqToken']
            $url = "https://graph.facebook.com/v19.0/".$pixel."/events?access_token=".$fbqToken;
            //$url = "https://graph.facebook.com/v19.0/".$this->routes['pixel']."/events?access_token=".$this->routes['fbqToken'];
            $data = array();
            //外部编码
            $external_id = "";

            //客户信息参数
            $user_data = array(
                "em" => hash("sha256", $em),//邮箱，字符串或 list<string>，前后去空格，全部转成小写，必须进行哈希处理
                "ph" => hash("sha256", $ph),//电话号码，字符串或 list<string>，必须进行哈希处理
                "fn" => hash("sha256", $fn),//名字,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "ln" => hash("sha256", $ln),//姓氏,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母 a-z 字符。仅限小写字母，且不可包含标点符号。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                //"db"=>hash("sha256",$db),//出生日期,字符串或 list<string>,必须进行哈希处理。我们接受 YYYYMMDD 格式，其中涵盖各类月、日、年组合，带不带标点均可。
                //"ge"=>hash("sha256",$ge),//性别,字符串或 list<string>,必须进行哈希处理。我们接受以小写首字母表示性别的做法。
                "ct" => hash("sha256", $ct),//城市,字符串或 list<string>,必须进行哈希处理。推荐使用罗马字母字符 a 至 z。仅限小写字母，且不可包含标点符号、特殊字符和空格。若使用特殊字符，则须按 UTF-8 格式对文本进行编码。
                "st" => hash("sha256", $st),//州/省/自治区/直辖市,字符串或 list<string>,必须进行哈希处理。使用 2 个字符的 ANSI 缩写代码，必须为小写字母。请使用小写字母对美国境外的州/省/自治区/直辖市名称作标准化处理，且不可包含标点符号、特殊字符和空格。
                "zp" => hash("sha256", $zp),//邮编,字符串或 list<string>,必须进行哈希处理。使用小写字母，且不可包含空格和破折号。美国邮编只限使用前 5 位数。英国邮编请使用邮域 + 邮区 + 邮政部门格式。
                "country" => hash("sha256", $country),//国家/地区,字符串或 list<string>,必须进行哈希处理。请按照 ISO 3166-1 二位字母代码表示方式使用小写二位字母国家/地区代码。重要提示：请始终包含客户的国家/地区代码，即使所有国家/地区代码均来自同一国家/地区亦是如此。我们会在全球范围内进行匹配，这个简单步骤将有助我们根据您的名单匹配尽可能多的账户中心账户。
                "external_id" => hash("sha256", $external_id),//外部编号,字符串或 list<string>,推荐进行哈希处理。可以是广告主提供的任何唯一编号，如会员编号、用户编号和外部 Cookie 编号。您可以为给定事件发送一或多个外部编号。如果是通过其他渠道发送外部编号，此编号的格式应与通过转化 API 发送时的格式相同。
                "client_ip_address" => $ip,//客户端 IP 地址,字符串,无需进行哈希处理。与事件对应的浏览器 IP 地址必须是有效的 IPV4 或 IPV6 地址。若用户启用了 IPV6，请优先使用 IPV6，而非 IPV4。切勿对 client_ip_address 用户数据参数进行哈希处理。请勿包含空格。始终提供真实的 IP 地址，确保事件报告准确无误。请注意：此信息会自动添加到通过浏览器发送的事件中，但对于通过服务器发送的事件，您必须手动配置该信息。
                "client_user_agent" => $client_user_agent,//客户端用户代理程序,字符串,无需进行哈希处理。与事件对应的浏览器的用户代理程序。对于使用转化 API 分享的网站事件，必须填写 client_user_agent 参数。
                "fbc" => $userdata->fbc,//点击编号,字符串,无需进行哈希处理。Facebook 点击编号值存储在您网域下的 _fbc 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${fbclid}。
                "fbp" => $userdata->fbp,//浏览器编号,字符串,无需进行哈希处理。Facebook 浏览器编号值存储在您网域下的 _fbp 浏览器 Cookie 中。格式为 fb.${subdomain_index}.${creation_time}.${random_number}。
                //"subscription_id"=>"",//订阅编号,无需进行哈希处理。此交易中用户的订阅编号；类似于单件商品的订单编号。
                //"fb_login_id"=>"",//Facebook 登录编号,无需进行哈希处理。在用户首次登录应用实例时，Meta 会分发此编号。此编号也称为“应用范围编号”。
                "lead_id" => "",//线索编号,无需进行哈希处理。此编号与 Meta 线索广告生成的线索相关联。
                "anon_id" => "",//字符串,无需进行哈希处理。您的安装编号。此字段表示唯一的应用程序安装实例。注意：此参数仅用于应用事件
                "madid" => "",//字符串,无需进行哈希处理。您的移动广告客户编号、Android 设备中的广告编号或 Apple 设备中的广告 ID (IDFA)。注意：此参数仅用于应用事件
                "page_id" => "",//字符串,无需进行哈希处理。您的公共主页编号。指定与事件关联的公共主页编号。使用与智能助手关联的公共主页的 Facebook 公共主页编号。
                "page_scoped_user_id" => "",//字符串,无需进行哈希处理。指定与记录事件的 Messenger 智能助手关联的公共主页范围用户编号。使用提供给 Webhooks 的公共主页范围用户编号。
                "ctwa_clid" => "",//字符串,无需进行哈希处理。点击 Meta 为 WhatsApp 直达广告生成的编号。
                "ig_account_id" => "",//字符串,无需进行哈希处理。与商家关联的 Instagram 账户编号。
                "ig_sid" => ""//字符串,无需进行哈希处理。根据 Instagram 范围用户编号 (IGSID) 识别与 Instagram 互动的用户。可以从此 Webhooks 获取 IGSID。
            );
            $data_processing_options = array();
            $fb = array(
                "event_id"=>$event_id,
                "event_name" => $eventname,
                "event_time" => time(),
                "user_data" => $user_data,
                "custom_data" => $custom_data,
                "event_source_url" => $event_source_url,
                "action_source" => "website",
                "data_processing_options" => $data_processing_options
            );

            array_push($data, $fb);
            $data_post = array(
                "data" => $data,
                //"test_event_code"=>"TEST48067"
            );
            $data_post = http_build_query((object)$data_post);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
            $output = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Errno'.curl_error($ch);//捕抓异常
            }
            curl_close($ch);

            $list = htmlspecialchars_decode($output);
            $arrayData = json_decode($list, true);
            $this->success($arrayData);
        }
    }
}