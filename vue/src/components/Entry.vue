<template>
  <div class="login">
  <el-row type="flex" class="row-bg" justify="center">
    <el-col :span="8">
      <el-tabs type="border-card" v-model="selectedType">
        <el-tab-pane label="登录">
          <el-form ref="loginForm" :model="loginForm" :rules="loginRules" label-width="80px">

            <el-form-item label="账号" prop="loginName">
              <el-input v-model="loginForm.loginName"></el-input>
            </el-form-item>

            <el-form-item label="密码" prop="password">
              <el-input v-model="loginForm.password"></el-input>
            </el-form-item>

            <el-form-item>
              <el-button type="primary" @click="loginSubmit">登录</el-button>
              <el-button @click="loginReset">重置</el-button>
            </el-form-item>

          </el-form>
        </el-tab-pane>

        <el-tab-pane label="注册">
          <el-form ref="registerForm" :model="registerForm" :rules="registerRules" label-width="80px">

            <el-form-item label="账号" prop="loginName">
              <el-input v-model="registerForm.loginName"></el-input>
            </el-form-item>

            <el-form-item label="密码" prop="password">
              <el-input v-model="registerForm.password"></el-input>
            </el-form-item>

            <el-form-item label="重复密码" prop="agPassword">
              <el-input v-model="registerForm.agPassword"></el-input>
            </el-form-item>

            <el-form-item label="用户名" prop="userName">
              <el-input v-model="registerForm.userName"></el-input>
            </el-form-item>

            <el-form-item label="选择地址">
              <el-col :span="8">
                <el-form-item label="">
                  <el-select v-model="registerForm.provinceId" placeholder="选择省" @change="changeProvince">
                    <el-option v-for="province in provinceList" :label="province.areaName" :value="province.id" :key="province.id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>

              <el-col :span="8">
                <el-form-item label="">
                  <el-select v-model="registerForm.cityId" placeholder="选择市" @change="changeCity">
                    <el-option v-for="city in cityList" :label="city.areaName" :value="city.id" :key="city.id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>

              <el-col :span="8">
                <el-form-item label="">
                  <el-select v-model="registerForm.countryId" placeholder="选择区">
                    <el-option v-for="country in countryList" :label="country.areaName" :value="country.id" key="country.id"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-form-item>

            <el-form-item>
              <el-button type="primary" @click="registerSubmit">注册</el-button>
              <el-button @click="registerReset">重置</el-button>
            </el-form-item>

          </el-form>
        </el-tab-pane>
      </el-tabs>
      
    </el-col>
  </el-row>
  </div>
</template>

<script>
import router from '@/router'

export default {
  name: 'login',
  data () {
    return {
      selectedType: '0',
      provinceList: [],
      cityList: [],
      countryList: [],
      // 登录表单
      loginForm: {
        loginName: '',
        password: ''
      },
      // 登录表单验证规则
      loginRules: {
        loginName: [
          {required: true, message: '请输入账号', trigger: 'blur'}
        ],
        password: [
          {required: true, message: '请输入密码', trigger: 'blur'},
          {min: 6, message: '密码至少6位', trigger: 'blur'}
        ]
      },
      // 注册表单
      registerForm: {
        loginName: '',
        password: '',
        agPassword: '',
        userName: '',
        provinceId: '',
        cityId: '',
        countryId: ''
      },
      // 注册表单验证规则
      registerRules: {
        loginName: [
          {required: true, message: '请输入账号', trigger: 'blur'}
        ],
        password: [
          {required: true, message: '请输入密码', trigger: 'blur'},
          {min: 6, message: '密码至少6位', trigger: 'blur'}
        ],
        agPassword: [
          {required: true, message: '请输入重复密码', trigger: 'blur'}
        ],
        userName: [
          {required: true, message: '请输入用户名', trigger: 'blur'}
        ]
      }
    }
  },
  methods: {
    // 查询地区下拉
    findArea (parentAreaId, target) {
      this.$http.get('/index/entry/findArea', {
        params: {
          parentAreaId: parentAreaId
        }
      }).then(
        res => {
          this[target] = res.body
        }
        )
    },
    // 选择省回调
    changeProvince () {
      this.registerForm.cityId = ''
      this.registerForm.countryId = ''
      this.findArea(this.registerForm.provinceId, 'cityList')
    },
    // 选择市回调
    changeCity () {
      this.registerForm.countryId = ''
      this.findArea(this.registerForm.cityId, 'countryList')
    },
    // 提交登录
    loginSubmit () {
      this.$refs['loginForm'].validate((valid) => {
        if (valid) {
          this.$http.post('/index/entry/login', this.loginForm, {emulateJSON: true}).then(
              res => {
                if (res.body.status === '1') {
                  this.$message.success('登录成功')
                  router.push({name: 'List'})
                } else {
                  this.$message.error(res.body.msg)
                }
              }
            )
        }
      })
    },
    // 重置登录
    loginReset () {
      this.$refs['loginForm'].resetFields()
    },
    // 提交注册
    registerSubmit () {
      this.$refs['registerForm'].validate((valid) => {
        if (valid) {
          if (!this.registerForm.provinceId || !this.registerForm.cityId || !this.registerForm.countryId) {
            this.$message.error('请选择地址~')
            return false
          }
          if (this.registerForm.password !== this.registerForm.agPassword) {
            this.$message.error('两次输入的密码不同')
            return false
          }
          this.$http.post('/index/entry/register', this.registerForm, {emulateJSON: true}).then(
            res => {
              if (res.body.status === '1') {
                this.$message.success('注册成功')
                this.registerReset()
                this.selectedType = '0'
              } else {
                this.$message.error(res.body.msg)
              }
            }
            )
        }
      })
    },
    // 重置注册
    registerReset () {
      this.$refs['registerForm'].resetFields()
      this.registerForm.provinceId = ''
      this.registerForm.cityId = ''
      this.registerForm.countryId = ''
    }
  },
  created () {
    this.selectedType = this.$route.params.selectedType
    this.findArea(0, 'provinceList')
  }
}
</script>

<style scoped>
.login{
  padding-top: 200px;
}
</style>
