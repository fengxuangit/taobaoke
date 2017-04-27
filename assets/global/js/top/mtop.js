function L(str) {
    console.error(str);
};

var mtop = {
    pid: 'mm_10011550_0_0',
    is_init: false,
    dataType:'jsonp',
    init: function(call) {
        var _this = this;
        if (!this.is_init) {
            if('KISSY' in window && 'lib' in window){
                 _this.is_init = true;
                 if (typeof call == 'function') call.call(_this);
            }else{
                var ks = 'https://g.alicdn.com/kissy/k/1.4.4/seed-min.js';
                this.append(ks, function() {
                    _this.append("assets/global/js/top/taobao_mtop.js", function() {
                        _this.is_init = true;
                        if (typeof call == 'function') call.call(_this);
                    });
                });
            }
        }
        return this;
    },
    get_secreKey:function(call){
         var _this = this;
        _cookie.get("https://m.taobao.com/",'_m_h5_tk',function(val){
            //自动写到cookie中
           C('_m_h5_tk',val);
            if (typeof call == 'function') call.call(_this,val);
        });
         return this;
    },
    append: function(url, call) {
        var tmp = url.split("/");
        var id = tmp[tmp.length - 1].replace(/\./g, '_').replace(/\?(.*)$/, '');
        var obj = document.getElementById(id);
        if (obj) {
            if (obj['_load_over'] === true) {
                if (typeof call == 'function') call(obj);
            } else {
                var check_timer = setInterval(function() {
                    if (obj['_load_over'] === true) {
                        if (typeof call == 'function') call(obj);
                        clearInterval(check_timer);
                    }
                }, 100);
            }
            return;
        }
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.id = id;
        script.charset = 'utf-8';
        if (script.readyState) {
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                    script._load_over = true;
                    if (typeof call == 'function') call(script);
                }
            };
        } else {
            script.onload = function() {
                script._load_over = true;
                if (typeof call == 'function') call(script);
            };
        }
        script.src = url;
        document.body.appendChild(script);

        return this;

    },
    get_style: function(styleId, callback) {
        if (!this.is_init) {
             console.error("mtop not init") ;
             return ;
        }

        var config = {
            styleId: styleId,
            pid: this.pid,
            unid: '0',
            w: '13'
        }
        var type = 'post';
        var dataType = location.protocol.indexOf('http')!=-1 ? 'jsonp':'json';
        if(dataType == 'jsonp')  type = 'get';

        var _this = this;
        lib.mtop.request({
            api: 'mtop.aitaobao.style.get',
            v: '1.0',
            dataType:dataType,
            type:type,
            data: config
        }, function(rs, type) {
            _this.check(rs, callback,'style');
        }, function(json, type) {
             _this.refre();
            callback('mtop error ' + json.ret[0].split('::')[1]);
        });
        return this;
    },
    get_goods: function(num_iid, callback) {
         if (!this.is_init) {
             console.error("mtop not init") ;
             return ;
        }

        var extParams = {
            id: num_iid,
            ali_trackid: '2:' + this.pid + ':1464879491_2k2_1265878601',
            spm: 'a311n.7676423.1005.30.',
            pvid: "201_10.176.141.130_2429024351_1464863596227",
        };
        var config = {
            itemNumId: num_iid,
            exParams: JSON.stringify(extParams)
        };
        var _this = this;

        lib.mtop.request({
            api: 'mtop.taobao.detail.getdetail',
            v: '6.0',
            dataType:this.dataType,
            type:'get',
            ttid: '2013@taobao_h5_1.0.0',
            data: config
        }, function(rs, type) {
            _this.check(rs, callback,'goods');
        }, function(json, type) {
            var rs = json.ret[0].split('::');
            callback('mtop error: ' + (rs[1] ? rs[1] : rs[0]));
        });

        return this;
    },get_desc:function(num_iid, type,callback){
        if (!this.is_init) {
             console.error("mtop not init") ;
             return ;
        }
        //mtop.wdetail.getitemdescx/4.1/

        //type   0=手机版,1=pc版
        var _this = this;
        // this.get_goods(num_iid,function(rs){
         //       var f = sub_str(rs.item.taobaoDescUrl,'&f=',-1);

                type = ~~type+"";
                var f = '';
                var data = { id:num_iid,type:type,f:f};

                lib.mtop.request({
                    api: 'mtop.taobao.detail.getdesc',
                    v: '6.0',
                    timeout:'20000',
                    dataType:_this.dataType,
                    type:'get',
                    data: data
                }, function(rs, type) {
                    _this.check(rs, callback,'desc');
                }, function(json, type) {
                    var rs = json.ret[0].split('::');
                    var msg = (rs[1] ? rs[1] : rs[0]);

                    callback('mtop error: ' +msg );
                    if(msg == '非法请求'){
                        Dialog.info('获取失败,请重新刷新页面');
                    }else{
                        Dialog.info(msg);
                    }


                });
      //  })
        return this;
    },
    check: function(json, callback,parse) {

        if (json && json.ret && json.ret[0] && json.ret[0].indexOf('SUCCESS') === 0) {
            var data = json.data;
            var key = 'parse_'+parse;
            if(parse &&  key in this ) data = this[key](data);
            callback(data);
        } else {
            this.refre();
            var msg = json.ret && json.ret[0] && json.ret[0].split('::')[1] || '未知错误';
            Dialog.info(msg);
            callback(msg);
        }
    },refre:function(){
        this.get_secreKey();
    },parse_goods:function(data){

        var rs = data.item;
        var seller = data.seller;
        var s = {};

       var shop = {
            logo: seller.shopIcon,
            seller_id: seller.userId,
            shop_id: seller.shopId,
            url: 'http://store.taobao.com/shop/view_shop.htm?user_number_id='+seller.userId,
            title: seller.shopName,
            shop_type: seller.shopType == 'B' ? 1 : 2,
            item_count: seller.allItemCount,
            nick: seller.sellerNick
        }

            s.title = rs.title;
            s.shop_type = shop.shop_type;
            s.num_iid = rs.itemId;
            s.bili = '';
            s.images = rs.images;
            s.picurl = rs.images[0];
            s.baoyou = 1;
            s.nick = shop.nick;
            s.sid = shop.seller_id;
            s.url = 'http://item.taobao.com/item.htm?id=' + rs.itemId;
            s.shop_url = shop.url;
            s.sum = 999;
                 // var tmp = rs.ds_provcity.split(' ');
                 // s.state = tmp[0];
                 // s.city = tmp[1];


            var val = JSON.parse(data.apiStack[0].value);

            s.yh_price = parseFloat(val.price.price.priceText).toFixed(1);
            if (val.price.extraPrices.length>0) {
                s.price = parseFloat(val.price.extraPrices[0].priceText).toFixed(1);
                var zhe = String(10 / parseFloat(s.price / s.yh_price));
                s.zk = zhe.substring(0, 3);
            } else {
                s.price = s.yh_price;
                s.zk = 10;
            }


           s.shop = shop;
           return s;
    },parse_style:function(data){
        var rs = {
            title:data.description.substr(0,30),
            content:data.description,
            picurl:'http:'+data.mainPic,
            like:data.like,
            images:[],
            keywords:data.tags
        }

        for (var i = 0; i < data.subPics.length; i++) {
            rs.images.push('http:'+data.subPics[i]);
        }
        var goods = [] ;
        for(var i=0;i<data.items.length;i++){
            var v = data.items[i];
            if(!v.itemStatus) continue;
            goods.push({num_iid:v.itemId,like:v.like,picurl:'http'+v.picUrl,yh_price:v.discountPrice});
        }
        rs.goods = goods;
        return rs;
    }
}
