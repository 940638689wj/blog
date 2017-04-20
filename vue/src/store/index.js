import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store(
  {
    state: {
      blogTypeId: '0'
    },
    mutations: {
      selectBlogTypeId (state, msg) {
        state.blogTypeId = msg
      }
    }
  }
)
