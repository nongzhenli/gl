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
import ActionLottery from '@/components/component/ActionLottery'
import ActionWechatForm from '@/components/component/ActionWechatForm'

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
                title: "点点按钮，抽取大奖",
                component: ActionLottery
            },
            {
                path: 'aid/2',
                name: 'ActionWechatForm',
                title: "填写领取联系信息",
                component: ActionWechatForm
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
