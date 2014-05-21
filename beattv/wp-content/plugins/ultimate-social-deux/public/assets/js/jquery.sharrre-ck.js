/*!
 *  Sharrre.com - Make your sharing widget!
 *  Version: beta 1.3.5
 *  Author: Julien Hany
 *  License: MIT http://en.wikipedia.org/wiki/MIT_License or GPLv2 http://en.wikipedia.org/wiki/GNU_General_Public_License
 */(function(t,n,r,i){function h(e,n){this.element=e;this.options=t.extend(!0,{},u,n);this.options.share=n.share;this._defaults=u;this._name=o;this.init()}function p(e,t,s,o){var u=n.screenLeft!=i?n.screenLeft:screen.left,a=n.screenTop!=i?n.screenTop:screen.top;width=n.innerWidth?n.innerWidth:r.documentElement.clientWidth?r.documentElement.clientWidth:screen.width;height=n.innerHeight?n.innerHeight:r.documentElement.clientHeight?r.documentElement.clientHeight:screen.height;var f=width/2-s/2+u,l=height/2-o/2+a,c=n.open(e,t,"scrollbars=yes, width="+s+", height="+o+", top="+l+", left="+f);n.focus&&c.focus()}var o="ultimate_social_deux",u={className:"sharrre",share:{googlePlus:!1,facebook:!1,twitter:!1,digg:!1,delicious:!1,stumbleupon:!1,linkedin:!1,pinterest:!1},shareTotal:0,template:"",title:"",url:r.location.href,text:r.title,urlCurl:"sharrre.php",count:{},total:0,shorterTotal:!0,enableHover:!0,enableCounter:!0,enableTracking:!1,hover:function(){},hide:function(){},click:function(){},render:function(){},buttons:{googlePlus:{url:"",urlCount:!1,size:"medium",lang:"en-US",annotation:""},facebook:{url:"",urlCount:!1,action:"like",layout:"button_count",width:"",send:"false",faces:"false",colorscheme:"",font:"",lang:"en_US"},twitter:{url:"",urlCount:!1,count:"horizontal",hashtags:"",via:"",related:"",lang:"en"},digg:{url:"",urlCount:!1,type:"DiggCompact"},delicious:{url:"",urlCount:!1,size:"medium"},stumbleupon:{url:"",urlCount:!1,layout:"1"},linkedin:{url:"",urlCount:!1,counter:""},pinterest:{url:"",media:"",description:"",layout:"horizontal"},buffer:{url:"",media:"",description:"",layout:"horizontal",tweetText:""}}},a={googlePlus:"",facebook:"https://graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=%27{url}%27&callback=?",twitter:"http://cdn.api.twitter.com/1/urls/count.json?url={url}&callback=?",digg:"http://services.digg.com/2.0/story.getInfo?links={url}&type=javascript&callback=?",delicious:"http://feeds.delicious.com/v2/json/urlinfo/data?url={url}&callback=?",stumbleupon:"",linkedin:"http://www.linkedin.com/countserv/count/share?format=jsonp&url={url}&callback=?",pinterest:"",buffer:"https://api.bufferapp.com/1/links/shares.json?url={url}&callback=?"},f={googlePlus:function(e){var i=e.options.buttons.googlePlus;t(e.element).find(".buttons").append('<div class="button googleplus"><div class="g-plusone" data-size="'+i.size+'" data-href="'+(i.url!==""?i.url:e.options.url)+'" data-annotation="'+i.annotation+'"></div></div>');n.___gcfg={lang:e.options.buttons.googlePlus.lang};var s=0;if(typeof gapi=="undefined"&&s==0){s=1;(function(){var e=r.createElement("script");e.type="text/javascript";e.async=!0;e.src="//apis.google.com/js/plusone.js";var t=r.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})()}else gapi.plusone.go()},facebook:function(e){var n=e.options.buttons.facebook;t(e.element).find(".buttons").append('<div class="button facebook"><div id="fb-root"></div><div class="fb-like" data-href="'+(n.url!==""?n.url:e.options.url)+'" data-send="'+n.send+'" data-layout="'+n.layout+'" data-width="'+n.width+'" data-show-faces="'+n.faces+'" data-action="'+n.action+'" data-colorscheme="'+n.colorscheme+'" data-font="'+n.font+'" data-via="'+n.via+'"></div></div>');var i=0;if(typeof FB=="undefined"&&i==0){i=1;(function(e,t,r){var i,s=e.getElementsByTagName(t)[0];if(e.getElementById(r))return;i=e.createElement(t);i.id=r;i.src="//connect.facebook.net/"+n.lang+"/all.js#xfbml=1";s.parentNode.insertBefore(i,s)})(r,"script","facebook-jssdk")}else FB.XFBML.parse()},twitter:function(e){var n=e.options.buttons.twitter;t(e.element).find(".buttons").append('<div class="button twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'+(n.url!==""?n.url:e.options.url)+'" data-count="'+n.count+'" data-text="'+e.options.text+'" data-via="'+n.via+'" data-hashtags="'+n.hashtags+'" data-related="'+n.related+'" data-lang="'+n.lang+'">Tweet</a></div>');var i=0;if(typeof twttr=="undefined"&&i==0){i=1;(function(){var e=r.createElement("script");e.type="text/javascript";e.async=!0;e.src="//platform.twitter.com/widgets.js";var t=r.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})()}else t.ajax({url:"//platform.twitter.com/widgets.js",dataType:"script",cache:!0})},digg:function(e){var n=e.options.buttons.digg;t(e.element).find(".buttons").append('<div class="button digg"><a class="DiggThisButton '+n.type+'" rel="nofollow external" href="http://digg.com/submit?url='+encodeURIComponent(n.url!==""?n.url:e.options.url)+'"></a></div>');var i=0;if(typeof __DBW=="undefined"&&i==0){i=1;(function(){var e=r.createElement("SCRIPT"),t=r.getElementsByTagName("SCRIPT")[0];e.type="text/javascript";e.async=!0;e.src="//widgets.digg.com/buttons.js";t.parentNode.insertBefore(e,t)})()}},delicious:function(e){if(e.options.buttons.delicious.size=="tall")var n="width:50px;",r="height:35px;width:50px;font-size:15px;line-height:35px;",i="height:18px;line-height:18px;margin-top:3px;";else var n="width:93px;",r="float:right;padding:0 3px;height:20px;width:26px;line-height:20px;",i="float:left;height:20px;line-height:20px;";var s=e.shorterTotal(e.options.count.delicious);typeof s=="undefined"&&(s=0);t(e.element).find(".buttons").append('<div class="button delicious"><div style="'+n+'font:12px Arial,Helvetica,sans-serif;cursor:pointer;color:#666666;display:inline-block;float:none;height:20px;line-height:normal;margin:0;padding:0;text-indent:0;vertical-align:baseline;">'+'<div style="'+r+'background-color:#fff;margin-bottom:5px;overflow:hidden;text-align:center;border:1px solid #ccc;border-radius:3px;">'+s+"</div>"+'<div style="'+i+'display:block;padding:0;text-align:center;text-decoration:none;width:50px;background-color:#7EACEE;border:1px solid #40679C;border-radius:3px;color:#fff;">'+'<img src="http://www.delicious.com/static/img/delicious.small.gif" height="10" width="10" alt="Delicious" /> Add</div></div></div>');t(e.element).find(".delicious").on("click",function(){e.openPopup("delicious")})},stumbleupon:function(e){var i=e.options.buttons.stumbleupon;t(e.element).find(".buttons").append('<div class="button stumbleupon"><su:badge layout="'+i.layout+'" location="'+(i.url!==""?i.url:e.options.url)+'"></su:badge></div>');var o=0;if(typeof STMBLPN=="undefined"&&o==0){o=1;(function(){var e=r.createElement("script");e.type="text/javascript";e.async=!0;e.src="//platform.stumbleupon.com/1/widgets.js";var t=r.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})();s=n.setTimeout(function(){if(typeof STMBLPN!="undefined"){STMBLPN.processWidgets();clearInterval(s)}},500)}else STMBLPN.processWidgets()},linkedin:function(e){var i=e.options.buttons.linkedin;t(e.element).find(".buttons").append('<div class="button linkedin"><script type="in/share" data-url="'+(i.url!==""?i.url:e.options.url)+'" data-counter="'+i.counter+'"></script></div>');var s=0;if(typeof n.IN=="undefined"&&s==0){s=1;(function(){var e=r.createElement("script");e.type="text/javascript";e.async=!0;e.src="//platform.linkedin.com/in.js";var t=r.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})()}else n.IN.init()},pinterest:function(e){var n=e.options.buttons.pinterest;t(e.element).find(".buttons").append('<div class="button pinterest"><a href="http://pinterest.com/pin/create/button/?url='+(n.url!==""?n.url:e.options.url)+"&media="+n.media+"&description="+n.description+'" class="pin-it-button" count-layout="'+n.layout+'">Pin It</a></div>');(function(){var e=r.createElement("script");e.type="text/javascript";e.async=!0;e.src="//assets.pinterest.com/js/pinit.js";var t=r.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})()}},l={googlePlus:function(){},facebook:function(){fb=n.setInterval(function(){if(typeof FB!="undefined"){FB.Event.subscribe("edge.create",function(e){_gaq.push(["_trackSocial","facebook","like",e])});FB.Event.subscribe("edge.remove",function(e){_gaq.push(["_trackSocial","facebook","unlike",e])});FB.Event.subscribe("message.send",function(e){_gaq.push(["_trackSocial","facebook","send",e])});clearInterval(fb)}},1e3)},twitter:function(){tw=n.setInterval(function(){if(typeof twttr!="undefined"){twttr.events.bind("tweet",function(e){e&&_gaq.push(["_trackSocial","twitter","tweet"])});clearInterval(tw)}},1e3)},digg:function(){},delicious:function(){},stumbleupon:function(){},linkedin:function(){function e(){_gaq.push(["_trackSocial","linkedin","share"])}},pinterest:function(){}},c={googlePlus:function(e){p("https://plus.google.com/share?hl="+e.buttons.googlePlus.lang+"&url="+encodeURIComponent(e.buttons.googlePlus.url!==""?e.buttons.googlePlus.url:e.url),"googlePlus",us_sharrre.googleplus_width,us_sharrre.googleplus_height)},facebook:function(e){p("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(e.buttons.facebook.url!==""?e.buttons.facebook.url:e.url)+"&t="+e.text+"","facebook",us_sharrre.facebook_width,us_sharrre.facebook_height)},twitter:function(e){p("https://twitter.com/intent/tweet?text="+encodeURIComponent(e.text)+"&url="+encodeURIComponent(e.buttons.twitter.url!==""?e.buttons.twitter.url:e.url)+(e.buttons.twitter.via!==""?"&via="+e.buttons.twitter.via:""),"twitter",us_sharrre.twitter_width,us_sharrre.twitter_height)},digg:function(e){p("http://digg.com/tools/diggthis/submit?url="+encodeURIComponent(e.buttons.digg.url!==""?e.buttons.digg.url:e.url)+"&title="+e.text+"&related=true&style=true","digg",us_sharrre.digg_width,us_sharrre.digg_height)},delicious:function(e){p("http://www.delicious.com/save?v=5&noui&jump=close&url="+encodeURIComponent(e.buttons.delicious.url!==""?e.buttons.delicious.url:e.url)+"&title="+e.text,"delicious",us_sharrre.delicious_width,us_sharrre.delicious_height)},stumbleupon:function(e){p("http://www.stumbleupon.com/badge/?url="+encodeURIComponent(e.buttons.stumbleupon.url!==""?e.buttons.stumbleupon.url:e.url),"stumble",us_sharrre.stumble_width,us_sharrre.stumble_height)},linkedin:function(e){p("https://www.linkedin.com/cws/share?url="+encodeURIComponent(e.buttons.linkedin.url!==""?e.buttons.linkedin.url:e.url)+"&token=&isFramed=true","linkedin",us_sharrre.linkedin_width,us_sharrre.linkedin_height)},pinterest:function(e){p("http://pinterest.com/pin/create/button/?url="+encodeURIComponent(e.buttons.pinterest.url!==""?e.buttons.pinterest.url:e.url)+"&media="+encodeURIComponent(e.buttons.pinterest.media)+"&description="+e.buttons.pinterest.description,"pinterest",us_sharrre.pinterest_width,us_sharrre.pinterest_height)},buffer:function(e){p("http://bufferapp.com/add?url="+encodeURIComponent(e.buttons.buffer.url!==""?e.buttons.buffer.url:e.url)+"&text="+e.buttons.buffer.tweetText+"&via=&picture=&count="+e.buttons.buffer.layout+"&source=button","buffer",us_sharrre.buffer_width,us_sharrre.buffer_height)}};h.prototype.init=function(){var e=this;if(this.options.urlCurl!==""){a.googlePlus=this.options.urlCurl+"?url={url}&type=googlePlus";a.stumbleupon=this.options.urlCurl+"?url={url}&type=stumbleupon";a.pinterest=this.options.urlCurl+"?url={url}&type=pinterest"}t(this.element).addClass(this.options.className);typeof t(this.element).data("title")!="undefined"&&(this.options.title=t(this.element).attr("data-title"));typeof t(this.element).data("url")!="undefined"&&(this.options.url=t(this.element).data("url"));typeof t(this.element).data("text")!="undefined"&&(this.options.text=t(this.element).data("text"));t.each(this.options.share,function(t,n){n===!0&&e.options.shareTotal++});e.options.enableCounter===!0?t.each(this.options.share,function(t,n){if(n===!0)try{e.getSocialJson(t)}catch(r){}}):e.options.template!==""?this.options.render(this,this.options):this.loadButtons();t(this.element).hover(function(){t(this).find(".buttons").length===0&&e.options.enableHover===!0&&e.loadButtons();e.options.hover(e,e.options)},function(){e.options.hide(e,e.options)});t(this.element).click(function(){e.options.click(e,e.options);return!1})};h.prototype.loadButtons=function(){var e=this;t(this.element).append('<div class="buttons"></div>');t.each(e.options.share,function(t,n){if(n==1){f[t](e);e.options.enableTracking===!0&&l[t]()}})};h.prototype.getSocialJson=function(e){var n=this,r=0,i=a[e].replace("{url}",encodeURIComponent(this.options.url));this.options.buttons[e].urlCount===!0&&this.options.buttons[e].url!==""&&(i=a[e].replace("{url}",this.options.buttons[e].url));if(i!=""&&n.options.urlCurl!=="")t.getJSON(i,function(t){if(typeof t.count!="undefined"||typeof t.shares!="undefined"){if(t.count)var i=t.count+"";else if(t.shares)var i=t.shares+"";else var i="0";i=i.replace("Â ","");r+=parseInt(i,10)}else typeof t[0]!="undefined"?r+=parseInt(t[0].total_posts,10):t.data&&t.data.length>0&&typeof t.data[0].total_count!="undefined"?r+=parseInt(t.data[0].total_count,10):typeof t[0]!="undefined";n.options.count[e]=r;n.options.total+=r;n.renderer();n.rendererPerso()}).error(function(){n.options.count[e]=0;n.rendererPerso()});else{n.renderer();n.options.count[e]=0;n.rendererPerso()}};h.prototype.rendererPerso=function(){var t=0;for(e in this.options.count)t++;t===this.options.shareTotal&&this.options.render(this,this.options)};h.prototype.renderer=function(){var e=this.options.total,n=this.options.template;this.options.shorterTotal===!0&&(e=this.shorterTotal(e));if(n!==""){n=n.replace("{total}",e);t(this.element).html(n)}else t(this.element).html('<div class="box"><a class="count" href="#">'+e+"</a>"+(this.options.title!==""?'<a class="share" href="#">'+this.options.title+"</a>":"")+"</div>")};h.prototype.shorterTotal=function(e){e>=1e6?e=(e/1e6).toFixed(2)+"M":e>=1e3&&(e=(e/1e3).toFixed(1)+"k");return e};h.prototype.openPopup=function(e){c[e](this.options);if(this.options.enableTracking===!0){var t={googlePlus:{site:"Google",action:"+1"},facebook:{site:"facebook",action:"like"},twitter:{site:"twitter",action:"tweet"},digg:{site:"digg",action:"add"},delicious:{site:"delicious",action:"add"},stumbleupon:{site:"stumbleupon",action:"add"},linkedin:{site:"linkedin",action:"share"},pinterest:{site:"pinterest",action:"pin"}};_gaq.push(["_trackSocial",t[e].site,t[e].action])}};h.prototype.simulateClick=function(){var e=t(this.element).html();t(this.element).html(e.replace(this.options.total,this.options.total+1))};h.prototype.update=function(e,t){e!==""&&(this.options.url=e);t!==""&&(this.options.text=t)};t.fn[o]=function(e){var n=arguments;if(e===i||typeof e=="object")return this.each(function(){t.data(this,"plugin_"+o)||t.data(this,"plugin_"+o,new h(this,e))});if(typeof e=="string"&&e[0]!=="_"&&e!=="init")return this.each(function(){var r=t.data(this,"plugin_"+o);r instanceof h&&typeof r[e]=="function"&&r[e].apply(r,Array.prototype.slice.call(n,1))})}})(jQuery,window,document);