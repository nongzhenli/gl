import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
/* Layout */
import Layout from '../views/layout/Layout'
/**
*当设置 true 的时候该路由不会再侧边栏出现 如401，login等页面，或者如一些编辑页面/edit/1
hidden: true // (默认 false)

*当设置 noredirect 的时候该路由在面包屑导航中不可被点击
redirect: noredirect

*当你一个路由下面的 children 声明的路由大于1个时，自动会变成嵌套的模式--如组件页面
*只有一个时，会将那个子路由当做根路由显示在侧边栏--如引导页面
*若你想不管路由下面的 children 声明的个数都显示你的根路由
*你可以设置 alwaysShow: true，这样它就会忽略之前定义的规则，一直显示根路由
alwaysShow: true

name:'router-name'            //设定路由的名字，一定要填写不然使用<keep-alive>时会出现各种问题
meta : {
  roles: ['admin','editor']   //设置该路由进入的权限，支持多个权限叠加
  title: 'title'              //设置该路由在侧边栏和面包屑中展示的名字
  icon: 'svg-name'            //设置该路由的图标
  noCache: true               //如果设置为true ,则不会被 <keep-alive> 缓存(默认 false)
}
**/
export const constantRouterMap = [
    { path: '/login', component: () => import('@/views/login/index'), hidden: true },
    { path: '/404', component: () => import('@/views/404'), hidden: true },

    {
        path: '/',
        component: Layout,
        redirect: '/dashboard',
        name: 'Dashboard',
        hidden: true,
        children: [{
            path: 'dashboard',
            component: () => import('@/views/dashboard/index')
        }]
    },

    {
        path: '/example',
        component: Layout,
        redirect: '/example/table',
        name: 'Example',
        hidden: true,
        meta: { title: 'Example', icon: 'example' },
        children: [
            {
                path: 'table',
                name: 'Table',
                component: () => import('@/views/table/index'),
                meta: { title: 'Table', icon: 'table' }
            },
            {
                path: 'tree',
                name: 'Tree',
                component: () => import('@/views/tree/index'),
                meta: { title: 'Tree', icon: 'tree' }
            }
        ]
    },

    {
        path: '/form',
        hidden: true,
        component: Layout,
        children: [
            {
                path: 'index',
                name: 'Form',
                component: () => import('@/views/form/index'),
                meta: { title: 'Form', icon: 'form' }
            }
        ]
    },

    /**
     * 营销活动模块路由地址
     */
    {
        path: '/marketing',
        component: Layout,
        redirect: '/marketing/list',
        name: 'Marketing',
        meta: { title: '营销管理', icon: 'example' },
        children: [
            {   // 营销活动列表
                path: 'list',
                name: 'MarketingList',
                component: () => import('@/views/marketing/index'),
                meta: { title: '活动列表' }
            },
            {   // 抽奖活动详情
                path: 'lottery/:id(\\d+)', // 此处正则要多加\符 (\d+) => (\\d+)
                name: 'LotteryActivity',
                hidden: true,
                component: () => import('@/views/marketing/lottery'),
                meta: { title: '抽奖活动详情', page: 'lottery' }
            },
            {   // 吸粉活动详情
                path: 'fans/:id(\\d+)',
                name: 'FansActivity',
                hidden: true,
                component: () => import('@/views/marketing/fans'),
                meta: { title: '吸粉活动详情', page: 'fans' }
            },
            {   // 创建营销活动
                path: 'create',
                name: 'MarketingCreate',
                component: () => import('@/views/tree/index'),
                meta: { title: '创建活动', page: 'create' }
            }
        ]
    },

    /**
     * 微信公众号开发配置
     */
    {
        path: '/wechat',
        component: Layout,
        redirect: '/wechat/list',
        name: 'Wechat',
        meta: { title: '微信公众号', icon: 'example' },
        children: [
            {   // 微信公众号列表
                path: 'list',
                name: 'WechatList',
                component: () => import('@/views/wechat/index'),
                meta: { title: '公众号列表' }
            },
            {   // 微信公众号详情页
                path: 'detail/:id(\\d+)',
                name: 'WechatDetail',
                hidden: true,
                component: () => import('@/views/wechat/detail'),
                meta: { title: '详情页' }
            },
            {   // 创建营销活动
                path: 'create',
                name: 'WechatCreate',
                component: () => import('@/views/tree/index'),
                meta: { title: '公众号接入', page: 'create' }
            }
        ]
    },

    { path: '*', redirect: '/404', hidden: true }
]

export default new Router({
    // mode: 'history', //后端支持可开
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRouterMap
})

