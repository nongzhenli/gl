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
import LotteryRotate from "@/components/LotteryRotate";
export default {
    data() {
        return {
            userInfo: {}, // 用户信息
            loginLayer: false // 验证码弹层
        };
    },
    created() {
        this.getUserInfo();
        console.log(this.$route.params)
    },
    components: { LotteryRotate},
    methods: {
        // 获取用户信息
        getUserInfo() {
            // 异步获取 奖品数据
            axios({
                url: "https://www.easy-mock.com/mock/5af3d62380d0207179ad7929/lottery/user",
                method: "get"
            }).then(response => {
                this.userInfo = response.data.data;
                if(this.userInfo.status.sign == 0){
                    this.loginLayer = true;
                }else if(this.userInfo.status.sign == 1){
                    this.loginLayer = false;
                }
            }).catch(error => {});
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