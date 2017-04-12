<template>
<div>
  <NavDiv></NavDiv>
  <br><br><br><br>
  <el-row type="flex" class="blogList" justify="center" v-for="blog in blogList">
    <!-- <el-col :span="6"><div class="grid-content bg-purple"></div></el-col> -->
    <el-col :span="12"><div class="grid-content bg-purple-light">
      <p class="title"><b>{{blog.title}}</b></p>
      <p class="author">
        <i class="el-icon-edit"></i>{{blog.author}}&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="el-icon-time"></i>{{blog.createTime}}
      </p>
      <p>{{blog.content}}</p>
      <p class="author"><i class="el-icon-document"></i>123</p>
      <hr style="height:1px;border:none;border-top:1px solid #dddddd;" />
    </div></el-col>
    <!-- <el-col :span="6"><div class="grid-content bg-purple"></div></el-col> -->
  </el-row>
</div>
</template>

<script>
import NavDiv from './components/Nav'

export default {
  name: 'list',
  data () {
    return {
      activeIndex: '1',
      searchContent: '',
      blogList: [
        {
          title: '这是标题这是标题这是标题这是标题这是标题~~~',
          content: '这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容...',
          author: '作者',
          createTime: '2017-04-02'
        },
        {
          title: '这是标题这是标题这是标题这是标题这是标题~~~',
          content: '这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容这是预览内容...',
          author: '作者',
          createTime: '2017-04-02'
        }
      ]
    }
  },
  components: {
    NavDiv
  },
  methods: {
    handleSelect (key, keyPath) {
      console.log(key, keyPath)
    },
    handleIconClick () {
      console.log('点击搜索')
    }
  },
  created () {
  }
}
</script>

<style scoped>
.blogList{

}
.title{
  font-size: 25px;
}
.author{
  color: #cccccc;
  font-size: 14px;
}

</style>
