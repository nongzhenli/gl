// 获取cookie
export const VueCookie = {
    add: (objName, objValue, objHours) => {
        var str = objName + "=" + escape(objValue);
        if (objHours > 0) {//为0时不设定过期时间，浏览器关闭时cookie自动消失
            var date = new Date();
            var ms = objHours * 3600 * 1000;
            date.setTime(date.getTime() + ms);
            str += "; expires=" + date;
        }
        document.cookie = str;
        // alert("添加cookie成功");
    },
    get: (name) => {
        var arrStr = document.cookie.split("; ");
        for (var i = 0; i < arrStr.length; i++) {
            var temp = arrStr[i].split("=");
            if (temp[0] == name)
                return unescape(temp[1]);
        }
    },
    del: (name) => {
        var date = new Date();
        date.setTime(date.getTime() - 10000);
        document.cookie = name + "=a; expires=" + date;
        
    },
    all: () => {
        var str = document.cookie;
        if (str == "") {
            str = "没有保存任何cookie";
        }
        // alert(str);
    }
}
