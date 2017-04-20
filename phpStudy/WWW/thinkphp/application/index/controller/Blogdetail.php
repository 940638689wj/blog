<?php
namespace app\index\controller;

use think\Db;

class Blogdetail
{
	/**
	*	文章详情数据
	*/
  	public function selectBlog($id='')
    {
    	$select = Db::name('blog')
            ->alias('bl')
            ->join('user us','bl.userId = us.id')
            ->join('blog_type bt','bl.blogTypeId = bt.id')
            ->where('bl.id','=', $id)
            ->field('bl.id,bl.title,bl.content,bl.createTime,us.userName,
                bl.blogTypeId,bt.name AS blogTypeName')
            ->find();
       	return $select;
    }

    // 添加评论
    public function addComment($blogId=0, $content='')
    {
        $insert = Db::name('comment')
            ->insert(['userId'=>session('userId'),
            'content'=>$content,
            'blogId'=>$blogId, 
            'createTime'=>date("Y-m-d H:i:s")]);
        if($insert) {
            return true;
        }
    }

    // 获取评论列表
    public function findComment($blogId=0)
    {
        $select = Db::name('comment')
            ->alias('co')
            ->join('user us', 'co.userId = us.id')
            ->where('blogId', '=', $blogId)
            ->order('co.id DESC')
            ->select();
        // 总数
        $selectCount = Db::name('comment')
            ->field('count(1) as count')
            ->where('blogId','=', $blogId)
            ->find();
        return json(['rows'=>$select,'count'=>$selectCount['count']]);
    }
    
}
