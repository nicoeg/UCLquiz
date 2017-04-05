
<div class="row center-lg center-md center-sm">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 login-container">
        <form action="" method="POST">
            <h1>Login</h1>

            <input type="text" name="username" placeholder="Brugernavn">
            <input type="text" name="password" placeholder="Adgangskode">

            <label class="remember" for="remember">
                <input type="checkbox" id="remember" name="remember">
                Husk mit login til næste gang
            </label>

            <input type="submit" class="button primary" value="Login">

            <a class="forgot-login" href="#">Har du glemt din adgangskode?</a>
        </form>
        <img class="quote" src="<?= base_url('images/quote.png') ?>" alt="Quote">
    </div>
</div>

