jQuery(document).ready(function($){
    var base_url = window.settings.baseUrl;

    function base_url_gen(string) {
        return base_url + string;
    }

    $('.link--view').on('click', function(e) {
        var path = "api/quiz_rest/getsingle";
        var qID = $(this).data('id');

        e.preventDefault();

        console.log(base_url_gen(path));
        return;

        $.ajax({
            type: "GET",
            url: base_url_gen(path),
            data: {
                id: qID
            },
            contentType: 'application/json',
            success: function (response) {
                response = jQuery.parseJSON(response);
                
                if(response.error) 
                {
                    window.location.assign(response.redirect);
                } 
                else
                {
                    $('.modal').addClass('modal--active');
                    $('#id').html(response.id);
                    $('#title').html(response.title);
                    $('#level').html(response.level);
                    $('#course').html(response.cID);
                    $('#createdBy').html(response.uID);
                }
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Error stuff here
            }
        });
    });

    function postQuiz()
    {
        var path = 'api/quiz_rest/post';

        $('input[type="button"]').click(function(e){
            e.preventDefault();

            $.ajax(function()
            {
                type: 'POST',
                url: base_url_gen(path),
                data: {
                    title: $('input[name="title"]').val(),
                    course: $('input[name="course"]').val(),
                    level: $('input[name="level"]').val()
                },
                contentType: 'application/json',
                success: function (response) {
                    console.log('works');
                },
                error: function(xhr, status, error) {
                    console.log('Not working');
                } 
            });
        });
    }

    postQuiz();
});