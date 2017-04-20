<template>
<div>
  <el-row type="flex" justify="center" class="detail">
    <el-col :span="16">
    <h1 class="font-center">{{blog.title}}</h1>
    <div class="font-center title">
      作者：{{blog.userName}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      发布时间：{{blog.createTime}}
    </div>
    <div class="content" v-html="blog.content"></div>
    <div class="comment">
      <hr style="height:1px;border:none;border-top:1px solid #aaaaaa;" />
      <div class="title">写下您的评论...</div>
      <div id="editor"></div>
      <el-row type="flex" class="row-bg submit-comment" justify="end">
        <el-button type="primary" @click="submitComment">提交</el-button>
        <el-button @click="editor.clear()">清空</el-button>
      </el-row>
      <br><br>
      <h3>{{commentCount}}条评论</h3>
      <template v-for="comment in commentList">
        <hr style="height:1px;border:none;border-top:1px solid #aaaaaa;" />
        <div class="title">{{comment.userName}}<br>{{comment.createTime}}</div>
        <p class="list-content" v-html="comment.content"></p>
      </template>
      <br><br>
    </div>
    </el-col>
  </el-row>
</div>
</template>

<script>
import WangEditor from 'wangeditor'

export default {
  name: 'list',
  data () {
    return {
      blog: {},
      editor: '',
      isLogin: false,
      commentCount: 0,
      commentList: []
    }
  },
  methods: {
    // 获取评论列表
    findComment () {
      this.$http.get('/index/blogdetail/findComment', {
        params: {
          blogId: this.$route.params.id
        }
      }).then(
          res => {
            this.commentCount = res.body.count
            this.commentList = res.body.rows
          }
        )
    },
    // 提交评论
    submitComment () {
      this.$http.post('/index/blogdetail/addComment', {
        blogId: this.$route.params.id,
        content: this.editor.$txt.html()
      }, {emulateJSON: true}).then(
        res => {
          this.$message.success('评论成功~')
          this.editor.clear()
          this.findComment()
        }
      )
    }
  },
  created () {
    // 加载文章内容
    this.$http.get('/index/blogdetail/selectBlog', {
      params: {
        id: this.$route.params.id
      }
    }).then(
        res => {
          this.blog = res.body
        }
      )
    this.findComment()
  },
  mounted () {
    // 获取是否登录
    this.$http.get('/index/entry/isLogin').then(
        res => {
          this.isLogin = res.body
          // 初始化富文本
          this.editor = new WangEditor('editor')
          this.editor.create()
          if (this.isLogin) {
            this.editor.enable()
          } else {
            this.editor.disable()
          }
        }
      )
  }
}
</script>

<style scoped>
.detail{
  padding-top: 100px;
}
.font-center{
  text-align: center;
}
.title{
  color: #999999;
  font-size: 14px;
  padding: 10px;
}
.content{
  padding: 40px;
}
#editor{
  height: 200px;
}
.submit-comment{
  padding: 10px;
}
.list-content{
  padding: 0 10px 0 10px;
}
</style>
