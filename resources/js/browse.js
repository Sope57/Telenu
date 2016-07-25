$(document).on("ready ajaxComplete",function(){
    window.addToList = function(id) {
        $.ajax({ url: '../resources/php/browse.php',
            data: {action: 'updateMyList', index : id},
            type: 'post',
            success: function(response) {
                $('.add'+id+'toList').empty();
                var container = document.getElementById('add'+id+'toList');
                container.innerHTML = response;
            }
        });
    }
});

$( function() {

  var $seriesgrid = $('.series-grid').isotope({
    percentPosition: true,
    itemSelector: '.grid-item',
    layoutMode: 'fitRows',
    masonry: {
      columnWidth: '.grid-sizer'
    },
    getSortData: {
      name: '.name',
      rating: '.rating parseInt'
    }
  });

  $('.sort-by-button-group').on( 'click', 'a', function() {
    var sortValue = $(this).attr('data-sort-value');
    $seriesgrid.isotope({ sortBy: sortValue });
  });

  var $bwfgrid = $('.bwf-grid').isotope({
    percentPosition: true,
    itemSelector: '.grid-item',
    layoutMode: 'fitRows',
    masonry: {
      columnWidth: '.grid-sizer'
    }
  });

  $('.filters-button-group').on( 'click', 'a', function() {
    var filterValue = $( this ).attr('data-filter');
    $bwfgrid.isotope({ filter: filterValue });
  });

  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'a', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });
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
            }, 500);
        }
    });
}