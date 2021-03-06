import Vue from 'vue'
import Router from 'vue-router'
import Entry from '@/components/Entry'

import Index from '@/components/inside/Index'
import List from '@/components/inside/List'
import Add from '@/components/inside/Add'
import Detail from '@/components/inside/Detail'
import Video from '@/components/inside/Video'
import Appoint from '@/components/inside/Appoint'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      redirect: '/blog/list'
    },
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
          path: 'detail/:id',
          name: 'Detail',
          component: Detail
        },
        {
          path: 'video',
          name: 'Video',
          component: Video
        },
        {
          path: 'add',
          name: 'Add',
          component: Add
        },
        {
          path: 'appoint',
          name: 'Appoint',
          component: Appoint
        }
      ]
    }
  ]
})
