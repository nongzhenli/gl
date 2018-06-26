import request from '@/utils/request'

// 获取营销活动列表
export function getMarktingList(params) {
    return request({
        url: '/table/list',
        method: 'get',
        params
    })
}
