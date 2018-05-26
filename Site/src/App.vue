<template>
    <div id="app">
        <!-- <img src="./assets/logo.png"> -->
        <router-view/>
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
html, body {
    background-color: #49a6f8 !important;
    background: -webkit-gradient(
        linear,
        left top,
        left bottom,
        from(#337cf6),
        to(#49a6f8)
    ) !important;
}
#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    /* margin-top: 60px; */
}
</style>
