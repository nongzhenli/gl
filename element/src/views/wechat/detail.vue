<template>
    <div class="app-container view-wechat-detail">

        <!-- 微信基本信息区域 -->
        <div class="wechat-header">
            <div class="wx_box wx_info float_l">
                <header class="hd">微信公众号详情</header>
                <div class="bd">
                    <div class="wechat-info__img display_ib font_size_0">
                        <img width="80"
                            height="80"
                            class="display_ib"
                            src="http://wx.qlogo.cn/mmopen/9MS2zuo1Gianicic2ZrV80ITJwKo38QQub4qS6Y6C2clTjjia2f0RpbkX9fqHwXAFp8pDEN4ic3UicYpnIujbhHsnfp6bEoD766ibqia/0"
                            alt="">
                    </div>
                    <div class="wacht-info__text display_ib">
                        <p>I &nbsp;&nbsp;D：1</p>
                        <p>名称：南宁麦琪儿童摄影</p>
                        <p>类型：认证服务号</p>
                    </div>
                    <div class="wacht-info__base_option">
                        <header class="hd">公众号基本配置</header>
                        <div class="bd">
                            <ul>
                                <li>
                                    <span>开发者ID：</span>
                                    <strong>wxa97eb027b796594e</strong>
                                </li>
                                <li>
                                    <span>开发者密码：</span>
                                    <strong class="app_secret">
                                        0b753bf072ca2e8a0a996f2d15da97a8
                                    </strong>
                                </li>
                                <li>
                                    <span>服务器地址：</span>
                                    <strong>http://gl.gxqqbaby.cn/api/wechat/set/1</strong>
                                </li>
                                <li>
                                    <span>令牌Token：</span>
                                    <strong>mqqzjlb</strong>
                                </li>
                                <li>
                                    <span>消息加解密钥：</span>
                                    <strong>84Hdh1rerzWzypUINtASz6Mg2JhF1h2eAYWoeeVK5ka</strong>
                                </li>
                            </ul>
                            <p class="tip_text">（注意！请严格保证配置信息需要同微信公众号官方平台一致）</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wx_box wx_setting ">
                <header class="hd">微信功能设置</header>
                <div class="bd">
                    <ul>
                        <li>
                            <a href="javascirpt:void(0)">群发消息</a>
                        </li>
                        <li>
                            <a href="javascirpt:void(0)">素材管理</a>
                        </li>
                        <li>
                            <!-- <a href="/">自定义菜单</a> -->
                            <router-link :to="'menu/'+ this.$route.params.id">自定义菜单</router-link>
                        </li>
                        <li>
                            <a href="javascirpt:void(0)">自动回复</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="wechat-header__info">

            </div>
            <div class="wechat-header__setting">

            </div>
        </div>

        <!-- 微信数据统计区域 -->
        <div class="wechat-data">
            <div class="row">
                <echart-pie></echart-pie>
                <echart-pie-sex></echart-pie-sex>
            </div>
            <div class="row">
                <echart-map></echart-map>
            </div>
        </div>
    </div>
</template>

<script>
import { getWechatDetail } from '@/api/wechat'
import EchartMap from '@/components/Echarts/map';
import EchartPie from '@/components/Echarts/pie';
import EchartPieSex from '@/components/Echarts/pieSex';

export default {
    data() {
        return {
            list: null,
            listLoading: true,
        }
    },
    components: {
        EchartMap,
        EchartPie,
        EchartPieSex
    },
    created() {
        this.fetchData();
        console.log(this.$route);
    },
    mounted() {
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getWechatDetail({ id: this.$route.params.id }).then(response => {
                this.list = response.data.items
                this.listLoading = false
            })
        },
    },
}
</script>

<style lang="less">
.font_size_0 {
    font-size: 0;
}
.display_ib {
    display: inline-block;
}
.float_l {
    float: left;
}
ul,
li {
    margin: 0;
    padding: 0;
    list-style: none;
}

.view-wechat-detail {
    padding: 50px 80px;
}
.wechat-data {
    margin: 30px auto;
    padding: 15px;
    border: 20px solid #eff3f6;
    background-color: #eff3f6;
    outline: 1px solid #e7e9ea;
    .row {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 30px;
        outline: 1px solid #e7e9ea;
    }
    .component_echarts {
        display: inline-block;
        vertical-align: top;
        margin-bottom: 15px;
        margin-right: 30px;
    }
}
.wechat-header {
    overflow: hidden;
    .wx_box {
        vertical-align: top;
        border: 1px solid #e7e9ea;
        .hd {
            width: 100%;
            display: block;
            margin: auto;
            background: #eff3f6;
            border-radius: 0;
            padding: 8px 16px;
            color: #808080;
            border-bottom: 1px solid #e0e5e8;
        }
        .bd {
            // height: 120px;
            padding: 15px;
        }
    }
    .wx_info {
        min-width: 600px;
        margin-right: 15px;
        .wechat-info__img .img {
            vertical-align: middle;
        }
        .wacht-info__text {
            vertical-align: top;
            p {
                padding-left: 10px;
                margin: 0;
                line-height: 1.6;
            }
        }
        .wacht-info__base_option {
            margin-top: 15px;

            .hd {
                background-color: transparent;
                padding-left: 0;
            }
            .bd {
                background-color: #eff3f6a8;
                border: 1px solid #e0e5e8;
                border-top: 0;
            }
            li {
                display: block;
                line-height: 1.6;
                color: #808080;

                & > span {
                    display: inline-block;
                    width: 112px;
                    text-align: right;
                }
                & > strong {
                    font-weight: 400;
                    color: #a7a4a4;
                    font-family: Helvetica Neue;
                }
            }
            .tip_text {
                color: #e6a23c;
            }
        }
    }
    .wx_setting {
        overflow: hidden;
        .bd {
            padding-top: 0;
        }
        ul,
        li {
            display: inline-block;
            overflow: hidden;
            font-size: 0;
            margin-right: 15px;
            margin-top: 14px;
            & > a {
                display: block;
                padding: 10px 20px;
                color: #606266;
                font-size: 16px;
                border: 1px solid #dcdfe6;
                background-color: #f7f7fa;
                border-radius: 2px;

                &:hover {
                    background: #5fcac6;
                    outline: none;
                    color: #fff;
                }
            }
        }
        ul {
            margin: 0;
        }
        li {
            vertical-align: middle;
        }
    }
}
</style>
