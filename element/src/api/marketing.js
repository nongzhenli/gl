import request from '@/utils/request'

// 获取营销活动列表
export function getMarktingList(params) {
    return request({
        url: '/marketing/list',
        method: 'get',
        params
    })
}

/**
 * 公众号吸粉类活动
 * #获取活动详情
 */
export function getMarktingGetFans(params) {
    return request({
        url: '/marketing/get/fans',
        method: 'get',
        params
    })
}
// 导出吸粉数据
export function exportExcelFansDataApi(params) {
    return request({
        url: '/marketing/fans/export-exce',
        method: 'post',
        data: params
    })
}


/**
 * 抽奖类活动
 * #获取活动详情
 */
export function getMarktingGetLottery(params) {
    return request({
        url: '/marketing/get/lottery',
        method: 'get',
        params
    })
}