/**
 * Created by thinkpad on 14-6-25.
 */

var tX = [];
var tY = [];
var x;
var y;
var isSlide = true;
var clientX, clientY;
function touchstart(a) {
    x = a.touches[0].pageX;
    y = a.touches[0].pageY;
    clientX = a.touches[0].clientX;
    clientY = a.touches[0].clientY;
    tX.push(x);
    tY.push(y);
    var b = $("#func").css("margin-left");
    y = parseInt(b.split("px").shift())
}
function touchmove(c) {
    isSlide = true;
    var d = c.touches;
    var e = d[0];
    tX.push(e.pageX);
    tY.push(e.pageY);
    if (tX != undefined && tX.length > 1) {
        var b = Math.abs(e.clientX - clientX);
        if (tY != undefined && tY.length > 1) {
            var a = Math.abs(e.clientY - clientY);
            if (b > a) {
                if (y == -298) {
                    c.preventDefault();
                    $("#func").css("margin-left", (e.pageX - 298 - x) + "px")
                } else {
                    c.preventDefault();
                    $("#func").css("margin-left", (e.pageX - x) + "px")
                }
            } else {
                isSlide = false
            }
        }
    }
}
function touchend(g) {
    if (isSlide) {
        if (tX != undefined && tX.length > 1) {
            var b = parseInt(tX[0], 10);
            var f = parseInt(tX[tX.length - 1], 10);
            var d = Math.abs(b - f);
            if (tY != undefined && tY.length > 1) {
                var a = parseInt(tY[0], 10);
                var e = parseInt(tY[tY.length - 1], 10);
                var c = Math.abs(a - e);
                if (f > b) {
                    $("#func").animate({
                            "margin-left": "0px"
                        },
                        200)
                } else {
                    $("#func").animate({
                            "margin-left": "-298px"
                        },
                        200)
                }
            }
            tX = [];
            tY = []
        }
    } else {
        var h = parseInt($("#func").css("margin-left").replace("px", ""));
        if (h < -149) {
            $("#func").animate({
                    "margin-left": "-298px"
                },
                200)
        } else {
            $("#func").animate({
                    "margin-left": "0px"
                },
                200)
        }
        tX = [];
        tY = []
    }
}
var startPosX;
var startPosY;
var powerA;
var powerB;
var isend = false;
var cpage = 1;
function tStart(a) {
    startPosX = a.touches[0].pageX;
    startPosY = a.touches[0].pageY
}
function tMove(a) {
    var d = $("#slider").css("margin-left").replace("px", "");
    var b = Math.abs(Math.ceil(parseInt(d) / 71)) + 5;
    var j = $("#slider img");
    for (var e = 0; e < b; e++) {
        if (j.length > e && $(j[e]).attr("imgdata")) {
            $(j[e]).attr("src", $(j[e]).attr("imgdata"));
            $(j[e]).removeAttr("imgdata")
        }
    }
    if (Math.abs(a.touches[0].pageY - startPosY) < Math.abs(a.touches[0].pageX - startPosX)) {
        a.preventDefault()
    }
    var f = a.touches;
    var h = parseInt($("#slider").css("width").replace("px", ""));
    if (a.touches.length == 1) {
        if (f[0].pageX > startPosX) {
            var g = f[0].pageX - startPosX;
            var c = parseInt($("#slider").css("margin-left").replace("px", ""));
            $("#slider").css("margin-left", c + g + "px")
        } else {
            var g = f[0].pageX - startPosX;
            var c = parseInt($("#slider").css("margin-left").replace("px", ""));
            $("#slider").css("margin-left", c + g + "px")
        }
        startPosX = f[0].pageX
    }
    if (f.length > 0) {
        powerA = powerB;
        powerB = f[f.length - 1].pageX
    }
}
function tEnd(c) {
    var d = parseInt($("#slider").css("margin-left").replace("px", ""));
    var b = parseInt($("#slider").css("width").replace("px", ""));
    if (powerA && powerB && powerA > 0 && powerB > 0) {
        var a = Math.abs(powerA - powerB);
        if (a > 0) {
            $("#slider").animate({
                    "margin-left": (powerA > powerB ? d - a: d + a) + "px"
                },
                200)
        }
    }
    if (d > 0) {
        setTimeout(function() {
                $("#slider").animate({
                        "margin-left": "0px"
                    },
                    200)
            },
            200)
    }
    if (Math.abs(d) > (b - 320)) {
        if (!isend) {
            cpage += 1;
            jQuery.post("/index/getWare.json", {
                    page: cpage
                },
                function(h) {
                    if (h && h.crazyList && h.crazyList.length > 0) {
                        var f;
                        var g;
                        for (var e = 0; e < h.crazyList.length; e++) {
                            g = h.crazyList[e];
                            f = '<li class="new-tbl-cell"><a href="/product/' + g.wareId + '.html",$sid)"><img src="' + g.imageurl + '" width="70" height="70"><span>&yen;' + g.jdPrice + "</span></a></li>";
                            $("#slider").append(f)
                        }
                    } else {
                        isend = true;
                        setTimeout(function() {
                                $("#slider").animate({
                                        "margin-left": -((b - 320 + 20)) + "px"
                                    },
                                    200)
                            },
                            200)
                    }
                },
                "json")
        } else {
            setTimeout(function() {
                    $("#slider").animate({
                            "margin-left": -((b - 320 + 20)) + "px"
                        },
                        200)
                },
                200)
        }
    }
    powerA = 0;
    powerB = 0
}
$(function() {
    $("#newkeyword").focus(function() {
        $("#newkeyword").attr("style", "color:#333;")
    });
    $("#newkeyword").blur(function() {
        $("#newkeyword").attr("style", "color:#333;")
    })
});

