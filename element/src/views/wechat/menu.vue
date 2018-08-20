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
                        <ul class="pre_menu_list grid_line "
                            id="menuList">
                            <li class="jsMenu pre_menu_item grid_item jslevel1  size1of2"
                                id="menu_0"
                                style="display: none;">
                                <a href="javascript:void(0);"
                                    class="pre_menu_link"
                                    draggable="false">
                                    <i class="icon14_menu_add"></i>
                                    <span class="js_l1Title">添加菜单</span>
                                </a>
                            </li>
                            <template v-if="menuOptionsJson.length > 0">
                                <li class="jsMenu pre_menu_item grid_item"
                                    v-for="(item, idx) in menuOptionsJson"
                                    :key="idx"
                                    :class="['size1of'+ (menuOptionsJson.length), {'selected current': isCurrent(idx)}]">
                                    <a href="javascript:void(0);"
                                        class="pre_menu_link js_addL1Btn"
                                        title="最多添加3个一级菜单"
                                        draggable="false"
                                        @click.stop="menuTab(0, idx)">
                                        <i class="icon_menu_dot js_icon_menu_dot dn" v-show="menuOptionsJson[idx].sub_button_list.length > 0"></i>
                                        <span class="js_l1Title">{{item.name, "菜单名称" | menuNameIsEmpty}}</span>
                                    </a>
                                    <!-- 子菜单 -->
                                    <div class="sub_pre_menu_box js_l2TitleBox"
                                        v-show="isCurrent(idx)">
                                        <ul class="sub_pre_menu_list">
                                            <li class="js_addMenuBox"
                                                v-for="(sub_item, sub_idx) in menuOptionsJson[idx].sub_button_list"
                                                :class="{current: subIsCurrent(sub_idx)}"
                                                :key="sub_idx">
                                                <a href="javascript:void(0);"
                                                    class="jsSubView js_addL2Btn"
                                                    title="最多添加5个子菜单"
                                                    draggable="false"
                                                    @click.stop="menuTab(1, sub_idx)">
                                                    <span class="sub_pre_menu_inner js_sub_pre_menu_inner">
                                                        <span class="js_l2Title">{{sub_item.name, "子菜单名称" | menuNameIsEmpty}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="js_addMenuBox"
                                                v-show="menuOptionsJson[idx].sub_button_list.length < 5">
                                                <a href="javascript:void(0);"
                                                    class="jsSubView js_addL2Btn"
                                                    title="最多添加5个子菜单"
                                                    draggable="false"
                                                    @click.stop="menuAdd(1, idx)">
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
                            </template>

                            <li class="js_addMenuBox pre_menu_item grid_item no_extra ">
                                <a href="javascript:void(0);"
                                    class="pre_menu_link js_addL1Btn"
                                    title="最多添加3个一级菜单"
                                    draggable="false"
                                    @click.stop="menuAdd(0)">
                                    <i class="icon14_menu_add"></i>
                                    <span class="js_l1Title"
                                        v-show="menuOptionsJson.length == 0">添加菜单</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sort_btn_wrp"></div>
            </div>
            <!-- 右侧内容 -->
            <menu-right :current-menu-option.sync="currentMenuOption" :del-menu-by-sort.sync="delMenuBySort"></menu-right>
        </main>
    </div>
</template>

<script>
import menuRight from '@/views/wechat/menuRight';
export default {
    /**
     * menuOptionsJson 
     * @param name              菜单按钮标题
     * @param type              1菜单直接操作，0不操作菜单【父菜单如果有子菜单时，则type=0，如果没有子菜单可直接操作type=1】
     * @param sub_button_list   子菜单按钮项【顶级父菜单拥有】
     * @param act_list          子菜单按钮操作事件【子级菜单拥有】
     */
    data() {
        return {
            // 自定义菜单Json配置
            menuOptionsJson: [],
            currentIdx: -1,
            subCurrentIdx: -1,
            currentMenuOption: [],
            delMenuBySort: {
                "parent_sort": -1,
                "sort": -1,
            }
        }
    },
    components: {
        menuRight,
    },
    filters: {
        menuNameIsEmpty(data, type) {
            if(!data || data == ""){
                return type;
            }
            return data;
        },
    },
    created() {
        // console.log(this.$route)
    },
    mounted() {
    },
    watch: {
        currentIdx(newValue, oldValue) {
            // 先清空
            this.currentMenuOption = [];
            if(newValue < 0){
                return false;
            }
            this.currentMenuOption = this.menuOptionsJson[newValue];
        },
        subCurrentIdx(newValue, oldValue) {
            if(newValue < 0 ) {
                let parent_sort = this.currentMenuOption.parent_sort;
                if(parent_sort == this.menuOptionsJson[this.currentIdx]['sort']){
                    this.currentMenuOption = this.menuOptionsJson[this.currentIdx];
                }
                // this.currentMenuOption.sub_button_list = [];
                return false;
            }
            // 返回当前子菜单配置
            this.currentMenuOption = this.menuOptionsJson[this.currentIdx].sub_button_list[newValue];
        },
        // 删除菜单通过sort排序
        delMenuBySort(newValue, oldValue){
            // 子菜单删除
            if(newValue.parent_sort >= 0){
                this.menuOptionsJson[newValue.parent_sort].sub_button_list.splice((newValue.sort), 1);
                this.menuOptionsJson[newValue.parent_sort].sub_button_list.forEach(function(item, index, array){
                    // 大于被删除数组元素索引的其它元素进行sort重构
                    if(index >= newValue.sort){
                        array[index].sort = index;
                    }
                });
                this.subCurrentIdx = -1
            }else if(newValue.sort >= 0){ // 父菜单删除
                this.menuOptionsJson.splice((newValue.sort), 1)
                this.menuOptionsJson.forEach(function(item, index, array){
                    if(index >= newValue.sort){
                        array[index].sort = index;
                        // 子菜单parent_sort重构
                        item.sub_button_list.forEach(function(sub_item, sub_index, sub_array){
                            sub_array[sub_index].parent_sort = index;
                        });
                    }
                });
                this.currentIdx = -1
                this.subCurrentIdx = -1
            }
        }
    },
    methods: {
        // 判断是否当前选中
        isCurrent(idx) {
            if (idx == this.currentIdx) {
                return true;
            }
            return false;
        },
        // 子菜单判断当前
        subIsCurrent(idx) {
            if (idx == this.subCurrentIdx) {
                return true;
            }
            return false;
        },
        /** menuAdd 父级菜单被点击事件
         * @param _type 自定义事件点击类型，0父菜单添加，2子菜单添加
         * @param _idx 点击事件按钮idx索引
         */
        menuAdd(_type, _idx) {
            // 父菜单添加
            if (_type === 0) {
                if (this.menuOptionsJson.length > 2) return false;
                // 直接先赋值了（不先经过push略有些不妥..原本写法见作用域底部注释）
                this.currentIdx = this.menuOptionsJson.length;
                let addOption = {
                    "name": "菜单名称",
                    "type": 0,
                    "send_message": {
                        "send_type": 0,
                        "send_context": {}
                    },
                    "sort": this.currentIdx,
                    "act_list": [],
                    "sub_button_list": [],
                }
                this.menuOptionsJson.push(addOption);
                // this.currentIdx = this.menuOptionsJson.length - 1;

            } else if (_type === 1) {
                // 子菜单添加
                // 直接先赋值了（不先经过push略有些不妥..原本写法见作用域底部注释）
                this.subCurrentIdx = this.menuOptionsJson[_idx].sub_button_list.length;
                let sub_button_option = {
                    "name": "子菜单名称",
                    "type": 1,
                    "send_message": {
                        "send_type": 2,
                        "send_context": {}
                    },
                    "parent_sort": _idx,
                    "sort": this.subCurrentIdx,
                    "act_list": [],
                    "sub_button_list": []
                }
                this.menuOptionsJson[_idx].sub_button_list.push(sub_button_option);
                // this.subCurrentIdx = this.menuOptionsJson[_idx].sub_button_list.length - 1
            }

        },
        // 菜单切换
        menuTab(typeIdx, _idx) {
            if (typeIdx == 0) {
                this.currentIdx = _idx;
                if(this.subCurrentIdx >= 0) {
                    this.subCurrentIdx = -1; // 父级菜单切换，子菜单不被选中
                }
            } else if (typeIdx == 1) {
                this.subCurrentIdx = _idx;
            }
        },
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

.size1of0 {
    width: 100%;
}
.size1of1 {
    width: 50%;
}
.size1of2,
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
                    font-size: 14px;
                    min-height: 50px;
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
                &.no_extra.grid_item {
                    float: none;
                    width: auto;
                    overflow: hidden;
                }
            }
            .current.pre_menu_item {
                .pre_menu_link {
                    border: 1px solid #44b549;
                    line-height: 48px;
                    background-color: #fff;
                    color: #44b549;
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
            &:hover {
                background-color: #eee;
                border: 1px solid #d0d0d0;
                line-height: 45px;
                cursor: pointer;

                .sub_pre_menu_inner {
                    border-top: 0;
                }
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
</style>
