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
                <div id="wx_charts" style="width: 80%; height: 600px;"></div>
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

            var citydata = [
                { name: "北京", value: 974 },
                { name: "天津", value: 532 },
                { name: "上海", value: 834 },
                { name: "重庆", value: 683 },
                { name: "河北", value: 283 },
                { name: "河南", value: 345 },
                { name: "云南", value: 272 },
                { name: "辽宁", value: 194 },
                { name: "黑龙江", value: 342 },
                { name: "湖南", value: 389 },
                { name: "安徽", value: 267 },
                { name: "山东", value: 675 },
                { name: "新疆", value: 174 },
                { name: "江苏", value: 574 },
                { name: "浙江", value: 278 },
                { name: "江西", value: 528 },
                { name: "湖北", value: 144 },
                { name: "广西", value: 448 },
                { name: "甘肃", value: 197 },
                { name: "山西", value: 203 },
                { name: "内蒙古", value: 373 },
                { name: "陕西", value: 563 },
                { name: "吉林", value: 147 },
                { name: "福建", value: 112 },
                { name: "贵州", value: 373 },
                { name: "广东", value: 747 },
                { name: "青海", value: 38 },
                { name: "西藏", value: 126 },
                { name: "四川", value: 215 },
                { name: "宁夏", value: 172 },
                { name: "海南", value: 77 },
                { name: "台湾", value: 837 },
                { name: "香港", value: 677 },
                { name: "澳门", value: 43 },
                { name: "南海诸岛", value: 53 }
            ];
            var yMax = 1000;
            var dataShadow = [];
            var resultdata0 = [];
            var titledata = [];
            var bartop10 = [];

            function NumDescSort(a, b) {
                return b.value - a.value;
            }
            function NumAsceSort(a, b) {
                return a.value - b.value;
            }

            // 先进行一次降序排序，找出最大的前十个
            citydata.sort(NumDescSort);

            for (var i = 0; i < 23; i++) {
                var top10 = {
                    name: citydata[i].name,
                    value: citydata[i].value
                };
                bartop10.push(top10);
                dataShadow.push(yMax);
            }

            bartop10.sort(NumAsceSort);
            for (var i = 0; i < bartop10.length; i++) {
                titledata.push(bartop10[i].name);
            }

            var option = {
                title: [
                    {
                        show: true,
                        text: '地域分布',
                    },
                    {
                        show: true,
                        text: 'TOP 10 排行榜',
                        right: '40',
                        textStyle: {
                            color: '#666666',
                            fontSize: 14
                        }
                    }
                ],
                tooltip: {
                    trigger: "item"
                },
                legend: {
                    show: false
                },
                grid: {
                    // 仅仅控制条形图的位置
                    show: true,
                    containLabel: false,
                    right: 40,
                    top: 50,
                    bottom: 30,
                    width: '30%'
                },
                visualMap: {
                    type: 'continuous',
                    min: 0,
                    max: 1000,
                    text: ['多', '少'],
                    seriesIndex: [0, 2],
                    dimension: 0,
                    realtime: false,
                    left: 0,
                    itemWidth: 18,
                    itemHeight: 100,
                    calculable: true,
                    inRange: {
                        color: ['rgba(159,205,253,0.50)', '#60ACFC'],
                        symbolSize: [100, 100]
                    },
                    outOfRange: {
                        color: ['#eeeeee'],
                        symbolSize: [100, 100]
                    },
                },
                toolbox: {
                    show: false
                },

                xAxis: [
                    {
                        type: "value",
                        position: 'top',
                        inside: false,
                        axisLabel: {
                            show: false
                        },
                        splitLine: {
                            show: false
                        },
                        margin: 10
                    }
                ],
                yAxis: [
                    {
                        type: "category",
                        boundaryGap: true,
                        axisLine: {
                            show: false
                        },
                        axisLabel: {
                            align: "right",
                            margin: 10,
                            showMaxLabel: true,
                        },
                        data: titledata
                    }
                ],

                series: [
                    {
                        name: "人数",
                        type: "map",
                        mapType: "china",
                        left: '100',
                        width: '40%',
                        roam: true,
                        mapValueCalculation: "sum",
                        zoom: 1,
                        selectedMode: false,
                        showLegendSymbol: false,
                        label: {
                            normal: {
                                show: true,
                                textStyle: {
                                    color: '#666'
                                }
                            },
                            emphasis: {
                                textStyle: {
                                    color: '#234EA5'
                                }
                            }
                        },
                        itemStyle: {
                            normal: {
                                areaColor: '#EEEEEE',
                                borderColor: '#FFFFFF'
                            },
                            emphasis: {
                                areaColor: '#E5F39B'
                            }
                        },
                        data: citydata
                    },
                    {
                        name: "背景",
                        type: "bar",
                        roam: false,
                        visualMap: false,
                        itemStyle: {
                            color: "#eeeeee",
                            opacity: 0.5
                        },
                        label: {
                            show: false
                        },
                        emphasis: {
                            itemStyle: {
                                color: "#eeeeee",
                                opacity: 0.5
                            },
                            label: {
                                show: false
                            },
                        },
                        silent: true,
                        barWidth: 18,
                        barGap: '-100%',
                        data: dataShadow,
                        animation: false
                    },
                    {
                        name: "人数",
                        type: "bar",
                        roam: false,
                        visualMap: false,
                        // itemStyle: {
                        //   color: "#60ACFC"
                        // },
                        barWidth: 18,
                        label: {
                            normal: {
                                show: true,
                                fontSize: 12,
                                position: 'insideLeft'
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data: bartop10
                    }

                ]
            };
            // 自适应
            myChart.setOption(option);
            window.onresize = function () {
                myChart.resize();
            };
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
            margin-bottom: 15px;
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
