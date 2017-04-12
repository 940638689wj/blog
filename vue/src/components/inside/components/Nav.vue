<template>
  <div>
    <el-menu :default-active="activeIndex" class="el-menu" mode="horizontal" @select="handleSelect">
      <el-menu-item index="1">首页</el-menu-item>
      <el-submenu index="2">
        <template slot="title">文章分类</template>
        <el-menu-item index="2-1">分类1</el-menu-item>
        <el-menu-item index="2-2">分类2</el-menu-item>
        <el-menu-item index="2-3">分类3</el-menu-item>
      </el-submenu>
    </el-menu>

    <!-- logo或标题 -->
    <div class="logo">
      <b>尤琳杰のblog</b>
    </div>

    <!-- 搜索栏 -->
    <div class="search">
      <el-input
      placeholder="搜索"
      icon="search"
      v-model="searchContent"
      :on-icon-click="handleIconClick">
      </el-input>
    </div>

    <!-- 登录注册按钮 -->
    <div class="buttonGroup">
      <el-button type="default">登录</el-button>
      <el-button type="default">注册</el-button>
    </div>

    <div class="write">
      <el-button type="primary" icon="edit">写文章</el-button>
    </div>

  </div>

</template>

<script>
export default {
  name: 'nav',
  data () {
    return {
      activeIndex: '1',
      searchContent: ''
    }
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
.logo{
  position: fixed;
  left: 30px;
  top: 15px; 
  font-size: 20px;
  font-style: italic;
  color: #EA6F5A;
}
.search{
  position: fixed;
  right: 340px;
  top: 12px; 
}
.buttonGroup{
  position: fixed;
  right: 30px;
  top: 12px;
}
.write{
  position: fixed;
  right: 230px;
  top: 12px;
}
.el-menu{
  padding-left: 300px;
}
</style>
