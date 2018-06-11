<template>

    <div class="lottery-rotate" @click="clickLotteryBnt">
        <div class="inside">
            <div v-if="prizeInfo" v-for="(item, idx ) of prizeInfo" :key="idx" ref="pice" :class="{'border_': idx != 4, 'rotate-btn': idx == 4, 'active': index == idx}">
                <template v-if="item!==null">
                    <img :src="item.img_url" :title="item.name" :alt="item.name" />
                </template>
                <template v-else>
                    <img :src="imgUrl.prizeBtn" class="rotate-img" />
                </template>
            </div>
        </div>

        <!-- 中奖Toast -->
        <lottery-toast :lottery-prize="prizeObj" :show-toast.sync="showToast" v-show="showToast" :status.sync="status">
        </lottery-toast>

        <!-- 验证码Toast -->
        <lottery-vcode v-if="showVcode" :show-vcode.sync="showVcode" :status.sync="status">
        </lottery-vcode>

        <!-- Toast -->
        <div class="van-toast van-toast--default van-toast--middle" v-show="loading" style="z-index: 2036;">
            <div class="van-loading van-loading--circular van-loading--white">
                <span class="van-loading__spinner van-loading__spinner--circular">
                    <svg viewBox="25 25 50 50" class="van-loading__circular">
                        <circle cx="50" cy="50" r="20" fill="none"></circle>
                    </svg>
                </span>
            </div>
            <div class="van-toast__text">加载中...</div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../utils/utils";
import LotteryToast from "@/components/LotteryToast";
import LotteryVcode from "@/components/LotteryVcode";
export default {
    // 组件传值 iSign 判断是否登录
    props: ["loginStatu", "prizeIndex"],
    data() {
        return {
            title: "积分转盘",
            index: -1, // 当前转动到哪个位置，起点位置
            count: 8, // 总共有多少个位置
            timer: 0, // 每次转动定时器
            speed: 200, // 初始转动速度
            times: 0, // 转动次数
            cycle: 50, // 转动基本次数：即至少需要转动多少次再进入抽奖环节
            prize: -1, // 中奖位置
            prizeObj: {}, // 中奖奖品信息
            click: true, // 防止转盘未停止重复触发
            showToast: false, // 中奖弹层
            showVcode: false, // 验证码弹层
            status: this.loginStatu, // 登录状态
            loading: false,

            prizeInfo: [], // 奖品数据
            rollSort: [], // 滚动顺序
            imgUrl: {
                // notStartBtn: require("../assets/img/lottery/noStart.png"),
                prizeBtn: require("../assets/img/lottery/prizeBtn.png")
            },
        };
    },
    components: {
        LotteryToast,
        LotteryVcode
    },
    created() {
        this.getPrizeJson();

    },
    watch: {
        loginStatu(newValue, oldValue) {
            // 父动态改变值，此处监听，保证子组件能动态获取
            if (newValue >= 0) {
                this.status = newValue;
            }
        }
    },
    mounted() {
        // console.log("mounted：" + this.status);
    },
    methods: {
        // 获取奖品列表数据
        getPrizeJson() {
            // 异步获取奖品数据
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/lottery/prize/info",
                method: "GET"
            }).then(response => {
                this.prizeInfo = response.data.prizeInfo
                this.rollSort = response.data.roll;

            }).catch(error => { });
        },
        // 开始抽奖
        clickLotteryBnt(event) {
            // 触发按钮 rotate-img
            if (event.target.className != "rotate-img") return;

            // 未报名
            if (this.status == 0) {
                this.showVcode = true;
                return false;
            } else if (this.status == 1) {
                // 已经报名，待抽奖
                this.showVcode = false;
            } else if (this.status == 2) {
                // 已抽奖，待领取
                this.showToast = true;
                this.prize = this.prizeIndex;
                this.prizeObj = this.prizeInfo[this.prize];
                this.showVcode = false;

                return false;

            } else if (this.status == 3) {
                // 已领取
                this.showToast = true;
                this.prize = this.prizeIndex;
                this.prizeObj = this.prizeInfo[this.prize];
                this.showVcode = false;

                return false;
            }

            if (!this.click) return;

            // 返回抽奖结果 【包含执行了 转动、防重复点击、】
            this.resultPrize();
        },
        // 开始转动
        startRoll() {
            this.times += 1; // 转动次数
            this.oneRoll(); // 转动过程调用的每一次转动方法，这里是第一次调用初始化

            // 如果当前转动次数达到要求 && 目前转到的位置是中奖位置
            if (this.times > this.cycle + 10 && this.prize === this.index) {
                clearTimeout(this.timer); // 清除转动定时器，停止转动
                this.prize = -1;
                this.times = 0;
                this.click = false; // 只能抽奖一次，所有抽奖完成后，设置 falase

                // 延迟弹出
                // *知识点：setTimeout函数中，this指向 setTimeout，反而使用箭头函数 this始终指向 源this
                setTimeout(() => {
                    this.showToast = true;
                }, 600);

                console.log("你已经中奖了");
            } else {
                if (this.times < this.cycle) {
                    this.speed -= 10; // 加快转动速度
                } else if (this.times === this.cycle) {
                    // *******数据模拟，实际点击时候，从接口获取数据****
                    // 随机获得一个中奖位置
                    var index = parseInt(Math.random() * 7, 0) || 0;
                    if (index == 4) index = 0;
                    // ********** 接口回调返回抽奖结果 end ************

                    // this.prize = index;
                    this.prizeObj = this.prizeInfo[this.prize];

                    // console.log(this.prizeObj);
                    // console.log(`中奖位置${this.prize}`);
                } else if (
                    this.times > this.cycle + 10
                    && ((this.prize === 0 && this.index === 7)
                        || this.prize === this.index + 1)) {
                    this.speed += 110;
                } else {
                    this.speed += 20;
                }

                if (this.speed < 40) {
                    this.speed = 40;
                }

                // 定时器调用
                this.timer = setTimeout(this.startRoll, this.speed);
            }
        },
        // 每一次转动
        oneRoll() {
            let index_ = this.index; // 当前转到的位置
            let indexOf = this.rollSort.indexOf(index_) + 1; // 获取下个转动的顺序索引
            if (indexOf >= this.count) {
                // 假如下次转动顺序索引大于数组本身，则从0开始
                indexOf = 0;
            }
            this.index = this.rollSort[indexOf];
        },
        // 返回抽奖结果
        resultPrize() {
            // 异步获取抽奖结果（位置）
            axios({
                url: "http://gl.gxqqbaby.cn/api/v1/lottery/user/prize",
                method: "POST",
                headers: { 'token': this.utils.VueCookie.get("loginToken") }
            }).then(response => {
                console.log(response)
                if (response.data.statu == 1) {
                    // 首次抽奖返回
                    this.prize = response.data.prize.index;
                    this.speed = 200;
                    this.click = false;
                    // 开始转动
                    this.startRoll();
                } else if (response.data.statu == 2) {
                    // 已经抽奖过了（防止前端状态被篡改，每次触发点击则请求验证）
                    this.prize = response.data.prize.index;
                    this.showToast = true;
                    this.click = false;
                }
            }).catch(error => { });
        }
    }
};
</script>

