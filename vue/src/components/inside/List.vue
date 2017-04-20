<template>
<div>
  <!-- 搜索栏 -->
  <div class="search">
    <el-input
    placeholder="搜索标题"
    icon="search"
    v-model="searchContent"
    :on-icon-click="loadList">
    </el-input>
  </div>
  <div style="margin-top:100px"></div>
  <el-row type="flex" justify="center" v-for="blog in blogList" :key="blog.id">
    <el-col :span="12">
      <div class="grid-content bg-purple-light">
        <p class="title">
          <router-link :to="{name: 'Detail', params: {id: blog.id}}">
            {{blog.title}}
          </router-link>
        </p>
        <p class="userName">
          <i class="el-icon-edit"></i>{{blog.userName}}&nbsp;&nbsp;&nbsp;&nbsp;
          <i class="el-icon-time"></i>{{blog.createTime}}
        </p>
        <p class="content" v-html="blog.content.length < 100 ? blog.content : blog.content.substring(0,100)+'...'"></p>
        <p class="userName">
          <el-button type="danger" :plain="true" size="mini" @click="selectBlogType(blog.blogTypeId)">{{blog.blogTypeName}}</el-button>
          {{blog.commentCount}}人评论
        </p>
        <hr style="height:1px;border:none;border-top:1px solid #aaaaaa;" />
      </div>
    </el-col>
  </el-row>
  <!-- 分页 -->
  <el-row type="flex" justify="end" class="pager">
    <el-col :span="12">
      <el-pagination
          @current-change="loadList"
          :current-page="pageNo"
          :page-size="pageSize"
          layout="total, prev, pager, next"
          :total="blogCount">
      </el-pagination>
    </el-col>
  </el-row>
</div>
</template>

<script>
export default {
  name: 'list',
  data () {
    return {
      pageNo: 1,
      pageSize: 10,
      searchContent: '',
      blogList: [],
      blogCount: 0
    }
  },
  computed: {
    // 文章类型
    blogTypeId () {
      if (this.$store.state.blogTypeId === '0') {
        return ''
      }
      return this.$store.state.blogTypeId
    }
  },
  watch: {
    blogTypeId () {
      this.loadList(1)
    }
  },
  methods: {
    // 加载分页数据
    loadList (pageNo) {
      console.log(this.blogTypeId)
      this.pageNo = pageNo
      this.$http.get('/index/bloglist/selectBlogList', {
        params: {
          pageNo: this.pageNo,
          pageSize: this.pageSize,
          blogTypeId: '%' + this.blogTypeId + '%',
          searchContent: '%' + this.searchContent + '%'
        },
        emulateJSON: true
      }).then(
        res => {
          this.blogList = res.body.rows
          this.blogCount = res.body.count
        }
      )
    },
    toDetail () {
      console.log(1)
    },
    // 选择导航栏
    selectBlogType (blogTypeId) {
      this.$store.commit('selectBlogTypeId', blogTypeId)
    }
  },
  created () {
    // 初始化文章列表
    this.loadList(1)
  }
}
</script>

<style scoped>
.search{
  position: fixed;
  z-index: 2;
  right: 340px;
  top: 12px; 
}
.title a{
  font-size: 20px;
  font-weight: bold;
  color: #000000;
  text-decoration: none;
}
.title:HOVER {
  text-decoration: underline;
}
.userName{
  color: #999999;
  font-size: 14px;
}
.content{
  font-size: 15px;
}
.pager{
  padding: 30px 0 50px 0;
}
</style>
