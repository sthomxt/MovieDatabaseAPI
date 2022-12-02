var tmdb;

$(document).ready(function() {

    $('#search-button').click(function(e) {
        // store search field information
        let serach_param = $('#search').val();
        if (serach_param) {
            // hide unused page contents
            $('#contents').addClass('invisible');
            let formData = { search: serach_param, method: 'search' }
            // send form data to API via ajax call
            ajax_call(formData, 'search');
        }
    });

    details_click = function(data) {
        let formData = { search: data, method: 'details' }
        // send form data to API via ajax call
        ajax_call(formData, 'details');
    }

    ajax_call = function(formData, method) {
        $.ajax('include/ajax.inc.php', {
            type: 'POST',  // http method
            data: formData,  // data to submit
            success: function (response) {
                // store API response to global variable
                tmdb = JSON.parse(response);
                // update webpage
                display(tmdb, method);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                // move to background
                $('#info').html('Error' + errorMessage);
            }
        });
    }

    display = function(contents, method) {
        // update webpage depending on method = search/details
        let div_content = '';
        if (method=='search') {
            // search results content
            jQuery.each(contents, function(i, val) {
                div_content = div_content + '<div id="tmdb_grid" class="col-sm-3 border border-2 m-1 p-2 rounded font-weight-bold" ' +
                    'style="cursor:pointer !important; border-color:#8758AC !important; background-color:#E7E1F2;" ' +
                    'onclick="details_click(\'' + val.id + '\',\'details\')">' +
                    '<div class="pull-left" style="font-weight: 500;">' + val.title + '</div>' +
                    '<div class="pull-right">' + val.year + '</div>' +
                    '</div>';
            });

            if (div_content.length === 0) { div_content = '<span class="display-6 text-danger">No Results Found</span>'; }

            let div_open = '<div class="container">';
            let div_close = '</div>';
            let hover = '<style>#tmdb_grid:hover { background-color: #D6C1E0 !important; }</style>';

            $('#contents').html( div_open + '<div class="row">' + div_content + '</div>' + div_close + hover );
            $('#contents').removeClass('invisible');

        } else {
            // details page content
            let val = JSON.parse(JSON.stringify(contents));
            let div_open = '<div class="container">';
            let div_close = '</div>';
            let image = val[0].poster_path;

            if (image) { image = 'https://image.tmdb.org/t/p/w200' + val[0].poster_path; }
            else { image = 'include/no-image-icon.png'; }

            div_content = '<div class="container">' +
                '<div class="row">' +
                    '<div class="col-md-2 mb-2">' +
                        '<img src="' + image + '"  class="img-fluid" alt="Responsive image" />' +
                    '</div>' +
                    '<div class="col">' +
                        '<div class="h5 p-2 text-white" style="background-color:#8758AC !important;">' + val[0].title + ' ' + val[0].year + '</div>' +
                        '<div class="p-2" style="background-color:#E7E1F2 !important;">' + val[0].overview  + '</div>' +
                        '<div class="p-2">' + val[0].genre + '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('#contents').html( div_open + div_content + div_close );
            $('#contents').removeClass('invisible');
        }

    }
    
});