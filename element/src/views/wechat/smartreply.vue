<template>
    <div class="app-container view-wechat__smartreply">
        <header class="view-wechat-page__header">
            <h3 class="view-wechat-page__title">关键词回复</h3>
            <nav class="tab tab-automsg">
                <ul class="tab-automsg__navs">
                    <li class="tab-automsg__item tag-item-smartreply tab-automsg__item_current">
                        <router-link :to="'../smartreply/'+ this.$route.params.id">关键词回复</router-link>
                    </li>
                    <li class="tab-automsg__item tag-item-autoreply">
                        <router-link :to="'../autoreply/'+ this.$route.params.id">自动回复</router-link>
                    </li>
                    <li class="tab-automsg__item tag-item-followreply">
                        <router-link :to="'../followreply/'+ this.$route.params.id">自动回复</router-link>
                    </li>
                </ul>
            </nav>
            <div class="tip-text">
                <i class="el-icon-info"></i>请先确定微信官方公众号平台是否已经开服务器配置！否则此项配置无效/操作异常
            </div>
        </header>
        <main class="view-wechat-page__body">
            <div class="rule-list"
                v-show="!is_rule_add">
                <div class="top-header clearfix">
                    <div class="search-row float_l">
                        <el-input placeholder="搜索关键词/规则名称"
                            class="input-with-select">
                            <el-button slot="append"
                                icon="el-icon-search"></el-button>
                        </el-input>
                    </div>
                    <div class="search-row float_r">
                        <el-button type="success"
                            size="medium "
                            @click="ruleDataSet">添加回复</el-button>
                    </div>
                </div>
                <div class="table-body">
                    <el-table :data="smartReplyList"
                        style="width: 100%"
                        header-row-class-name="thead-row__header"
                        cell-class-name="table-td__private">
                        <el-table-column type="expand">
                            <template slot-scope="props">
                                <el-form label-position="left"
                                    inline
                                    class="demo-table-expand">
                                    <el-form-item label="关键词">
                                        <span v-for="keywords of props.row.keywords">{{ keywords.key_name }}
                                            <i class="keywords_name_status"
                                                v-if="keywords.key_type == 1">(半匹配)</i>
                                            <i class="keywords_name_status"
                                                v-else-if="keywords.key_type == 2">(全匹配)</i>、</span>
                                        <i class="keywords_name_status"></i>
                                    </el-form-item>
                                    <el-form-item label="回复内容">
                                        <div class="keywords_reply_item"
                                            v-for="send of props.row.send_content"
                                            v-html="send.json_str"></div>
                                    </el-form-item>
                                </el-form>
                            </template>
                        </el-table-column>
                        <el-table-column label="规则名称"
                            prop="name">
                        </el-table-column>
                        <el-table-column label="关键词">
                            <template slot-scope="props">
                                <span v-for="keywords of props.row.keywords">{{ keywords.key_name }}、</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="回复内容">
                            <template slot-scope="props">
                                <span>{{ sendTypeNumFilter(props.row.send_content) }}</span>
                                <!-- <span v-for="send_content in sendTypeFilter(props.row.send_content)">{{ send_content.num }}</span> -->
                            </template>
                        </el-table-column>
                        <el-table-column label="操作"
                            header-align="right"
                            align="right"
                            class-name="operate_area">
                            <template slot-scope="scope">
                                <a href="javascript:void(0)">详情</a>
                                <a href="javascript:void(0)">编辑</a>
                                <a href="javascript:void(0)">删除</a>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
            <!-- 编辑数据 -->
            <div class="rule-eidt"></div>
            <!-- 添加数据 -->
            <div class="rule-add"
                v-show="is_rule_add">
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">规则名称</label>
                    <div class="form-row__input el-form-item__content not_style">
                        <el-input placeholder="输入规则名称"
                            v-model="rule_data.name"
                            clearable>
                        </el-input>
                        <p style="font-size: 14px; color: #606266;">规则名称不能为空且最多60个字</p>
                    </div>
                </div>
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">关键词</label>
                    <div class="form-row__input el-form-item__content">
                        <el-input placeholder="请输入内容"
                            v-model="rule_data.keywords.name"
                            class="input-with-select">
                            <el-select v-model="rule_data.keywords.statu"
                                slot="prepend"
                                placeholder="请选择">
                                <el-option label="半匹配"
                                    value="1"></el-option>
                                <el-option label="全匹配"
                                    value="2"></el-option>
                            </el-select>
                        </el-input>
                    </div>
                </div>
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">回复内容</label>
                    <div class="form-row__input el-form-item__content not_style">
                        <el-row>
                            <div class="msg_sender_wrp"
                                v-show="is_msg_send_button">
                                <ul class="clearfix">
                                    <li class="msg-sender__tab_appmsg">图文消息</li>
                                    <li class="msg-sender__tab_text">文字</li>
                                    <li class="msg-sender__tab_img">图片</li>
                                    <li class="msg-sender__tab_audio">语音</li>
                                    <li class="msg-sender__tab_video">视频</li>
                                </ul>
                            </div>
                        </el-row>

                    </div>
                </div>
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">回复方式</label>
                    <div class="form-row__input el-form-item__content not_style">
                        <el-radio-group v-model="rule_data.type"
                            class="reply_all__type">
                            <el-radio label="1">回复全部</el-radio>
                            <el-radio label="2">随机回复一条</el-radio>
                        </el-radio-group>
                    </div>
                </div>

                <div class="form-row__group form-row__group-btn">
                    <el-row class="text_align_c">
                        <el-button type="success"
                            small="small"
                            @click="ruleDataSet('new')"
                            native-type="button">保存</el-button>
                        <el-button plain
                            small="small"
                            native-type="button"
                            @click="ruleDataSet('cancel')">取消</el-button>
                    </el-row>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { getWxSmartReply } from '@/api/wechat'
