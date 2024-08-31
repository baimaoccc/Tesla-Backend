<?php

namespace app\admin\controller\fastchat;

use addons\fastchat\library\Chat;
use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Pushmessage extends Backend
{

    /**
     * FastChatServiceUser模型对象
     * @var \app\admin\model\FastChatServiceUser
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");

            if ($params) {

                if ($params['serviceuser_id'] <= 0) {
                    $this->error('请选择服务账号！');
                }

                if ($params['group_id'] <= 0 && $params['admin_group_id'] <= 0) {
                    $this->error('请选择用户或管理员分组！');
                }

                if ($params['message'] == '') {
                    $this->error('请填写消息内容！');
                }

                // 先实例化再链式调用
                /*$Chat = new Chat(1);//这里传的是服务号ID
                $Chat->user('1,2,3')->send('消息内容');*/

                // 静态链式调用
                $res = Chat::init($params['serviceuser_id'])
                    ->user_group($params['group_id'])
                    ->admin_group($params['admin_group_id'])
                    ->send($params['message']);

                if ($res['errcode'] == 0) {
                    $this->success('消息推送成功！');
                } else {
                    $this->error($res['errmsg']);
                }

            }

        }

        return $this->view->fetch();
    }

    public function example()
    {

        $res = Chat::init(1)
            ->user('1,2')
            // ->user(array(1,2))
            ->admin('2')
            ->user_group('1,2')
            ->admin_group('1,2')
            ->send('消息内容');

        if ($res['errcode'] == 0) {
            $this->success('消息推送成功！');
        } else {
            $this->error($res['errmsg']);
        }
    }
}
