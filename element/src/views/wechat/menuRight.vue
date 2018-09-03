<template>
    <div class="menu_form_area">
        <div id="js_none"
            class="menu_initial_tips tips_global"
            style="display: none;">点击左侧菜单进行编辑操作</div>
        <div id="js_rightBox"
            class="portable_editor to_left">
            <!-- 修改信息 -->
            <div class="editor_inner"
                v-show="menuIsNullArray(menuOption)">
                <!-- 头部 -->
                <div class="global_mod float_layout menu_form_hd js_second_title_bar">
                    <h4 class="global_info">菜单名称</h4>
                    <div class="global_extra">
                        <a href="javascript:void(0);"
                            id="jsDelBt"
                            @click="menuDel()">删除菜单</a>
                    </div>
                </div>
                <p style="margin-top: 10px; color: #8d8d8d;"
                    v-show="!isCurrentIsEmpty(menuOption)">已为 “{{menuOption.name}}” 添加了{{isCurrentIsEmpty(menuOption, "length")}}个子菜单，无法设置其他内容。</p>
                <!-- 主体内容 -->
                <div class="menu_form_bd">
                    <!-- 已修改时提醒 -->
                    <div id="js_innerNone"
                        style="display: none;"
                        class="msg_sender_tips tips_global">已添加子菜单，仅可设置菜单名称。</div>
                    <!-- 子菜单名称 -->
                    <div class="frm_control_group js_setNameBox">
                        <label for=""
                            class="frm_label">
                            <strong class="title js_menuTitle">菜单名称</strong>
                        </label>
                        <div class="frm_controls">
                            <span class="frm_input_box with_counter counter_in append"> <input type="text"
                                    ref="name"
                                    :value="menuOption.name"
                                    @change="updataWxMenuCustomItemOption($event, 'name')"
                                    @input="watchInputRefValue('name')"
                                    class="frm_input js_menu_name"> </span>
                            <p class="frm_msg fail js_titleEorTips dn"
                                style="display: none;">字数超过上限</p>
                            <p class="frm_msg fail js_titlenoTips dn"
                                style="display: none;">请输入菜单名称</p>
                            <p class="menu_name__tip"
                                ref="menu_name__tip"
                                style="display: none">字数不匹配或超过上限</p>
                            <p class="frm_tips js_titleNolTips">字数不超过8个汉字或16个字母</p>
                        </div>
                    </div>

                    <!-- 子菜单内容 -->
                    <div v-show="isCurrentIsEmpty(menuOption)"
                        class="frm_control_group"
                        style="display: block;">
                        <label for=""
                            class="frm_label"
                            style="margin-top: 0;">
                            <strong class="title js_menuContent">菜单内容</strong>
                        </label>
                        <div class="frm_controls frm_vertical_pt">
                            <label class="frm_radio_label js_radio_sendMsg "
                                :class="{'selected': send_message.send_type == 0}">
                                <i class="icon_radio"></i>
                                <span class="lbl_content">发送消息</span> <input type="radio"
                                    value="0"
                                    v-model="send_message.send_type"
                                    name="hello"
                                    class="frm_radio"> </label>
                            <label class="frm_radio_label js_radio_url"
                                :class="{'selected': send_message.send_type == 1}">
                                <i class="icon_radio"></i>
                                <span class="lbl_content">跳转网页</span> <input type="radio"
                                    value="1"
                                    v-model="send_message.send_type"
                                    name="hello"
                                    class="frm_radio"> </label>
                            <label class="frm_radio_label js_radio_weapp"
                                :class="{'selected': send_message.send_type == 2}">
                                <i class="icon_radio"></i>
                                <span class="lbl_content">跳转小程序</span> <input type="radio"
                                    value="2"
                                    v-model="send_message.send_type"
                                    name="hello"
                                    class="frm_radio"> </label>
                        </div>
                    </div>

                    <!-- 选择素材内容 -->
                    <div v-show="isCurrentIsEmpty(menuOption)"
                        class="menu_content_container">
                        <!-- 发送消息 -->
                        <div class="menu_content send jsMain"
                            v-show="send_message.send_type == 0">
                            <!-- 发送消息容器 -->
                            <div class="msg_sender">
                                <!-- TAG切换 -->
                                <div class="msg_tab">
                                    <!-- 顶部TAG切换 -->
                                    <div class="tab_navs_panel">
                                        <div class="tab_navs_wrp">
                                            <ul class="tab_navs js_tab_navs">
                                                <li class="tab_nav tab_appmsg width4"
                                                    v-for="(data, index) in send_text_message.item"
                                                    @click.stop="sendMessageTab(index)"
                                                    :class="{'selected': send_text_message.current == index}"
                                                    :data-type="data.type" >
                                                    <a href="javascript:void(0);" onclick="return false;">
                                                        <i class="icon_msg_sender" ></i>
                                                        <span class="msg_tab_title" >{{data.name}}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- 切换内容 -->
                                    <div class="tab_panel">
                                        <!-- 切换图文内容块 -->
                                        <div class="tab_content"
                                            v-show="send_text_message.current == 0">
                                            <div class="js_appmsgArea inner ">
                                                <div class="tab_cont_cover create-type__list jsMsgSendTab" data-index="0" v-show="!send_text_message.item[0].context.media_id">
                                                    <!-- 从素材库选择 -->
                                                    <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            @click="dialogImgTextVisible = true"
                                                            class="create-type__link jsMsgSenderPopBt"
                                                            data-type="10"
                                                            data-index="0">
                                                            <i class="create-type__icon file"></i>
                                                            <strong class="create-type__title">从素材库选择图文</strong>
                                                        </a>
                                                    </div>
                                                    <!-- 自建图文 -->
                                                    <!-- <div class="create-type__item">
                                                        <a target="_blank"
                                                            class="create-type__link">
                                                            <i class="create-type__icon new"></i>
                                                            <strong class="create-type__title">自建图文</strong>
                                                        </a>
                                                    </div> -->
                                                    <!--  转载文章 -->
                                                    <!-- <div class="create-type__item">
                                                        <a target="_blank"
                                                            class="create-type__link"
                                                            data-type="10"
                                                            data-index="0">
                                                            <i class="create-type__icon share"></i>
                                                            <strong class="create-type__title">转载文章</strong>
                                                        </a>
                                                    </div> -->
                                                </div>
                                                <div class="msgSender_media" v-if="send_text_message.item[0].context.media_id">
                                                    <div class="menu-sendMsg__selet_list">
                                                        <div class="item">
                                                            <div class="last-time">{{send_text_message.item[0].context.update_time | formatTime}}</div>
                                                            <div class="item-body">
                                                                <img :src="send_text_message.item[0].context.content.news_item.new_thumb_url" alt="">
                                                            </div>
                                                            <div class="item-title">{{send_text_message.item[0].context.content.news_item.title}}</div>
                                                        </div>
                                                        <el-button type="text" class="menu-sedMsg__del" @click="delSendMsgContent(0)">删除</el-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 切换图片内容块 -->
                                        <div class="tab_content"
                                            v-show="send_text_message.current == 1">
                                            <div class="js_imgArea inner ">
                                                <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                    data-index="1"
                                                    data-type="2">
                                                    <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            class="create-type__link jsMsgSenderPopBt"
                                                            data-type="2"
                                                            data-index="1">
                                                            <i class="create-type__icon file"></i>
                                                            <strong class="create-type__title">从素材库选择图片</strong>
                                                        </a>
                                                    </div>
                                                    <!-- <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            id="msgSendImgUploadBt"
                                                            class="create-type__link"
                                                            data-type="2">
                                                            <i class="create-type__icon pic"></i>
                                                            <strong class="create-type__title">上传图片</strong>
                                                        </a>
                                                    </div> -->

                                                </div>

                                            </div>
                                        </div>
                                        <!-- 切换语音内容块 -->
                                        <div class="tab_content"
                                            v-show="send_text_message.current == 2">
                                            <div class="js_audioArea inner ">
                                                <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                    data-index="2"
                                                    data-type="3">
                                                    <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            class="create-type__link jsMsgSenderPopBt"
                                                            data-type="3"
                                                            data-index="2">
                                                            <i class="create-type__icon file"></i>
                                                            <strong class="create-type__title">从素材库选择语音</strong>
                                                        </a>
                                                    </div>
                                                    <!-- <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            id="msgSendAudioUploadBt"
                                                            class="create-type__link">
                                                            <i class="create-type__icon voice"></i>
                                                            <strong class="create-type__title">新建语音</strong>
                                                        </a>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 切换视频内容块 -->
                                        <div class="tab_content"
                                            v-show="send_text_message.current == 3">
                                            <div class="js_videoArea inner ">
                                                <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                    data-index="3">
                                                    <div class="create-type__item">
                                                        <a href="javascript:;"
                                                            class="create-type__link jsMsgSenderPopBt"
                                                            data-type="15"
                                                            data-index="3">
                                                            <i class="create-type__icon file"></i>
                                                            <strong class="create-type__title">从素材库选择视频</strong>
                                                        </a>
                                                    </div>
                                                    <!-- <div class="create-type__item">
                                                        <a target="_blank"
                                                            href="/cgi-bin/appmsg?t=media/videomsg_edit&amp;action=video_edit&amp;type=15&amp;lang=zh_CN&amp;token=1032462349"
                                                            class="create-type__link">
                                                            <i class="create-type__icon video"></i>
                                                            <strong class="create-type__title">新建视频</strong>
                                                        </a>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 选择图文 -->
                                    <dialog-img-text-msg 
                                        :data-index="menuOption.id"
                                        :dialog-img-text-visible.sync="dialogImgTextVisible" 
                                        :img-text-data.sync="send_text_message.item[0].context"
                                        ref="jsonstr"></dialog-img-text-msg>
                                </div>
                            </div>
                        </div>
                        <!-- 跳转网页 -->
                        <div class="menu_content url jsMain"
                            v-show="send_message.send_type == 1">
                            <div class="">
                                <p class="menu_content_tips tips_global">订阅者点击该子菜单会跳到以下链接</p>
                                <div class="frm_control_group">
                                    <label for=""
                                        class="frm_label">页面地址</label>
                                    <div class="frm_controls">
                                        <span class="frm_input_box disabled"><input type="text" v-model="send_url_message.context.url"
                                                class="frm_input"> </span>
                                        <p class="profile_link_msg_global menu_url mini_tips warn dn js_warn"
                                            style="display: none;"> 请勿添加其他公众号的主页链接 </p>
                                        <p class="frm_tips" v-show="send_url_message.context.url != ''" > 来自
                                            <span class="js_name"></span>素材库 -《<span class="js_title">{{ send_url_message.context.title }}</span>》</span>
                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="frm_control_group btn_appmsg_wrap">
                                    <div class="frm_controls">
                                        <p class="frm_msg fail dn"
                                            id="urlUnSelect"
                                            style="display: none;">
                                            <span for="urlText"
                                                class="frm_msg_content"
                                                style="display: inline;">请选择一篇文章</span>
                                        </p>
                                        <a href="javascript:;"
                                            id="js_appmsgPop" @click="dialogUrlVisible = true" v-show="send_url_message.context.url == ''">从公众号图文消息中选择</a>
                                        <el-button native-type="button" size="small" @click="dialogUrlVisible = true" v-show="send_url_message.context.url != ''">重新选择</el-button>
                                    </div>
                                </div>
                            </div>
                            <!-- 从素材库选择跳转链接 -->
                            <dialog-url-msg 
                                :data-index="menuOption.id"
                                :dialog-url-visible.sync="dialogUrlVisible" 
                                :url-data.sync="send_url_message.context"
                                ref="jsonstr"></dialog-url-msg>
                        </div>
                        <!-- 跳转小程序 -->
                        <div class="menu_content weapp "
                            v-show="send_message.send_type == 2">
                            <div class="">跳转小程序</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="editor_inner"
                v-show="!menuIsNullArray(menuOption)">
                <div class="menu-options__null">点击左侧菜单进行编辑操作</div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatTime } from '@/utils/index'
