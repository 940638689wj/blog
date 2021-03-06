<?php
namespace app\index\controller;

use think\Db;

// 系统入口
class Entry
{
	/**
	*	登录
	*/
  	public function login($loginName='',$password='')
    {
    	$select = Db::name('user')->where('loginName','=',$loginName)->find();
        if(!$select){
            return json(['msg'=>'账号不存在','status'=>'2','data'=>'']);

        }
    	if ($select['password'] != md5($password))
    	{
    	    return json(['msg'=>'密码错误','status'=>'2','data'=>'']);
        }
        session('userId',$select['id']);
        return json(['msg'=>'ok','status'=>'1','data'=>'']);
    }

    /**
	*	根据父节点获取地区
	*/
    public function findArea($parentAreaId='')
    {
    	if($parentAreaId != ''){
    		$select = Db::name('area')->where('parentAreaId','=',$parentAreaId)->field('id,areaName')->select();
    		return $select;
    	}
    	return [];
    }

    /**
    * 注册
    */
    public function register()
    {
    	$select = Db::name('user')->where('loginName','=',$_POST['loginName'])->find();
    	if(!$select)
    	{
    		$insert = Db::name('user')->insert([
                'loginName'=>$_POST['loginName'], 
    			'password'=>md5($_POST['password']),
    			'userName'=>$_POST['userName'],
    			'provinceId'=>$_POST['provinceId'],
    			'cityId'=>$_POST['cityId'],
    			'countryId'=>$_POST['countryId'],
                'createTime'=>date("Y-m-d H:i:s")
    			]);
    		if($insert)
    		{
	    		return json(['msg'=>'ok','status'=>'1','data'=>'']);
    		}
    	}
    	return json(['msg'=>'账号已存在','status'=>'2','data'=>'']);
    }

    // 获取登录状态
    public function isLogin()
    {
    	if(session('userId')){
    		return true;
    	}
    	return false;
    }

    // 查询当前用户信息
    public function getUserName()
    {
        $select = Db::name('user')
            ->where('id', '=', session('userId'))
            ->field('loginName,userName')
            ->find();

        return $select;
    }

    // 退出登录
    public function logout()
    {
    	session('userId',null);
    	return true;
    }
}
