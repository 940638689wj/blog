<template>
	<div>
		<NavDiv></NavDiv>
    <div class="centerForContent"></div>
    <Breadcrumb></Breadcrumb>
		<router-view></router-view>
  </div>
</template>

<script>
import NavDiv from './components/Nav'
import Breadcrumb from './components/Breadcrumb'

export default {
  name: '',
  data () {
    return {
    }
  },
  components: {
    NavDiv,
    Breadcrumb
  },
  methods: {
  },
  created () {
  }
}
</script>

<style scoped>
.centerForContent{
  margin: auto;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: #ffffff;
  width: 70%;
  position: fixed;
  filter:alpha(opacity=90); /*IE滤镜*/
  -moz-opacity:0.9; /*Firefox私有*/
  opacity:0.9;/*其他*/
}
</style>
