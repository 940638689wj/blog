<template>
<!-- 约战 -->
<div class="appoint">
  <el-row type="flex" justify="center">
    <el-col :span="14">

    <el-tabs value="send">
        <el-tab-pane label="发起约战" name="send">
          <div class="tip">*自动匹配附近（同区）用户</div>
          <el-table :data="sendList" stripe style="width: 100%">
            <el-table-column prop="loginName" label="账号"></el-table-column>
            <el-table-column prop="userName" label="用户名"></el-table-column>
            <el-table-column prop="statusName" label="状态"></el-table-column>
            <el-table-column prop="" label="操作">
              <template scope="scope">
                <el-button type="primary" size="small" v-if="!scope.row.status"
                  @click="submitAppointDialogShow(scope.$index, scope.row)">约战申请</el-button>
                <el-button size="small" v-if="scope.row.status"
                  @click="cancelAppoint(scope.$index, scope.row)">撤回申请</el-button>
              </template>
            </el-table-column>
          </el-table>

          <!-- 分页 -->
          <el-row type="flex" justify="end" class="pager">
            <el-col :span="12">
              <el-pagination
                  @current-change="loadSendList"
                  :current-page="sendPageNo"
                  :page-size="sendPageSize"
                  layout="total, prev, pager, next"
                  :total="sendCount">
              </el-pagination>
            </el-col>
          </el-row>
        </el-tab-pane>

        <el-tab-pane label="收到约战" name="receive">
          <div class="tip">*展开可查看申请描述</div>
          <el-table :data="receiveList" stripe style="width: 100%">
            <el-table-column type="expand">
              <template scope="props">
                {{props.row.content}}
              </template>
            </el-table-column>
            <el-table-column prop="loginName" label="账号"></el-table-column>
            <el-table-column prop="userName" label="用户名"></el-table-column>
            <el-table-column prop="statusName" label="状态"></el-table-column>
            <el-table-column prop="qq" label="qq号"></el-table-column>
            <el-table-column prop="phone" label="手机号"></el-table-column>
            <el-table-column prop="" label="操作">
              <template scope="scope">
                <template  v-if="scope.row.status == 1">
                  <el-button size="small" type="primary"
                    @click="replyAppoint(scope.$index, scope.row, 2)">接受</el-button>
                  <el-button size="small" type="danger"
                    @click="replyAppoint(scope.$index, scope.row, 3)">拒绝</el-button>
                </template>
              </template>
            </el-table-column>
          </el-table>

          <!-- 分页 -->
          <el-row type="flex" justify="end" class="pager">
            <el-col :span="12">
              <el-pagination
                  @current-change="loadReceiveList"
                  :current-page="receivePageNo"
                  :page-size="receivePageSize"
                  layout="total, prev, pager, next"
                  :total="receiveCount">
              </el-pagination>
            </el-col>
          </el-row>
        </el-tab-pane>
      </el-tabs>

    </el-col>
  </el-row>

  <!-- 约战申请对话框 -->
  <el-dialog title="约战申请" v-model="submitAppointDialog">
    <el-form>
      <el-form-item label="qq号" label-width="80px">
        <el-input v-model="form.qq"></el-input>
      </el-form-item>
      <el-form-item label="手机号" label-width="80px">
        <el-input v-model="form.phone"></el-input>
      </el-form-item>
      <el-form-item label="申请描述" label-width="80px">
        <el-input type="textarea" v-model="form.content" :autosize="{minRows: 5}" placeholder="请输入申请信息，如自我介绍、联系方式和详细地址等"></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button @click="submitAppointDialog = false">取 消</el-button>
      <el-button type="primary" @click="submitAppoint">确 定</el-button>
    </div>
  </el-dialog>

</div>
</template>

<script>

