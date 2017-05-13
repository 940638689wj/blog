<template>
  <div class="nav">
  <!-- 标签页 -->
  
    <el-menu theme="dark" :default-active="blogTypeId" class="el-menu" mode="horizontal" @select="selectBlogType">
      <el-menu-item index="0">
        <router-link :to="{name: 'List'}">全部</router-link>
      </el-menu-item>

      <el-submenu index="-99">
        <template slot="title">文章分类</template>
        <el-menu-item index="1">技术讨论</el-menu-item>
        <el-menu-item index="2">聊天灌水</el-menu-item>
        <el-menu-item index="3">比赛交流</el-menu-item>
      </el-submenu>

      <el-menu-item index="-1">视频欣赏</el-menu-item>

      <template v-if="isLogin">
        <el-menu-item index="-2">我的文章</el-menu-item>
        <el-menu-item index="-3">同区约战</el-menu-item>
        <el-menu-item index="-4">同市约战</el-menu-item>
      </template>
      
    </el-menu>

    <!-- logo或标题 -->
    <div class="logo">
      <b>尤琳杰の篮球小窝</b>
    </div>

    <!-- 登录注册按钮 -->
    <div class="buttonGroup">
      <template v-if="isLogin">
        <span style="color:#eeeeee">您好，{{userName}}</span>
        <el-button type="default" @click="logout">退出登录</el-button>
      </template>
      <template v-else>
        <router-link :to="{name: 'Entry', params: {selectedType: '0'}}">
          <el-button type="default">登录</el-button>
        </router-link>
        <router-link :to="{name: 'Entry', params: {selectedType: '1'}}">
          <el-button type="default">注册</el-button>
        </router-link>
      </template>
    </div>

    <router-link :to="{name: 'Add'}" class="write" v-if="isLogin">
      <el-button type="primary" icon="edit">写文章</el-button>
    </router-link>

  </div>

</template>

<script>
import router from '@/router'

export default {
  name: 'nav',
  data () {
    return {
      isLogin: false,
      userName: '',
      searchContent: '',
      blogTypeList: []
    }
  },
  computed: {
    blogTypeId () {
      return this.$store.state.blogTypeId
    }
  },
  methods: {
    // 登出
    logout () {
      this.$confirm('确认退出登录？', '退出', {
        type: 'warning'
      }).then(() => {
        this.$http.get('/index/entry/logout').then(
            res => {
              this.isLogin = false
              router.push({name: 'List'})
              window.location.reload()
            }
          )
      })
    },
    // 选择导航栏
    selectBlogType (key, keyPath) {
      if (key !== '-1') {
        this.$store.commit('selectBlogTypeId', key)
      }
      // 跳转至列表
      if (key === '0' || key === '1' || key === '2' || key === '3' || key === '-2') {
        router.push({name: 'List'})
      }
      // 跳转至视频
      if (key === '-1') {
        router.push({name: 'Video'})
      }
      // 跳转至约战
      if (key === '-3') {
        router.push({name: 'Appoint', query: {type: 1}})
      }
      if (key === '-4') {
        router.push({name: 'Appoint', query: {type: 2}})
      }
    }
  },
  created () {
    // 获取是否登录
    this.$http.get('/index/entry/isLogin').then(
        res => { this.isLogin = res.body }
      )
    // 获取用户名
    this.$http.get('/index/entry/getUserName').then(
        res => { this.userName = res.body.userName }
      )
    // 加载文章类型列表
    this.$http.get('/index/bloglist/findBlogType').then(
        res => {
          this.blogTypeList = res.body
        }
      )
  }
}
</script>

<style scoped>
.logo{
  position: absolute;
  left: 30px;
  top: 15px; 
  font-size: 20px;
  font-style: italic;
  color: #EA6F5A;
}
.buttonGroup{
  position: absolute;
  right: 30px;
  top: 12px;
}
.write{
  position: absolute;
  right: 280px;
  top: 12px;
}
.el-menu{
  padding-left: 300px;
}
.nav{
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  z-index: 1;
}
.nav a{
  text-decoration: none;
}
</style>
