// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import "../src/assets/js/flexible"
import Vue from 'vue'
import vueRouter from 'vue-router'
// import Vuex from 'vuex'
// import 'es6-promise/auto'
import axios from "axios";
import App from './App'
import routers from './router'

import * as utils from './utils/utils.js'

// 全局使用 vue-router
Vue.use(vueRouter)
const router =new vueRouter({
    mode: 'hash',
    routes: routers
})

Vue.config.productionTip = false;
Vue.prototype.utils = utils

router.beforeEach((to, from, next) => {
    if (!utils.VueCookie.get("loginToken") && to.path != '/author') {
        // 第一次访问
        utils.VueCookie.set('beforeLoginUrl', to.fullPath) // 保存用户进入的url
        next('/author');
    } else if (utils.VueCookie.get("loginToken")) {
        next();
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
