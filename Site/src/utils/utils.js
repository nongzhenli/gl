// 获取cookie
// export const VueCookie = {
//     add: (objName, objValue, objHours) => {
//         var str = objName + "=" + escape(objValue);
//         if (objHours > 0) {//为0时不设定过期时间，浏览器关闭时cookie自动消失
//             var date = new Date();
//             var ms = objHours * 3600 * 1000;
//             date.setTime(date.getTime() + ms);
//             str += "; expires=" + date;
//         }
//         document.cookie = str;
//         // alert("添加cookie成功");
//     },
//     get: (name) => {
//         var arrStr = document.cookie.split("; ");
//         for (var i = 0; i < arrStr.length; i++) {
//             var temp = arrStr[i].split("=");
//             if (temp[0] == name)
//                 return unescape(temp[1]);
//         }
//     },
//     del: (name) => {
//         var date = new Date();
//         date.setTime(date.getTime() - 10000);
//         document.cookie = name + "=a; expires=" + date;

//     },
//     all: () => {
//         var str = document.cookie;
//         if (str == "") {
//             str = "没有保存任何cookie";
//         }
//         // alert(str);
//     }
// }


export const VueCookie = {
    set: function (name, value, time) {
        // 缓存过期时间
        let Days = time? time: 1;
        let exp = new Date()
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000)
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