import { validatByteMaxLength } from '@/utils/validate'
import { updataWxMenuCustomItem } from '@/api/wechat'
import dialogImgTextMsg from '@/components/WxMenu/dialogImgTextMsg';
import dialogUrlMsg from '@/components/WxMenu/dialogUrlMsg';
export default {
    // props: {
    //     propName: {
    //         type: Number,
    //         default: 
    //     },
    // },
    props: ['currentMenuOption', 'delMenuBySort'],
    data() {
        return {
            menuOption: this.currentMenuOption,
            // 菜单内容
            send_message: {
                "send_type": 0,
                "send_context_tab": 0,
                "send_context": {}
            },
            // 发送消息
            send_text_message: {
                "current": 0,
                "item": [{
                    "type": 10,
                    "name": "图文消息",
                    "context": {}
                },{
                    "type": 12,
                    "name": "图片",
                    "context": {}
                },{
                    "type": 13,
                    "name": "语音",
                    "context": {}
                },{
                    "type": 14,
                    "name": "视频",
                    "context": {}
                }]
            },
            // 跳转网址
            send_url_message: {
                "type": 1,
                "context": {
                    "title": "",
                    "url": "",
                    "media_id": "",
                    "time": 0,
                },
            },
            //跳转小程序
            send_weapp_message: {
                "type": 2,
                "context": {},
            },
            // 选择图文素材
            dialogImgTextVisible: false,
            dialogImagseVisible: false,
            dialogAudioVisible: false,
            dialogVideoVisible: false,
            // 选择跳转网页url
            dialogUrlVisible: false,
            // 选择跳转小程序
            dialogWebAppVisible: false,

        }
    },
    components: {
        dialogImgTextMsg,
        dialogUrlMsg
    },
    created() {
        let _that_menuOption = this.menuOption;
        //  Object.keys(_that_menuOption.send_message.send_context).length != 0
        if(Object.keys(_that_menuOption).length != 0 && _that_menuOption.send_message.send_context.hasOwnProperty('media_id')){
            let _current =  _that_menuOption.send_message.send_context_tab;
            this.send_text_message.current = _current
            this.send_text_message.item[_current].context = _that_menuOption.send_message.send_context
            _current= null;
        }
    },
    mounted(){
    },
    filters: {
        formatTime: function(data) {
            return formatTime(data, true, "更新于 {y}-{m}-{d} {h}:{i}");
        }
    },
    watch: {
        menuOption: {
            handler(newValue, oldValue) {
                this.$emit("update:currentMenuOption", newValue);
            },
            // 代表在watch里声明了menuOption这个方法之后立即先去执行handler方法
            // immediate: true,
            deep: true,
        },
        send_text_message: {
            handler(newValue, oldValue) {
                let _current = newValue.current;
                this.send_message.send_context_tab = _current
                this.send_message.send_context = newValue.item[_current];
                _current = null;
            },
            deep: true
        },
        send_message: {
            handler(newValue, oldValue) {
                // 先判断当前变动配置是否已选择素材（存在media_id）
                if(!newValue.send_context.context.hasOwnProperty('media_id')) return false
                // 防止每次渲染组件，无限的嵌套了context，首选判断所选内容是否一致（条件media_id）
                if(this.menuOption.send_message.send_context.media_id == newValue.send_context.context.media_id) return false
                let _send_message = {
                    "send_type": newValue.send_type,
                    "send_context_tab": newValue.send_context_tab,
                    "send_context": newValue.send_context.context,
                }
                this.menuOption.send_message = _send_message
            },
            deep: true
        },
    },
    computed: {
    },
    mounted() {
    },
    methods: {
        // 判断当前配置
        isCurrentIsEmpty(data, str) {
            if (data.sub_button_list instanceof Array && data.sub_button_list.length > 0) {
                if (str == "length") return data.sub_button_list.length;
                return false;
            }
            return true;
        },
        // 判断配置是否为空数组
        menuIsNullArray(data) {
            if (data instanceof Array && data.length == 0) return false;
            return true;
        },
        // 删除菜单
        menuDel() {
            const h = this.$createElement;
            this.$msgbox({
                title: '提示',
                message: h('div', null, [
                    h('p', null, '删除确定 '),
                    h('p', null, '删除后“' + this.currentMenuOption.name + '”菜单下设置的内容将被删除')
                ]),
                showCancelButton: true,
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning',
                customClass: 'menu-message__delete',
            }).then(() => {
                if (this.menuOption.parent_sort >= 0) {
                    this.$emit("update:delMenuBySort", {
                        "parent_sort": this.menuOption.parent_sort,
                        "sort": this.menuOption.sort
                    });
                } else if (this.menuOption.sort >= 0) { // 父菜单删除
                    this.$emit("update:delMenuBySort", {
                        "sort": this.menuOption.sort
                    });
                }
                this.menuOption = [];
                this.$message({
                    type: 'success',
                    message: '删除成功！'
                });
            }).catch(() => {
                // this.$message({
                //     type: 'info',
                //     message: '已取消删除'
                // });
            });
        },
        /**
         * 更新菜单
         * @param  key|String  更新数据类型
         */
        updataWxMenuCustomItemOption(event, key) {
            let options = {
                "id": this.menuOption.id,
                "key": key,
                "value": this.$refs[key].value,
            },
                maxLength = this.menuOption.type == 0 ? 8 : 16;
            if (validatByteMaxLength(1, options.value, maxLength)) {
                updataWxMenuCustomItem({
                    "wx_id": this.$route.params.id,
                    "options": JSON.stringify(options)
                }).then(response => {
                    this.$nextTick(() => {
                        this.menuOption.name = options.value
                        // 如果快速切换其他input radio时，发生异常。待解决..
                    })
                })
            }
        },
        // 监听ref值
        watchInputRefValue(key) {
            let maxLength = this.menuOption.type == 0 ? 8 : 16;
            if (!validatByteMaxLength(1, this.$refs[key].value, maxLength)) {
                this.$refs['menu_name__tip'].style.display = "block"
            } else {
                this.$refs['menu_name__tip'].style.display = "none"
            }
        },
        // 消息内容_选择素材
        sendContextSelect() {

        },
        // 切换发送消息tab
        sendMessageTab(index){
            this.send_text_message.current = index;
        },
        /** 删除消息内容
         * @param index|Number  删除内容索引
         */
        delSendMsgContent(index){
            this.send_text_message.item[index].context = {};
            let _send_message = {
                "send_type": this.send_message.send_type,
                "send_context_tab": this.send_message.send_context_tab,
                "send_context": this.send_message.send_context.context,
            }
            this.menuOption.send_message = _send_message
        }
    },
}
</script>

