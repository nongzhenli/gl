<template>
    <div>
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
                            v-for="(item, index) in selectListItem.list"
                            @click="selectListItem.current = item"
                            :class="{'current': selectListItem.current.media_id == item.media_id}">
                            <div class="last-time">{{item.last_time}}</div>
                            <div class="item-body">
                                <img :src="item.img_url"
                                    alt="">
                            </div>
                            <div class="item-title">{{item.title}}</div>
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
import { getWxMenuSendMsgContext } from '@/api/wechat'
export default {
    props: ['dialogImgTextVisible', "imgTextData"],
    data() {
        return {
            loading: true,
            selectListItem: {
                "type": 10,
                "list": [{
                    "title": "文章测试1",
                    "img_url": "https://img.zcool.cn/community/01c1e3571b8b2632f875a399443575.jpg@2o.jpg",
                    "media_id": 1234567891,
                    "last_time": 1535337469
                },{
                    "title": "文章测试2",
                    "img_url": "https://img.zcool.cn/community/01c1e3571b8b2632f875a399443575.jpg@2o.jpg",
                    "media_id": 123456789,
                    "last_time": 15353374692
                }],
                "current": {}
            }
        }
    },
    created() {
        console.log(this.dialogImgTextVisible)
    },
    watch: {
        dialogImgTextVisible(newValue, oldValue) {
            if(newValue == true){
                this.getSendMsgImgTextItem()
            }
        }
    },
    methods: {
        // 请求获取图文素材
        getSendMsgImgTextItem(){
            // msg_type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
            getWxMenuSendMsgContext({
                // "wx_id": this.$route.params.id,
                "wx_id": 2,
                "msg_type": "news"
            }).then(response => {
                
            })
        },
        retrunItemData() {
            if(Object.keys(this.selectListItem.current).length == 0){
                this.$message.error('错误，至少选择一个素材！');
                return false;
            }
            this.$emit("update:dialogImgTextVisible", false);
            this.$emit("update:imgTextData", this.selectListItem.current);
            this.selectListItem.list = []
            this.selectListItem.current = {}
        },
        closeDialog(){
            this.$emit("update:dialogImgTextVisible", false);
            this.selectListItem.list = []
            this.selectListItem.current = {}
        }
    },
}
</script>

<style lang="less">

</style>
