<template>
    <div class="app-container view-marketing-activity">
        <div class="top-form-area">
            <el-row>
                <el-button size="medium"  icon="el-icon-tickets" @click="dialogFormVisible = true" >导出数据</el-button>
                <!-- <el-button type="text" @click="dialogFormVisible = true">导出数据</el-button> -->
                <el-dialog title="导出活动数据" :visible.sync="dialogFormVisible">
                    <el-form :model="form">
                        <el-form-item label="导出文件名" :label-width="formLabelWidth">
                        <el-input v-model="form.name" auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="活动区域" :label-width="formLabelWidth">
                        <el-select v-model="form.region" placeholder="请选择活动区域">
                            <el-option label="区域一" value="shanghai"></el-option>
                            <el-option label="区域二" value="beijing"></el-option>
                        </el-select>
                        </el-form-item>
                    </el-form>
                    <div slot="footer" class="dialog-footer">
                        <el-button @click="dialogFormVisible = false">取 消</el-button>
                        <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
                    </div>
                </el-dialog>
            </el-row>
        </div>
        <div class="table-data-list">
            <el-table :data="list.data"
                      v-loading.body="listLoading"
                      element-loading-text="Loading"
                      stripe
                      fit
                      highlight-current-row
                      header-row-class-name="thead-row__header">
                <el-table-column align="left"
                                 label='序号'
                                 width="80">
                    <template slot-scope="scope">
                        {{scope.row.id}}
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
                                 min-width="130"
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
                <el-table-column label="支持人数"
                                 max-width="160"
                                 align="left">
                    <template slot-scope="scope">{{scope.row.people}}</template>
                </el-table-column>
                <el-table-column align="left"
                                 prop="last_follow_unfollow_time"
                                 label="关注/取消时间"
                                 width="150">
                    <template slot-scope="scope">
                        <span v-html="isEmptyFilter(scope.row.last_follow_unfollow_time)"></span>
                    </template>
                </el-table-column>
                <el-table-column align="left"
                                 width="150"
                                 prop="complete_time"
                                 label="完成时间">
                    <template slot-scope="scope">
                        <span v-html="isEmptyFilter(scope.row.complete_time)"></span>
                    </template>
                </el-table-column>
                <el-table-column align="left"
                                 prop="sign_time"
                                 label="填表时间"
                                 width="150">
                    <template slot-scope="scope">
                        <span v-html="isEmptyFilter(scope.row.sign_time)"></span>
                    </template>
                </el-table-column>

                <el-table-column align="left"
                                 prop="get_time"
                                 label="领取时间"
                                 width="150">
                    <template slot-scope="scope">
                        <span v-html="isEmptyFilter(scope.row.get_time)"></span>
                    </template>
                </el-table-column>
                <el-table-column align="left"
                                 prop="create_time"
                                 label="创建时间"
                                 width="150">
                    <template slot-scope="scope">
                        <span v-html="isEmptyFilter(scope.row.create_time)"></span>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination background
                layout="prev, pager, next"
                :total="list.total"
                prev-text="上一页"
                next-text="下一页"
                class="marketing-activity__page-list"
                @current-change="pageDataGet">
            </el-pagination>
        </div>
    </div>
</template>

<script>
import { getMarktingGetFans } from "@/api/marketing";
import { formatTime } from "@/utils/index";
export default {
    data() {
        return {
            list: {
                data: [],
                total: 0
            },
            listLoading: true,

            dialogTableVisible: false,
            dialogFormVisible: false,
            form: {
            name: '',
            region: '',
            date1: '',
            date2: '',
            delivery: false,
            type: [],
            resource: '',
            desc: ''
            },
            formLabelWidth: '120px'
        };
    },
    created() {
        this.fetchData();
    },
    computed: {},
    filters: {
        statusFilter(data, type) {
            const statusMap = {
                "0": {
                    type: "danger",
                    name: "取消关注"
                },
                "1": {
                    type: "gray",
                    name: "已关注"
                },
                "2": {
                    type: "success",
                    name: "已完成"
                },
                "3": {
                    type: "success",
                    name: "成功领取奖品"
                },
                "4": {
                    type: "gray",
                    name: "已成功填表"
                }
            };
            return statusMap[data][type];
        }
    },
    mounted() {},
    methods: {
        // 初始化数据
        fetchData() {
            this.listLoading = true;
            getMarktingGetFans({ id: this.$route.params.id }).then(response => {
                this.list.data = response.data.data;
                this.list.total = response.data.total;
                this.listLoading = false;
            });
        },
        // 过滤单元格空数据 【无法通过过滤器、计算器实现，替换methods方法使用，OK】
        isEmptyFilter(data) {
            return (
                formatTime(data, true, "{y}-{m}-{d} {h}:{i}") ||
                `<i style='color: #bbb;'>NULL</i>`
            );
        },
        // 分页
        pageDataGet(pageIdx) {
            this.listLoading = true;
            getMarktingGetFans({
                id: this.$route.params.id,
                p: pageIdx
            }).then(response => {
                this.list.data = response.data.data;
                this.list.total = response.data.total;
                this.listLoading = false;
            });
        }
    }
};
</script>
<style lang="less">
.marketing-activity__page-list {
    margin: 30px 0;

    &.el-pagination.is-background button.btn-prev,
    &.el-pagination.is-background button.btn-next {
        padding: 0 8px;

        &:not([disabled="disabled"]):hover {
            background-color: #409eff;
            color: #fff;
        }
    }
}
</style>
 