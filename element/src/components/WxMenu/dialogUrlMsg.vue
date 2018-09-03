<template>
    <div class="sendMsg__url_dialog">
        <!-- 选择元素 -->
        <el-dialog title="选择图文消息"
            custom-class="menu-sendMsg__selet-context"
            width="780px"
            :before-close="closeDialog"
            :visible.sync="dialogUrlVisible">
            <el-tabs v-model="activeName"
                @tab-click="handleClick">
                <el-tab-pane label="素材库"name="first" >
                    <el-table
                        class="news_tab__table"
                        header-row-class-name="news_tab__table_header"
                        row-class-name="news_tab__table_tr"
                        tooltip-effect="dark"
                        style="width: 96%"
                        :data="tableData3">
                        <el-table-column
                        label="标题"
                        show-overflow-tooltip>
                            <template slot-scope="scope">
                                <el-radio 
                                v-model="radio" 
                                :label="scope.$index"
                                @change="changeRadioValue"
                                >{{ scope.row.title }}</el-radio>
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="日期"
                            width="200">
                            <template slot-scope="scope">{{ scope.row.time|formatTime }}</template>
                        </el-table-column>
                    </el-table>
                </el-tab-pane>
                <el-tab-pane label="历史消息"
                    name="second">历史消息</el-tab-pane>
            </el-tabs>
            <el-row style="text-align: center;"
                class="footer_button">
                <el-button type="success"
                    size="medium "
                    native-type="button"
                    @click="retrunItemData()">确定</el-button>
                <el-button type="info"
                    plain
                    size="medium "
                    native-type="button"
                    @click="closeDialog()">取消</el-button>
            </el-row>
        </el-dialog>
    </div>
</template>

<script>
import { formatTime } from '@/utils/index'
import { updataWxMenuCustomItem } from '@/api/wechat'
import { get, getList } from '@/api/wxMedia'
export default {
    props: ['dialogUrlVisible', "urlData"],
    data() {
        return {
            activeName: 'first',
            loading: true,
            radio: null,
            selectItem: {
                "title": "",
                "url": "",
                "media_id": "",
                "time": 0,
            },
            tableData3: [{
                title: "阿萨德",
                url: "www.baidu.com__1",
                media_id: "123345566_1",
                time: "1535959451",
            }, {
                title: "大黑测试图文文章222",
                url: "www.baidu.com__2",
                media_id: "123345565_2",
                time: "1535959451",
            }, {
                title: "分享图片",
                url: "www.baidu.com__3",
                media_id: "123345566_3",
                time: "1535959451",
            }, {
                title: "大黑测试图文文章",
                url: "www.baidu.com__4",
                media_id: "123345566_4",
                time: "1535959451",
            }],
        }
    },
    created() {
        // console.log(this.dialogUrlVisible)

    },
    watch: {
        dialogUrlVisible(newValue, oldValue) {
            if (newValue == true) {
                this.getSendMsgImgTextItem()
            }
        }
    },
    filters: {
        formatTime: function (data) {
            return formatTime(data, true, "{y}年{m}月{d}日 {h}:{i}");
        }
    },
    computed: {
    },
    methods: {
        // 请求获取图文素材
        getSendMsgImgTextItem() {
            this.loading = true;
            // msg_type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
            getList({
                "wx_id": 2,
                "msg_type": "news"
            }).then(response => {
                this.selectListItem.items = response.data
                this.$nextTick(() => {
                    this.loading = false;
                })
            })
            console.log(this.$parent)
        },
        retrunItemData() {
            if (this.radio === null) {
                this.$message.error('错误，至少选择一个素材！');
                return false;
            }

            // 更新数据
            let options = {
                "id": this.$attrs['data-index'],
                "key": "jsonstr",
                // "value": this.selectListItem.current,
                "value": {
                    "send_type": this.$parent.send_message.send_type,
                    "send_context_tab": this.$parent.send_message.send_context_tab,
                    "send_context": this.selectItem,
                }
            }
            console.log(options)
            // updataWxMenuCustomItem({
            //     "wx_id": this.$route.params.id,
            //     "options": JSON.stringify(options)
            // }).then(response => {
            //     console.log(response)
            // })

            this.$emit("update:dialogUrlVisible", false);
            this.$emit("update:urlData", this.selectItem);
            this.selectItem = {}
            this.radio = null
        },
        closeDialog() {
            this.$emit("update:dialogUrlVisible", false);
            this.selectItem = {}
            this.radio = null
        },
        // tab切换
        handleClick(tab, event) {
            console.log(tab, event);
        },
        // 单选内容
        changeRadioValue(radio){
            this.selectItem= this.tableData3[radio];
        }
    },
}
</script>

<style lang="less">
// 选择素材
.sendMsg__url_dialog {
    .menu-sendMsg__selet_list {
        height: 450px;
    }
    .el-tabs__nav-wrap {
        margin: auto -20px;
        padding: 0 20px;
    }
    .el-tabs__nav-wrap::after {
        height: 1px;
    }
    .news_tab__table {
        border: 1px solid #E4E7ED;
    }
    .news_tab__table_header th {
        padding: 10px 15px;
        background-color: #f4f5f9;
    }
    .news_tab__table_tr td {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>
