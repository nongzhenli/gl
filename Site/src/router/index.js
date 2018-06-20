// import Vue from 'vue'
// import Router from 'vue-router'
// Vue.use(Router)
// import Lottery from '@/components/Lottery'
// import Author from '@/components/Author'

// export default [{
//     path: '/',
//     redirect: '/lottery' //重定向
// }, {
//     path: '/lottery',
//     name: 'lottery',
//     component: Lottery,
//     meta: {
//         "auth": true
//     }
// }, {
//     path: '/author',
//     name: 'author',
//     component: Author
// }, {
//     path: '*',
//     redirect: '/',
// }]
import Action from '@/components/pages/Action'
import ActionType from '@/components/component/ActionType'
// import ActionLottery from '@/components/component/ActionLottery'
// import ActionWechatForm from '@/components/component/ActionWechatForm'

import Author from '@/components/pages/Author'
import NotFoundComponent from '@/components/pages/404'

export default [
    {
        path: '/',
        redirect: '/action/aid/1' //重定向
    },
    { // 活动页面路由
        path: '/action',
        name: 'action',
        redirect: '/action/list',
        component: Action,
        children: [
            {
                path: 'list',
                name: 'actionType',
                component: ActionType
            },
            {
                path: 'aid/1',
                name: 'ActionLottery',
                meta: {
                    title: "点点按钮，抽取大奖",
                },
                // 路由组件懒加载
                // component: ActionLottery
                component: resolve => require(['@/components/component/ActionLottery'], resolve),//懒加载
            },
            {
                path: 'aid/2',
                name: 'ActionWechatForm',
                meta: {
                    title: "填写领取联系信息",
                },
                // 路由组件懒加载
                // component: ActionWechatForm
                component: resolve => require(['@/components/component/ActionWechatForm'], resolve),//懒加载

            }
        ]
    },
    {
        path: '/author',
        name: 'author',
        title: "授权登录",
        component: Author
    },
    {
        path: '*',
        name: '404',
        title: '404',
        component: NotFoundComponent,
    }
]
