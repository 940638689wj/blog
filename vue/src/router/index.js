import Vue from 'vue'
import Router from 'vue-router'
import Entry from '@/components/Entry'

import Index from '@/components/inside/Index'
import List from '@/components/inside/List'
import Add from '@/components/inside/Add'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/entry/:selectedType',
      name: 'Entry',
      component: Entry
    },
    {
      path: '/blog',
      component: Index,
      children: [
        {
          path: 'list',
          name: 'List',
          component: List
        },
        {
          path: 'add',
          name: 'Add',
          component: Add
        }
      ]
    }
  ]
})
