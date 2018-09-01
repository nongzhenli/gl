<template>
    <div class="sendMsg__imgText_dialog">
        <!-- 选择元素 -->
        <el-dialog title="选择素材"
            custom-class="menu-sendMsg__selet-context"
            width="960px"
            :before-close="closeDialog"
            :visible.sync="dialogImgTextVisible"
            >
            <el-row class="clearfix header">
                <div class="search-row float_l">
                    <el-input placeholder="搜索关键词/规则名称"
                        class="input-with-select">
                        <el-button slot="append"
                            icon="el-icon-search"></el-button>
                    </el-input>
                </div>
                <div class="search-row float_r">
                    <el-button type="success"
                        size="medium">
                        <i class="el-icon-plus"></i> 新建图文消息</el-button>
                </div>
            </el-row>
            <el-row>
                <div class="menu-sendMsg__selet_list" v-loading="loading">
                    <ul>
                        <li class="item"
                            v-for="(item, index) in selectListItem.items.item"
                            @click="selectListItem.current = item"
                            :class="{'current': selectListItem.current.media_id == item.media_id}">
                            <div class="last-time">{{item.update_time | formatTime}}</div>
                            <div class="item-body">
                                <img :src="item.content.news_item.new_thumb_url" alt="">
                            </div>
                            <div class="item-title">{{item.content.news_item.title}}</div>
                            <span class="menu-sendMsg__item__layer">
                                <i class="el-icon-check"></i>
                            </span>
                        </li>
                    </ul>
                </div>
            </el-row>
            <el-row style="text-align: center;"
                class="footer_button">
                <el-button type="success"
                    size="medium "
                    native-type="button" @click="retrunItemData()">确定</el-button>
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
    props: ['dialogImgTextVisible', "imgTextData"],
    data() {
        return {
            loading: true,
            selectListItem: {
                "type": 10,
                "items": [],
                "current": {}
            }
        }
    },
    created() {
        // console.log(this.dialogImgTextVisible)
        
    },
    watch: {
        dialogImgTextVisible(newValue, oldValue) {
            if(newValue == true){
                this.getSendMsgImgTextItem()
            }
        }
    },
    filters: {
        formatTime: function(data) {
            return formatTime(data, true, "更新于 {y}-{m}-{d} {h}:{i}");
        }
    },
    computed: {
    },
    methods: {
        // 请求获取图文素材
        getSendMsgImgTextItem(){
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
            if(Object.keys(this.selectListItem.current).length == 0){
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
                    "send_context": this.selectListItem.current,
                }
            }
            updataWxMenuCustomItem({
                "wx_id": this.$route.params.id,
                "options": JSON.stringify(options)
            }).then(response => {
                console.log(response)
            })

            this.$emit("update:dialogImgTextVisible", false);
            this.$emit("update:imgTextData", this.selectListItem.current);
            this.selectListItem.items = []
            this.selectListItem.current = {}
        },
        closeDialog(){
            this.$emit("update:dialogImgTextVisible", false);
            this.selectListItem.items = []
            this.selectListItem.current = {}
        },
    },
}
</script>

<style lang="less">
// 选择素材
.menu-sendMsg__selet-context {
    .el-dialog__body .header {
        margin: 0 -20px;
        padding: 10px 20px;
        border-bottom: 1px solid #e7e7eb;
    }
    .footer_button {
        text-align: center;
        margin: 80px 0 10px;
    }
}
.menu-sendMsg__selet_list {
    margin: 0 -20px;
    padding: 30px 20px;
    max-height: 450px;
    overflow-y: auto;

    .item {
        display: inline-block;
        position: relative;
        width: 38%;
        padding: 0 14px;
        margin-bottom: 20px;
        border: 1px solid #e7e7eb;
        margin-left: 30px;
        vertical-align: top;
        cursor: pointer;
        .last-time {
            padding: 12px 0;
            margin-bottom: 14px;
            border-bottom: 1px solid #e7e7eb;
            color: #888;
        }
        .item-body img {
            display: block;
            width: 100%;
            max-width: 100%;
        }
        .item-title {
            padding: 15px;
            padding-left: 4px;
        }

        .menu-sendMsg__item__layer {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: none;
            background-color: rgba(0, 0, 0, 0.56);
            text-align: center;

            i.el-icon-check {
                position: relative;
                top: 50%;
                margin-top: -30px;
                font-size: 60px;
                color: #fff;
            }
        }
        &:hover {
            .menu-sendMsg__item__layer {
                display: block;
            }
        }
        &.current .menu-sendMsg__item__layer {
            display: block;
        }
    }
    
    &::-webkit-scrollbar {
    width: 6px;
    height: 6px;
    }
    &::-webkit-scrollbar-thumb {
        background-color: #c2c2c2;
        background-clip: padding-box;
        min-height: 28px;
    }
    &::-webkit-scrollbar-track-piece {
        background-color: #fff;
    }
}
.sendMsg__imgText_dialog {
    .menu-sendMsg__selet_list {
        height: 450px;
    }
}

</style>