<style lang="less" >
.menu-message__delete {
    width: 520px;
    .el-message-box__content {
        padding: 60px 40px;
    }
    .el-message-box__status {
        font-size: 48px !important;
    }
    .el-message-box__message {
        padding-left: 62px;
    }
}
// 右侧
.menu_form_area {
    display: block;
    vertical-align: top;
    float: none;
    width: auto;
    overflow: hidden;
    font-size: 14px;
    line-height: 1.6;
    .editor_inner {
        min-height: 560px;
        padding-bottom: 20px !important;

        .menu-options__null {
            text-align: center;
            padding-top: 200px;
            color: #8d8d8d;
        }
    }

    .menu_name__tip {
        margin-top: 8px;
        margin-bottom: -4px;
        color: #e15f63;
    }

    .menu_content .frm_control_group {
        margin-top: 0;
    }
    .menu_content_tips {
        padding-bottom: 10px;
    }

    .portable_editor .frm_control_group {
        margin-bottom: 10px;
    }

    .pre_menu_item {
        position: relative;
        float: left;
        line-height: 38px;
        text-align: center;
    }

    .pre_menu_item .icon_menu_dot {
        background: url(/mpres/zh_CN/htmledition/comm_htmledition/style/page/menu/index_z3ff724.png)
            0 -36px no-repeat;
        width: 7px;
        height: 7px;
        vertical-align: middle;
        display: inline-block;
        margin-right: 2px;
        margin-top: -2px;
        *margin-top: 0;
    }

    .pre_menu_item a {
        display: block;
        width: auto;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: normal;
        color: #616161;
        text-decoration: none;
    }

    .pre_menu_link {
        border-left: 1px solid #e7e7eb;
    }

    .btn_appmsg_wrap {
        margin-top: -10px;
        padding-left: 85px;
    }

    .select_list_container {
        padding: 20px 30px;
    }

    .select_list_container .frm_input_box {
        width: 278px;
    }

    .select_list_container .loading_area {
        position: relative;
    }

    .select_list_container .icon_loading_small {
        margin-left: -20px;
        top: 185px;
    }
    .portable_editor .frm_control_group {
        margin-bottom: 10px
    }
    .frm_control_group.btn_appmsg_wrap #js_appmsgPop {
        text-decoration: none;
        color: #576b95;
    }
    

}
.menu_initial_tips {
    text-align: center;
    padding-top: 200px;
    color: #8d8d8d;
    font-size: 14px;
}
.menu_form_hd {
    padding: 9px 0;
    border-bottom: 1px solid #e7e7eb;
    overflow: hidden;
    h4 {
        font-weight: 400;
        margin: 0;
    }
}
.portable_editor {
    position: relative;
    &.to_left {
        padding-left: 12px;
    }
    .frm_control_group {
        margin-top: 30px;
        margin-bottom: 10px;
        padding-bottom: 0;
    }
    .editor_inner {
        padding: 0 20px 5px;
        background-color: #f4f5f9;
        border: 1px solid #e7e7eb;
        border-radius: 0;
        -moz-border-radius: 0;
        -webkit-border-radius: 0;
        box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
    }
}
.global_mod.float_layout .global_info {
    float: left;
}
.global_mod .global_extra {
    float: right;
    & > a {
        color: #576b95;
    }
}

