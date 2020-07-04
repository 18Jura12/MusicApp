//$( window ).on( 'load', function() {
//    $( '.btn-group').on( 'click', ukloni ); //div
//} );

function ukloni() {
    var pjesma = $(this).children(":first").val();
    console.log( pjesma );

}