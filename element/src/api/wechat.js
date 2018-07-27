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

// 公众号关键词回复规则
export function WechatSmartReply(params) {
    return request({
        url: '/wechat/smartreply',
        method: 'get',
        params
    })
}
// 公众号收到消息回复规则
export function WechatAutoReply(params) {
    return request({
        url: '/wechat/autoreply',
        method: 'get',
        params
    })
}
// 公众号被关注回复规则
export function WechatFollowReply(params) {
    return request({
        url: '/wechat/followreply',
        method: 'get',
        params
    })
}