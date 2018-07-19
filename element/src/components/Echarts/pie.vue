<template>
    <div class="component component_echarts component_echarts__pie">
        <div :id="key"
            style="width: 500px; height:360px;"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            key: 'echart_pie_' + Math.random()
        }
    },
    created() {
    },
    mounted() {
        this.pieEchartInit();
    },
    methods: {
        pieEchartInit() {
            let myChart = this.$echarts.init(document.getElementById(this.key))
            let option = {
                title: {
                    text: '近七日粉丝来源统计',
                    subtext: '2018.7.19 - 2018.7.26',
                    textStyle: {
                        fontSize: 14
                    }
                },
                color: ['#5182e4', '#9bcc66', '#3fb27e', '#f7cb4a', '#f88d48', '#f35352'],
                tooltip: {
                    trigger: 'item',
                    padding: 15,
                    formatter: "<span>{b}</span> : {c}<br><span style='margin-left: 30px;'>占人数比例：{d}%</span>"
                },
                legend: {
                    orient: 'vertical',
                    right: 'right',
                    itemWidth: 10,
                    itemHeight: 10,
                    textStyle: {
                        color: "#aaa"
                    },
                    data: ['扫码二维码', '名片分享', '公众号搜索', '图文右上角搜索', '图文页内公众号名称', '其他合计']
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '65%',
                        center: ['40%', '55%'],
                        hoverAnimation: false,  // 高亮不开启动画
                        animation: true,   // 开启动画效果
                        data: [
                            { value: 1548, name: '扫码二维码' },
                            { value: 310, name: '名片分享' },
                            { value: 234, name: '公众号搜索' },
                            { value: 135, name: '图文右上角搜索' },
                            { value: 135, name: '图文页内公众号名称' },
                            { value: 81, name: '其他合计' }
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 0,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)',

                            },
                            borderWidth: 1,
                            borderColor: "#fff",
                        },
                    }
                ]
            };
            myChart.setOption(option);
        }
    },
}
</script>

<style scoped>
</style>