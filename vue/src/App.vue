<template>
  <div id="app" v-cloak>
    <div class="backImg"></div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
#app {
  /*font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,;*/
  font-family: Helvetica;
}
.backImg{
  /*background-color: #555555;*/
  background-image: url('./assets/image/background.jpg');
  background-size: 100% 100%;
  background-repeat: no-repeat;
  background-attachment: fixed;
  position: fixed;
  top:0;
  bottom: 0;
  left: 0;
  right: 0;
}
body{
  margin: 0;
}
[v-cloak]{
  display: none;
}
</style>
