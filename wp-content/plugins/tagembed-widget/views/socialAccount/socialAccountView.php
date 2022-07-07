<?php
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headView.php";
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headerView.php";
if (TAGEMBED_PLUGIN_MODE == "live"):
    wp_enqueue_script('__script-social-account-js', 'https://cdn.tagembed.com/wp-plugin/js/socialAccount/tagembed.social.account.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
else:
    wp_enqueue_script('__script-social-account-js', TAGEMBED_PLUGIN_URL . '/assets/js/socialAccount/tagembed.social.account.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
endif;
?>
<div style="" id="__tagembed__accounts" class="__tagembed__tabcontent __tagembed__accountsection">
    <div class="__tagembed__connaccountwrap">
        <div class="__tagembed__caleft">
            <h3>Connected Accounts</h3>
            <div>Note : Tagembed never store (or even have access to) the usernames/passwords you use to connect.</div>
        </div>
        <!--Start-- Show Share Link For Add Connect Account Popup -->
        <div class="__tagembed__caright">
            <div class="__tagembed__clipboard">
                <label>Wondering how to connect an account you don't have access to?</label>
                <button type="button" onclick="__tagembed__manageShareLinkPopup();" class="__tagembed__btn">
                    Share
                </button>
            </div>
        </div>
        <!--End-- Show Share Link For Add Connect Account Popup -->
    </div>
    <div class="__tagembed__sourcerow">
        <div class="__tagembed__ssright __tagembed__sizefull">
            <div class="__tagembed__conntectedacc">
                <div class="__tagembed__addaccount">
                    <a href="javascript:void(0);" onclick="__tagembed__connectSocialAccounts();"><i class="fas fa-plus" aria-hidden="true"></i><span>Add Account</span></a>
                </div>
                <table width="100%" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr><th>Network</th><th>Account</th><th>Token Validity</th><th>Status</th><th>Refresh</th><th>Delete</th></tr>
                    </thead>
                    <tbody id="__tagembed__alreday_exist_accounts"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Start--Add Account Section-->
<div id="__tagembed__pick_a_source_section" class="__tagembed__overlay" style="display:none;">
    <div class="__tagembed__popupwrap __tagembed__popup_xl">
        <button id="__tagembed__pick_a_source_section_close_btn" type="button" class="__tagembed__closebtn"></button>
        <div class="__tagembed__popupinn">
            <div class="__tagembed__header"><h2>Pick a source</h2></div>
            <hr class="__tagembed__horizontaborder">
            <div class="__tagembed__formwbody">
                <div class="__tagembed__formwrow">
                    <ul class="__tagembed__addnetwork" id="__tagembed__pick_a_source"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End--Add Account Section-->
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/common/shareLinkView.php"; ?>
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/footerView.php"; ?>