.frm_label {
    float: left;
    width: 5em;
    margin-top: 0.3em;
    margin-right: 1em;
    font-size: 14px;
    font-weight: normal;
    .title {
        font-weight: 400;
        font-style: normal;
    }
}
.tips_global {
    color: #8d8d8d;
}
.frm_controls {
    display: table-cell;
    vertical-align: top;
    float: none;
    width: auto;
}
.frm_input_box {
    display: inline-block;
    position: relative;
    height: 32px;
    line-height: 32px;
    vertical-align: middle;
    width: 278px;
    font-size: 14px;
    padding: 0 10px;
    border: 1px solid #e7e7eb;
    box-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    border-radius: 0;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    background-color: #fff;
}
.frm_input_box.append {
    padding-right: 30px;
}
.frm_input_box.counter_in {
    width: 228px;
    padding-right: 60px;
    box-sizing: content-box;
}
.frm_input,
.frm_textarea {
    width: 100%;
    background-color: transparent;
    border: 0;
    outline: 0;
}
.frm_input {
    height: 22px;
    margin: 4px 0;
    margin: 0;
}
.frm_tips {
    color: #8d8d8d;
}
.frm_tips,
.frm_msg {
    padding-top: 8px;
    width: 300px;
}
.menu_form_area .frm_tips,
.menu_form_area .frm_msg {
    width: auto;
}
.icon_radio {
    background: url("../../../static/icon/wx_base_icon.png") 0 -140px no-repeat;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    display: inline-block;
}
.icon_radio.selected,
.selected .icon_radio {
    background: url("../../../static/icon/wx_base_icon.png") 0 -160px no-repeat;
}
.frm_radio,
.frm_checkbox {
    position: absolute;
    left: -999em;
}
input[type="checkbox"],
input[type="radio"] {
    box-sizing: border-box;
    padding: 0;
}
.frm_radio_label,
.frm_checkbox_label {
    display: inline-block;
    text-align: left;
    cursor: pointer;
    margin-right: 1em;
}
.icon_radio,
.icon_checkbox {
    margin-right: 3px;
    margin-top: -2px;
}
.frm_radio_label > span {
    font-weight: 400;
    color: #353535;
}