function createPicMove(a, b, c) {
    var g = function(j) {
        return "string" == typeof j ? document.getElementById(j) : j
    };
    var d = function(j, l) {
        for (var k in l) {
            j[k] = l[k]
        }
        return j
    };
    var f = function(j) {
        return j.currentStyle || document.defaultView.getComputedStyle(j, null)
    };
    var i = function(l, j) {
        var k = Array.prototype.slice.call(arguments).slice(2);
        return function() {
            return j.apply(l, k.concat(Array.prototype.slice.call(arguments)))
        }
    };
    var e = {
        Quart: {
            easeOut: function(k, j, m, l) {
                return - m * ((k = k / l - 1) * k * k * k - 1) + j
            }
        },
        Back: {
            easeOut: function(k, j, n, m, l) {
                if (l == undefined) {
                    l = 1.70158
                }
                return n * ((k = k / m - 1) * k * ((l + 1) * k + l) + 1) + j
            }
        },
        Bounce: {
            easeOut: function(k, j, m, l) {
                if ((k /= l) < (1 / 2.75)) {
                    return m * (7.5625 * k * k) + j
                } else {
                    if (k < (2 / 2.75)) {
                        return m * (7.5625 * (k -= (1.5 / 2.75)) * k + 0.75) + j
                    } else {
                        if (k < (2.5 / 2.75)) {
                            return m * (7.5625 * (k -= (2.25 / 2.75)) * k + 0.9375) + j
                        } else {
                            return m * (7.5625 * (k -= (2.625 / 2.75)) * k + 0.984375) + j
                        }
                    }
                }
            }
        }
    };
    var h = function(k, n, m, l) {
        this._slider = g(n);
        this._container = g(k);
        this._timer = null;
        this._count = Math.abs(m);
        this._target = 0;
        this._t = this._b = this._c = 0;
        this.Index = 0;
        this.SetOptions(l);
        this.Auto = !!this.options.Auto;
        this.Duration = Math.abs(this.options.Duration);
        this.Time = Math.abs(this.options.Time);
        this.Pause = Math.abs(this.options.Pause);
        this.Tween = this.options.Tween;
        this.onStart = this.options.onStart;
        this.onFinish = this.options.onFinish;
        var j = !!this.options.Vertical;
        this._css = j ? "top": "left";
        var o = f(this._container).position;
        o == "relative" || o == "absolute" || (this._container.style.position = "relative");
        this._container.style.overflow = "hidden";
        this._slider.style.position = "absolute";
        this.Change = this.options.Change ? this.options.Change: this._slider[j ? "offsetHeight": "offsetWidth"] / this._count
    };
    h.prototype = {
        SetOptions: function(j) {
            this.options = {
                Vertical: true,
                Auto: true,
                Change: 0,
                Duration: 50,
                Time: 10,
                Pause: 4000,
                onStart: function() {},
                onFinish: function() {},
                Tween: e.Quart.easeOut
            };
            d(this.options, j || {})
        },
        Run: function(j) {
            j == undefined && (j = this.Index);
            j < 0 && (j = this._count - 1) || j >= this._count && (j = 0);
            this._target = -Math.abs(this.Change) * (this.Index = j);
            this._t = 0;
            this._b = parseInt(f(this._slider)[this.options.Vertical ? "top": "left"]);
            this._c = this._target - this._b;
            this.onStart();
            this.Move()
        },
        Move: function() {
            clearTimeout(this._timer);
            if (this._c && this._t < this.Duration) {
                this.MoveTo(Math.round(this.Tween(this._t++, this._b, this._c, this.Duration)));
                this._timer = setTimeout(i(this, this.Move), this.Time)
            } else {
                this.MoveTo(this._target);
                this.Auto && (this._timer = setTimeout(i(this, this.Next), this.Pause))
            }
        },
        MoveTo: function(j) {
            this._slider.style[this._css] = j + "px"
        },
        Next: function() {
            this.Run(++this.Index)
        },
        Previous: function() {
            this.Run(--this.Index)
        },
        Stop: function() {
            clearTimeout(this._timer);
            this.MoveTo(this._target)
        }
    };
    return new h(a, b, c, {
        Vertical: false
    })
}



