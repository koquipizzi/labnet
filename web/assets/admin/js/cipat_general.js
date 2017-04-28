
$(document).on('ready', function () {   
    

    $(function check_order(){
        $( "a" ).each(function( index ) {
            var attr = $(this).attr('data-sort');
            if (typeof attr !== typeof undefined && attr !== false) {
                 //   console.log( "a: " + $( this ).text() );
                 $(this).addClass('sorting');            
            }
        });    
    });
    

    
});

    