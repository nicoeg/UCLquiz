<div class="row center-lg center-md center-sm">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 main-container login-container">
        <form>
            <div class="error">Forkert login</div>

            <h1>Login</h1>

            <input type="email" name="username" id="email" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Adgangskode">

            <label class="remember" for="remember">
                <input type="checkbox" id="remember" name="remember">
                Husk mit login til næste gang
            </label>

            <input type="submit" class="button primary" value="Login">

            <a class="forgot-login" href="<?= base_url('support') ?>">Har du glemt din adgangskode?</a>
        </form>
        <img class="quote" src="<?= base_url('images/quote.png') ?>" alt="Quote">
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$('form').on('submit', function(e) {
    e.preventDefault();

    var data = $('#email').val() + ':' + $('#password').val();

    var base_url = '<?php echo base_url(); ?>';

    function base_url_gen(string) {
        return base_url + string;
    }

    var path = "api/user";

    var base64data = btoa(data);

    $('form .button').addClass('loading');
    $('form .error').removeClass('shown');

    $.ajax({
        type: "GET",
        url: base_url_gen(path),
        headers: {
            Authorization: 'Basic ' + base64data
        },
        data: {keyName: data},
        contentType: 'application/json',
        success: function (response) {
            response = jQuery.parseJSON(response);
            if (response.error) {
                $('form .button').removeClass('loading');
                $('form .error').addClass('shown');
            } else if (response.redirect) {
                window.location.assign(response.redirect);
                console.log(response.redirect);
            }

            $('form .button').removeClass('loading');

            console.log(response);
        },
        error: function (xhr, status, error) {
            $('form .button').removeClass('loading');
            $('form .error').addClass('shown');
        }
    });
    // console.log(data + ', ' + base_url(path));
    // return false;
});
</script>