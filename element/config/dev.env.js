'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
    NODE_ENV: '"development"',

    /**
     * 使用axios代理 proxyTable解决dev跨域请求线上地址，此请求地址应该是 http://localhost:9528/v1...形式
     */
    BASE_API: '"/v1"',
})
