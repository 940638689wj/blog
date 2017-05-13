<template>
  <div class="breadcrumb">
  <!-- 面包屑 -->
    <el-row type="flex" justify="center" style="">
      <el-col :span="12">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
          <el-breadcrumb-item v-if="text">{{text}}</el-breadcrumb-item>
        </el-breadcrumb>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  name: 'breadcrumb',
  data () {
    return {
    }
  },
  computed: {
    text () {
      let blogTypeId = this.$store.state.blogTypeId
      if (blogTypeId === '1') {
        return '技术讨论'
      }
      if (blogTypeId === '2') {
        return '聊天灌水'
      }
      if (blogTypeId === '1') {
        return '比赛交流'
      }
      if (blogTypeId === '-1') {
        return '视频欣赏'
      }
      if (blogTypeId === '-2') {
        return '我的文章'
      }
      if (blogTypeId === '-3') {
        return '同区约战'
      }
      if (blogTypeId === '-4') {
        return '同市约战'
      }
      return ''
    }
  },
  methods: {
  },
  created () {
  }
}
</script>

<style scoped>
.breadcrumb{
  margin:80px 0 20px -100px;
}
</style>
