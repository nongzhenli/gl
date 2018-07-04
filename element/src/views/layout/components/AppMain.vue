<template>
    <section class="app-main">
        <transition name="fade"
            mode="out-in">
            <router-view :key="key"></router-view>
            <!-- <router-view></router-view> -->
        </transition>
    </section>
</template>

<script>
export default {
    name: 'AppMain',
    computed: {
        key() {
            return this.$route.name !== undefined ? this.$route.name + +new Date() : this.$route + +new Date()
        }
    }
}
</script>

<style lang="less">
.el-table__header-wrapper {
    .thead-row__header {
        color: #333;
    }
}
</style>

