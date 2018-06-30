import request from '@/utils/request'

// 获取营销活动列表
export function getMarktingList(params) {
    return request({
        url: '/marketing/list',
        method: 'get',
        params
    })
}

// 获取活动报名人数统计
export function getMarktingNumber(params) {
    return request({
        url: '/marketing/number',
        method: 'get',
        params
    })
}

