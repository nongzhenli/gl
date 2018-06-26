<template>
    <el-scrollbar wrapClass="scrollbar-wrapper">
        <el-menu mode="vertical"
            :show-timeout="200"
            :default-active="$route.path"
            :collapse="isCollapse"
            background-color="#304156"
            text-color="#fff"
            active-text-color="#ffd04b">
            <sidebar-item :routes="routes"></sidebar-item>
        </el-menu>
    </el-scrollbar>
</template>

<script>
import { mapGetters } from 'vuex'
import SidebarItem from './SidebarItem'

export default {
    components: { SidebarItem },
    computed: {
        ...mapGetters([
            'sidebar'
        ]),
        routes() {
            // 传递所有路由配置
            return this.$router.options.routes
        },
        isCollapse() {
            return !this.sidebar.opened
        }
    }
}
</script>
