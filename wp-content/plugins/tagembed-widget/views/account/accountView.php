<?php
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headView.php";
if (TAGEMBED_PLUGIN_MODE == "live"):
    wp_enqueue_script('__script-account-js', 'https://cdn.tagembed.com/wp-plugin/js/account/tagembed.account.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
else:
    wp_enqueue_script('__script-account-js', TAGEMBED_PLUGIN_URL . '/assets/js/account/tagembed.account.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
endif;
$__tagembed__chat_script = false; /* Use : Manage Chat Hide Show */
?>
<!--<div class="__tagembed__container">-->
<div class="__tagembed__row">
    <div class="__tagembed__col __tagembed__col_12 __tagembed__login_account">
        <!--Error-->
        <div id="__tagembed__account_error" class="__tagembed__acount_error __tagembed__danger"> Unknown email. Check again or try your email address.<br></div>
        <!--Tabbing-->
        <div id="__tagembed__account_tab_view" class="__tagembed__tabarea">
            <ul>
                <li><a id="__tagembed__account_login" onclick="__tagembed__manage_account_view('login')" href="javascript:void(0);" class="active">Login</a></li>
                <li><a id="__tagembed__account_register" onclick="__tagembed__manage_account_view('register')" href="javascript:void(0);">Register</a></li>
            </ul>
        </div>
        <!--Start-- Login View-->
        <div id="__tagembed__account_login_view" class="__tagembed__login_account_inn">
            <div class="__tagembed__login_with">
                <h2>Sign In</h2>
                <!--<a href="javascript:void(0);"><span> 9389 </span><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>-->
            </div>
            <!--<p class="__tagembed__or">OR</p>-->
            <p>Enter your email and password</p>
            <form action="javascript:void(0);" id="__tagembed__login_form">
                <div class="__tagembed__form_row">
                    <input type="email" name="emailId" value=""  placeholder="Email" required autofocus>
                    <span id="__tagembed__login_email_id_error"></span>
                </div>
                <div class="__tagembed__form_row">
                    <input type="password" name="password"  value=""   placeholder="Password" required>
                    <span id="__tagembed__login_password_error"></span>
                </div>
                <div class="__tagembed__submit_sec">
                    <!--<a href="javascript:void(0);" onclick="__tagembed__manage_account_view('forgotPassword')">Forgot Password</a>-->
                    <a href="https://app.tagembed.com/accounts/forgotpassword/" target="_blank" >Forgot Password</a>
                    <a href="javascript:void(0);" onclick="__tagembed__manage_account_view('forgotPassword')"></a>
                    <button type="submit" class="__tagembed__btn">Sign In</button>
                </div>
            </form>
            <!-- <div class="__tagembed__socialogin">
            <a href="javascript:void(0);"><i class="fa fa-google" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>-->
        </div>
        <!--End-- Login View-->
        <!--Start-- Register View-->
        <div id="__tagembed__account_register_view" class="__tagembed__register_inn">
            <div class="__tagembed__login_with">
                <h2>Sign Up</h2>
                <!--<a href="javascript:void(0);"><span> 9389 </span><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>-->
            </div>
            <!--<p class="__tagembed__or">OR</p>-->
            <p>Enter your details to create your account</p>
            <form action="javascript:void(0);" id="__tagembed__register_form">
                <div class="__tagembed__form_row">
                    <input type="text" name="fullName"  value=""  placeholder="Full Name" required>
                    <span id="__tagembed__register_full_name_error"></span>
                </div>
                <div class="__tagembed__form_row">
                    <input type="email" name="emailId"  value=""  placeholder="Email" required>
                    <span id="__tagembed__register_email_id_error"></span>
                </div>
                <div class="__tagembed__form_row">
                    <input type="password" name="password" value=""  placeholder="Password" required>
                    <span id="__tagembed__register_password_error"></span>
                </div>
                <div class="__tagembed__submit_sec __tagembed__flexend">
                    <button type="submit" class="__tagembed__btn">Create Account</button>
                </div>
            </form>
            <!--
            <div class="__tagembed__socialogin">
            <a href="javascript:void(0);"><i class="fa fa-google" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>-->
        </div>
        <!--End-- Register View-->
        <!--Start-- Forgot Password View-->
        <!--<div id="__tagembed__account_forgot_password_view" class="__tagembed__forgot_inn">
        <h2>Forgot Password</h2>
        <p>Enter your email address below to reset your password.</p>
        <form>
        <div class="__tagembed__form_row">
        <input type="text" placeholder="Email Id"/>
        <span>Email is required.</span>
        </div>
        </form>
        <div class="__tagembed__submit_sec">
        <span>Take me back to <a href="javascript:void(0);"  onclick="__tagembed__manage_account_view('login')">Login</a></span>
        <butotn class="__tagembed__btn">Submit</butotn>
        </div>
        </div>-->
        <!--End-- Forgot Password View-->
    </div>
</div>
<!--</div>-->
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/footerView.php"; ?>
