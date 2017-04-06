jQuery(document).ready(function($){
    $('.link--view').on('click', function(e) {
        e.preventDefault();

        var base_url = window.settings.baseUrl;
        var path = "api/quiz_rest/getsingle";
        var qID = $(this).data('id');

        function base_url_gen(string) {
            return base_url + string;
        }

        $.ajax({
            type: "GET",
            url: base_url_gen(path),
            data: {
                id: qID
            },
            contentType: 'application/json',
            success: function (response) {
                // response = jQuery.parseJSON(response);
                
                // if(response.error) 
                // {
                //     window.location.assign(response.redirect);
                // } 
                // else
                // {
                //     $('.modal').addClass('modal--active');
                //     $('#id').html(response.id);
                //     $('#title').html(response.title);
                //     $('#level').html(response.level);
                //     $('#course').html(response.cID);
                //     $('#createdBy').html(response.uID);
                // }
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Error stuff here
            }
        });
    });
});