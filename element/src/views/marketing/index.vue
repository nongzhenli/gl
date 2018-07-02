<template>
    <div class="app-container view-marketing-index">
        <el-table :data="list"
            v-loading.body="listLoading"
            element-loading-text="Loading"
            stripe
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
            <el-table-column label="活动名"
                class-name="el-table-cell__activity-name">
                <template slot-scope="scope">
                    <router-link :to="'activity/'+ scope.row.id ">{{scope.row.name}}</router-link>
                </template>
            </el-table-column>
            <el-table-column label="活动类型"
                width="160"
                align="left"
                prop="type"
                :filters="[{text: '报名抽奖', value: '报名抽奖'}, {text: '公众号吸粉', value: '公众号吸粉'}]"
                :filter-method="filterHandler"
                >
                <template slot-scope="scope">
                    {{scope.row.type}}
                </template>
            </el-table-column>
            <el-table-column label="报名量"
                width="110"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.pageviews}}人
                </template>
            </el-table-column>
            <el-table-column label="支付量"
                width="110"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.pageviews}}人
                </template>
            </el-table-column>
            <el-table-column label="支付总金额"
                width="150"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.pageviews}}元
                </template>
            </el-table-column>

            <el-table-column class-name="status-col"
                label="活动状态"
                width="110"
                align="left">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status | statusFilter">{{scope.row.status| statusFilter | statusNameFilter}}</el-tag>
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
                    <i class="el-icon-time"></i>
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
                    <i class="el-icon-time"></i>
                    <span>{{scope.row.create_time}}</span>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import { getMarktingList } from '@/api/marketing'

export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    filters: {
        statusFilter(status) {
            const statusMap = {
                "0": 'danger',
                "1": 'success',
                "2": 'gray',
            }
            return statusMap[status]
        },
        statusNameFilter(status) {
            const statusMap = {
                "danger": '已结束',
                "success": '进行中',
                "gray": '未开始',
            }
            return statusMap[status]
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getMarktingList(this.listQuery).then(response => {
                this.list = response.data.items
                this.listLoading = false
            })
        },
        // 数据筛选方法
        filterHandler(value, row, column) {
            const property = column['property'];
            return row[property] === value;
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


