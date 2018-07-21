<template>
    <div class="app-container view-wechat__menu">
        <div class="wechat-menu__header">
            <p class="title">自定义菜单</p>
            <span class="sub-text">若近期开启过吸粉活动，请确认吸粉活动已经结束，否则切勿修改菜单，以免影响吸粉活动进行。</span>
        </div>
        <main class="wechat-menu__body">
            
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    created(){
        console.log(this.$route)
    }
}
</script>

<style lang="less" scoped>
// 自定义菜单容器
.view-wechat__menu {
    padding: 50px 60px;
}

// 头部提示
.wechat-menu__header {
    padding: 10px 15px;
    background: #f7f7fa;
    border: 1px solid #d8d7d7;
    border-radius: 4px;

    .title { font-size: 18px; color: #303133; }
    .sub-text { font-size: 14px; color: #E6A23C; }
    .title,
    .sub-text {
        display: block;
        margin: 15px auto;
    }
}
</style>
