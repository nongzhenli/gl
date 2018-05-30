<template>
    <div class="lottery-vcode">
        <div class="lottert-vcode-parent-layer">
            <div
                class="lottert-vcode-layer"
                v-show="is_show"
            >
                <p class="title">填写个人信息马上参与抽奖吧！</p>
                <div class="row-input input-name">
                    <div class="item-input">
                        <input
                            type="text"
                            v-model="name"
                            placeholder="填写姓名"
                            required
                        />
                    </div>

                </div>
                <div class="row-input input-mobile">
                    <div class="item-input">
                        <input
                            type="tel"
                            v-model="mobile"
                            placeholder="填写11位手机号码"
                            required
                            maxlength="11"
                        />
                    </div>
                </div>
                <!-- 短信验证码  -->
                <div class="row-input input-vcode">
                    <div class="item-input">
                        <input
                            type="tel"
                            v-model="vcode"
                            placeholder="短信验证码"
                            required
                            maxlength="4"
                        />
                    </div>
                    <button
                        class="post-vcode"
                        v-text="vcodeText"
                        @click="postVcode"
                    ></button>
                </div>
                <!-- 短信验证码 end -->

                <div class="row-input ">
                    <button
                        type="button"
                        class="submit-btn"
                        @click="submitLogin"
                    >确认报名</button>
                </div>
        </div>
        <transition name="fadeLeft">
            <button
                class="colse-btn"
                @click="backIndex()"
            >x</button>
        </transition>
    </div>

    </div>
</template>

<script>
const TIME_COUNT = 60;
import axios from "axios";
export default {
    props: ["showVcode", "isLogin"],
    data() {
        return {
            name: "",
            mobile: null,
            vcode: null,
            vcodeText: "获取验证码",
            vcodeCount: 0,
            vcodeTimer: null,

            is_show: this.showVcode,
            is_axios: true
        };
    },
    created() { },
    watch: {
        showVcode(newValue, oldValue) {
            this.is_show = newValue;
        }
    },
    mounted() { },
    methods: {
        // 报名
        submitLogin(event) {
            let reg = /(?:^1[3456789]|^9[28])\d{9}$/;
            let zh_name = /[\u4e00-\u9fa5]$/;

            if (!this.name || !zh_name.test(this.name)) {
                alert("请填写您的联系姓名");
                return false;
            }
            if (!this.mobile || !reg.test(this.mobile)) {
                alert("请填写正确的手机号码");
                return false;
            }

            // if (!this.vcode || this.vcode == "") {
            //     alert("验证码不正确");
            //     return false;
            // }
            if (!this.is_axios) return;
            this.is_axios = !this.is_axios;
            axios({
                url: "https://www.easy-mock.com/mock/5af3d62380d0207179ad7929/lottery/login",
                method: "get"
            }).then(response => {
                // console.log(response.data.data.statu);
                this.is_axios = !this.is_axios;
                this.$emit("update:isLogin", false); // 改变登录状态
                this.$emit("update:showVcode", false); // 不显示报名窗口
                // this.$destroy(); // 销毁这个组件
            }).catch(error => { });
        },
        // 获取验证码
        postVcode() {
            const _this = this;

            if (!this.vcodeTimer) {
                this.vcodeCount = TIME_COUNT;
                this.vcodeText = this.vcodeCount + "s重新获取";
                // 倒计时
                _this.vcodeCount--; // 初始化先执行一次，因为定时器 1000ms执行一次，点击的一刻存在时间间隔
                this.vcodeTimer = setInterval(function () {
                    _this.vcodeText = _this.vcodeCount + "s重新获取";
                    if (
                        _this.vcodeCount > 0 &&
                        _this.vcodeCount <= TIME_COUNT
                    ) {
                        _this.vcodeCount--;
                    } else {
                        _this.vcodeText = "重新获取";
                        clearInterval(_this.vcodeTimer);
                        _this.vcodeTimer = null;
                    }
                }, 1000);
            } else {
                return false;
            }
        },
        // 返回活动首页
        backIndex() {
            this.$emit("update:showVcode", false);
            // 返回的时候，假如存在计时器，请先关闭
            if (this.vcodeTimer >= 0) {
                clearInterval(this.vcodeTimer);
            }
        }
    }
};
</script>

<style lang="less" scoped>
@import "vue2-animate/dist/vue2-animate.min.css";
.lottery-vcode {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;

    .lottert-vcode-parent-layer {
        position: relative;
        top: 48%;
        transform: translateY(-50%);

        .lottert-vcode-layer {
            padding: 0 0.6rem;
            position: relative;
            z-index: 22;
            color: #fff;
            width: 8rem;
            // height: 6rem;
            margin: auto;

            border-radius: 0.2rem;
            overflow: hidden;
            background-color: #00bcd4;
            box-shadow: 4px 4px 1px #3f4142;
            box-sizing: border-box;

            .title {
                font-size: 0.4rem;
                margin: 0.5rem auto;
            }
            .item-input {
                padding-bottom: 0.35rem;
                & > input {
                    width: 100%;
                    border: 0;
                    outline: 0;
                    padding: 0.3rem;
                    font-size: 0.4rem;
                    box-sizing: border-box;
                }
            }
            .input-vcode {
                font-size: 0;
                overflow: hidden;
                & > .item-input {
                    display: inline-block;
                    vertical-align: middle;
                    width: 60%;
                    input {
                        height: 1rem;
                    }
                }
                & > .post-vcode {
                    display: inline-block;
                    width: 40%;
                    height: 1rem;
                    font-size: 0.4rem;
                    border: 1px solid #f2f2f2;
                    box-sizing: border-box;
                    outline: 0;
                    background-color: #e8e6e6;
                    border-left: 1px solid #d6d5d5;
                    color: #333;
                    vertical-align: top;
                }
            }
            .submit-btn {
                width: 100%;
                padding: 0.2rem;
                font-size: 0.44rem;
                background-color: #ff7a00;
                color: #fff;
                outline: 0;
                border: 1px solid #fb6a3d;
                border-radius: 0.1rem;
                margin: 0.5rem auto 0.6rem;
                box-shadow: 2px 2px 0px #ff5722;
            }
        }

        .colse-btn {
            position: absolute;
            left: 50%;
            bottom: -20%;
            width: 1rem;
            height: 0.95rem;
            line-height: 0.9rem;
            margin: auto;
            padding: 0;
            text-align: center;
            font-size: 0;
            transform: translateX(-50%);
            border-radius: 50%;
            outline: 0;
            border: 0;

            background-image: url("../assets/img/lottery/close.png");
            background-size: cover;
            background-position: center;
            font-size: 0;
            background-color: rgba(255, 255, 255, 0.55);
        }
    }
}
</style>
