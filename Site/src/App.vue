<template>
    <div id="app">
        <!-- <img src="./assets/logo.png"> -->
        <router-view v-wechat-title="$route.meta.title"></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {};
    },
    mounted() {}
};
</script>

<style>
/* html, body {
    background-color: #fee330 !important;
} */
body {
    width: 100%;
    height: 100%;
}
#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    /* margin-top: 60px; */
    width: 100%;
    height: 100%;
}
</style>