// 菜单内容
.menu_content {
    padding: 16px 20px;
    border: 1px solid #e7e7eb;
    background-color: #fff;
}
.menu_content.send {
    border: 0;
    padding: 0;
}
.msg_sender {
    border: 1px solid #e7e7eb;
}
.msg_tab {
    background-color: #fff;
}
.msg_sender .tab_navs_panel {
    overflow: hidden;
    background-color: #f6f8f9;
}
.msg_sender .tab_navs_switch_wrp {
    display: none;
    line-height: 60px;
    background-color: #f6f8f9;
}
.msg_sender .tab_navs_panel {
    overflow: hidden;
    background-color: #f6f8f9;
}
.msg_sender .tab_navs_wrp {
    overflow: hidden;
}
.menu_form_area .msg_sender .tab_navs_wrp {
    width: 420px;
}
.tab_navs {
    text-align: center;
    line-height: 30px;
    border-bottom: 1px solid #e7e7eb;
    box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
    -moz-box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
    -webkit-box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
}
.msg_sender .tab_navs {
    background-color: #f6f8f9;
    line-height: 60px;
    height: 60px;
    border-top-width: 0;
    white-space: nowrap;
    text-align: left;
    font-size: 0;
    border-bottom-width: 0;
    box-shadow: none;
}
.tab_nav {
    float: left;
    font-size: 14px;
}
.tab_nav a {
    display: block;
    text-decoration: none;
    color: #222;
    outline: 0;
    padding: 0 20px;
}
.msg_sender .tab_nav {
    float: none;
    display: inline-block;
    vertical-align: top;
}
.icon_msg_sender {
    margin-right: 3px;
    margin-top: -2px;
    display: inline-block;
    vertical-align: middle;
    width: 22px;
    height: 20px;
}
.tab_appmsg .icon_msg_sender {
    // background-image: url('https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png');
    // background-size: cover;
}
.tab_appmsg .icon_msg_sender {
}