export default {
    data() {
        return {
            listLoading: true,
            smartReplyList: [],
            is_rule_add: false,
            is_msg_send_button: true,
            rule_data: {
                name: '',
                keywords: [
                    {
                        name: '',
                        statu: '',
                    }
                    // 可多个关键字
                ],
                contents: [
                    {
                        type: "",
                        text: ""
                    },
                    // 可多条内容
                ],
                type: "2"
            },
        }
    },
    created() {
        this.fetchData();
    },
    // 过滤器
    filters: {
    },
    // 计算属性
    computed: {
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getWxSmartReply({ wx_id: this.$route.params.id }).then(response => {
                this.smartReplyList = response.data
                this.$nextTick(function () {
                    this.listLoading = false
                });
            })
        },
        // 规则弹层集中处理函数
        ruleDataSet(type) {
            if (type == 'save') {
                this.createRulePost();
            }
            this.is_rule_add = !this.is_rule_add;
        },
        // 创建规则请求
        createRulePost() {
            console.log('xxx')
        },
        // 发送内容类型数量事件过滤器
        sendTypeNumFilter(data) {
            let sendTypeTotal = {
                "1": {
                    "text": "文本",
                    "num": 0,
                },
                "2": {
                    "text": "图片",
                    "num": 0,
                },
                "3": {
                    "text": "语音",
                    "num": 0,
                },
                "4": {
                    "text": "视频",
                    "num": 0,
                },
                "5": {
                    "text": "图文",
                    "num": 0,
                },
                "6": {
                    "text": "图文（链）",
                    "num": 0,
                },
                "7": {
                    "text": "音乐",
                    "num": 0,
                },
                "8": {
                    "text": "卡卷",
                    "num": 0,
                },
                "9": {
                    "text": "小程序",
                    "num": 0,
                },
                "10": {
                    "text": "其他",
                    "num": 0,
                },
            };
            for (let item of data) {
                ++sendTypeTotal[item.send_type].num
            }

            // 对象排序
            let sortkey = Object.keys(sendTypeTotal).sort((a, b) => {
                return sendTypeTotal[b].num - sendTypeTotal[a].num;
            })

            let str = "";
            // 重构数组
            for (let idx of sortkey) {
                if (sendTypeTotal[idx].num <= 0) {
                    break;
                }
                str += sendTypeTotal[idx].text + sendTypeTotal[idx].num + "，";
            }
            // \u3001 正则匹配 、
            // \uff0c 正则匹配 ，
            return str.replace(/([\uff0c|\u3001]*$)/g, "");
        }

    },
}
</script>

