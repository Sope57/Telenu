$('.dropdown').hover(
    function(){
        $(this).children('.dropdown-menu').slideDown(200,stop());
    },
    function(){
        $(this).children('.dropdown-menu').slideUp(200,stop());
    }
);

function stop(){
    $('.dropdown-menu').stop(true, true);
}

function openNav() {
    document.getElementById("searchNav").style.height = "100%";
    $("#search").focus();
}

function closeNav() {
    document.getElementById("searchNav").style.height = "0%";
}

$(document).ready(function(e) {
	$("#search").keyup(function(){
		$("#livesearch").show();
		var x = $(this).val();
		$.ajax({
			url: 'http://telenu.tv/resources/php/livesearch.php',
			data: 'q='+x,
			type: 'GET',
			success:function(data){
				$("#livesearch").html(data);
			}
		});
	});
});

$('#showRegister').modal({
  backdrop: 'static',
  keyboard: false
})