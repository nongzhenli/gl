<template>
    <div class="com-author">
        <img :src="lodingImg" alt="loding.." width="100%">
    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../../utils/utils";
export default {
    data() {
        return {
            lodingImg: require("../../assets/img/lottery/loading.jpg")
        };
    },
    created() {
        // 检测会员有没有登录
        if (!this.utils.VueCookie.get("loginToken")) {
            let ua = window.navigator.userAgent.toLowerCase();
            if (ua.match(/MicroMessenger/i) == "micromessenger") {
                // 跳转到微信授权页面
                window.onload = function () {
                    window.location.href = "http://gl.gxqqbaby.cn/api/v1/user/author";
                }

            } else {
                alert("请使用微信客户端打开");
                return false;
            }
        } else {
            // 如果有token 则去验证token是否有效
            this.login();
        }
    },
    mounted() { },
    methods: {
        // 获取url参数
        getUrlParam: function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        },

        // 验证token
        login() {
            // 跳转回到登录前路由页面
            let beforeLoginUrl = this.utils.VueCookie.get("beforeLoginUrl") ? this.utils.VueCookie.get("beforeLoginUrl") : "/index";
            this.$router.push({
                path: beforeLoginUrl
            });
            console.log("进入.login");
        }
    }
};
</script>
<style lang="less" scoped>
</style>