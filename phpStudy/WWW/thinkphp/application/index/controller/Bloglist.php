<?php
namespace app\index\controller;

use think\Db;

class Bloglist
{
	/**
	*	文章列表数据
	*/
  	public function selectBlog($pageNo=1,$pageSize=10,$searchContent='')
    {
        // 列表
    	$select = Db::name('blog')
            ->alias('bl')
            ->join('user us','bl.userId = us.id')
            ->limit(($pageNo - 1)*$pageSize,$pageSize)
            ->order('bl.id DESC')
            ->where('bl.title','like', $searchContent)
            ->field('bl.id,bl.title,bl.content,bl.createTime,us.userName,
                (select count(1) from comment where blogId = bl.id) AS commentCount')
            ->select();
        // 总数
        $selectCount = Db::name('blog')
            ->field('count(1) as count')
            ->find();
       	return json(['rows'=>$select,'count'=>$selectCount['count'],'id'=>session('userId')]);
    }

    // 添加文章
    public function addBlog($title='',$content='',$blogTypeId=0)
    {
        $insert = Db::name('blog')
            ->insert(['userId'=>session('userId'),
            'content'=>$content,
            'title'=>$title, 
            'blogTypeId'=>$blogTypeId,
            'status'=>1,
            'createTime'=>date("Y-m-d H:i:s")]);
        if($insert) {
            return true;
        }
    }

    // 获取文章类型列表
    public function findBlogType()
    {
        $select = Db::name('blog_type')->select();
        return $select;
    }
    
}
