import request from '@/utils/request'

// 获取营销活动列表
export function getWechatList(params) {
    return request({
        url: '/wechat/list',
        method: 'get',
        params
    })
}

// 公众号详情页
export function getWechatDetail(params) {
    return request({
        url: '/wechat/detail',
        method: 'get',
        params
    })
}