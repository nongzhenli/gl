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
import ActionView from '@/components/component/ActionView'

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
                path: 'aid/:id',
                name: 'ActionView',
                component: ActionView
            }
        ]
    },
    {
        path: '/author',
        name: 'author',
        component: Author
    },
    {
        path: '*',
        name: '404',
        component: NotFoundComponent,
    }
]
