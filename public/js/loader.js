var loaderLoading = '<div class="bg_loader loader" id="loader">';
function showLoader(){
    $('body').fadeIn('slow').append(loaderLoading);
}

function hideLoader(){
    $('#loader').fadeOut('slow').remove();;
}