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

// 自定义菜单配置获取全部
export function getWxMenuCustomAll(params) {
    return request({
        url: '/wechat/menu/get',
        method: 'get',
        params
    })
}
// 自定义菜单创建
export function createWxMenuCustomItem(params) {
    return request({
        url: '/wechat/menu/create',
        method: 'post',
        data: params
    })
}
// 自定义菜单更新
export function updataWxMenuCustomItem(params) {
    return request({
        url: '/wechat/menu/updata',
        method: 'post',
        data: params
    })
}
// 获取菜单【发送消息】素材内容
export function getWxMenuSendMsgContext(params) {
    return request({
        url: '/wechat/menu/sendmsg',
        method: 'get',
        params
    })
}

// 获取菜单【发送消息】素材内容
export function getWxForeverByMedia(params) {
    return request({
        url: '/wechat/menu/sendmsg',
        method: 'get',
        params
    })
}