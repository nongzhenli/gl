<template>
    <div class="com-author">
        <img :src="lodingImg" alt="loding.." width="100%">
    </div>
</template>

<script>
import { VueCookie } from "../utils/utils";
export default {
    data() {
        return {
            lodingImg: require('../assets/img/lottery/loading.jpg')
        };
    },
    created() {
        // 检测会员有没有登录
        if (!this.utils.VueCookie.get("loginToken")) {
            let ua = window.navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == "micromessenger") {
                // 跳转到微信授权页面
                window.location.href = "http://gl.gxqqbaby.cn/api/v1/user/author";
            }
        } else {
            // 如果有token 但是vuex中没有用户登录信息则做登录操作
            this.login();
        }
    },
    mounted() {},
    methods: {
        login() {
            console.log('进入.login')
            // let url = this.webUrl + "/Wap/User/info";
            // 通过cookie中保存的token 获取用户信息
            // this.$http.get(url).then(response => {
            //     response = response.body;
            //     if (response) {
            //         // 保存用户登录状态(Vuex)
            //         this.$store.commit("user", response);
            //         setTimeout(() => {
            //             this.goBeforeLoginUrl(); // 页面恢复(进入用户一开始请求的页面)
            //         }, 2000);
            //     } else {
            //         this.$alert("服务器撸猫去惹 :(", "wrong");
            //         if (this.utils.VueCookie.get("user")) {
            //             // 跳转到微信授权页面
            //             window.location.href =this.webUrl + "/Wap/User/getOpenid";
            //         }
            //     }
            // });
        }
    }
};
</script>
<style lang="less" scoped>
</style>