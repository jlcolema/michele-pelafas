jQuery(document).ready(function($) {

    $('.mp-load-more').click(function(){
        event.preventDefault();

        //Get values for ajax query
        var maxpages = $(this).data('maxpages'),
            posts_per_page = $(this).data('ppp'),
            cat = $(this).data('cat'),
            postnotin = $(this).data('postnotin');

        var button = $(this),
            data = {
            'action': 'loadmore',
            'page' : mp_loadmore_params.current_page,
            'posts_per_page' : posts_per_page,
            'cat' : cat,
            'postnotin' : postnotin
        };

        console.log(postnotin);
 
        $.ajax({
            url : mp_loadmore_params.ajaxurl, // AJAX handler
            data : data,
            type : 'POST',
            beforeSend : function ( xhr ) {
                button.text('Loading...'); // change the button text, you can also add a preloader image
            },
            success : function( data ){
                if( data ) { 
                    var items = $( data ); // data is the HTML of loaded posts

                    $('.grid-items').append( items );

                    mp_loadmore_params.current_page++;

                    if ( mp_loadmore_params.current_page == maxpages ) 
                        button.remove(); // if last page, remove the button

                    button.text('Load More');
                } else {
                    button.remove(); // if no data, remove the button as well
                }
            }
        });
    });

});