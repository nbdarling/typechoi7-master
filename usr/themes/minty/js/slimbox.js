!function(a){function y(){var c=b.scrollLeft(),d=b.width();a([t]).css("left",c+d/2),i&&a(s).css({left:c,top:b.scrollTop(),width:d,height:b.height()})}function z(c){c?a("object").add(m?"select":"embed").each(function(a,b){n[a]=[b,b.style.visibility],b.style.visibility="hidden"}):(a.each(n,function(a,b){b[0].style.visibility=b[1]}),n=[]);var d=c?"bind":"unbind";b[d]("scroll resize",y),a(document)[d]("keydown",A)}function A(b){var d=b.which,e=a.inArray;return e(d,c.closeKeys)>=0?H():e(d,c.nextKeys)>=0?C():e(d,c.previousKeys)>=0?B():null}function B(){return D(g)}function C(){return D(h)}function D(a){return a>=0&&(e=a,f=d[e][0],g=(e||(c.loop?d.length:0))-1,h=(e+1)%d.length||(c.loop?0:-1),G(),t.className="lbLoading",p=new Image,p.onload=E,p.src=f),!1}function E(){var e,i,m,n,o;t.className="",a(u).css({backgroundImage:"url("+f+")",visibility:"hidden",display:"","background-size":"100%"}),e=p.width,i=p.height,m=b.width(),n=b.height(),e>=m||i>=n?m>=n?(a(v).width(.8*n*e/i),a([v,w,x]).height(.8*n)):(a(v).width(.8*m),a([v,w,x]).height(.8*m*i/e)):(a(v).width(p.width),a([v,w,x]).height(p.height)),g>=0&&(q.src=d[g][0]),h>=0&&(r.src=d[h][0]),k=u.offsetWidth,l=u.offsetHeight,o=Math.max(0,j-l/2),t.offsetHeight!=l&&a(t).animate({height:l,top:o},c.resizeDuration,c.resizeEasing),t.offsetWidth!=k&&a(t).animate({width:k,marginLeft:-k/2},c.resizeDuration,c.resizeEasing),a(t).queue(function(){a(u).css({display:"none",visibility:"",opacity:""}).fadeIn(c.imageFadeDuration,F)})}function F(){g>=0&&a(w).show(),h>=0&&a(x).show()}function G(){p.onload=null,p.src=q.src=r.src=f,a([t,u]).stop(!0),a([w,x,u]).hide()}function H(){return e>=0&&(G(),e=g=h=-1,a(t).hide(),a(s).stop().fadeOut(c.overlayFadeDuration,z)),!1}var c,d,f,g,h,i,j,k,l,s,t,u,v,w,x,b=a(window),e=-1,m=!window.XMLHttpRequest,n=[],p=(document.documentElement,{}),q=new Image,r=new Image;a(function(){a("body").append(a([s=a('<div id="lbOverlay" />').click(H)[0],t=a('<div id="lbCenter" />')[0]]).css("display","none")),u=a('<div id="lbImage" />').appendTo(t).append(v=a('<div style="position: relative;" />').append([w=a('<a id="lbPrevLink" href="#" />').click(B)[0],x=a('<a id="lbNextLink" href="#" />').click(C)[0]])[0])[0]}),a.slimbox=function(e,f,g){return c=a.extend({loop:!1,overlayOpacity:.8,overlayFadeDuration:200,resizeDuration:200,resizeEasing:"swing",initialWidth:250,initialHeight:250,imageFadeDuration:200,closeKeys:[27,88,67],previousKeys:[37,80],nextKeys:[39,78]},g),"string"==typeof e&&(e=[[e,f]],f=0),j=b.scrollTop()+b.height()/2,k=c.initialWidth,l=c.initialHeight,a(t).css({top:Math.max(0,j-l/2),width:k,height:l,marginLeft:-k/2}).show(),i=m||s.currentStyle&&"fixed"!=s.currentStyle.position,i&&(s.style.position="absolute"),a(s).css("opacity",c.overlayOpacity).fadeIn(c.overlayFadeDuration),y(),z(1),d=e,c.loop=c.loop&&d.length>1,D(f)},a.fn.slimbox=function(b,c,d){c=c||function(a){return[a.href,a.title]},d=d||function(){return!0};var e=this;return e.unbind("click").click(function(){var h,j,f=this,g=0,i=0;for(h=a.grep(e,function(a,b){return d.call(f,a,b)}),j=h.length;j>i;++i)h[i]==f&&(g=i),h[i]=c(h[i],i);return a.slimbox(h,g,b)})}}(jQuery),jQuery(document).ready(function(a){a(".entry-content a:has(img)").slimbox()});