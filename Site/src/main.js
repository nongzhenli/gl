// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import "../src/assets/js/flexible"
import Vue from 'vue'
import vueRouter from 'vue-router'
// import Vuex from 'vuex'
// import 'es6-promise/auto'
import axios from "axios";
import App from './App'
import router from './router'

import * as utils from './utils/utils.js'

// 全局使用 vue-router
Vue.use(vueRouter)
Vue.config.productionTip = false;
Vue.prototype.utils = utils

router.beforeEach((to, from, next) => {
    console.log(to)
    console.log(from)
    // utils.VueCookie.set("loginToken", "7de769bc0ff5df35ef56fe5dc47e8aa3");
    if (!utils.VueCookie.get("loginToken") && to.path != '/author') {
        // 第一次访问
        console.log("授权登录");
        // 跳转到微信授权页面，微信授权地址通过服务端获得
        // axios.post("https://www.mqxpyy.com/wxsq/index.php/Api/Lottery/login").then(res => {
        //     console.log(res);
        //     var data = res.data;
        //     if(data.msg == 0){
        //         window.location.href = data.url
        //     } else if(data.msg == 1) {
        //         next();
        //     }
        // });
        window.location.href = "http://gl.gxqqbaby.cn/api/v1/user/wxcode";
    } else if (utils.VueCookie.get("loginToken")) {
        console.log(utils.VueCookie.get("loginToken"));


    } else {
        // console.log("cookie生效期内登录");
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
        this.login();
    },
    methods: {
        login(){
            console.log('xxx');
        }
    }
})
