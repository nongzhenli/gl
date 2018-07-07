<template>
    <div class="app-container view-marketing-activity">
        <el-table :data="list"
            v-loading.body="listLoading"
            element-loading-text="Loading"
            stripe
            border
            fit
            highlight-current-row
            header-row-class-name="thead-row__header">
            <el-table-column align="left"
                label='序号'
                width="80">
                <template slot-scope="scope">
                    {{scope.$index}}
                </template>
            </el-table-column>
            <el-table-column label="昵称"
                width="140"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.nickname}}
                </template>
            </el-table-column>
            <el-table-column label="姓名"
                class-name="el-table-cell__activity-name"
                width="140">
                <template slot-scope="scope">
                    {{scope.row.custname}}
                    <!-- <router-link :to="'activity/'+ scope.row.id "></router-link> -->
                </template>
            </el-table-column>
            <el-table-column label="手机号码"
                width="160"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.mobile}}
                </template>
            </el-table-column>
            <el-table-column label="状态"
                width="130"
                align="left">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status, 'type' | statusFilter">{{ scope.row.status, 'name' | statusFilter }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="推荐人"
                max-width="160"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.prize_id}}
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="last_follow_unfollow_time"
                label="关注/取消时间"
                width="130">
                <template slot-scope="scope">
                    <span  v-html="isEmptyFilter(scope.row.last_follow_unfollow_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                width="130"
                prop="complete_time"
                label="完成时间">
                <template slot-scope="scope">
                    <span  v-html="isEmptyFilter(scope.row.complete_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="sign_time"
                label="填表时间"
                width="130">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.sign_time)"></span>
                </template>
            </el-table-column>

            <el-table-column align="left"
                prop="get_time"
                label="领取时间"
                width="130">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.get_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="create_time"
                label="创建时间"
                width="130">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.create_time)"></span>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import { getMarktingGetFans } from '@/api/marketing'
export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    created() {
        this.fetchData();
        // 获取路由信息
        console.log(this.$route);
    },
    computed: {
    },
    filters: {
        statusFilter(data, type) {
            const statusMap = {
                "0": {
                    "type": "danger",
                    "name": "取消关注"
                },
                "1": {
                    "type": "gray",
                    "name": "已关注"
                },
                "2": {
                    "type": "success",
                    "name": "已完成"
                },
                "3": {
                    "type": "success",
                    "name": "成功领取奖品"
                },
                "4": {
                    "type": "gray",
                    "name": "已成功填表"
                },
            }
            return statusMap[data][type];
        },
    },
    mounted() {

    },
    methods: {
        // 初始化数据
        fetchData() {
            this.listLoading = true
            getMarktingGetFans({ id: this.$route.params.id }).then(response => {
                this.list = response.data.items
                this.listLoading = false
            })
        },
        // 过滤单元格空数据 【无法通过过滤器、计算器实现，替换methods方法使用，OK】
        isEmptyFilter(data) {
            return data || `<i style='color: #bbb;'>NULL</i>`;
        }
    },
}
</script>
<style lang="less">
</style>
 