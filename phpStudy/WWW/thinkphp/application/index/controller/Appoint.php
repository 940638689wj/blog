<?php
namespace app\index\controller;

use think\Db;

class Appoint
{
	// 获取同地区的用户列表
    public function findSend($pageNo=1,$pageSize=10,$type=0)
    {
    	// 查询当前用户信息
    	$selectUser = Db::name('user')
    		->where('id', '=', session('userId'))
    		->find();

    	// 查询同地区非自身的用户
    	$select = Db::name('user')
    		->alias('us')
    		->join('appoint ap', 'us.id = ap.toUserId and ap.fromUserId = '.session('userId'), 'left');
        if($type == '1') {
            $select = $select->where('us.countryId', '=', $selectUser['countryId']);
        } 
        if ($type == '2') {
            $select = $select->where('us.cityId', '=', $selectUser['cityId']);
        }
        $select = $select->where('us.id', '<>', $selectUser['id'])
            ->limit(($pageNo - 1)*$pageSize,$pageSize)
            ->order('us.id DESC')
            ->field('us.id,us.loginName,us.userName,ap.status')
            ->select();

        // 总数
        $selectCount = Db::name('user')
            ->field('count(1) as count');
        if($type == '1') {
            $selectCount = $selectCount->where('countryId', '=', $selectUser['countryId']);
        } 
        if ($type == '2') {
            $selectCount = $selectCount->where('cityId', '=', $selectUser['cityId']);
        }
        $selectCount = $selectCount->where('countryId', '=', $selectUser['countryId'])
            ->where('id', '<>', $selectUser['id'])
            ->find();
        return json(['rows'=>$select,'count'=>$selectCount['count']]);
    }

    // 约占申请
    public function submitAppoint($toUserId=0,$qq='',$phone='',$content='')
    {
    	$insert = Db::name('appoint')->insert([
    		'fromUserId'=>session('userId'),
    		'toUserId'=>$toUserId,
            'qq'=>$qq,
            'phone'=>$phone,
    		'content'=>$content,
    		'status'=>1,
    		'createTime'=>date("Y-m-d H:i:s")
    		]);
    	if($insert){
    		return true;
    	}
    }

    // 撤回申请
    public function cancelAppoint($toUserId=0)
    {
    	$delete = Db::name('appoint')
    		->where('fromUserId', '=', session('userId'))
    		->where('toUserId', '=', $toUserId)
    		->delete();
        if($delete){
            return true;
        }
    }

    // 获取 收到约战列表
    public function findReceive($pageNo=1,$pageSize=10,$type=0)
    {
    	// 查询同地区非自身的用户
    	$select = Db::name('appoint')
    		->alias('ap')
    		->join('user us', 'ap.fromUserId = us.id', 'left')
            ->where('ap.toUserId', '=', session('userId'))
            ->limit(($pageNo - 1)*$pageSize,$pageSize)
            ->order('ap.id DESC')
            ->field('ap.id,ap.qq,ap.phone,ap.content,ap.status,us.loginName,us.userName')
            ->select();

        // 总数
        $selectCount = Db::name('appoint')
            ->field('count(1) as count')
            ->where('toUserId', '=', session('userId'))
            ->find();
        return json(['rows'=>$select,'count'=>$selectCount['count']]);
    }

    // 回应约战
    public function replyAppoint($id=0, $status=0)
    {
    	$update = Db::name('appoint')->update([
    		'status'=>$status,
    		'id'=>$id
    		]);

    	if($update){
    		return true;
    	}
    }
}
