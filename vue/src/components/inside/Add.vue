<template>
<div>
  <el-row type="flex" justify="center" class="add">
    <!-- <el-col :span="6"><div class="grid-content bg-purple"></div></el-col> -->
    <el-col :span="16">
      <div class="grid-content bg-purple-light">
        <el-form ref="blogForm" :model="blogForm" :rules="blogRules" label-width="100px">

          <el-form-item label="标题" prop="title">
            <el-input v-model="blogForm.title"></el-input>
          </el-form-item>

          <el-form-item label="文章类型">
            <el-select v-model="blogForm.blogTypeId" placeholder="请选择">
              <el-option
                v-for="blogType in blogTypeList"
                :label="blogType.name"
                :value="blogType.id"
                :key="blogType.id">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="内容" prop="content">
            <div id="editor" style="height:350px"></div>
          </el-form-item>

          <el-form-item>
            <el-button type="primary" @click="blogSubmit">发布</el-button>
            <el-button @click="blogReset">重置</el-button>
          </el-form-item>

        </el-form>
      </div>
    </el-col>
    <!-- <el-col :span="6"><div class="grid-content bg-purple"></div></el-col> -->
  </el-row>
</div>
</template>

<script>
import WangEditor from 'wangeditor'
import router from '@/router'

export default {
  name: 'list',
  data () {
    return {
      blogTypeList: [],
      blogForm: {
        title: '',
        blogTypeId: 0
      },
      editor: null,
      blogRules: {
        title: [
          {required: true, message: '请输入标题', trigger: 'blur'}
        ]
      }
    }
  },
  methods: {
    // 提交文章
    blogSubmit () {
      this.$refs['blogForm'].validate((valid) => {
        if (valid) {
          this.$http.post('/index/bloglist/addBlog', {
            title: this.blogForm.title,
            blogTypeId: this.blogForm.blogTypeId,
            content: this.editor.$txt.html()
          }, {
            emulateJSON: true
          }).then(
            res => {
              if (res.body) {
                this.$message.success('发布成功~')
                router.push({name: 'List'})
              }
            }
          )
        }
      })
    },
    // 重置文章
    blogReset () {
      this.$refs['blogForm'].resetFields()
      this.blogForm.blogTypeId = this.blogTypeList[0].id
      this.editor.clear()
    }
  },
  created () {
    this.$store.commit('selectBlogTypeId', '-2')
    // 加载文章类型列表
    this.$http.get('/index/bloglist/findBlogType').then(
        res => {
          this.blogTypeList = res.body
          this.blogForm.blogTypeId = res.body[0].id
        }
      )
  },
  mounted () {
    // 初始化富文本
    this.editor = new WangEditor('editor')
    this.editor.create()
  }
}
</script>

<style scoped>
</style>
