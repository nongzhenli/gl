<template>
    <el-breadcrumb class="app-breadcrumb"
        separator-class="el-icon-arrow-right">
        <transition-group name="breadcrumb">
            <el-breadcrumb-item v-for="(item,index)  in levelList"
                :key="item.path"
                v-if="item.meta.title">
                <span v-if="item.redirect==='noredirect'||index==levelList.length-1"
                    class="no-redirect">{{item.meta.title}}</span>
                <router-link v-else
                    :to="item.redirect||item.path">{{item.meta.title}}</router-link>
            </el-breadcrumb-item>
        </transition-group>
    </el-breadcrumb>
</template>

<script>
export default {
    created() {
        this.getBreadcrumb();
    },
    data() {
        return {
            levelList: null
        };
    },
    watch: {
        $route() {
            this.getBreadcrumb();
        }
    },
    methods: {
        getBreadcrumb() {
            const $_thisRoute = this.$route;
            let matched = this.$route.matched.filter(item => item.name);
            const first = matched[0];
            if (first && first.name !== "dashboard") {
                matched = [ { path: "/dashboard", meta: { title: "起始页" } }].concat(matched);
            }
            // 针对兄弟路由地址，B兄弟路由面包屑导航在A后面。例如： 面包屑 A/B
            if ($_thisRoute.meta.parent) {
                // 2018/07/22 自定义面包屑导航【path 不够灵活，待拓展】
                let $_thisRoutePath = $_thisRoute.meta.parent.replace(/:id/, $_thisRoute.params.id);
                matched.splice(2, 0, {
                    path: $_thisRoutePath,
                    meta: { title: "详情" }
                });
                // end
            }
            this.levelList = matched;
        }
    }
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.app-breadcrumb.el-breadcrumb {
    display: inline-block;
    font-size: 12px;
    line-height: 42px;
    margin-left: 5px;
    .no-redirect {
        color: #97a8be;
        cursor: text;
    }
}
</style>
