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
                <el-tab-pane class="news_msg" label="素材库" name="first" >
                    <el-table
                        v-loading="loading"
                        class="news_tab__table"
                        header-row-class-name="news_tab__table_header"
                        row-class-name="news_tab__table_tr"
                        tooltip-effect="dark"
                        :data="news_data.item">
                        <el-table-column
                        label="标题"
                        show-overflow-tooltip>
                            <template slot-scope="scope">
                                <el-radio 
                                v-model="radio" 
                                :label="scope.$index"
                                >{{ scope.row.content.news_item.title }}</el-radio>
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="发布日期"
                            width="200">
                            <template slot-scope="scope">{{ scope.row.content.update_time|formatTime }}</template>
                        </el-table-column>
                    </el-table>
                </el-tab-pane>
                <el-tab-pane class="history_msg" label="历史消息"
                    name="second" >
                    <div class="preview_area">
                        <p class="desc">公众帐号历史消息列表示例</p>
                    </div>
                    <div class="form_area">
                        <el-checkbox v-model="isCheckboxHistoryMsg" @change="checkboxHistoryMsg">跳转到历史消息列表</el-checkbox>
                    </div>
                    
                    
                </el-tab-pane>
            </el-tabs>
            <el-row style="text-align: center;"
                class="footer_button">
                <el-button type="success"
                    :disabled="radio|isRadioBool"
                    size="medium "
                    native-type="button"
                    @click="submitItemData()">确定</el-button>
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
            isCheckboxHistoryMsg: false,
            selectItem: {
                "title": "",
                "url": "",
                "update_time": 0,
            },
            news_data: {
                "item": [],
                "item_count": 0,
                "total_count": 0
            }
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
        },
        radio(newValue, oldValue){
            if(newValue != null && newValue >= 0) {
                // 历史消息
                if(newValue == 1000) return this.selectItem = {
                    "title": "历史消息",
                    "url": "www.baidu.com/history",
                    "update_time": +new Date()
                }
                // 图文素材
                let _that_news_data = this.news_data
                this.selectItem = {
                    "title": _that_news_data.item[newValue].content.news_item.title,
                    "url": _that_news_data.item[newValue].content.news_item.url,
                    "update_time": _that_news_data.item[newValue].content.update_time
                }
            }
        }
    },
    filters: {
        formatTime: function (data) {
            return formatTime(data, true, "{y}年{m}月{d}日{h}:{i}");
        },
        isRadioBool(data){
            if(data !== null) return false
            return true
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
                this.news_data = response.data
                this.$nextTick(() => {
                    this.loading = false;
                })
            })
        },
        submitItemData() {
            if (this.radio === null) {
                this.$message.error('错误，至少选择一个素材！');
                return false;
            }
            // 更新数据
            let options = {
                "id": this.$attrs['data-index'],
                "key": "jsonstr",
                "value": {
                    "send_type": this.$parent.send_message.send_type,
                    "send_context_tab": this.$parent.send_message.send_context_tab,
                    "send_context": this.selectItem,
                }
            }
            updataWxMenuCustomItem({
                "wx_id": this.$route.params.id,
                "options": JSON.stringify(options)
            }).then(response => {
                this.$emit("update:dialogUrlVisible", false);
                this.$emit("update:urlData", this.selectItem);
                this.selectItem = {}
                this.radio = null
                this.isCheckboxHistoryMsg = false
            })
        },
        closeDialog() {
            this.$emit("update:dialogUrlVisible", false);
            this.selectItem = {}
            this.radio = null
            this.isCheckboxHistoryMsg = false
        },
        // tab切换
        handleClick(event) {
            // 【待解决】如果点击当前tab且已有被选中值，则radio也会被清空
            this.radio = null
            this.isCheckboxHistoryMsg = false
        },
        // 复选框
        checkboxHistoryMsg(bool){
            if(bool) return this.radio = 1000 
            this.radio = null
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

    // 图文素材库
    .news_msg {
        padding: 20px 20px 0;
        .news_tab__table {
            width: auto;
            border: 1px solid #E4E7ED;
            .el-radio__inner {
                border-color: #c3c5cc;
            }
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
    

    // 素材库
    .history_msg {
        padding-top: 40px;
        .preview_area {
            width: 240px;
            height: 348px;
            float: left;
            margin-right: 50px;
            background: transparent url(https://res.wx.qq.com/mpres/htmledition/images/advanced/history_msg3a7b38.png) no-repeat 0 0;
            position: relative;
            margin-left: 80px;
            border: 1px solid #e7e7eb;
            .desc {
                position: absolute;
                top: 100%;
                margin-top: 10px;
                width: 100%;
                text-align: center;
            }
        }
        .form_area {
            overflow: hidden;
            padding: 180px 0;
            text-align: center;
        }
    }
}
</style>
