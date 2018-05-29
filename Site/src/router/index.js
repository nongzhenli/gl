// import Vue from 'vue'
// import Router from 'vue-router'
import LoginWx from '@/components/LoginWx'
import Lottery from '@/components/Lottery'
import Author from '@/components/Author'

// Vue.use(Router)
export default [{
    path: '/',
    redirect: '/lottery' //重定向
}, {
    path: '/lottery',
    name: 'lottery',
    component: Lottery,
    meta: {
        "auth": true
    }
}, {
    path: '/author',
    name: 'author',
    component: Author
},{
    path: '*',
    redirect: '/',
}]

