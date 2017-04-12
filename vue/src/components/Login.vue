<template>
  <div>
    <el-col :span="6">
      <el-form ref="form" :model="form" label-width="80px">
        <el-form-item label="账号">
          <el-input v-model="form.loginName"></el-input>
        </el-form-item>
        <el-form-item label="密码">
          <el-input v-model="form.password"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">登录</el-button>
          <el-button @click="reset">重置</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </div>
</template>

<script>
export default {
  name: 'login',
  data () {
    return {
      form: {
        loginName: '',
        password: ''
      }
    }
  },
  methods: {
    onSubmit () {
      console.log(1)
    },
    reset () {
      this.form.loginName = ''
      this.form.password = ''
    }
  },
  created () {
    this.$http.get('/entry/test.php').then(
        res => {
          console.log(res.body)
        }
      )
  }
}
</script>

<style scoped>
</style>
