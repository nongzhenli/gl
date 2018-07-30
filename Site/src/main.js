import "../src/assets/js/flexible"
import Vue from 'vue'
import vueRouter from 'vue-router'
// import Vuex from 'vuex'
// import 'es6-promise/auto'
import axios from "axios";
import App from './App'
import routers from './router'
import vueWchatTitle from 'vue-wechat-title'
import * as utils from './utils/utils.js'

// 全局使用 vue-router
Vue.use(vueRouter)
// 引入解决vue微信ios动态变更title（兼容安卓）
Vue.use(vueWchatTitle)
const router = new vueRouter({
    mode: 'hash',
    routes: routers
})

Vue.config.productionTip = false;
Vue.prototype.utils = utils

router.beforeEach((to, from, next) => {
    console.log("目标", to);
    console.log("来源", from);
    if (!utils.VueCookie.get("loginToken") && to.path != '/author') {  // 情形1、 当 不存在token且不在author页面
        // 第一次访问
        utils.VueCookie.set('beforeLoginUrl', to.fullPath) // 保存用户进入的url
        utils.VueCookie.set('aid', to.meta.aid) // 保存aid
        next('/author');
        return false;
    } else if (utils.VueCookie.get("loginToken")) {  // 情形2、当存在tokne且直接进入授权页面author或刷新时
        // 验证 token
        axios.post("http://gl.gxqqbaby.cn/api/v1/token/verify", {
            "token": utils.VueCookie.get("loginToken")
        }).then(response => {
            if(response.data.isValid == true){
                next();
            }else {
                utils.VueCookie.set('beforeLoginUrl', to.fullPath) // 保存用户进入的url
                next('/author');
                return false;
            }

        }).catch(error => {
            console.log(error);
        });
    } else {
        next();
    }
});


/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>',
    mounted() {
    },
    methods: {
    }
})
