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
                    <router-link :to="scope.row.page_url+'/'+ scope.row.id ">{{scope.row.name}}</router-link>
                </template>
            </el-table-column>
            <el-table-column label="活动类型"
                width="160"
                align="left"
                prop="type"
                :filters="[{text: '报名抽奖', value: '报名抽奖'}, {text: '公众号吸粉', value: '公众号吸粉'}]"
                :filter-method="filterHandler">
                <template slot-scope="scope">
                    {{scope.row.type}}
                </template>
            </el-table-column>
            <el-table-column label="报名量"
                width="110"
                align="left">
                <template slot-scope="scope">
                    {{scope.row.total, "人" | intNumFilter}}
                </template>
            </el-table-column>
            <el-table-column class-name="status-col"
                label="活动状态"
                width="110"
                align="left">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status, 'type' | statusFilter">{{scope.row.status, 'name' | statusFilter}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="操作人"
                width="110"
                align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.create_by}}</span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="start_time"
                label="开始时间"
                max-width="150">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.start_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="end_time"
                max-width="150"
                label="结束时间">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.end_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                prop="create_time"
                label="创建时间"
                max-width="150">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.create_time)"></span>
                </template>
            </el-table-column>
            <el-table-column align="left"
                label="操作"
                width="80">
                <template slot-scope="scope">
                    <router-link :to="scope.row.page_url+'/'+ scope.row.id ">
                        <el-button size="mini" type="primary">查看</el-button>
                    </router-link>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import { getMarktingList } from '@/api/marketing'
import { formatTime } from '@/utils/index'

export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    filters: {
        statusFilter(data, type) {
            const statusMap = {
                "0": {
                    "type": "danger",
                    "name": "已结束"
                },
                "1": {
                    "type": "success",
                    "name": "进行中"
                },
                "2": {
                    "type": "gray",
                    "name": "未开始"
                },

            }
            return statusMap[data][type];
        },
        valFloatFilter(value) {
            if (!value) {
                value = 0.00;
            }
            // 截取当前数据到小数点后三位
            let transformVal = Number(value).toFixed(3);
            let realVal = transformVal.substring(0, transformVal.length - 1);
            // num.toFixed(3)获取的是字符串
            return realVal
        },
        intNumFilter(data, unit) {
            if (data) {
                data += unit;
            } else {
                data = "/";
            }
            return data;

        }

    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getMarktingList().then(response => {
                this.list = response.data.items
                this.listLoading = false
            })
        },
        // 数据筛选方法
        filterHandler(value, row, column) {
            const property = column['property'];
            return row[property] === value;
        },
        // 过滤单元格空数据 【无法通过过滤器、计算器实现，替换methods方法使用，OK】
        isEmptyFilter(data) {
            return formatTime(data, true, "{y}-{m}-{d} {h}:{i}") || `<i style='color: #bbb;'>NULL</i>`;
        }
    }
}
</script>

<style lang="less">
.thead-row__header {
    th {
        color: #9a9a9a;
        font-weight: 400;
    }
}
</style>


