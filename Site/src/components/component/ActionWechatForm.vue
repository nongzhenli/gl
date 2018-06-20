<template>
    <div class="action-wechat-form">
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
            <button type="button" class="submit-btn" @click="submitLogin">确认领取</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { VueCookie } from "../../utils/utils";
export default {

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
        background-image: url("../../assets/img/lottery/lotteryBtn.png");
        margin: 0.5rem auto 0.6rem;
        background-repeat: no-repeat;
        background-size: contain;
        background-color: transparent;
        border: 0;
    }
}
</style>
