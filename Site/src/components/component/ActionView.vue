<template>
    <div class="action-view">
        <action-lottery v-if="aid === 1"></action-lottery>
        <action-lottery v-if="aid === 1"></action-lottery>
    </div>
</template>

<script>
import ActionLottery from '@/components/component/ActionLottery'
export default {
    data() {
        return {
            "aid": 0
        }
    },
    components: { ActionLottery },
    created () {
        // 通过url截取活动aid参数，不是通过路由参数
        if(this.getUrlParam('aid')){
            this.aid = this.getUrlParam('aid')
        }
    },
    methods: {
        // 获取url参数
        getUrlParam: function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        },
    },
}
</script>

<style lang="less" scoped>
</style>