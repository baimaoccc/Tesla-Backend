<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class FastChatServiceUser extends Model
{

    use SoftDelete;


    // 表名
    protected $name = 'fastchat_service_user';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'add_sessiondata_text',
        'online_status_text',
        'status_text'
    ];

    public function getAddSessiondataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['add_sessiondata']) ? $data['add_sessiondata'] : '');
        $list  = $this->getAddSessiondataList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getAddSessiondataList()
    {
        return ['0' => __('Add_sessiondata 0'), '1' => __('Add_sessiondata 1'), '2' => __('Add_sessiondata 2')];
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list  = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1')];
    }

    public function getOnlineStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['online_status']) ? $data['online_status'] : '');
        $list  = $this->getOnlineStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getOnlineStatusList()
    {
        return ['0' => __('online_status 0'), '1' => __('online_status 1')];
    }

    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