export default {
  name: 'appoint',
  data () {
    return {
      // 发起约战 相关数据
      sendPageNo: 1,
      sendPageSize: 10,
      sendList: [], // 附近用户列表
      sendCount: 0,
      form: {
        toUserId: 0,
        qq: '',
        phone: '',
        content: ''
      },
      submitAppointDialog: false,
      // 收到约战 相关数据
      receivePageNo: 1,
      receivePageSize: 10,
      receiveList: [], // 收到约战列表
      receiveCount: 0
    }
  },
  computed: {
    type () {
      return this.$route.query.type
    }
  },
  watch: {
    type () {
      this.loadSendList(1)
    }
  },
  methods: {
    getStatusName (rows) {
      for (let row of rows) {
        if (!row.status) {
          row.statusName = '未申请'
        } else if (row.status === 1) {
          row.statusName = '待回复'
        } else if (row.status === 2) {
          row.statusName = '已接受'
        } else if (row.status === 3) {
          row.statusName = '已拒绝'
        }
      }
    },
    // 加载附近用户
    loadSendList (sendPageNo) {
      if (sendPageNo) {
        this.sendPageNo = sendPageNo
      }
      this.$http.get('/index/appoint/findSend', {
        params: {
          pageNo: this.sendPageNo,
          pageSize: this.sendPageSize,
          type: this.type
        },
        emulateJSON: true
      }).then(
        res => {
          this.getStatusName(res.body.rows)
          this.sendList = res.body.rows
          this.sendCount = res.body.count
        }
        )
    },
    // 打开约战申请对话框
    submitAppointDialogShow (index, row) {
      this.form.toUserId = row.id
      this.submitAppointDialog = true
    },
    // 提交约占申请
    submitAppoint () {
      this.$http.post('/index/appoint/submitAppoint', this.form, {
        emulateJSON: true
      }).then(
      res => {
        if (res.body) {
          this.$message.success('申请成功')
          this.submitAppointDialog = false
          this.form.qq = ''
          this.form.phone = ''
          this.form.content = ''
          this.loadSendList()
        }
      }
      )
    },
    // 撤回约战申请
    cancelAppoint (index, row) {
      this.$confirm('确认撤回申请？', '撤回申请').then(
        () => {
          this.$http.post('/index/appoint/cancelAppoint', {
            toUserId: row.id
          }, {
            emulateJSON: true
          }).then(
          res => {
            if (res.body) {
              this.$message.success('撤回成功')
              this.loadSendList()
            }
          }
          )
        }
        )
    },
    // 加载收到约战数据
    loadReceiveList (receivePageNo) {
      if (receivePageNo) {
        this.receivePageNo = receivePageNo
      }
      this.$http.get('/index/appoint/findReceive', {
        params: {
          pageNo: this.receivePageNo,
          pageSize: this.receivePageSize,
          type: this.type
        },
        emulateJSON: true
      }).then(
      res => {
        this.getStatusName(res.body.rows)
        this.receiveList = res.body.rows
        this.receiveCount = res.body.count
      }
      )
    },
    // 回复约战申请
    replyAppoint (index, row, status) {
      let str = status === 2 ? '接受' : '拒绝'
      this.$confirm('确认' + str + row.userName + '的约战吗？', str).then(
        () => {
          this.$http.post('/index/appoint/replyAppoint', {
            id: row.id,
            status: status
          }, {
            emulateJSON: true
          }).then(
          res => {
            if (res.body) {
              this.$message.success(str + '成功')
              this.loadReceiveList()
            }
          }
          )
        }
        )
    }
  },
  created () {
    this.$store.commit('selectBlogTypeId', '-3')
    this.loadSendList()
    this.loadReceiveList()
  }
}
</script>

<style scoped>
.appoint div{
  font-size:16px;
}
.pager{
  padding: 30px 0 50px 0;
}
.tip{
  color: #888888;
  font-size: 12px;
  font-weight: bold;
  -webkit-transform-origin-x: 0; 
  -webkit-transform: scale(0.8);
  color: #EA6F5A;
  margin: 0 0 10px 0;
}
</style>
