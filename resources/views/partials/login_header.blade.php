
<div class="row login-line">
    <div class="span12">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="row">
                        <div class="span6 login-text">
                            Welcome! Don't have an account yet? Or maybe you <a href="/password-recovery">forgot your password?</a>
                        </div>
                        <div class="span6 login-form">
                            <form action="/login" method="post" name="login-form" id="login-form">
                                <div class="form-row">
                                    <input name="email" id="login-name focusIt" value="" required="" class="text login_input" placeholder="login" type="email">
                                    <input name="password" id="login-password" value="" required="" class="text login_input" placeholder="password" type="password">
                                    <input id="login-submit" name="login-submit" value="OK" class="btn" type="button" onclick="login();">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function login() {
        $.ajax({
            type:"POST",
            data: $('#login-form').serializeArray(),
            url: "/login",
            success: function(response) {
                console.log(response);
                if (response.status) {
                    window.location = '/me/bulk';
                } else {
                    alert(response.error);
                }
                
            }
        });
    }
</script>

