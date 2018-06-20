<template>
    <div class="container">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/01.jpg')" alt="01.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/02.jpg')" alt="02.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/03.jpg')" alt="03.jpg">
        <!-- 九宫格抽奖 -->
        <lottery-rotate :login-statu="loginStatu" :prize-index="prizeIndex"></lottery-rotate>
        <!-- 九宫格抽奖 end-->
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/06.jpg')" alt="06.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/07.jpg')" alt="07.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/08.jpg')" alt="08.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/09.jpg')" alt="09.jpg">
        <img class="bg-img" :src="require('../../assets/img/lottery/bgImg/10.jpg')" alt="10.jpg">
        
    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../../utils/utils";
import LotteryRotate from "@/components/component/ActionLotteryRotate";
export default {
    data() {
        return {
            userInfo: {},
            loginStatu: false,  // 验证码弹层，默认false不弹出，关联报名状态
            prizeIndex: null,   // 奖品索引值
            
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
                url: "http://gl.gxqqbaby.cn/api/v1/lottery/user/get",
                method: "POST",
                headers: { 'token': this.utils.VueCookie.get("loginToken") }
            }).then(response => {
                this.userInfo = response.data;
                if(response.data){
                    this.loginStatu = response.data.status;
                    this.prizeIndex = response.data.prize_index;
                }
            }).catch(error => { });
        }
    }
};

</script>
<style lang="less" scoped >
.container {
    position: relative;
    font-size: 0;
    overflow: hidden;
    background-color: #fee330;

    .bg-img {
        display: block;
        width: 100%;
        max-width: 100%;
        border: 0;
        outline: 0;
        // pointer-events: none;
    }
}
</style>