<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{

    /**
     * Order模型对象
     * @var \app\admin\model\Order
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Order;

    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
        /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);
            foreach ($list as $k => $v) {
                if($v->data){
                    $data=json_decode($v->data,true);
                    if(isset($data['ad'])){
                        $v->ad=$data['ad'];
                    }else{
                        $v->ad=0;
                    }
                    if(isset($data['firstName'])&&($data['lastName'])){
                        $v->username=$data['firstName'].' '.$data['lastName'];
                    }else{
                        $v->username='';
                    }
                    if(isset($data['email'])){
                        $v->email=$data['email'];
                    }else{
                        $v->email='';
                    }
                    if(isset($data['documentFront'])){
                        $v->documentFront=$data['documentFront'];
                    }else{
                        $v->documentFront='';
                    }
                    if(isset($data['userSelfPictureOrVideo'])){
                        $v->userSelfPictureOrVideo=$data['userSelfPictureOrVideo'];
                    }else{
                        $v->userSelfPictureOrVideo='';
                    }
                    if(isset($data['documentBack'])){
                        $v->documentBack=$data['documentBack'];
                    }else{
                        $v->documentBack=0;
                    }
                }else {
                    $v->ad=0;
                    $v->documentFront=0;
                    $v->userSelfPictureOrVideo=0;
                    $v->documentBack=0;
                }
                $v->data = '';
            }
            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

}
