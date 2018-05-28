export const VueCookie = {
    set: function (name, value, time) {
        // 缓存过期时间
        let hour = time? time: 2;
        let exp = new Date()
        exp.setTime(exp.getTime() + hour * 60 * 60 * 1000)
        document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString() + ';path=/'
    },
    get: function (name) {
        let arr = new RegExp('(^| )' + name + '=([^;]*)(;|$)')
        let reg = arr
        arr = document.cookie.match(reg)
        if (arr) {
            return unescape(arr[2])
        } else {
            return null
        }
    },
    del: function (name) {
        let exp = new Date()
        exp.setTime(exp.getTime() - 1)
        let cval = this.cookie.get(name)
        if (cval != null) {
            document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString() + ';path=/'
        }
    }
}
