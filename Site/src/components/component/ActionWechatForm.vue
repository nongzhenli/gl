<template>
    <div class="action-wechat-form">
        <!-- 未达到要求 -->
        <div v-if="status ==1">
            <p class="text-tip">抱歉，您的人气值未达到要求哦！</p>
        </div>
        <!-- 完成人气值，可填写 -->
        <div v-if="status ==2">
            <p class="title">填写领取联系信息</p>
            <!-- 姓名 -->
            <div class="row-input input-name">
                <div class="item-input">
                    <input type="text" v-model="name" placeholder="填写姓名" required />
                </div>
            </div>
            <!-- 手机 -->
            <div class="row-input input-mobile">
                <div class="item-input">
                    <input type="tel" v-model="mobile" placeholder="填写11位手机号码" required maxlength="11" />
                </div>
            </div>
            <div class="row-input ">
                <button type="button" class="submit-btn" @click="submitLogin">确认提交</button>
            </div>
        </div>
        <!-- 已提交信息 -->
        <div v-if="status ==4">
            <p class="text-tip">您已提交过联系信息，请您耐心等待客服通知，即可来店领取。</p>
        </div>

        <!-- 待领取礼品 -->
        <div v-if="status ==5" class="text-tip">
            <p>恭喜您获取礼品领取资格！点击“立即领取”按钮后，请与现场工作人员核对！</p>
            <button @click="userGetGood()" class="getBtn">立即领取</button>
        </div>

        <!-- 已经到店领取了 -->
        <div v-if="status ==3">
            <p class="text-tip">您已经已经到店领取礼品了呢！</p>
        </div>

    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../../utils/utils";
export default {
    data() {
        return {
            status: 0,
            name: "",
            mobile: "",
            is_axios: true
        }
    },
    created() {
        this.isUserGet(this.getUrlParam('aid'));
    },
    mounted(){
    },
    methods: {
        // 获取url参数
        // 拆分标识符 /
        getUrlParam: function (name) {
            //  window.location.hash 获取从#开始的url
            var reg = new RegExp("(^|/)" + name + "/([^/]*)(/|$)");
            var r = window.location.hash.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        },
        
        // 判断用户是否领取
        isUserGet(act_id) {
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/wechat/verifyUser",
                headers: { 'token': this.utils.VueCookie.get("loginToken") },
                method: "POST",
                data: {
                    "act_id": act_id,
                }
            }).then(response => {
                console.log(response);
                // status 粉丝状态，0取消关注，1关注，2已完成，4填写联系信息时间，5待领取礼品，3已领取
                if(response.data.status){
                    this.status =  response.data.status;
                    if(response.data.status == 4 && this.$route.query.statu == "ok"){
                        this.status = 5;
                    }
                }
            }).catch(error => {
                console.log(error);
            });
        },
        // 提交
        submitLogin(){
            let reg = /^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/;
            let zh_name = /[\u4e00-\u9fa5]$/;

            if (!this.name || !zh_name.test(this.name)) {
                alert("请填写您的联系姓名");
                return false;
            }
            if (!this.mobile || !reg.test(this.mobile)) {
                alert("请填写正确的手机号码");
                return false;
            }

            if (!this.is_axios) return;
            this.is_axios = !this.is_axios;
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/wechat/updataNameMobile",
                headers: { 'token': this.utils.VueCookie.get("loginToken") },
                method: "POST",
                data: {
                    "act_id": this.getUrlParam('aid'),
                    "custname": this.name,
                    "mobile": this.mobile
                }
            }).then(response => {
                console.log(response);
                if (response.data.status = 4) {
                    alert('提交成功，请您耐心等待客服通知，即可来店领取！');
                    // 刷新当前页面
                    this.$router.go(0);
                    this.status = response.data.status;
                    this.is_axios = !this.is_axios;
                }

                // this.$destroy(); // 销毁这个组件
            }).catch(error => { 
                console.log(error);
            });

        },
        // 用户获取礼品按钮
        userGetGood(){
            var act_id = this.getUrlParam('aid');
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/wechat/updataUserGood",
                headers: { 'token': this.utils.VueCookie.get("loginToken") },
                method: "POST",
                data: {
                    "act_id": act_id,
                }
            }).then(response => {
                console.log(response);
                if(response.data.status == 3){
                    alert('领取成功，请与现场工作人员核对！');
                    this.$router.go(0);
                }
                // response.data.status
            }).catch(error => {
                console.log(error);
            });
        }
    },
}
</script>

<style lang="less" scoped>
.action-wechat-form {
    width: 100%;
    min-height: 100%;
    background-color: #fee330;
    overflow: hidden;
    .title {
        font-size: 0.7rem;
        margin: 0.5rem auto;
        color: #000;
        font-weight: 600;
    }
    .item-input {
        padding-bottom: 0.35rem;
        padding-left: 0.35rem;
        padding-right: 0.35rem;
        & > input {
            width: 100%;
            border: 0;
            outline: 0;
            padding: 0.3rem;
            font-size: 0.4rem;
            box-sizing: border-box;
            border: 1px solid #333;
        }
    }
    .submit-btn {
        width: 4.5rem;
        height: 1.2rem;
        font-size: 0;
        color: rgba(255, 255, 255, 0);
        outline: 0;
        border-radius: 0.1rem;
        background-image: url("../../assets/img/lottery/lotteryBtn_.png");
        margin: 0.5rem auto 0.6rem;
        background-repeat: no-repeat;
        background-size: contain;
        background-color: transparent;
        border: 0;
    }
    .text-tip {
        font-size: 0.4rem;
        text-align: left;
        padding: 0.3rem;
    }
    .getBtn {
        width: 100%;
        height: 36px;
        line-height: 36px;
        margin: 30px auto;
        display: block;
    }
}
</style>
