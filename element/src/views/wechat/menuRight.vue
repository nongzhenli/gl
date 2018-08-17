<template>
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
                                    class="frm_input js_menu_name" v-model="currentMenuOption.name"> </span>
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

                    {{currentMenuOption}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // props: {
    //     propName: {
    //         type: Number,
    //         default: 
    //     },
    // },
    props: ['currentMenuOption'],
    data() {
        return {
            menuOption: this.currentMenuOption
        }
    },
    created() {
        console.log(this.currentMenuOption)
    },
    watch: {
        currentMenuOption: {
            handler(newValue, oldValue){
                this.$emit("update:currentMenuOption", newValue);
            },
            deep:true
        }
    },
    mounted() {
    },
    methods: {
    },
}
</script>

<style lang="less" scoped>
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
    background: url("../../../static/icon/wx_base_icon.png")
        0 -140px no-repeat;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    display: inline-block;
}
.icon_radio.selected,
.selected .icon_radio {
    background: url("../../../static/icon/wx_base_icon.png")
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
