<?php
namespace app\index\controller;

use think\Db;

class Bloglist
{
	/**
	*	文章列表数据
	*/
  	public function selectBlogList($pageNo=1,$pageSize=10,$blogTypeId=0,$searchContent='')
    {
        // 列表
    	$select = Db::name('blog')
            ->alias('bl')
            ->join('user us','bl.userId = us.id')
            ->join('blog_type bt','bl.blogTypeId = bt.id')
            ->limit(($pageNo - 1)*$pageSize,$pageSize)
            ->order('bl.id DESC')
            ->where('bl.title','like', $searchContent);
        if($blogTypeId > 0){
            $select = $select->where('bl.blogTypeId','=', $blogTypeId);
        } else if ($blogTypeId == -2) {
            $select = $select->where('us.id','=', session('userId'));
        }
        $select = $select->field('bl.id,bl.title,bl.content,bl.createTime,us.userName,
                bl.blogTypeId,bt.name AS blogTypeName,
                (select count(1) from comment where blogId = bl.id) AS commentCount')
            ->select();

        // 总数
        $selectCount = Db::name('blog')
            ->alias('bl')
            ->join('user us','bl.userId = us.id')
            ->where('bl.title','like', $searchContent)
            ->field('count(1) as count');
        if($blogTypeId > 0){
            $selectCount = $selectCount->where('bl.blogTypeId','=', $blogTypeId);
        } else if ($blogTypeId == -2) {
            $selectCount = $selectCount->where('us.id','=', session('userId'));
        }
        $selectCount = $selectCount->find();
       	return json(['rows'=>$select,'count'=>$selectCount['count']]);
    }

    // 添加文章
    public function addBlog($title='',$content='',$blogTypeId=0)
    {
        $insert = Db::name('blog')->insert([
            'userId'=>session('userId'),
            'content'=>$content,
            'title'=>$title, 
            'blogTypeId'=>$blogTypeId,
            'status'=>1,
            'createTime'=>date("Y-m-d H:i:s")
            ]);
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

    // 删除文章
    public function delBlog($id=0)
    {
        $delete = Db::name('blog')->delete($id);
        if($delete){
            return true;
        }
    }
    
}
