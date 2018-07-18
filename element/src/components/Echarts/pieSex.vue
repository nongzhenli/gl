<template>
    <div class="component component_echarts component_echarts__pie">
        <div :id="key"
            style="width: 400px; height:360px;"></div>
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
                    text: '用户性别比例',
                    textStyle: {
                        fontSize: 14
                    }
                },
                color: ['#4d5fb0', '#0fa8e0'],
                tooltip: {
                    trigger: 'item',
                    padding: 15,
                    formatter: "<span>{b}</span> : {c}<br><span style='margin-left: 30px;'>占人数比例：{d}%</span>"
                },
                legend: {
                    orient: 'vertical',
                    right: '30',
                    itemWidth: 10,
                    itemHeight: 10,
                    textStyle: {
                        color: "#aaa"
                    },
                    data: ['男', '女']
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '65%',
                        center: ['35%', '55%'],
                        hoverAnimation: false,  // 高亮不开启动画
                        animation: true,   // 开启动画效果
                        labelLine: {
                            show: false
                        },
                        data: [
                            { value: 654, name: '男' },
                            { value: 1548, name: '女' },
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
.component_echarts {
    display: inline-block;
    vertical-align: top;
    margin-bottom: 30px;
}
</style>