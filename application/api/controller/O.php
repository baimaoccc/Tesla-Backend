<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\Config;

/**
 * 手机短信接口
 */
class O extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    /**
     * 发送验证码
     *
     * @ApiMethod (POST)
     * @param string $mobile 手机号
     * @param string $event 事件名称
     */
    public function getOrder()
    {
        $page = $this->request->post("page",0);
        $per_page = $this->request->post("per_page",10);
        $states=$this->request->post('states');
        $where=[];
        if($states){
           $where['states']=$states;
        }
        $vehicleModel=$this->request->post('vehicleModel');
        if($vehicleModel){
           $where["data"]=['LIKE','%"vehicleModel":"'.$vehicleModel.'"%'];
        }
        $ruleList=Db::name('order')->where($where)->order('id','desc')->limit($page*$per_page,$per_page)->select();
        $total=Db::name('order')->where($where)->count();
        $this->success('请求成功',['list'=>$ruleList,'total'=>$total]);
    }
    public function review() {
        if($this->request->isPost()){
            $id=$this->request->post('id');
            if(!$id){
                $this->error('订单错误');
            }
            $where=['id'=>$id];
            $where['review']=0;
            $res=Db::name('order')->where($where)->update(['review'=>1]);
            if ($res){
                $this->success('success');
            }else{
                $this->error('error');
            }
            
        }
    }
    /**
     * 检测验证码
     *
     * @ApiMethod (POST)
     * @param string $mobile 手机号
     * @param string $event 事件名称
     * @param string $captcha 验证码
     */
    public function check()
    {
        $mobile = $this->request->post("mobile");
        $event = $this->request->post("event");
        $event = $event ? $event : 'register';
        $captcha = $this->request->post("captcha");

        if (!$mobile || !\think\Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('手机号不正确'));
        }
        if ($event) {
            $userinfo = User::getByMobile($mobile);
            if ($event == 'register' && $userinfo) {
                //已被注册
                $this->error(__('已被注册'));
            } elseif (in_array($event, ['changemobile']) && $userinfo) {
                //被占用
                $this->error(__('已被占用'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未注册
                $this->error(__('未注册'));
            }
        }
        $ret = Smslib::check($mobile, $captcha, $event);
        if ($ret) {
            $this->success(__('成功'));
        } else {
            $this->error(__('验证码不正确'));
        }
    }
}
