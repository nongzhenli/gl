import Vue from 'vue'
import Router from 'vue-router'

import LoginWx from '@/components/LoginWx'
import Lottery from '@/components/Lottery'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/',
            redirect: '/lottery' //重定向
        },
        {
            path: '/lottery',
            name: 'lottery',
            component: Lottery
        },
        {
            path: '/loginwx',
            name: 'loginwx',
            component: LoginWx
        },
    ]
})
