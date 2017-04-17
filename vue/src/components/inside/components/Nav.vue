<template>
  <div class="nav">
    <el-menu theme="dark" :default-active="activeIndex" class="el-menu" mode="horizontal" @select="handleSelect">
      <el-menu-item index="1">
        <router-link :to="{name: 'List'}">首页</router-link>
      </el-menu-item>
      <el-submenu index="2">
        <template slot="title">文章分类</template>
        <el-menu-item index="2-1">分类1</el-menu-item>
        <el-menu-item index="2-2">分类2</el-menu-item>
        <el-menu-item index="2-3">分类3</el-menu-item>
      </el-submenu>
    </el-menu>

    <!-- logo或标题 -->
    <div class="logo">
      <b>尤琳杰の篮球博客</b>
      <!-- <b>blog~</b> -->
    </div>

    <!-- 登录注册按钮 -->
    <div class="buttonGroup">
      <template v-if="isLogin">
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
export default {
  name: 'nav',
  data () {
    return {
      isLogin: false,
      activeIndex: '1',
      searchContent: ''
    }
  },
  methods: {
    logout () {
      this.$confirm('确认退出登录？', '退出', {
        type: 'warning'
      }).then(() => {
        this.$http.get('/index/entry/logout').then(
            res => {
              this.isLogin = false
            }
          )
      })
    },
    handleSelect (key, keyPath) {
      console.log(key, keyPath)
    },
    handleIconClick () {
      console.log('点击搜索')
    }
  },
  created () {
    this.$http.get('/index/entry/isLogin').then(
        res => { this.isLogin = res.body }
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
  right: 230px;
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
</style>
