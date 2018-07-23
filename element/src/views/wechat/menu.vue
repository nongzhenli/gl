<template>
    <div class="app-container view-wechat__menu">
        <div class="wechat-menu__header">
            <p class="title">自定义菜单</p>
            <span class="sub-text">若近期开启过吸粉活动，请确认吸粉活动已经结束，否则切勿修改菜单，以免影响吸粉活动进行。</span>
        </div>
        <main class="wechat-menu__body">
            <div class="menu_preview_area">
                <div class="mobile_menu_preview">
                    <div class="mobile_hd tc">BIG黑钦</div>
                    <div class="mobile_bd">
                        <ul class="pre_menu_list grid_line ui-sortable ui-sortable-disabled"
                            id="menuList">
                            <li class="jsMenu pre_menu_item grid_item jslevel1 ui-sortable ui-sortable-disabled size1of2"
                                id="menu_0">
                                <a href="javascript:void(0);"
                                    class="pre_menu_link"
                                    draggable="false">

                                    <i class="icon_menu_dot js_icon_menu_dot dn"></i>
                                    <i class="icon20_common sort_gray"></i>
                                    <span class="js_l1Title">测试文章</span>
                                </a>
                                <div class="sub_pre_menu_box js_l2TitleBox"
                                    style="">
                                    <ul class="sub_pre_menu_list">

                                        <li id="subMenu_menu_0_0"
                                            class="jslevel2 current selected">
                                            <a href="javascript:void(0);"
                                                class="jsSubView"
                                                draggable="false">
                                                <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
                                                    <i class="icon20_common sort_gray"></i>
                                                    <span class="js_l2Title">图片测试</span>
                                                </span>
                                            </a>
                                        </li>

                                        <li id="subMenu_menu_0_1"
                                            class="jslevel2">
                                            <a href="javascript:void(0);"
                                                class="jsSubView"
                                                draggable="false">
                                                <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
                                                    <i class="icon20_common sort_gray"></i>
                                                    <span class="js_l2Title">小程序</span>
                                                </span>
                                            </a>
                                        </li>

                                        <li id="subMenu_menu_0_2"
                                            class="jslevel2">
                                            <a href="javascript:void(0);"
                                                class="jsSubView"
                                                draggable="false">
                                                <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
                                                    <i class="icon20_common sort_gray"></i>
                                                    <span class="js_l2Title">跳转网页测试</span>
                                                </span>
                                            </a>
                                        </li>

                                        <li class="js_addMenuBox">
                                            <a href="javascript:void(0);"
                                                class="jsSubView js_addL2Btn"
                                                title="最多添加5个子菜单"
                                                draggable="false">
                                                <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
                                                    <i class="icon14_menu_add"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <i class="arrow arrow_out"></i>
                                    <i class="arrow arrow_in"></i>
                                </div>
                            </li>

                            <li class="js_addMenuBox pre_menu_item grid_item no_extra size1of2">
                                <a href="javascript:void(0);"
                                    class="pre_menu_link js_addL1Btn"
                                    title="最多添加3个一级菜单"
                                    draggable="false">
                                    <i class="icon14_menu_add"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sort_btn_wrp">

                </div>
            </div>
            <div class="menu_form_area">
                <div id="js_none"
                    class="menu_initial_tips tips_global"
                    style="display: none;">点击左侧菜单进行编辑操作</div>
                <div id="js_rightBox"
                    class="portable_editor to_left">
                    <!-- 修改信息 -->
                    <div class="editor_inner">
                        <!-- 头部 -->
                        <div class="global_mod float_layout menu_form_hd js_second_title_bar">
                            <h4 class="global_info">菜单名称</h4>
                            <div class="global_extra">
                                <a href="javascript:void(0);"
                                    id="jsDelBt">删除子菜单</a>
                            </div>
                        </div>
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
                                            class="frm_input js_menu_name"> </span>
                                    <p class="frm_msg fail js_titleEorTips dn"
                                        style="display: none;">字数超过上限</p>
                                    <p class="frm_msg fail js_titlenoTips dn"
                                        style="display: none;">请输入菜单名称</p>
                                    <p class="frm_tips js_titleNolTips">字数不超过8个汉字或16个字母</p>
                                </div>
                            </div>

                            <!-- 子菜单内容 -->
                            <div class="frm_control_group"
                                style="display: block;">
                                <label for=""
                                    class="frm_label">
                                    <strong class="title js_menuContent">菜单内容</strong>
                                </label>
                                <div class="frm_controls frm_vertical_pt">
                                    <label class="frm_radio_label js_radio_sendMsg selected"
                                        data-editing="0">
                                        <i class="icon_radio"></i>
                                        <span class="lbl_content">发送消息</span> <input type="radio"
                                            name="hello"
                                            class="frm_radio"> </label>
                                    <label class="frm_radio_label js_radio_url"
                                        data-editing="0">
                                        <i class="icon_radio"></i>
                                        <span class="lbl_content">跳转网页</span> <input type="radio"
                                            name="hello"
                                            class="frm_radio"> </label>
                                    <label class="frm_radio_label js_radio_weapp"
                                        data-editing="0">
                                        <i class="icon_radio"></i>
                                        <span class="lbl_content">跳转小程序</span> <input type="radio"
                                            name="hello"
                                            class="frm_radio"> </label>
                                </div>
                            </div>

                            <!-- 选择素材内容 -->
                            <div class="menu_content_container">
                                <!-- 发送消息 -->
                                <div class="menu_content send jsMain">
                                    <!-- 发送消息容器 -->
                                    <div class="msg_sender">
                                        <!-- TAG切换 -->
                                        <div class="msg_tab">
                                            <!-- 顶部TAG切换 -->
                                            <div class="tab_navs_panel">
                                                <div class="tab_navs_wrp">
                                                    <ul class="tab_navs js_tab_navs">
                                                        <!-- 发送图文 tag -->
                                                        <li class="tab_nav tab_appmsg width4"
                                                            data-type="10"
                                                            data-tab=".js_appmsgArea"
                                                            data-tooltip="图文消息">
                                                            <a href="javascript:void(0);"
                                                                onclick="return false;">
                                                                <i class="icon_msg_sender"></i>
                                                                <span class="msg_tab_title">图文消息</span>
                                                            </a>
                                                        </li>
                                                        <!-- 发送图片 tag -->
                                                        <li class="tab_nav tab_img width4 selected"
                                                            data-type="2"
                                                            data-tab=".js_imgArea"
                                                            data-tooltip="图片">
                                                            <a href="javascript:void(0);"
                                                                onclick="return false;">&nbsp;
                                                                <i class="icon_msg_sender"></i>
                                                                <span class="msg_tab_title">图片</span>
                                                            </a>
                                                        </li>
                                                        <!-- 发送语音 tag -->
                                                        <li class="tab_nav tab_audio width4"
                                                            data-type="3"
                                                            data-tab=".js_audioArea"
                                                            data-tooltip="语音">
                                                            <a href="javascript:void(0);"
                                                                onclick="return false;">&nbsp;
                                                                <i class="icon_msg_sender"></i>
                                                                <span class="msg_tab_title">语音</span>
                                                            </a>
                                                        </li>
                                                        <!-- 发送视频 tag -->
                                                        <li class="tab_nav tab_video width4 no_extra"
                                                            data-type="15"
                                                            data-tab=".js_videoArea"
                                                            data-tooltip="视频">
                                                            <a href="javascript:void(0);"
                                                                onclick="return false;">&nbsp;
                                                                <i class="icon_msg_sender"></i>
                                                                <span class="msg_tab_title">视频</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- 切换内容 -->
                                            <div class="tab_panel">
                                                <!-- 切换图文内容块 -->
                                                <div class="tab_content">
                                                    <div class="js_appmsgArea inner ">
                                                        <!--type 10图文 2图片  3语音 15视频 11商品消息-->
                                                        <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                            data-index="0">
                                                            <!-- 从素材库选择 -->
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    class="create-type__link jsMsgSenderPopBt"
                                                                    data-type="10"
                                                                    data-index="0">
                                                                    <i class="create-type__icon file"></i>
                                                                    <strong class="create-type__title">从素材库选择</strong>
                                                                </a>
                                                            </div>
                                                            <!-- 自建图文 -->
                                                            <div class="create-type__item">
                                                                <a target="_blank"
                                                                    href="/cgi-bin/appmsg?t=media/appmsg_edit&amp;action=edit&amp;type=10&amp;isMul=1&amp;isNew=1&amp;lang=zh_CN&amp;token=1032462349"
                                                                    class="create-type__link">
                                                                    <i class="create-type__icon new"></i>
                                                                    <strong class="create-type__title">自建图文</strong>
                                                                </a>
                                                            </div>
                                                            <!--  转载文章 -->
                                                            <div class="create-type__item">
                                                                <a target="_blank"
                                                                    href="/cgi-bin/appmsg?t=media/appmsg_edit&amp;action=edit&amp;type=10&amp;isMul=1&amp;isNew=1&amp;share=1&amp;lang=zh_CN&amp;token=1032462349"
                                                                    class="create-type__link"
                                                                    data-type="10"
                                                                    data-index="0">
                                                                    <i class="create-type__icon share"></i>
                                                                    <strong class="create-type__title">转载文章</strong>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- 切换图片内容块 -->
                                                <div class="tab_content"
                                                    style="display: none;">
                                                    <div class="js_imgArea inner ">
                                                        <!--type 10图文 2图片  3语音 15视频 11商品消息-->
                                                        <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                            data-index="1"
                                                            data-type="2">
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    class="create-type__link jsMsgSenderPopBt"
                                                                    data-type="2"
                                                                    data-index="1">
                                                                    <i class="create-type__icon file"></i>
                                                                    <strong class="create-type__title">从素材库选择</strong>
                                                                </a>
                                                            </div>
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    id="msgSendImgUploadBt"
                                                                    class="create-type__link"
                                                                    data-type="2">
                                                                    <i class="create-type__icon pic"></i>
                                                                    <strong class="create-type__title">上传图片</strong>
                                                                </a>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- 切换语音内容块 -->
                                                <div class="tab_content"
                                                    style="display: none;">
                                                    <div class="js_audioArea inner ">
                                                        <!--type 10图文 2图片  3语音 15视频 11商品消息-->

                                                        <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                            data-index="2"
                                                            data-type="3">
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    class="create-type__link jsMsgSenderPopBt"
                                                                    data-type="3"
                                                                    data-index="2">
                                                                    <i class="create-type__icon file"></i>
                                                                    <strong class="create-type__title">从素材库选择</strong>
                                                                </a>
                                                            </div>
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    id="msgSendAudioUploadBt"
                                                                    class="create-type__link">
                                                                    <i class="create-type__icon voice"></i>
                                                                    <strong class="create-type__title">新建语音</strong>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- 切换跳转小程序内容块 -->
                                                <div class="tab_content"
                                                    style="display: none;">
                                                    <div class="js_videoArea inner ">
                                                        <!--type 10图文 2图片  3语音 15视频 11商品消息-->
                                                        <div class="tab_cont_cover create-type__list jsMsgSendTab"
                                                            data-index="3">
                                                            <div class="create-type__item">
                                                                <a href="javascript:;"
                                                                    class="create-type__link jsMsgSenderPopBt"
                                                                    data-type="15"
                                                                    data-index="3">
                                                                    <i class="create-type__icon file"></i>
                                                                    <strong class="create-type__title">从素材库选择</strong>
                                                                </a>
                                                            </div>
                                                            <div class="create-type__item">
                                                                <a target="_blank"
                                                                    href="/cgi-bin/appmsg?t=media/videomsg_edit&amp;action=video_edit&amp;type=15&amp;lang=zh_CN&amp;token=1032462349"
                                                                    class="create-type__link">
                                                                    <i class="create-type__icon video"></i>
                                                                    <strong class="create-type__title">新建视频</strong>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 发送消息 -->
                                <div class="menu_content url jsMain"
                                    style="display: none;"></div>
                                <!-- 发送消息 -->
                                <div class="menu_content weapp "
                                    style="display: none;"></div>

                                <!-- 已经存在的配置 -->
                                <div class="menu_content sended"
                                    style="display: none;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    created() {
        console.log(this.$route)
    },
    mounted(){
    },
    methods: {
        
    },
}
</script>

