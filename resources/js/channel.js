function update_video_data(index) {
    $.ajax({ url: '../resources/php/channel.php',
        data: {action: 'update_video_data', index : index},
        type: 'post',
        success: function(response) {
            $('.videoDataContainer').empty();
            var container = document.getElementById('videoDataContainer');
            container.innerHTML = response;
            $.ajax({ url: '../resources/php/channel.php',
                data: {action: 'fetch_social_share'},
                type: 'post',
                success: function(response) {
                    $('.social-share').empty();
                    var container = document.getElementById('social-share');
                    container.innerHTML = response;
                }
            });
        }
    });
}

function on_video_complete() {
	$.ajax({ url: '../resources/php/channel.php',
        data: {action: 'update_index'},
        type: 'post',
        success: function(response) {
            update_video_data(response);
        }
    });
}

$(document).on("ready ajaxComplete",function(){
	window.openReply = function(id) {
	    $('#form'+id).removeClass('hidden');
		$('#form'+id).children('textarea[name="text_cmt"]').focus();
	}
	window.postComment = function(id) {
	    $('#'+id).ajaxForm(function() {
	       $.ajax({ url: '../resources/php/channel.php',
                data: {action: 'get_comments'},
                type: 'post',
                success: function(response) {
                    $('.comments').empty();
                    var container = document.getElementById('comments');
                    container.innerHTML = response;
                }
            });
	    });
	}
    window.postRating = function() {
        $('#ratingForm').ajaxForm(function() {
            $.ajax({ url: '../resources/php/channel.php',
                data: {action: 'update_rating_data'},
                type: 'post',
                success: function(response) {
                    $("#telep").css('width', response['rating'] + '%');
                    $("#telen").css('width', response['ratingn'] + '%');
                }
            });
        });
    }
    window.updateVideoData = function(id) {
		var index = id;
        update_video_data(index);
    }
    window.updateUrlLink = function(vidkey, ChL) {
        var
            sObj = {"video": vidkey},
            title = ChL,
            url = ChL + "&v=" + vidkey;
        history.pushState(sObj, title, url);
    }
});

$(document).ready(function(){
    $('#videoCarousel').owlCarousel({
        margin:50,
        stagePadding:40,
        loop:false,
        nav:true,
        dots:false,
        navText: [
          "<i class='fa fa-chevron-left'></i>",
          "<i class='fa fa-chevron-right'></i>"
          ],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    })
});

$(window).load(function(){
    naver();    
});

function naver(){
    $('.navigator').on('click', function (event) {
        var target = $($(this).attr('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
}

$(function(){
    $("#carouselButton").click(function(){
        $("#carouselButton").addClass("activeView");
        $("#gridButton").removeClass("activeView");
        $("#gridView").addClass("hidden");
        $("#carouselView").removeClass("hidden");
    });
});

$(function(){
    $("#gridButton").click(function(){
        $("#gridButton").addClass("activeView");
        $("#carouselButton").removeClass("activeView");
        $("#carouselView").addClass("hidden");
        $("#gridView").removeClass("hidden");
    });
});

$("input[type=radio]").click(function() {
    $("label").each(function() {
        $( this ).removeClass( "checked" );
    });
    $("label[for='"+$(this).attr('id')+"']").addClass( "checked" );
    $("#ratingForm").submit();
});

$(window).scroll(function() {
  var scrolledY = $(window).scrollTop();
  $('.bannerOverlay').css('background-position', 'left ' + ((scrolledY)) + 'px');
});

