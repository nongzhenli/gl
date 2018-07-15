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
                            src="http://wx.qlogo.cn/mmopen/9MS2zuo1Gianicic2ZrV80ITJwKo38QQub4qS6Y6C2clTjjia2f0RpbkX9fqHwXAFp8pDEN4ic3UicYpnIujbhHsnfp6bEoD766ibqia/0"
                            alt="">
                    </div>
                    <div class="wacht-info__text display_ib">
                        <p>公众号微信：maiqi0771</p>
                        <p>公众号名称：南宁麦琪儿童摄影</p>
                        <p>公众号类型：认证服务号</p>
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
                            <a href="javascirpt:void(0)">最定义菜单</a>
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
            <!-- 粉丝区域分布统计 -->
            <div class="wechat-charts">
                <div id="wx_charts"
                    :style="{width: '800px', height: '500px'}"></div>
            </div>
            <!-- 粉丝性别统计 -->
            <div class="wechat-charts">

            </div>

            <!-- 粉丝关注来源统计 -->
            <div class="wechat-charts">

            </div>
        </div>
    </div>
</template>

<script>
import { getWechatDetail } from '@/api/wechat'
export default {
    data() {
        return {
            list: null,
            listLoading: true
        }
    },
    created() {
        this.fetchData();
        console.log(this.$route);
    },
    mounted() {
        this.drawLine();
    },
    methods: {
        fetchData() {
            this.listLoading = true
            getWechatDetail({ id: this.$route.params.id }).then(response => {
                this.list = response.data.items
                this.listLoading = false
            })
        },

        // 图表数据
        drawLine() {
            // 基于准备好的dom，初始化echarts实例
            let myChart = this.$echarts.init(document.getElementById('wx_charts'))
            // 绘制图表 【地图只显示左下角，是因为官网已经暂停地图，只能手动引入地图（待解决）】
            let option = {
                title: {
                    text: 'iphone销量',
                    subtext: '纯属虚构',
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['iphone3', 'iphone4', 'iphone5']
                },
                visualMap: {
                    min: 0,
                    max: 2500,
                    left: 'left',
                    top: 'bottom',
                    text: ['高', '低'],           // 文本，默认为数值文本
                    calculable: true
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    feature: {
                        mark: { show: true },
                        dataView: { show: true, readOnly: false },
                        restore: { show: true },
                        saveAsImage: { show: true }
                    }
                },
                series: [
                    {
                        name: 'iphone3',
                        type: 'map',
                        mapType: 'china',
                        roam: false,
                        label: {
                            normal: {
                                show: false
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data: [
                            { name: '北京', value: Math.round(Math.random() * 1000) },
                            { name: '天津', value: Math.round(Math.random() * 1000) },
                            { name: '上海', value: Math.round(Math.random() * 1000) },
                            { name: '重庆', value: Math.round(Math.random() * 1000) },
                            { name: '河北', value: Math.round(Math.random() * 1000) },
                            { name: '河南', value: Math.round(Math.random() * 1000) },
                            { name: '云南', value: Math.round(Math.random() * 1000) },
                            { name: '辽宁', value: Math.round(Math.random() * 1000) },
                            { name: '黑龙江', value: Math.round(Math.random() * 1000) },
                            { name: '湖南', value: Math.round(Math.random() * 1000) },
                            { name: '安徽', value: Math.round(Math.random() * 1000) },
                            { name: '山东', value: Math.round(Math.random() * 1000) },
                            { name: '新疆', value: Math.round(Math.random() * 1000) },
                            { name: '江苏', value: Math.round(Math.random() * 1000) },
                            { name: '浙江', value: Math.round(Math.random() * 1000) },
                            { name: '江西', value: Math.round(Math.random() * 1000) },
                            { name: '湖北', value: Math.round(Math.random() * 1000) },
                            { name: '广西', value: Math.round(Math.random() * 1000) },
                            { name: '甘肃', value: Math.round(Math.random() * 1000) },
                            { name: '山西', value: Math.round(Math.random() * 1000) },
                            { name: '内蒙古', value: Math.round(Math.random() * 1000) },
                            { name: '陕西', value: Math.round(Math.random() * 1000) },
                            { name: '吉林', value: Math.round(Math.random() * 1000) },
                            { name: '福建', value: Math.round(Math.random() * 1000) },
                            { name: '贵州', value: Math.round(Math.random() * 1000) },
                            { name: '广东', value: Math.round(Math.random() * 1000) },
                            { name: '青海', value: Math.round(Math.random() * 1000) },
                            { name: '西藏', value: Math.round(Math.random() * 1000) },
                            { name: '四川', value: Math.round(Math.random() * 1000) },
                            { name: '宁夏', value: Math.round(Math.random() * 1000) },
                            { name: '海南', value: Math.round(Math.random() * 1000) },
                            { name: '台湾', value: Math.round(Math.random() * 1000) },
                            { name: '香港', value: Math.round(Math.random() * 1000) },
                            { name: '澳门', value: Math.round(Math.random() * 1000) }
                        ]
                    },
                    {
                        name: 'iphone4',
                        type: 'map',
                        mapType: 'china',
                        label: {
                            normal: {
                                show: false
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data: [
                            { name: '北京', value: Math.round(Math.random() * 1000) },
                            { name: '天津', value: Math.round(Math.random() * 1000) },
                            { name: '上海', value: Math.round(Math.random() * 1000) },
                            { name: '重庆', value: Math.round(Math.random() * 1000) },
                            { name: '河北', value: Math.round(Math.random() * 1000) },
                            { name: '安徽', value: Math.round(Math.random() * 1000) },
                            { name: '新疆', value: Math.round(Math.random() * 1000) },
                            { name: '浙江', value: Math.round(Math.random() * 1000) },
                            { name: '江西', value: Math.round(Math.random() * 1000) },
                            { name: '山西', value: Math.round(Math.random() * 1000) },
                            { name: '内蒙古', value: Math.round(Math.random() * 1000) },
                            { name: '吉林', value: Math.round(Math.random() * 1000) },
                            { name: '福建', value: Math.round(Math.random() * 1000) },
                            { name: '广东', value: Math.round(Math.random() * 1000) },
                            { name: '西藏', value: Math.round(Math.random() * 1000) },
                            { name: '四川', value: Math.round(Math.random() * 1000) },
                            { name: '宁夏', value: Math.round(Math.random() * 1000) },
                            { name: '香港', value: Math.round(Math.random() * 1000) },
                            { name: '澳门', value: Math.round(Math.random() * 1000) }
                        ]
                    },
                    {
                        name: 'iphone5',
                        type: 'map',
                        mapType: 'china',
                        label: {
                            normal: {
                                show: false
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data: [
                            { name: '北京', value: Math.round(Math.random() * 1000) },
                            { name: '天津', value: Math.round(Math.random() * 1000) },
                            { name: '上海', value: Math.round(Math.random() * 1000) },
                            { name: '广东', value: Math.round(Math.random() * 1000) },
                            { name: '台湾', value: Math.round(Math.random() * 1000) },
                            { name: '香港', value: Math.round(Math.random() * 1000) },
                            { name: '澳门', value: Math.round(Math.random() * 1000) }
                        ]
                    }
                ]
            };
            myChart.setOption(option);
        }
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

.wechat-header {
    overflow: hidden;
    .wx_box {
        .hd {
            width: 100%;
            display: block;
            margin: auto;
            background: #eff3f6;
            border-radius: 0;
            padding: 8px 16px;
            color: gray;
        }
        .bd {
            padding: 15px;
        }
        vertical-align: top;
    }
    .wx_info {
        .wechat-info__img {
            img {
                vertical-align: middle;
            }
        }
        .wacht-info__text {
            vertical-align: top;
            p {
                padding-left: 10px;
                margin: 0;
                line-height: 1.6;
            }
        }
    }
    .wx_setting {
        overflow: hidden;
        padding-left: 15px;
        ul,
        li {
            display: inline-block;
            list-style: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
            font-size: 0;
            margin-right: 15px;
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
    }
}
</style>