<style lang="less" scoped>
// 自定义菜单容器
.view-wechat__menu {
    padding: 50px 60px;
}

// 头部提示
.wechat-menu__header {
    padding: 10px 15px;
    background: #f7f7fa;
    border: 1px solid #d8d7d7;
    border-radius: 4px;

    .title {
        font-size: 18px;
        color: #303133;
    }
    .sub-text {
        font-size: 14px;
        color: #e6a23c;
    }
    .title,
    .sub-text {
        display: block;
        margin: 15px auto;
    }
}

.size1of1 {
    width: 100%;
}
.size1of2 {
    width: 50%;
}
.size1of3 {
    width: 33.33%;
}

.wechat-menu__body {
    margin-top: 30px;
}
// 左侧
.menu_preview_area {
    position: relative;
    float: left;
    margin-right: 12px;
    .mobile_menu_preview {
        position: relative;
        width: 320px;
        height: 580px;
        background: transparent
            url("https://res.wx.qq.com/mpres/htmledition/images/bg/bg_mobile_head_default3a7b38.png")
            no-repeat 0 0;
        background-position: 0 0;
        border: 1px solid #e7e7eb;
        -webkit-background-size: contain;
        background-size: contain;

        .mobile_hd {
            color: #fff;
            text-align: center;
            padding-top: 34px;
            font-size: 15px;
            width: auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: normal;
            margin: 0 30px;
        }

        .pre_menu_list {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #e7e7eb;
            background: transparent
                url("https://res.wx.qq.com/mpres/htmledition/images/bg/bg_mobile_foot_default3a7b38.png")
                no-repeat 0 0;
            background-position: 0 0;
            background-repeat: no-repeat;
            padding-left: 43px;

            .pre_menu_item {
                position: relative;
                float: left;
                line-height: 50px;
                text-align: center;
                a {
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
                &:first-child .pre_menu_link {
                    border-left-width: 0;
                }
                .icon_menu_dot {
                    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/page/menu/index_z3c4bd4.png")
                        0 -36px no-repeat;
                    width: 7px;
                    height: 7px;
                    vertical-align: middle;
                    display: inline-block;
                    margin-right: 2px;
                    margin-top: -2px;
                }
            }
        }
    }
    .sub_pre_menu_box {
        bottom: 60px;
        background-color: #fafafa;
        border-top-width: 0;
    }
    .sub_pre_menu_inner {
        display: block;
        border-top: 1px solid #e7e7eb;
        width: auto;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: normal;
        cursor: pointer;
    }
    .sub_pre_menu_list {
        li:first-child {
            border-top: 1px solid #d0d0d0;
            .sub_pre_menu_inner {
                border-top-width: 0;
            }
        }
        li {
            line-height: 44px;
            border: 1px solid transparent;
            margin: 0 -1px -1px;
            font-size: 14px;
            a {
                padding: 0 0.5em;
            }
            &.current {
                background-color: #fff;
                border: 1px solid #44b549;
                position: relative;
                z-index: 1;
                line-height: 45px;
                a {
                    color: #44b549;
                }
            }
            &:hover {
                background-color: #eee;
                border: 1px solid #d0d0d0;
                line-height: 45px;
                cursor: pointer;

                .sub_pre_menu_inner {
                    border-top: 0;
                }
            }
        }
    }
    .icon14_menu_add {
        background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/page/menu/index_z3c4bd4.png")
            0 0 no-repeat;
        width: 14px;
        height: 14px;
        vertical-align: middle;
        display: inline-block;
        margin-top: -2px;
    }
}
.sub_pre_menu_box {
    position: absolute;
    bottom: 50px;
    left: 0;
    width: 100%;
    border: 1px solid #d0d0d0;
    background-color: #fff;
    .arrow {
        position: absolute;
        left: 50%;
        margin-left: -6px;
    }
    .arrow_out {
        bottom: -6px;
        display: inline-block;
        width: 0;
        height: 0;
        border-width: 6px;
        border-style: dashed;
        border-color: transparent;
        border-bottom-width: 0;
        border-top-color: #d0d0d0;
        border-top-style: solid;
    }
    .arrow_in {
        bottom: -5px;
        display: inline-block;
        width: 0;
        height: 0;
        border-width: 6px;
        border-style: dashed;
        border-color: transparent;
        border-bottom-width: 0;
        border-top-color: #fafafa;
        border-top-style: solid;
    }
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

// 右侧

.menu_form_area {
    // display: table-cell;
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
    // margin-top: 0.3em;
    margin-right: 2em;
    font-size: 14px;
    .title {
        font-weight: 400;
        font-style: normal;
    }
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
    height: 30px;
    line-height: 30px;
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
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/base/base_z3ebe56.png")
        0 -140px no-repeat;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    display: inline-block;
}
.icon_radio.selected,
.selected .icon_radio {
    background: url("https://res.wx.qq.com/mpres/zh_CN/htmledition/comm_htmledition/style/base/base_z3ebe56.png")
        0 -160px no-repeat;
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
}
.msg_sender .tab_content .inner {
    border-width: 0;
}
.tab_cont_cover {
    overflow: hidden;
}
.create-type__list {
    text-align: center;
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
</style>
