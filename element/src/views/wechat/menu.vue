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
                                    <strong class="title js_menuTitle">子菜单名称</strong>
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
                                    <strong class="title js_menuContent">子菜单内容</strong>
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
    }
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
}

.frm_label {
    float: left;
    width: 5em;
    margin-top: 0.3em;
    margin-right: 1em;
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
</style>
