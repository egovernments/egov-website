<script type="text/javascript">
    var __tagembed__ajax_url = "<?= admin_url('admin-ajax.php'); ?>";
    var __tagembed__network_already_exist_auth = [];
</script>
<?php
wp_enqueue_script('__jquery');
if (TAGEMBED_PLUGIN_MODE == "live"):
    wp_enqueue_script('__tagembed__common-js', 'https://cdn.tagembed.com/wp-plugin/js/tagembed.common.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
    wp_enqueue_script('__script-widget-js', 'https://cdn.tagembed.com/wp-plugin/js/widget/tagembed.widget.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
else:
    wp_enqueue_script('__tagembed__custom-js', TAGEMBED_PLUGIN_URL . '/assets/js/tagembed.common.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
    wp_enqueue_script('__script-widget-js', TAGEMBED_PLUGIN_URL . '/assets/js/widget/tagembed.widget.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
endif;
$__tagembed__chat_script = true; /* Use : Manage Chat Hide Show */
$__tagembed__account_page = true; /* Use : Check User Token Valid Or Not */
$__tagembed__user_details = __tagembed__user();
$__tagembed__active_widget_user_id = __tagembed__activeWidgetUser();
$__tagembed__active_widget_user_name = !empty($__tagembed__user_details->name) ? $__tagembed__user_details->name : "";
$__tagembed__menus = __tagembed__menus();
$__tagembed__active_menue_id = NULL;
$__tagembed__active_widget_id = __tagembed__activeWidget();
$__tagembed__active_widget_id = !empty($__tagembed__active_widget_id) ? $__tagembed__active_widget_id : 0;
$__tagembed__widgets = __tagembed__widgets();
/* $__tagembed__collaborators = __tagembed__collaborator($__tagembed__user_details->userId); */
?>
<!--Start--Check User Access Token-->
<?php if (!empty($__tagembed__user_details)): ?>
    <script>
        window.addEventListener ? window.addEventListener("load", __tagembed__check_user_token, false) : window.attachEvent && window.attachEvent("onload", __tagembed__check_user_token);
        function __tagembed__check_user_token() {
            let __tagembed__toast = new TagembedToast;
            __tagembed__open_loader();
            let formData = new FormData();
            formData.append('action', 'data');
            formData.append('__tagembed__ajax_action', '__tagembed__check_user_token');
            fetch(__tagembed__ajax_url, {
                method: 'POST',
                headers: {
                    'x-requested-with': 'XMLHttpRequest',
                },
                body: formData,
            }).then(response => {
                return response.json()
            }).then(response => {
                __tagembed__close_loader();
                if (response.status === true) {
                    if (!response.data.head.status && response.data.head.code == 401)
                        location.reload();
                } else {
                    __tagembed__toast.danger({message: "Something went wrong. Please try after sometime", position: '__tagembed__is-top-right'});
                }
            }).catch((error) => {
                console.log(error);
                __tagembed__close_loader();
                __tagembed__toast.danger({message: "Something went wrong. Please try after sometime", position: '__tagembed__is-top-right'});
            });
        }
        /*--End-- Check User Token*/
    </script>
<?php endif; ?>
<!--End--Check User Access Token-->
<div id="__tagembed__plugin_upgrade_message"></div>
<div class="__tagembed__container">
    <div class="__tagembed__row">
        <div class="__tagembed__col __tagembed__col_12 __tagembed__widget">
            <div class="__tagembed__widget_inn">