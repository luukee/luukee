$(window).scroll(function(){$(window).scrollTop()>100?$(".main-h").addClass("sticky"):$(".main-h").removeClass("sticky")}),$(".mobile-toggle").click(function(){$(".main-h").hasClass("open-nav")?$(".main-h").removeClass("open-nav"):$(".main-h").addClass("open-nav")}),$(".main-h li a").click(function(){$(".main-h").hasClass("open-nav")&&($(".navigation").removeClass("open-nav"),$(".main-h").removeClass("open-nav"))}),$("nav a").click(function(a){var n=$(this).attr("href"),o=70,i=$(n).offset().top-70;$("html, body").animate({scrollTop:i},500),a.preventDefault()});