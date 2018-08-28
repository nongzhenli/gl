import request from '@/utils/request'

// 获取媒体素材
export function get(params) {
    return request({
        url: 'wxmedia/get',
        method: 'POST',
        data: params
    })
}
// 获取媒体素材列表
export function getList(params) {
    return request({
        url: 'wxmedia/getList',
        method: 'get',
        params
    })
}