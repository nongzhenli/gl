<template>
    <div class="lottery-toast">
        <img src="../assets/img/lottery/circleLight.png" class="circleLight" alt="">

        <!-- 恭喜抽中 -->
        <div class="havePrize">
            <p>恭喜您抽中 {{prizeObj.name}}</p>
            <div class="proImg">
                <img :src="prizeObj.img_url" :alt="prizeObj.name">
            </div>
            <div class="des-text">工作人员将会在新店开业之后与您联系到店领取 请您保持手机通话顺畅哦</div>

            <button class="colse-btn" @click="colseLayer()">x</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            prizeObj: this.lotteryPrize, // 此时只能拿到初始值（空对象）
        };
    },
    props: ['lotteryPrize'],
    watch: {
        lotteryPrize(newValue, oldValue) {
            // 因为动态传值，所以此处监听需要再次赋值
            this.prizeObj = newValue;
            console.log("绑定的prizeObj：", this.prizeObj);
        }
    },
    mounted() {
        // console.log("初始化值：", this.prizeObj);
    },
    methods: {
        // 关闭弹层
        colseLayer() {
            this.$emit("update:showToast", false);
        }
    },
};
</script>

<style lang="less" scoped>
.lottery-toast {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    .noPrize {
        width: 5.3rem;
        height: 4.4rem;
        background-color: #fff;
        position: absolute;
        top: 3.2rem;
        left: 1.1rem;
        border-radius: 0.4rem;
        .close {
            position: absolute;
            width: 0.51rem;
            height: 0.51rem;
            top: -0.8rem;
            right: 0;
            img {
                width: 100%;
                height: 100%;
            }
        }
        p {
            font-size: 0.3rem;
            color: #707070;
            margin: 0.38rem auto 0.2rem;
            text-align: center;
        }
        .xiaofu {
            width: 1.7rem;
            height: 1.7rem;
            border-radius: 100%;
            margin: 0 auto 0.3rem;
            img {
                width: 100%;
                height: 100%;
                display: block;
            }
        }
        .btn {
            width: 3.7rem;
            height: 0.9rem;
            margin: 0 auto;
            background: url("../assets/img/lottery/btn.png") no-repeat;
            background-size: 100%;
            font-size: 0.36rem;
            color: #fff;
            line-height: 0.9rem;
            text-align: center;
            font-weight: 600;
        }
    }
    .haveLottery {
        width: 5.3rem;
        height: 4.4rem;
        background-color: #fff;
        position: absolute;
        top: 3.2rem;
        left: 1.1rem;
        border-radius: 0.4rem;
        .close {
            position: absolute;
            width: 0.51rem;
            height: 0.51rem;
            top: -0.8rem;
            right: 0;
            img {
                width: 100%;
                height: 100%;
            }
        }
        .xiaofu {
            width: 1.7rem;
            height: 1.7rem;
            margin: 0.3rem auto 0.2rem;
            img {
                width: 100%;
                height: 100%;
                display: block;
            }
        }
        p {
            font-size: 0.3rem;
            color: #707070;
            margin: 0.21rem auto 0.37rem;
            text-align: center;
        }
        .btn {
            width: 3.7rem;
            height: 0.9rem;
            margin: 0 auto;
            background: url("../assets/img/lottery/btn.png") no-repeat;
            background-size: 100%;
            font-size: 0.36rem;
            color: #fff;
            line-height: 0.9rem;
            text-align: center;
            font-weight: 600;
        }
    }
    .circleLight {
        width: 12.22rem;
        height: 12.22rem;
        position: absolute;
        top: 0.9rem;
        left: 50%;
        margin-left: -6.11rem;
        -webkit-animation: rotate 20s infinite linear;
        animation: rotate 20s infinite linear;
        transform-origin: 50% 50%;
        pointer-events: none;
    }
    @-webkit-keyframes rotate {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }
    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .havePrize {
        width: 7rem;
        padding-bottom: 0.5rem;
        border-radius: 0.4rem;
        position: absolute;
        top: 2.7rem;
        left: 0;
        right: 0;
        margin: auto;
        background: #fff url("../assets/img/lottery/prizinig.jpg") no-repeat;
        background-position: top center;
        background-size: 7.4rem 2.22rem;
        .oneBar {
            width: 1.18rem;
            height: 0.46rem;
            position: absolute;
            top: -0.1rem;
            right: 1.1rem;
            img {
                width: 100%;
                height: 100%;
            }
        }
        p {
            padding: 0 0.3rem;
            font-size: 0.45rem;
            color: #707070;
            font-weight: 700;
            margin: 2.72rem auto 0.3rem;
            text-align: center;
        }
        .proImg {
            width: 7rem;
            height: 3rem;
            margin: 0 auto 0.3rem;
            img {
                width: auto;
                max-width: 100%;
                height: 100%;
            }
        }
        .btn {
            width: 4.5rem;
            height: auto;
            margin: 0 auto;
            background: url(/static/img/btn.91d446f.png) no-repeat;
            background-size: 100%;
            text-align: center;
            background-position: center;
            a {
                font-size: 0.42rem;
                color: #fff;
                line-height: 1.2rem;
                text-align: center;
                font-weight: 600;
                letter-spacing: 0.1em;
                text-decoration: none;
            }
        }
        .des-text {
            font-size: 0.34rem;
            padding: 0 0.5rem;
            line-height: 2;
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
            background-color: rgba(255, 255, 255, 0.55);
        }
    }
}
</style>
