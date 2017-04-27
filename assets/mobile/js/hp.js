(function(b) {
    if (window.mhpz) {
        return
    }
    var c = {
            modules: {}
        },
        a = {
            version: "$Revision: 3937 $"
        };
    a.List = [];
    a.opts = {};
    a.exopts = {};
    a.queue = {};
    a.addModule = function(e, d) {
        if (c.modules[e]) {
            d = b.extend(c.modules[e], d)
        }
        c.modules[e] = d;
        if (c.modules[e] && c.modules[e].Init) {
            c.modules[e].Init(a.opts)
        }
    };
    a.getModule = function(d) {
        return c.modules[d]
    };
    a.Init = function(d) {
        b.extend(this.opts, d);
        return
    };
    b(document).ready(function() {
        for (var d in c.modules) {
            if (c.modules[d] && c.modules[d].OnLoad) {
                c.modules[d].OnLoad(a.opts)
            }
        }
    });
    window.mhpz = a
})(Zepto); (function(a) {
    Array.prototype.del = function(b) {
        if (b < 0) {
            return this
        } else {
            return this.slice(0, b).concat(this.slice(b + 1, this.length))
        }
    };
    a.Buffers = function() {
        this._s = new Array;
        this.type = false;
        if (arguments[0] == "queue") {
            this.type = true
        }
    };
    a.Buffers.prototype = {
        push: function(c) {
            if (arguments.length == 0) {
                return false
            }
            for (var b = 0; b < arguments.length; b++) {
                this._s.push(arguments[b])
            }
            return this._s.length
        },
        pop: function() {
            if (this._s.length == 0) {
                return null
            } else {
                if (this.type) {
                    return this._s.pop()
                } else {
                    return this._s.shift()
                }
            }
        },
        getTop: function() {
            if (this._s.length == 0) {
                return null
            } else {
                if (this.type) {
                    return this._s[this._s.length - 1]
                } else {
                    return this._s[0];
                }
            }
        },
        getLast: function() {
            if (this._s.length == 0) {
                return null
            } else {
                if (this.type) {
                    return this._s[0]
                } else {
                    return this._s[this._s.length - 1]
                }
            }
        },
        size: function() {
            return this._s.length
        },
        empty: function() {
            this._s.length = 0
        },
        isEmpty: function() {
            if (this._s.length == 0) {
                return true
            } else {
                return false
            }
        },
        toString: function() {
            var b = this._s.join("");
            this._s.length = 0;
            return b
        },
        toArray: function() {
            return this._s
        }
    };
//    a.browser.name = (navigator.userAgent.toLowerCase().match(/\b(chrome|opera|safari|msie|firefox)\b/) || ["", "mozilla"])[1];
 //   a.browser.ver = a.browser.version;
    a.extend({
        getScript: function(d, c) {
            var b = false;
            var e = [];
            callback = new Function;
            if (arguments.length > 1) {
                switch (a.type(c)) {
                    case "boolean":
                        b = c;
                        break;
                    case "function":
                        callback = c;
                        break;
                    case "object":
                        b = c.cache ? c.cache: false;
                        callback = c.callback ? c.callback: callback;
                        e = c.parameter ? c.parameter: e;
                        break
                }
            }
            a.ajax({
                type: "GET",
                url: d,
                success: function() {
                    try {
                        callback.apply(this, (e))
                    } catch(f) {}
                },
                dataType: "script",
                cache: b
            })
        },
        cookie: function(f, g, c) {
            if (arguments.length == 0) {
                try {
                    if (navigator.cookieEnabled == false) {
                        return false
                    }
                } catch(i) {}
                return true
            }
            if (arguments.length > 1 && String(g) !== "[object Object]") {
                c = a.extend({},
                    c);
                if (g === null || g === undefined) {
                    c.expires = -1
                }
                if (typeof c.expires === "number") {
                    var j = c.expires,
                        d = c.expires = new Date();
                    d.setDate(d.getDate() + j)
                }
                g = String(g);
                return (document.cookie = [encodeURIComponent(f), "=", c.raw ? g: encodeURIComponent(g), c.expires ? "; expires=" + c.expires.toUTCString() : "", c.path ? "; path=" + c.path: "", c.domain ? "; domain=" + c.domain: "", c.secure ? "; secure": ""].join(""))
            }
            c = g || {};
            var b, h = c.raw ?
                function(e) {
                    return e
                }: decodeURIComponent;
            return (b = new RegExp("(?:^|; )" + encodeURIComponent(f) + "=([^;]*)").exec(document.cookie)) ? h(b[1]) : ""
        },
        getParm: function(d, i) {
            var c = d ? d: window.location.toString();
            var e;
            if (c && c.indexOf("?")) {
                var b = c.split("?");
                var f = b[1];
                var h = {};
                if (f && f.indexOf("&")) {
                    var g = f.split("&");
                    Zepto.each(g,
                        function(j, l) {
                            if (l && l.indexOf("=")) {
                                var k = l.split("=");
                                if (i) {
                                    if (typeof(i) == "string" && i == k[0]) {
                                        e = k[1] == null ? "": k[1];
                                        return e
                                    }
                                } else {
                                    h[k[0]] = k[1]
                                }
                            }
                        })
                }
            }
            return h
        },
        ParseTpl: function(f, e) {
            var b;
            var d = new RegExp("{{#([a-zA-z0-9]+)}}");
            while ((b = d.exec(f)) != null) {
                var c = e[b[1]] === 0 ? "0": e[b[1]] || "";
                f = f.replace(new RegExp(b[0], "g"), c)
            }
            return f
        },
        rdStr: function(d, h) {
            var g = 8;
            var f = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
            d = d || g;
            d = d < 1 ? g: d;
            d = d > f.length ? g: d;
            var e = "";
            for (var c = 0; c < d; c++) {
                var b = Math.floor(Math.random() * f.length);
                e += f.substring(b, b + 1)
            }
            if (h) {
                e += new Date().getTime()
            }
            return e
        },
        getTime: {
            now: function() {
                return (new Date()).getTime()
            },
            getDateStr: function(f, x) {
                var d = function(h) {
                    if (a.type(h) !== "number") {
                        return
                    }
                    if (h == 3) {
                        return " " + v + ":" + q + ":" + l
                    }
                    if (h == 4) {
                        return " " + e + ":" + w
                    }
                    if (h == 6) {
                        return " " + e + ":" + w + ":" + r
                    }
                    return ""
                };
                if (!x) {
                    if (f < 10) {
                        x = f;
                        f = new Date()
                    }
                }
                var f = f || new Date();
                var i = "-",
                    c = "",
                    k = new Date(f);
                k.setTime(f);
                var b = k.getFullYear(),
                    j = b + "".substring(2, 4),
                    g = k.getMonth() + 1,
                    n = k.getDate(),
                    v = k.getHours(),
                    q = k.getMinutes(),
                    l = k.getSeconds();
                var o = g < 10 ? "0" + g: g,
                    u = n < 10 ? "0" + n: n,
                    e = v < 10 ? "0" + v: v,
                    w = q < 10 ? "0" + q: q,
                    r = l < 10 ? "0" + l: l;
                var y = {
                    Y: b,
                    YY: j,
                    M: g,
                    MM: o,
                    D: n,
                    DD: u,
                    h: v,
                    hh: e,
                    m: q,
                    mm: w,
                    s: l,
                    ss: r
                };
                switch (a.type(x)) {
                    case "string":
                        i = x;
                        break;
                    case "number":
                        c = d(x);
                        break;
                    case "object":
                        if (x.tpl) {
                            p = a.ParseTpl ? a.ParseTpl(x.tpl, y) : y;
                            return p;
                            break
                        }
                        i = x.rs ? x.rs: i;
                        c = d(x.HHMMSS ? x.HHMMSS: c);
                        break
                }
                var p = b + i + g + i + n + c;
                return p
            },
            friendly: function(g) {
                if (a.type(g) != "number") {
                    return ""
                }
                var j = "",
                    v = 1000,
                    o = v * 60,
                    e = o * 60,
                    u = +new Date,
                    c = new Date(),
                    b = c.getFullYear(),
                    p = c.getMonth(),
                    h = c.getDate(),
                    f = new Date(b, p, h),
                    n = f.getTime(),
                    k = u - g;
                if (k < 0) {
                    j = ""
                } else {
                    if (k <= o * 5) {
                        j = "刚刚"
                    } else {
                        if (k < e) {
                            var q = Math.floor(k / o);
                            j = q + "分钟前"
                        } else {
                            if (k < u - n) {
                                var i = new Date(g),
                                    d = i.getHours(),
                                    s = i.getMinutes();
                                if (d < 10) {
                                    d = "0" + d
                                }
                                if (s < 10) {
                                    s = "0" + s
                                }
                                j = "今日 " + d + ":" + s
                            } else {
                                var i = new Date(g),
                                    l = i.getMonth() + 1,
                                    r = i.getDate(),
                                    d = i.getHours(),
                                    s = i.getMinutes();
                                if (l < 10) {
                                    l = "0" + l
                                }
                                if (r < 10) {
                                    r = "0" + r
                                }
                                if (d < 10) {
                                    d = "0" + d
                                }
                                if (s < 10) {
                                    s = "0" + s
                                }
                                j = l + "月" + r + "日 " + d + ":" + s
                            }
                        }
                    }
                }
                return j
            },
            countDown: function() {
                if (parseInt(arguments[0]) > 0) {
                    var b = this,
                        c = false;
                    times = Math.floor((arguments[0] - (arguments[1] || (new Date()).getTime())) / 1000);
                    if (times < 0) {
                        c = true;
                        times = times < 0 ? -times: times
                    }
                    return {
                        t: c,
                        s: times % 60,
                        ss: times % 60 < 10 ? "0" + times % 60 : times % 60,
                        m: Math.floor(times / 60) % 60,
                        mm: Math.floor(times / 60) % 60 < 10 ? "0" + Math.floor(times / 60) % 60 : Math.floor(times / 60) % 60,
                        h: Math.floor(times / 3600) % 24,
                        hh: Math.floor(times / 3600) % 24 < 10 ? "0" + Math.floor(times / 3600) % 24 : Math.floor(times / 3600) % 24,
                        D: Math.floor(times / 86400),
                        DD: Math.floor(times / 86400) < 10 ? "0" + Math.floor(times / 86400) : Math.floor(times / 86400)
                    }
                } else {
                    return {}
                }
            },
            countTimer: new Array()
        }
    })
})(Zepto); (function(a) {
    var b = {
        x: 0,
        y: 0,
        lastX: 0,
        lastY: 0,
        status: "ok",
        init: function(e, d, f) {
            var c = this;
            e.bind("touchstart",
                function(g) {
                    c._touchstart(g)
                });
            e.bind("touchmove",
                function(g) {
                    c._touchmove(g,
                        function(h, i) {
                            d.call(e, h, i)
                        })
                });
            e.bind("touchend",
                function(g) {
                    c._touchend(g,
                        function(h, i) {
                            f.call(e, h, i)
                        })
                })
        },
        _touchstart: function(c) {
            var d = c.originalEvent;
            this.x = d.touches[0].pageX;
            this.scrollX = window.pageXOffset;
            this.scrollY = window.pageYOffset
        },
        _touchmove: function(c, f) {
            var d = c.originalEvent;
            if (d.touches.length > 1) {
                this.status = "ok";
                return
            }
            this.lastX = d.touches[0].pageX;
            var g = this.x - this.lastX;
            if (this.status == "ok") {
                if (this.scrollY == window.pageYOffset && this.scrollX == window.pageXOffset && Math.abs(g) > 50) {
                    this.status = "touch"
                } else {
                    return
                }
            }
            a(document.body).bind("touchmove",
                function() {
                    return false
                });
            f(this.x, this.lastX);
            d.preventDefault();
            return false
        },
        _touchend: function(d, c) {
            var f = d.originalEvent;
            if (this.status != "touch") {
                return
            }
            this.status = "ok";
            c(this.x, this.lastX);
            a(document.body).unbind("touchmove")
        }
    };
    a.fn.touchmove = function(c) {
        return a(this).each(function() {
            b.init(a(this), c.onMove || new Function, c.onMoveEnd || new Function)
        })
    }
})(Zepto);