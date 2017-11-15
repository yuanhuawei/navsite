/**
 * ==========================================
 * config.js
 * Copyright (c) 2014 wwww.114la.com
 * ==========================================
 */
 
 var searchName = window.location.search;
 if(typeof mainDomain == "undefined"){
	var mainDomain = "http://www.114la.com";
 }
 var staticDomain =  mainDomain + "/static/themes/default/theme/";
 (function(){
 
    var union_name = [
        "good",
        "wgho",
        "setup",
        "touchds",
        "339la",
        "hang",
        "ie567",
        "sky",
        "361la"
    ];
    var qq_union = [
        ["xy","xy.html"],
        ["long","long.html"],
        ["xiazaiba","xiazaiba.html"],
        ["soft","soft.html"],
        ["xs","xs.html"],
        ["qvod","qvod.html"],
        ["wl","wl.html"],
        ["hua","hua.html"],
        ["wgho","wgho.html"],
        ["anyue","anyue.html"],
        ["setup","setup.html"]
    ];


    for(var j = 0;j < qq_union.length; j++){
        if("?"+qq_union[j][0]==searchName){
            window.location.href = "http://www.qq.net/"+qq_union[j][1];
        }
    };
 
 })();

var Config = {
	getThemeUrl : function(){
		return mainDomain + '/theme.html?t=' + parseInt(Math.random() * 100);	
	},
	getThemeTypeUrl : function(type){
		type = type || "newest";
		return  'static/themes/default/theme/' + type + '.html?t=' + parseInt(Math.random() * 100);	
	},
    getThemeJs : function(theme){
        var themeJs = {
            "singer" : staticDomain + "static/themes/default/js/theme/singer.js",
            "2014women" : staticDomain + "static/themes/default/js/theme/2014women.js",
			"2014summer" : staticDomain + "static/themes/default/js/theme/2014summer.js"
        }
        return themeJs[theme];
    },
	cssFilePath : 'static/themes/default/css/skin/',
	SkinCookieName : 'skinCss',
	defaultTheme : "blue",
    Search: {
        s115: {
            action: "http://s.116.com/",
            name: "q",
            btn: "�� ��",
            img: ["static/images/search/116.gif", "116.com"],
            url: "http://s.116.com/",
            params: {
                ie: 'gbk'
            }
        },
        web: {
            action: "http://www.baidu.com/s",
            name: "wd",
            btn: "�ٶ�һ��",
            img: ["static/images/search/baidu.gif?v2.0", "�ٶ���ҳ"],
            url: "http://www.baidu.com/index.php?tn=" + BaiduTn.tn + "&ch=" + BaiduTn.ch,
            params: {
                tn: BaiduTn.tn,
                ch: BaiduTn.ch
            }
        },
        mp3: {
            action: "http://mp3.baidu.com/m",
            name: "word",
            btn: "�ٶ�һ��",
            img: ["static/images/search/mp3.gif?v2.0", "�ٶ�һ��"],
            url: "http://music.baidu.com/?ie=utf-8&ct=134217728&word=&tn="+BaiduTn.tn+"&ch="+BaiduTn.ch,
            params: {
                tn: BaiduTn.tn,
                ch: BaiduTn.ch,
                f: "ms",
                ct: "134217728",
                ie:"utf-8"
            }
        },
        v115: {
            action: "http://hz.v.baofeng.com/search/web/search.php",
            name: "keywords",
            btn: "������Ƶ",
            img: ["static/images/search/bf-video.gif?v2.0", "������Ƶ"],
            url: "http://hz.v.baofeng.com/",
            params: {
                //charset: 'gbk'
            }
        },
        image: {
            action: "http://image.baidu.com/i",
            name: "word",
            btn: "�ٶ�һ��",
            img: ["static/images/search/pic.gif?v2.0", "�ٶ�ͼƬ"],
            url: "http://image.baidu.com/",
            params: {
                ct: "201326592",
                cl: "2",
                pv: "",
                lm: "-1"
            }
        },
        zhidao: {
            action: "http://zhidao.baidu.com/q",
            name: "word",
            btn: "�ٶ�һ��",
            img: ["static/images/search/zhidao.gif?v2.0", "�ٶ�֪��"],
            url: "http://zhidao.baidu.com/q?pt=ylmf_ik",
            params: {
                tn: "ikaslist",
                ct: "17",
                pt: "ylmf_ik"
            }
        },
        taobao: {
            action: "http://search8.taobao.com/browse/search_auction.htm",
            name: "q",
            btn: "�Ա�����",
            img: ["static/images/search/taobao.gif?v2.0", "�Ա���"],
            url: "http://www.taobao.com/",
            params: {
                pid: "mm_33597634_3422071_11069807",
                unid: "114la",
                commend: "all",
                search_type: "action",
                user_action: "initiative",
                f: "D9_5_1",
                at_topsearch: "1",
                sid: "(05ba391dbdcada4634d4077c189eeef7)",
                sort: "",
                spercent: "0"
            }
        },
        baike: {
            action: "http://baike.baidu.com/searchword/",
            name: "word",
            btn: "��������",
            img: ["static/images/search/baike.gif", "�ٶȰٿ�"],
            url: "http://baike.baidu.com/",
            params: {
                tn: "baiduWikiSearch",
                submit: "search",
                pn: "0",
                rn: "10",
                ct: "17",
                lm: "0"
            }
        },
        ditu: {
            action: "http://map.baidu.com/m",
            name: "word",
            btn: "������ͼ",
            img: ["static/images/search/ditu.gif", "�ٶȵ�ͼ"],
            url: "http://map.baidu.com/",
            params: {
                ie: 'gbk'

            }
        },
        computer: {
            action: "http://search.yesky.com/searchproduct.do",
            name: "wd",
            btn: "�� ��",
            img: ["static/images/search/yesky.gif", "�켫����"],
            url: "http://product.yesky.com/",
            params: {
                ie: 'gbk'

            }
        }

    },
    Mail: [{
        val: 0 
    }, { /*163.com*/
        action: "http://reg.163.com/CheckUser.jsp",
        params: {
            url: "http://entry.mail.163.com/coremail/fcg/ntesdoor2?lightweight=1&verifycookie=1&language=-1&style=15",
            username: "#{u}",
            password: "#{p}"
        }
    }, { /*126.com*/
        action: "https://reg.163.com/logins.jsp",
        params: {
            domain: "126.com",
            username: "#{u}@126.com",
            password: "#{p}",
            url: "http://entry.mail.126.com/cgi/ntesdoor?lightweight%3D1%26verifycookie%3D1%26language%3D0%26style%3D-1"
        }
    }, { /*vip.163.com*/
        action: "https://ssl1.vip.163.com/logon.m",
        params: {
            username: "#{u}",
            password: "#{p}",
            enterVip: true
        }
    }, { /*sina.com*/
        action: "http://mail.sina.com.cn/cgi-bin/login.cgi",
        params: {
            u: "#{u}",
            psw: "#{p}"
        }
    }, { /*vip.sina.com*/
        action: "http://vip.sina.com.cn/cgi-bin/login.cgi",
        params: {
            user: "#{u}",
            pass: "#{p}"
        }
    }, { /*yahoo.com.cn*/
        action: "https://edit.bjs.yahoo.com/config/login",
        params: {
            login: "#{u}@yahoo.com.cn",
            passwd: "#{p}",
            domainss: "yahoo",
            ".intl": "cn",
            ".src": "ym"
        }
    }, { /*yahoo.cn*/
        action: "https://edit.bjs.yahoo.com/config/login",
        params: {
            login: "#{u}@yahoo.cn",
            passwd: "#{p}",
            domainss: "yahoocn",
            ".intl": "cn",
            ".done": "http://mail.cn.yahoo.com/inset.html"
        }
    }, { /*sohu.com*/
        action: "http://passport.sohu.com/login.jsp",
        params: {
            loginid: "#{u}@sohu.com",
            passwd: "#{p}",
            fl: "1",
            vr: "1|1",
            appid: "1000",
            ru: "http://login.mail.sohu.com/servlet/LoginServlet",
            ct: "1173080990",
            sg: "5082635c77272088ae7241ccdf7cf062"
        }
    }, { /*tom.com*/
        action: "http://login.mail.tom.com/cgi/login",
        params: {
            user: "#{u}",
            pass: "#{p}"
        }
    }, { /*21cn.com*/
        action: "http://passport.21cn.com/maillogin.jsp",
        params: {
            UserName: "#{u}@21cn.com",
            passwd: "#{p}",
            domainname: "21cn.com"
        }
    }, { /*yeah.net*/
        action: "https://reg.163.com/logins.jsp",
        params: {
            domain: "yeah.net",
            username: "#{u}@yeah.net",
            password: "#{p}",
            url: "http://entry.mail.yeah.net/cgi/ntesdoor?lightweight%3D1%26verifycookie%3D1%26style%3D-1"
        }
    }, {
        action: "http://zx.passport.189.cn/Logon/UDBCommon/S/PassportLogin.aspx?PassportLoginRequest=3500000000400101%243qGTaeZcFhxvAWjKmUNeSXwAgn1LsgB7Baj1rQn96XNKuzpE%2baP%2b9Q6CDg1Bqmrnosfrnoa6ujbo%0aBzYxmWBAESIoGVwlaoSM4%2fMixUkU7%2fAcJ0L4Yrckifcqhk3rO22i",
        params: {
            __VIEWSTATE: "/wEPDwUKMTYxODg2ODExNQ9kFgJmD2QWDgIBDxYCHgVzdHlsZQUSdmlzaWJpbGl0eTp2aXNpYmxlFgICAQ8PFgIeBFRleHQFG+eUqOaIt+WQjeaIluWvhueggemUmeivr+OAgmRkAg0PDxYEHgtOYXZpZ2F0ZVVybAVIaHR0cDovL3Bhc3Nwb3J0LjE4OS5jbi9TZWxmUy9ML1JlZy9TZWxlY3QuYXNweD9EZXZpY2VObz0zNTAwMDAwMDAwNDAwMTAxHwEFByDms6jlhoxkZAIPDw8WAh8BBTRodHRwOi8vd3d3LjE4OS5jbi93ZWJtYWlsL2pzcC8xODltaXNjL3Y1L2Nzcy91ZGIuY3NzZGQCEQ8PFgIfAQUtaHR0cDovL3dlYm1haWw1LjE4OS5jbi93ZWJtYWlsL1VEQkxvZ2luUmV0dXJuZGQCEw8PFgIfAQUQMzUwMDAwMDAwMDQwMDEwMWRkAhUPDxYCHwEFDDEyNC4yMDUuNzcuOWRkAhcPDxYCHwEFDHZCWWdGcWRydTVrPWRkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYBBQtjYl9TYXZlTmFtZYevyftAQT5CX9s2VZJOrPsTLqDH",
            __EVENTVALIDATION: "/wEWCQLckeONBALT8dy8BQKd+7qdDgK/8ZbBBQKhwImNCwK1yJy1AQLhyKz0DgKh/9zICgKnqZGuBiPwFoYTVzM5HAbhLCKRJWRuEyet",
            txtUserID: "#{u}",
            txtPwd: "#{p}"
        }
    }, { /*139.com*/
        action: "https://mail.10086.cn/Login/Login.ashx",
        params: {
            UserName: "#{u}",
            Password: "#{p}",
            ClientId: "5028",
            type: "mail"
        }
    }, { /*�ٶ��ʺ�*/
        action: "http://passport.baidu.com/?login",
        params: {
            u: "http://passport.baidu.com/center",
            username: "#{u}",
            password: "#{p}"
        }
    }, { /*renren*/
        action: "http://passport.renren.com/PLogin.do",
        params: {
            email: "#{u}",
            password: "#{p}",
            origURL: "http://www.renren.com/Home.do",
            domain: "renren.com"
        }
    }, { /*51.com*/
        action: "http://passport.51.com/login.5p",
        params: {
            passport_51_user: "#{u}",
            passport_51_password: "#{p}",
            gourl: "http%3A%2F%2Fmy.51.com%2Fwebim%2Findex.php"
        }
    }, { /*chinaren*/
        action: "http://passport.sohu.com/login.jsp",
        params: {
            loginid: "#{u}@chinaren.com",
            passwd: "#{p}",
            fl: "1",
            vr: "1|1",
            appid: "1005",
            ru: "http://profile.chinaren.com/urs/setcookie.jsp?burl=http://alumni.chinaren.com/",
            ct: "1174378209",
            sg: "84ff7b2e1d8f3dc46c6d17bb83fe72bd"
        }
    }],
    banner: {
        b4: {
            img: "static/images/banner/taoke12060.jpg",
            url: "http://pindao.huoban.taobao.com/channel/channelMall.htm?pid=mm_11140156_0_0"
        }
    },
    Track: [
		["js_mailSubmit", { n: "�����¼", u: "�����¼", q: 0}]
	],
    Keywords: [
		["���ɱ�����", "http://www.xiazaiba.com/html/1773.html"],
		["�ṷ", "http://www.xiazaiba.com/html/63.html"]
	]/*,
	citysArr:{
		'A-G':[����,��ɽ,���Ű뵺,����,����,
			����,����,����,��ɫ,����,����,
			����,����,����,����,��ɳ,����,
			����,����,�ɶ�,��ݸ,����,����,����,
			����,����,����,���Ǹ�,��ɽ,����,
			����,����,����,���,����,����],
		'H-L':[����,����,����,�Ϸ�,����,����,��ɽ,����,����,����,�ӳ�,����,��Դ,���ͺ���,������,
			����,��,������,����,����,����,����,����,����,������,��¡,������,���,��Ȫ,����,
			����,�������տ¶�����,��ɽ,
			��ˮ,���Ƹ�,����,����,����,����,�ȷ�,����,����,����,�뵺],
		'M-T':[��ɽ,÷��,ï��,
			����,�ϲ�,�Ͼ�,��ͨ,����,��ƽ,����,��Ͷ��,
			�Ž�,����,ƽ��,
			����,Ȫ��,�ൺ,����,��Զ,����,
			����,�Ϻ�,����,����,��Ǩ,����,����,ʯ��ׯ,����,����,�ع�,��β,��ͷ,����,��ƽ,
			̨��,̩��,ͭ��,���,̫ԭ,̩��,��ɽ,̨��,̨��,̨��,��ˮ],
		'W-Z':[��³ľ��,����,����,�ߺ�,Ϋ��,����,�人,����,����,
			����,����,����,����,����,����,��̶,�差,����,��۵�,�½�,
			ӥ̶,�˴�,����,�γ�,��̨,����,�˲�,����,�Ƹ�,����,�˱�,
			��ɽ,��,����,�Ͳ�,֣��,����,�麣,տ��,��ɽ,����,��Ҵ]
	}*/
};
/*
function getProId(proName) {
    var ProId;
    CityArr.forEach(function (element, index, array) {
        if (element[0] === proName) {
            ProId = element[2];
        }
    });
    return ProId;
}

function getCityId(ProId, CityName) {
    var CityId;
    CityArr.forEach(function (element, index, array) {
        if (element[0] === CityName && element[1] === ProId) {
            CityId = element[2];
        }
    });
    return CityId;
}
*/