<style lang="less" scoped>
.lottery-rotate {
    position: relative;
    width: 10rem;
    height: 11.5rem;
    padding-top: 27%;
    border-radius: 0.2rem;
    box-sizing: border-box;
    background-image: url("../assets/img/lottery/bgImg/LotteryRotateImg.png");
    background-size: contain;
    background-position: center center;
    background-repeat: no-repeat;
    margin-top: 0.5rem;
    .inside {
        width: 67%;
        margin-left: 15%;
        margin-right: auto;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-content: center;
        overflow: hidden;
    }
    .border_,
    .rotate-btn {
        display: inline-block;
        position: relative;
        background-size: 100%;
        width: 32%;
        height: auto;
        padding-top: 32%;
        box-sizing: border-box;
        margin-top: 2.4%;

        &:nth-child(3n) {
            margin-right: 0;
        }
        &:nth-child(7),
        &:nth-child(8),
        &:nth-child(9) {
            margin-bottom: 0;
        }
        box-sizing: border-box;
        img {
            max-width: 100%;
            height: 100%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
    .border_ {
        font-size: 0;
        border-radius: 0.2rem;
        background-color: #fff;

        img {
            max-width: 80%;
            height: 80%;
        }
        // background-image: url("../assets/img/lottery/border.png");
        &.active img {
            border: 0.09rem solid #ff5722;
            box-sizing: border-box;
            border-radius: 0.2rem;
            // background-image: url("../assets/img/lottery/borderSelect.png");
        }
    }
}
.van-toast {
    position: fixed;
    top: 50%;
    left: 50%;
    display: -webkit-box;
    display: -webkit-flex;
    display: flex;
    color: #fff;
    font-size: 12px;
    line-height: 1.2;
    border-radius: 5px;
    word-break: break-all;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    flex-direction: column;
    box-sizing: border-box;
    -webkit-transform: translate3d(-50%, -50%, 0);
    transform: translate3d(-50%, -50%, 0);
    background-color: rgba(0, 0, 0, 0.7);
    &.van-toast--default {
        width: 120px;
        min-height: 120px;
        padding: 15px;
        margin: 10px 0 5px;
        .van-toast__text {
            font-size: 14px;
            padding-top: 10px;
        }
        .van-loading {
            margin: 10px 0 5px;
        }
    }
    .van-loading {
        width: 30px;
        height: 30px;
        z-index: 0;
        font-size: 0;
        line-height: 0;
        position: relative;
        vertical-align: middle;
        .van-loading__spinner {
            z-index: -1;
            width: 100%;
            height: 100%;
            position: relative;
            display: inline-block;
            box-sizing: border-box;
            -webkit-animation: van-rotate 0.8s linear infinite;
            animation: van-rotate 0.8s linear infinite;
        }
        .van-loading__spinner--circular {
            -webkit-animation-duration: 2s;
            animation-duration: 2s;
            .van-loading__circular {
                width: 100%;
                height: 100%;
                & > circle {
                    stroke-width: 3;
                    stroke-linecap: round;
                    -webkit-animation: van-circular 1.5s ease-in-out infinite;
                    animation: van-circular 1.5s ease-in-out infinite;
                }
            }
        }
        &.van-loading--white circle {
            stroke: #fff;
        }
    }
    @keyframes van-rotate {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes van-circular {
        0% {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
        }
        50% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -40;
        }
        100% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -120;
        }
    }
}
</style>