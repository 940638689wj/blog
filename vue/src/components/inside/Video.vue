<template>
<!-- 篮球视频 -->
<div>
  <el-row type="flex" justify="center">
    <el-col :span="12">
      <div class="grid-content bg-purple-light">
        <p class="title">NBA各球星篮球过人绝招教学集锦</p>
        <embed height="600" width="100%" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="//static.hdslb.com/miniloader.swf" flashvars="aid=6073139&page=1" pluginspage="//www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
      </div>
      <br><br>
      <hr style="height:1px;border:none;border-top:1px solid #aaaaaa;" />
      <br><br>
      <div class="grid-content bg-purple-light">
        <p class="title">小托马斯教你如何成为一个NBA级别的球员！</p>
        <embed height="600" width="100%" quality="high" allowfullscreen="true" type="application/x-shockwave-flash" src="//static.hdslb.com/miniloader.swf" flashvars="aid=10011204&page=1" pluginspage="//www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
      </div>
      <br><br>
      <hr style="height:1px;border:none;border-top:1px solid #aaaaaa;" />
      <br><br>
    </el-col>
  </el-row>
</div>
</template>

<script>

export default {
  name: 'video',
  data () {
    return {
    }
  },
  created () {
    this.$store.commit('selectBlogTypeId', '-1')
  }
}
</script>

<style scoped>
.title{
  font-size: 20px;
  font-weight: bold;
  color: #000000;
  text-decoration: none;
}
</style>
