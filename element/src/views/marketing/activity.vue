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
                width="95">
                <template slot-scope="scope">
                    {{scope.$index}}
                </template>
            </el-table-column>
            <el-table-column label="昵称"
                width="120"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.nickname}}
                </template>
            </el-table-column>
            <el-table-column label="姓名"
                class-name="el-table-cell__activity-name"
                width="100">
                <template slot-scope="scope">
                    {{scope.row.custname}}
                    <!-- <router-link :to="'activity/'+ scope.row.id "></router-link> -->
                </template>
            </el-table-column>
            <el-table-column label="手机号码"
                width="110"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.mobile}}
                </template>
            </el-table-column>
            
            <el-table-column label="奖品名称"
                width="150"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.pageviews}}
                </template>
            </el-table-column>
            <el-table-column label="操作人"
                width="110"
                align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.author}}</span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="created_at"
                label="开始时间"
                max-width="150">
                <template slot-scope="scope">
                    <span>{{scope.row.create_time}}</span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="created_at"
                label="结束时间">
                <template slot-scope="scope">
                    <span>N/A</span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="created_at"
                label="创建时间"
                max-width="150">
                <template slot-scope="scope">
                    <span>{{scope.row.create_time}}</span>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import { getMarktingNumber } from '@/api/marketing'
export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    created() {
        this.listLoading = true
        getMarktingNumber({ act_id: 1 }).then(response => {
            console.log(response);
            this.list = response.data.items
            this.listLoading = false
        })
    },
    mounted() {

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
 