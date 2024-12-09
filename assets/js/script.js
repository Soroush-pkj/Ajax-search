jQuery(document).ready(function ($) {
    $('#ajax-search-input').on('keyup', function () {
        var searchTerm = $(this).val();

        if (searchTerm.length >= 1) {
            $('#loading-animation').show();
            $.ajax({
                url: ajaxSearch.ajax_url,
                type: 'POST',
                data: {
                    action: 'ajax_search_products',
                    term: searchTerm,
                },
                success: function (response) {
                    $('#loading-animation').hide();
                    $('#ajax-search-results').html(response);
                },
                error: function () {
                    $('#loading-animation').hide();
                    $('#ajax-search-results').html('مشکلی پیش آمده است.');
                },
            });
        } else {
            $('#loading-animation').hide();
            $('#ajax-search-results').html('');
        }
    });
});