.msg_sender .tab_nav .msg_tab_title {
    color: #8d8d8d;
}
.msg_sender .tab_nav.selected .msg_tab_title {
    color: #44b549;
}
.msg_sender .tab_nav:hover .msg_tab_title {
    color: #44b549;
}
.tab_panel {
    background-color: #fff;
    min-height: 216px;
}
.msg_sender .tab_panel {
    border-bottom-left-radius: 3px;
    -moz-border-radius-bottomleft: 3px;
    -webkit-border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    -moz-border-radius-bottomright: 3px;
    -webkit-border-bottom-right-radius: 3px;
}
.tab_content {
    padding: 35px 30px 0;
}
.msg_sender .tab_content {
    padding: 0;
}
.tab_content .inner {
    border: 1px solid #c6c6c6;
    border-radius: 3px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    padding: 14px 20px;
    padding-top: 0;
}
.msg_sender .tab_content .inner {
    border-width: 0;
}
.tab_cont_cover {
    overflow: hidden;
}
.create-type__list {
    text-align: left;
    padding: 45px 0;
}
.menu_form_area .msg_sender .tab_cont_cover {
    padding: 20px;
}
.create-type__list .create-type__item {
    display: inline-block;
    width: 130px;
    color: #8d8d8d;
    vertical-align: top;
    margin: 0 10px;
    transition: all 0.3s;
    text-align: center;
}
.create-type__list .create-type__item:hover {
    text-decoration: none;
    background-color: #f6f8f9;
}
.create-type__list .create-type__item a {
    color: #8d8d8d;
    display: block;
    height: 100%;
    padding-top: 28px;
    padding-bottom: 34px;
    box-sizing: border-box;
}
.create-type__icon.file {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 -44px no-repeat;
}
.create-type__list .create-type__item .create-type__icon {
    display: inline-block;
    width: 40px;
    height: 40px;
}
.create-type__list .create-type__item strong {
    font-weight: normal;
    display: block;
}
.create-type__icon.new {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 0 no-repeat;
}
.create-type__icon.share {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 -88px no-repeat;
}
.create-type__icon.pic {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 -220px no-repeat;
}
.create-type__icon.voice {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 -176px no-repeat;
}
.create-type__icon.video {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/widget/msg_sender_z_@all3d1796.png")
        0 -132px no-repeat;
}


// 已选择媒体素材
.msgSender_media {
    .menu-sendMsg__selet_list .item {
        width: 320px;
        margin-bottom: 0;
    }
    .menu-sedMsg__del {
        display: inline-block;
        overflow: hidden;
        padding-bottom: 2px;
        margin-left: 15px;
        vertical-align: bottom;
    }
}
</style>
