<template>
    <div class="component component_echarts component_echarts__map">
        <div :id="key"
            style="width: 500px; height:360px;">
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            key: 'echart_map_' + Math.random()
        }
    },
    created() {
    },
    mounted() {
        this.mapEchartInit();
    },

    methods: {
        // 图表数据
        mapEchartInit() {
            let myChart = this.$echarts.init(document.getElementById(this.key))
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
            var option = {
                title: [{
                    show: true,
                    text: '用户地域分布',
                    textStyle: {
                        fontSize: '14'
                    }
                }],
                tooltip: { trigger: "item" },
                legend: { show: false },
                visualMap: {
                    type: 'continuous',
                    min: 0,
                    max: 1000,
                    text: ['多', '少'],
                    seriesIndex: [0, 2],
                    dimension: 0,
                    realtime: true,
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
                toolbox: { show: true },
                series: [{
                    name: "人数",
                    type: "map",
                    mapType: "china",
                    left: '50',
                    width: '80%',
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
                }]
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