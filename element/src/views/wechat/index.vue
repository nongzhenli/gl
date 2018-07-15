<template>
    <div class="app-container view-wechat-index">
        <el-table :data="list"
            v-loading.body="listLoading"
            element-loading-text="Loading"
            stripe
            fit
            highlight-current-row
            header-row-class-name="thead-row__header">
            <el-table-column align="left"
                label='序号'
                width="60">
                <template slot-scope="scope">
                    {{scope.$index}}
                </template>
            </el-table-column>
            <el-table-column label="公众号名称"
                class-name="el-table-cell__activity-name">
                <template slot-scope="scope">
                    <router-link :to="'detail/'+ scope.row.id ">{{scope.row.name}}</router-link>
                </template>
            </el-table-column>
            <el-table-column label="APP_ID"
                width="170"
                class-name="el-table-cell__activity-name">
                <template slot-scope="scope">
                    {{scope.row.app_id}}
                </template>
            </el-table-column>
            <el-table-column label="状态"
                width="100"
                align="left"
                prop="status"
                :filters="[{text: '正常', value: 1}, {text: '注销', value: 0}]"
                :filter-method="filterHandler">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.status, 'type' | statusFilter">{{scope.row.status, 'name' | statusFilter}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column label="token令牌"
                min-width="110"
                align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.token}}</span>
                </template>
            </el-table-column>
            <el-table-column label="消息加解密密钥"
                min-width="160"
                align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.encodingaeskey}}</span>
                </template>
            </el-table-column>
            <el-table-column label="服务器地址(URL)"
                min-width="160"
                align="left">
                <template slot-scope="scope">
                    <span>{{scope.row.server_http_url}}</span>
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
                prop="last_time"
                label="最近更新时间"
                max-width="150">
                <template slot-scope="scope">
                    <span v-html="isEmptyFilter(scope.row.last_time)"></span>
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
                    <el-button size="mini"
                        type="primary">
                        <router-link :to="'detail/'+ scope.row.id ">查看</router-link>
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
import { getWechatList } from '@/api/wechat'
import { formatTime } from '@/utils/index'

export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    filters: {
        // 状态过滤器
        statusFilter(data, type) {
            const statusMap = {
                "0": {
                    "type": "danger",
                    "name": "注销"
                },
                "1": {
                    "type": "success",
                    "name": "正常"
                },
                "2": {
                    "type": "gray",
                    "name": "未开始"
                },

            }
            return statusMap[data][type];
        },
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getWechatList().then(response => {
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
</style>


