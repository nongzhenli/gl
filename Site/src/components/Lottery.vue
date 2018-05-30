<template>
    <div class="wap">
        <div class="banner">
            <img class="bannerImg"
                src="../assets/img/lottery/banner.png"
                alt="">
            <div class="prizeInfoBtn">
                <img class="prizeInfoBtnImg"
                    src="../assets/img/lottery/prizeInfo.png"
                    alt="">
            </div>
            <div class="priceChanceBtn">
                您有1次抽奖机会
            </div>
            <div class="whiteBar1 whiteBar">
                <img src="../assets/img/lottery/whiteBar.png"
                    alt="">
            </div>
            <div class="whiteBar2 whiteBar">
                <img src="../assets/img/lottery/whiteBar.png"
                    alt="">
            </div>
            <div class="whiteBar3 whiteBar">
                <img src="../assets/img/lottery/whiteBar.png"
                    alt="">
            </div>
            <div class="whiteBar4 whiteBar">
                <img src="../assets/img/lottery/whiteBar.png"
                    alt="">
            </div>
        </div>
        <!-- 九宫格抽奖 -->
        <lottery-rotate :login-layer="loginLayer"></lottery-rotate>

        
    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../utils/utils";
import LotteryRotate from "@/components/LotteryRotate";
export default {
    data() {
        return {
            userInfo: {
                // "user": {
                //     "id": 1,
                //     "name": "李妈妈",
                //     "mobile": 13132777334
                // },
                // "status": 0,  // 0 未参与报名 1 已报名
                // "prizeInfo": {
                //     "id": 1,
                //     "name": "iphone 6s",
                //     "des": "这是一台iphone6s。使用日期",
                //     "statu": 0 // 0待领取 1已领取
                // },
                // "time": 1526263478
            },
            loginLayer: false // 验证码弹层
        };
    },
    created() {
        this.getUserInfo();
        // console.log(this.$route.params)
    },
    components: { LotteryRotate },
    methods: {
        // 获取用户信息
        getUserInfo() {
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/user/1",
                method: "get",
                headers: { 'token': this.utils.VueCookie.get("loginToken") }
            }).then(response => {
                this.userInfo = response.data.data;
                console.log(response);

                if (this.userInfo.status == 0) {
                    this.loginLayer = true;
                } else if (this.userInfo.status == 1) {
                    this.loginLayer = false;
                }
            }).catch(error => { });
        }
    }
};

</script>
<style lang="less" scoped >
.wap {
    position: relative;
    .banner {
        width: 100%;
        height: 4.4rem;
        position: relative;
        .bannerImg {
            width: 100%;
            height: 4.4rem;
            pointer-events: none;
        }
        .prizeInfoBtn {
            width: 2rem;
            height: 1.27rem;
            position: absolute;
            top: 0;
            right: 0;
            .prizeInfoBtnImg {
                width: 2rem;
                height: 1.27rem;
            }
        }
        .priceChanceBtn {
            // width: 3.1rem;
            height: 0.6rem;
            border-radius: 0.6rem;
            background-color: #ff7a00;
            position: absolute;
            bottom: -0.6rem;
            left: 50%;
            transform: translateX(-50%);
            line-height: 0.66rem;
            font-size: 0.46rem;
            color: #fff;
            font-weight: 500;
            text-align: center;
            padding: 0.14rem 0.6rem;
        }
        .whiteBar {
            position: absolute;
            z-index: 0;
            transform: rotate(-30deg);
            img {
                width: 100%;
                height: 100%;
                display: block;
                // pointer-events 禁止了微信点击图片被打开、分享、保存
                pointer-events: none;
            }
        }
        .whiteBar1 {
            top: 6rem;
            left: -3rem;
            width: 9rem;
            height: 2.5rem;
        }
        .whiteBar2 {
            top: 6.2rem;
            right: -2rem;
            width: 9rem;
            height: 2.5rem;
        }
        .whiteBar3 {
            top: 11.5rem;
            left: -1.8rem;
            width: 9rem;
            height: 2.5rem;
        }
        .whiteBar4 {
            top: 12.2rem;
            left: 2.5rem;
            width: 9rem;
            height: 2.5rem;
        }
    }
    overflow: hidden;
}
</style>