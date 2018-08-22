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
export function getWxSmartReply(params) {
    return request({
        url: '/wechat/getsmartrule',
        method: 'get',
        params
    })
}
// 公众号收到消息回复规则
export function getWxAutoReply(params) {
    return request({
        url: '/wechat/autoreply',
        method: 'get',
        params
    })
}
// 公众号被关注回复规则
export function getWxFollowReply(params) {
    return request({
        url: '/wechat/followreply',
        method: 'get',
        params
    })
}

// 自定义菜单配置获取
export function getWxMenuCustom(params) {
    return request({
        url: '/wechat/menu/get',
        method: 'get',
        params
    })
}
// 自定义菜单创建
export function createWxMenuCustom(params) {
    return request({
        url: '/wechat/menu/create',
        method: 'post',
        data: params
    })
}