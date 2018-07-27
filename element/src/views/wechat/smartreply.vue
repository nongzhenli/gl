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
            <div class="data-list">
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
                            size="medium ">添加回复</el-button>
                    </div>
                </div>
                <div class="table-body">
                    <el-table :data="tableData5"
                        style="width: 100%"
                        header-row-class-name="thead-row__header"
                        cell-class-name="table-td__private">
                        <el-table-column type="expand">
                            <template slot-scope="props">
                                <el-form label-position="left"
                                    inline
                                    class="demo-table-expand">
                                    <el-form-item label="关键词">
                                        <span>{{ props.row.keywords }}</span>
                                        <i class="keywords_name_status">(半匹配)</i>
                                    </el-form-item>
                                    <el-form-item label="回复内容">
                                        <div class="keywords_reply_item">
                                            感谢您对麦琪儿童摄影的支持！<br><br>【参与方式】 <br>1、保存下方海报至手机相册<br>2、发送图片给好友，好友长按二维码识别<br>3、邀请10位好友扫码支持，即可获得蜂胶黄金磁疗能量枕一个！ <br>快去邀请好友吧！<br>蜂胶黄金磁疗能量枕等着你！
                                        </div>
                                        <div class="keywords_reply_item">{{ props.row.desc }}</div>
                                    </el-form-item>
                                </el-form>
                            </template>
                        </el-table-column>
                        <el-table-column label="规则名称"
                            prop="name">
                        </el-table-column>
                        <el-table-column label="关键词"
                            prop="keywords">
                        </el-table-column>
                        <el-table-column label="回复内容"
                            prop="desc">
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
            <div class="data-eidt"></div>
            <!-- 添加数据 -->
            <div class="data-add">
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">规则名称</label>
                    <div class="form-row__input el-form-item__content">
                        <el-input placeholder="请输入内容"
                            clearable>
                        </el-input>
                    </div>
                </div>
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">关键词</label>
                    <div class="form-row__input el-form-item__content">
                        <el-input placeholder="请输入内容"
                            v-model="input5"
                            class="input-with-select">
                            <el-select v-model="select"
                                slot="prepend"
                                placeholder="请选择">
                                <el-option label="办匹配"
                                    value="1"></el-option>
                                <el-option label="全匹配"
                                    value="2"></el-option>
                            </el-select>
                        </el-input>
                    </div>
                </div>
                <div class="form-row__group">
                    <label class="form_row__title el-form-item__label">回复方式</label>
                    <div class="form-row__input el-form-item__content not_style">
                        <el-radio v-model="radio"
                            label="1">回复全部</el-radio>
                        <el-radio v-model="radio"
                            label="2">随机回复一条</el-radio>
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
            input3: '',
            input4: '',
            input5: '',
            select: '',
            radio: '2',
            tableData5: [
                {
                    id: '12987122',
                    name: '投票',
                    keywords: '江浙小吃、小吃零食',
                    desc: '荷兰优质淡奶，奶香浓而不腻',
                    address: '上海市普陀区真北路',
                    shop: '王小虎夫妻店',
                    shopId: '10333'
                }, {
                    id: '12987123',
                    name: '免费',
                    keywords: '江浙小吃、小吃零食',
                    desc: '荷兰优质淡奶，奶香浓而不腻',
                    address: '上海市普陀区真北路',
                    shop: '王小虎夫妻店',
                    shopId: '10333'
                }, {
                    id: '12987125',
                    name: '宝宝照	',
                    keywords: '江浙小吃、小吃零食',
                    desc: '荷兰优质淡奶，奶香浓而不腻',
                    address: '上海市普陀区真北路',
                    shop: '王小虎夫妻店',
                    shopId: '10333'
                }, {
                    id: '12987126',
                    name: '孕妇照',
                    keywords: '江浙小吃、小吃零食',
                    desc: '荷兰优质淡奶，奶香浓而不腻',
                    address: '上海市普陀区真北路',
                    shop: '王小虎夫妻店',
                    shopId: '10333'
                }
            ]
        }
    }

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
                    margin-right: 40px;
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
        .data-add .el-form-item__content {
            display: block;
            overflow: hidden;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e4e8eb;
            &.not_style {
                margin: 0;
                border-bottom: 0;
            }
            .el-select .el-input {
                width: 100px;
            }
        }
    }
    .table-td__private {
        padding: 17px 0;
    }
    .thead-row__header th {
        background-color: #f6f8f9;
    }
}
</style>