<style lang="less" scoped>
.view-wechat__smartreply {
    overflow: hidden;
    margin: 0;
    padding: 30px 60px;
    .view-wechat-page__title {
        font-size: 26px;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 30px;
        color: #444;
    }
    .tab-automsg__navs {
        text-align: left;
        line-height: 40px;
        border-bottom: 1px solid #e0e1e2;
        font-size: 16px;
        overflow: hidden;
    }
    .tab-automsg__item {
        float: left;
        text-align: left;
        margin-right: 24px;
        line-height: 40px;
        a {
            display: block;
            width: auto;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: normal;
            max-width: 120px;
        }
    }
    .tip-text {
        background-color: #e0eaf6;
        padding: 14px 20px;
        position: relative;
        color: #576b95;
        font-size: 14px;
        margin: 50px 0 30px;
        & > i {
            font-size: 16px;
            margin-right: 5px;
            vertical-align: bottom;
        }
    }
    .tab-automsg__item_current {
        border-bottom: 2px solid #1aad19;
    }

    .tab-automsg__item_current,
    .tab-automsg__item:hover {
        a {
            color: #44b549;
        }
    }

    .view-wechat-page__body {
        .table-body {
            margin: 15px auto;
            .el-form-item {
                display: block;

                .keywords_name_status {
                    color: #9a9a9a;
                    margin-left: 3px;
                    font-style: normal;
                }
                .keywords_reply_item {
                    display: block;
                    overflow: hidden;
                    margin-bottom: 20px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #e4e8eb;
                }
            }
            .operate_area {
                a {
                    color: #576b95;
                    margin: 0 6px;
                }
            }
        }
    }

    .msg_sender_wrp {
        position: relative;
        top: 0;
        left: 5px;
        z-index: 3;
        width: 700px;
        background: #ffffff;
        margin-top: 6px;
        box-shadow: 0 1px 20px 0 #e4e8eb;
        border-radius: 2px;
        li {
            display: inline-block;
            padding: 0 20px;
            cursor: pointer;
            &:hover {
                color: #1aad19;
            }
        }
    }
    .msg_sender__button {
        // &:hover + .msg_sender_wrp {
        //     display: block;
        // }
    }
    .form-row__group {
        margin: 15px auto;
        &.form-row__group-btn {
            margin-top: 80px;
        }
    }
}
</style>
<style lang="less">
.view-wechat__smartreply {
    .view-wechat-page__body {
        .el-form-item__label {
            float: left;
            min-width: 100px;
        }
        .el-form-item__content {
            display: block;
            overflow: hidden;
            padding-top: 12px;
            line-height: 1.6;
        }

        .rule-add {
            background-color: rgb(250, 251, 253);
            padding: 15px;
            border: 1px solid rgb(228, 231, 237);
        }
        .rule-add .el-form-item__content {
            display: block;
            overflow: hidden;
            margin-bottom: 20px;
            padding-bottom: 20px;
            padding-top: 0;
            line-height: 40px;
            border-bottom: 1px solid #e4e8eb;
            &.not_style {
                margin: 0;
                border-bottom: 0;
            }
            .el-select .el-input {
                width: 100px;
            }
        }
        .rule-add .el-form-item__label {
            padding-right: 30px;
        }
        .rule-add .input-with-select {
            .el-input-group__prepend {
                color: #333;
            }
        }
    }
    .table-td__private {
        padding: 17px 0;
    }
    .thead-row__header th {
        background-color: #f6f8f9;
    }
    .reply_all__type {
        .el-radio__input.is-checked .el-radio__inner {
            border-color: #1aad19;
            background: #1aad19;
        }
        .el-radio__input.is-checked + .el-radio__label {
            color: #1aad19;
        }
    }
}
</style>
