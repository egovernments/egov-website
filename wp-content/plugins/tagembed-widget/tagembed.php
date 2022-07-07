<?php
/**
 * Plugin Name:       Tagembed Widget
 * Plugin URI:        https://tagembed.com/
 * Description:       Display Facebook feed, Instagram feed, Twitter feed, YouTube Videos and more social feeds from 15+ social networks on any page, posts or widgets using shortcode. Beautifully clean, customizable, and responsive Social Media Feed Widget Plugin for WordPress.
 * Version:           2.9
 * Author:            Tagembed
 * Author URI:        https://tagembed.com/
 */
if (!defined('WPINC'))
    die;
/* --Start-- Create Constant */
!defined('TAGEMBED_PLUGIN_MODE') && define('TAGEMBED_PLUGIN_MODE', "live");
!defined('TAGEMBED_PLUGIN_VERSION') && define('TAGEMBED_PLUGIN_VERSION', '2.9');
!defined('TAGEMBED_PLUGIN_DIR_PATH') && define('TAGEMBED_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
!defined('TAGEMBED_PLUGIN_URL') && define('TAGEMBED_PLUGIN_URL', plugin_dir_url(__FILE__));
!defined('TAGEMBED_PLUGIN_REDIRECT_URL') && define('TAGEMBED_PLUGIN_REDIRECT_URL', get_admin_url(null, 'admin.php?page='));
if (TAGEMBED_PLUGIN_MODE == "live"):
    !defined('TAGEMBED_PLUGIN_API_URL') && define('TAGEMBED_PLUGIN_API_URL', "https://app.tagembed.com/");
else:
    !defined('TAGEMBED_PLUGIN_API_URL') && define('TAGEMBED_PLUGIN_API_URL', "https://app.tagembed.com/beta/");
endif;
!defined('TAGEMBED_PLUGIN_CALL_BACK_URL') && define('TAGEMBED_PLUGIN_CALL_BACK_URL', admin_url() . "admin.php?page=tagembed");
/* --End-- Create Constant */

/* --Start--Include Files */
include_once TAGEMBED_PLUGIN_DIR_PATH . "helper/helper.php";
/* --End--Include Files */
/* --Start-- Add Js And Css */
function tagembed_plugin_scripts_css() {
    wp_enqueue_script('__tagembed__embbedJs', 'https://widget.tagembed.com/embed.min.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
    if (is_admin()):
        /* CSS */
        wp_enqueue_style('__tagembed__commonCss', 'https://cdn.tagembed.com/libraries/common/css/common.css', '', TAGEMBED_PLUGIN_VERSION);
        wp_enqueue_style('__tagembed__toastCss', 'https://cdn.tagembed.com/libraries/toast/toast.css', '', TAGEMBED_PLUGIN_VERSION);
        wp_enqueue_style('__tagembed__confirmDialogCss', 'https://cdn.tagembed.com/libraries/dialog/confirm_dialog.css', '', TAGEMBED_PLUGIN_VERSION);
        wp_enqueue_style('__tagembed__tagembedloaderCss', 'https://cdn.tagembed.com/libraries/loader/loader.css', '', TAGEMBED_PLUGIN_VERSION);
        if (TAGEMBED_PLUGIN_MODE == "live"):
            wp_enqueue_style('__tagembed__mainStyleCss', 'https://cdn.tagembed.com/wp-plugin/css/styles.css', '', TAGEMBED_PLUGIN_VERSION);
        else:
            wp_enqueue_style('__tagembed__popupCss', TAGEMBED_PLUGIN_URL . '/assets/css/styles.css', '', TAGEMBED_PLUGIN_VERSION);
        endif;
        /* JS */
        wp_enqueue_script('__tagembed__faJs', 'https://cdn.tagembed.com/wp-plugin/js/fa.js', ['jquery'], TAGEMBED_PLUGIN_VERSION);
        wp_enqueue_script('__tagembed__toastJs', 'https://cdn.tagembed.com/libraries/toast/toast.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__tagembed__confirmDialogJs', 'https://cdn.tagembed.com/libraries/dialog/confirm_dialog.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__tagembed__tagemedLoaderJs', 'https://cdn.tagembed.com/libraries/loader/loader.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        if (TAGEMBED_PLUGIN_MODE == "live"):
            wp_enqueue_script('__tagembed__deactive-js', 'https://cdn.tagembed.com/wp-plugin/js/tagembed.deactive.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
            wp_enqueue_script('__tagembed__tagembedDialogFormJs', 'https://cdn.tagembed.com/wp-plugin/js/dialog.form.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        else:
            wp_enqueue_script('__tagembed__deactive-js', TAGEMBED_PLUGIN_URL . '/assets/js/tagembed.deactive.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
            wp_enqueue_script('__tagembed__tagembedDialogFormJs', TAGEMBED_PLUGIN_URL . '/assets/js/dialog.form.js', ["jquery"], TAGEMBED_PLUGIN_VERSION, true);
        endif;
        /* --Start-- Gutenberge */
        if (!function_exists("register_block_type")):
            return;
        else:
            if (TAGEMBED_PLUGIN_MODE == "live"):
                wp_enqueue_style('__editor-css', 'https://cdn.tagembed.com/wp-plugin/editor/css/editor.css', ["wp-edit-blocks"], TAGEMBED_PLUGIN_VERSION);
                wp_register_script("__editor-js", 'https://cdn.tagembed.com/wp-plugin/editor/js/editor.js', ["wp-blocks", "wp-element", "wp-editor", "wp-components", "wp-i18n", "wp-data", "wp-compose"], TAGEMBED_PLUGIN_VERSION);
            else:
                wp_enqueue_style('__editor-css', TAGEMBED_PLUGIN_URL . '/assets/css/editor/editor.css', ["wp-edit-blocks"], TAGEMBED_PLUGIN_VERSION);
                wp_register_script("__editor-js", TAGEMBED_PLUGIN_URL . '/assets/js/editor/editor.js', ["wp-blocks", "wp-element", "wp-editor", "wp-components", "wp-i18n", "wp-data", "wp-compose"], TAGEMBED_PLUGIN_VERSION);
            endif;
            register_block_type("tagembed-block/tagembed", ["editor_script" => "__editor-js", "editor_style" => "__editor-css", "style" => "__editor-style-css"]);
        endif;
    /* --End-- Gutenberge */
    endif;
}
add_action("init", "tagembed_plugin_scripts_css");
add_filter('script_loader_tag', function ($tag, $handle) {
    if ('embbedJs' !== $handle)
        return $tag;
    return str_replace(' src', ' defer src', $tag);
}, 10, 2);
/* --End-- Add Js And Css */
/* --Start-- Add Menus */
function __tagembed__plugin_menus() {
    ob_start();
    ?>
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 200" style="enable-background:new 0 0 200 200;" xml:space="preserve">
        <title>Tagembed Icon</title>
        <g transform="translate(-211 -31)"><g id="Group_3576" transform="translate(211 31)">
                <path id="Path_5098" fill="#00E9FF" d="M64.3,119.1c5.4-25.2,10.2-49.2,15.6-73.8c0.6-3.6,1.2-7.2,1.8-10.8c0.6-10.8-6.6-19.8-17.4-21.6c-10.8-2.4-21,4.2-23.4,15C33,63.3,25.2,99.3,18,134.7c-3,14.4,7.2,25.2,22.8,25.2c32.4,1.2,65.4,1.8,97.8,2.4c6.6,0,12.6-0.6,18.6-3c7.8-4.2,12-13.2,9.6-22.2c-2.4-9.6-10.8-16.2-20.4-16.2c-21-0.6-42.6-1.2-63.6-1.8C76.9,119.1,70.9,119.1,64.3,119.1z"/>
                <path id="Path_5099" fill="#4179FF" d="M136.9,81.9c-25.8,0-50.4,0-75,0c-3.6,0-7.2,0-10.8-0.6c-10.8-1.8-18-10.8-18-21.6s9-19.8,19.8-19.8c36,0,72.6,0,109.2,0c14.4,0,22.8,12,19.8,27.6c-6,31.8-12,64.2-18,96c-1.2,6.6-3.6,12.6-7.2,17.4c-6,6.6-15.6,8.4-23.4,4.8c-9-4.2-13.2-13.8-11.4-23.4c3.6-21,7.8-41.4,11.4-62.4C134.5,94.5,135.7,87.9,136.9,81.9z"/>
                <g id="Group_3575" transform="translate(16.61 16.942)"><g><g><defs><polygon id="SVGID_1_" points="113.1,97 101.1,148.7 147.3,148.7 158.1,103.6"/></defs><clipPath id="SVGID_2_"><use xlink:href="#SVGID_1_"  style="overflow:visible;"/></clipPath><g id="Group_3574" class="st2" clip-path="url(#SVGID_2_)"><path id="Path_5100" fill="#00E9FF" d="M47.7,101.8C53.1,76.6,57.9,52.6,63.3,28c0.6-3.6,1.2-7.2,1.8-10.8C65.7,6.4,58.5-2.6,47.7-4.4c-10.8-1.8-21,4.8-23.4,15.6C16.5,46.6,8.7,82,1.5,118.1c-3,14.4,7.2,25.2,22.8,25.2c33,0.6,65.4,1.8,98.4,2.4c6.6,0,12.6-0.6,18.6-3c7.8-4.2,12-13.2,9.6-22.2c-2.4-9.6-10.8-16.2-21-16.2c-21-0.6-42-1.2-63-1.8C60.3,102.4,54.3,102.4,47.7,101.8z"/></g></g></g></g></g></g></svg>
    <?php
    $svg = ob_get_clean();
    add_menu_page('Tagembed', 'Tagembed', 'manage_options', 'tagembed', '__tagembed__view', 'data:image/svg+xml;base64,' . base64_encode($svg));
}
add_action("admin_menu", '__tagembed__plugin_menus');
/* --End-- Add Menus */
/* --Start-- Add & Manage Views */
function __tagembed__view() {
    if (!empty(__tagembed__user()->isLogin) && __tagembed__user()->isLogin == 'yes'):
        $__tagembed__menus = __tagembed__menus(['__tagembed__menu_condation' => 'STATUS = 1']);
        if (empty($__tagembed__menus)):
            include_once TAGEMBED_PLUGIN_DIR_PATH . "views/widget/widgetView.php";
        else:
            include_once TAGEMBED_PLUGIN_DIR_PATH . "views/" . $__tagembed__menus[0]->path . ".php";
        endif;
    else:
        include_once TAGEMBED_PLUGIN_DIR_PATH . "views/account/accountView.php";
    endif;
}
/* --End-- Add & Manage Views */
/* --Start-- Manage Ajax Calls */
add_action("wp_ajax_data", "__tagembed__dataAjaxHandler");
function __tagembed__dataAjaxHandler() {
    $param = [];
    $data = (object) $_REQUEST;
    /* --Start__ Sanetize All Input */
    foreach ($data as $key => $value):
        if (!in_array($key, ['emailId', 'password', 'youtubePlaylist']))
            inputSanetize($value);
    endforeach;
    /* --End__ Sanetize All Input */
    if (empty($data->__tagembed__ajax_action))
        return $this->__tagembed__exitWithDanger();
    global $wpdb;
    $action = $data->__tagembed__ajax_action;
    $__tagembed__user_details = __tagembed__user();
    switch ($action):
        case "__tagembed__register":
            if (empty($data->emailId) || empty($data->password) || empty($data->fullName))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['fullName'] = sanitize_text_field($data->fullName);
            $param['emailId'] = sanitize_email($data->emailId);
            $param['password'] = $data->password;
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/register', $param);
            $response = __tagembed__manageApiResponse($response);
            unset($param);
            $param = ['userId' => sanitize_key($response->userId)];
            __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/create', $param, ['Authorization:' . $response->accessToken]);
            if (__tagembed__login($response) == true)
                return __tagembed__exitWithSuccess(["redirectUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL]);
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__login":
            if (empty($data->emailId) || empty($data->password))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['emailId'] = sanitize_email($data->emailId);
            $param['password'] = $data->password;
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/login', $param);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            if (__tagembed__login($response) == true)
                return __tagembed__exitWithSuccess(["redirectUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL]);
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__logout":
            if (tagembed_logout())
                __tagembed__exitWithSuccess(["redirectUrl" => TAGEMBED_PLUGIN_REDIRECT_URL . 'tagembed']);
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__get_account_details":
            $data->auth = !empty($data->auth) ? 1 : 0;
            if (empty($__tagembed__user_details))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/getdetails', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__manage_active_widget":
            if (empty($data->widgetId))
                return __tagembed__exitWithDanger();
            if (__tagembed__manageActiveWidget($data->widgetId))
                __tagembed__exitWithSuccess();
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__menue":
            if (empty($data->menueId))
                return $this->__tagembed__exitWithDanger();
            if (__tagembed__menus(['__tagembed__menu_id' => $data->menueId]))
                __tagembed__exitWithSuccess(["redirectUrl" => TAGEMBED_PLUGIN_REDIRECT_URL . 'tagembed']);
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__create_widget":
            if (empty($__tagembed__user_details) || empty($data->name))
                return __tagembed__exitWithDanger("Validation Error", ['name' => 'Widget name is required']);
            $data->profanity = (isset($data->profanity)) ? 0 : 1;
            /* --Start-- Manage Param Data */
            $param['name'] = sanitize_text_field($data->name);
            $param['profanity'] = sanitize_key($data->profanity);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/create', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response, "redirectUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL]);
            break;
        case "__tagembed__edit_widget":
            if (empty($__tagembed__user_details) || empty($data->name) || empty($data->widgetId))
                return __tagembed__exitWithDanger("Validation Error", ['name' => 'Widget name is required']);
            /* --Start-- Manage Param Data */
            $param['name'] = sanitize_text_field($data->name);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/edit', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response, "redirectUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL]);
            break;
        case "__tagembed__update_widget_status":
            if (empty($__tagembed__user_details) || empty($data->widgetId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['status'] = sanitize_key($data->status);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/status', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__delete_widget":
            if (empty($__tagembed__user_details) || empty($data->widgetId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/delete', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__source_networks":
            $data->auth = !empty($data->auth) ? 1 : 0;
            if (empty($__tagembed__user_details))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['auth'] = sanitize_key($data->auth);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apinetwork/get', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_themes":
            if (empty($__tagembed__user_details) || empty($data->widgetId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'Apitheme/get', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__edit_themes":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->themeId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['themeId'] = sanitize_key($data->themeId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'Apitheme/edit', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_network_filter":
            if (empty($__tagembed__user_details) || empty($data->networkId))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['networkId'] = sanitize_key($data->networkId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apinetwork/filter', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_already_exist_accounts":
            if (empty($__tagembed__user_details))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/getalreadyexistaccounts', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__add_or_update_account":
            if (empty($__tagembed__user_details) || empty($data->networkId) || empty($data->type))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['connectedAccountId'] = $data->connectedAccountId;
            $param['feedId'] = sanitize_key($data->feedId);
            $param['type'] = sanitize_text_field($data->type);
            $param['networkId'] = sanitize_key($data->networkId);
            $param['filterId'] = sanitize_key($data->filterId);
            $param['otherData'] = $data->otherData;
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/addorupdate', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess(["__tagembed__requestCallBackUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL, "redirectUrl" => TAGEMBED_PLUGIN_API_URL . "apiauth/getauth", "__tagembed__feedData" => $response->__tagembed__feedData]);
            break;
        case "__tagembed__delete_account":
            if (empty($__tagembed__user_details) || empty($data->networkId) || empty($data->parentId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['parentId'] = sanitize_key($data->parentId);
            $param['networkId'] = sanitize_key($data->networkId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/delete', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__get_already_exist_auth":
            if (empty($__tagembed__user_details) || empty($data->networkId))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['networkId'] = sanitize_key($data->networkId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/get', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__search_google_location":
            if (empty($__tagembed__user_details) || empty($data->googleLocationName))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['googleLocationName'] = $data->googleLocationName;
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/searchgooglelocation', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_facebook_page_albums":
            if (empty($__tagembed__user_details) || empty($data->connectedAccountsId))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['connectedAccountsId'] = sanitize_key($data->connectedAccountsId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/apiauthfacebookpagealbums', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__search_youtube_channel":
            if (empty($__tagembed__user_details) || empty($data->youtubeChannelData))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['youtubeChannelData'] = $data->youtubeChannelData;
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/searchyoutubechannel', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_youtube_playlist":
            if (empty($__tagembed__user_details) || empty($data->youtubeId))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['youtubeId'] = $data->youtubeId;
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/getyoutubeplaylist', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_feed":
            if (empty($__tagembed__user_details) || empty($data->widgetId))
                return $this->__tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/get', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__update_feed_status":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->feedId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['feedId'] = sanitize_key($data->feedId);
            $param['status'] = sanitize_key($data->status);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/status', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__delete_feed":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->feedId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['feedId'] = sanitize_key($data->feedId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/delete', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__create_feed":
            if (empty($__tagembed__user_details) || empty($data->widgetName) || empty($data->networkName) || empty($data->filterName) || empty($data->widgetId) || empty($data->networkId) || empty($data->filterId))
                return __tagembed__exitWithDanger();
            $__tagembed__feed_input_data = ["feed" => sanitize_text_field($data->feed), "userId" => sanitize_key($__tagembed__user_details->userId), "moderation" => sanitize_key(isset($data->moderation) ? 1 : 0), "widgetName" => sanitize_text_field($data->widgetName), "networkName" => sanitize_text_field($data->networkName), "filterName" => sanitize_text_field($data->filterName), "widgetId" => sanitize_key($data->widgetId), "networkId" => sanitize_key($data->networkId), "filterId" => sanitize_key($data->filterId), "auth" => 0, "authId" => isset($data->authId) ? sanitize_key($data->authId) : 0];
            $__tagembed__feed_input_data["feed"] = !empty($data->feed) ? sanitize_text_field($data->feed) : '__tagembed__feed';
            $__tagembed__feed_filter_id = $data->filterId;
            switch ($__tagembed__feed_input_data['networkId']):
                case 1:
                    $__tagembed__feed_input_data['auth'] = 1;
                    $__tagembed__feed_input_data['multiplePhoto'] = sanitize_key(isset($data->multiplePhoto) ? 1 : 0);
                    $__tagembed__feed_input_data['excludeRetweet'] = sanitize_key(isset($data->excludeRetweet) ? 1 : 0);
                    if (!empty($data->list))
                        $__tagembed__feed_input_data['list'] = sanitize_key($data->list);
                    break;
                case 2:
                    $__tagembed__feed_input_data['auth'] = 1;
                    break;
                case 3:
                    $__tagembed__feed_input_data['auth'] = 1;
                    switch ($__tagembed__feed_filter_id):
                        case 65:
                            $__tagembed__feed_input_data['accountAlbumType'] = sanitize_key(isset($data->accountAlbumType) ? $data->accountAlbumType : "");
                            $__tagembed__feed_input_data['accountAlbumData'] = sanitize_text_field(isset($data->accountAlbumData) ? $data->accountAlbumData : "");
                            break;
                    endswitch;
                    break;
                case 4:
                    if ($__tagembed__feed_filter_id == 29):
                        $__tagembed__feed_input_data['auth'] = 1;
                    else:
                        $__tagembed__feed_input_data['placeId'] = $data->placeId;
                        $__tagembed__feed_input_data['placeName'] = $data->placeName;
                    endif;
                    break;
                case 5:
                    switch ($__tagembed__feed_filter_id):
                        case 1:
                        case 72:
                            $pintrestUrl = 'https://www.pinterest.com/' . $data->feed . '/feed.rss';
                            break;
                        case 12:
                            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data->feed))
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid URL"]);
                            $pintrestHeaders = explode("/", parse_url($data->feed)['path']);
                            $__tagembed__feed_input_data['value1'] = strtolower($pintrestHeaders[1]);
                            $__tagembed__feed_input_data['value2'] = strtolower($pintrestHeaders[2]);
                            $pintrestUrl = 'https://www.pinterest.com/' . $__tagembed__feed_input_data['value1'] . '/' . $__tagembed__feed_input_data['value2'] . '.rss';
                            break;
                    endswitch;
                    $pintrestData = file_get_contents($pintrestUrl, false, stream_context_create(["ssl" => ["verify_peer" => false, "verify_peer_name" => false]]));
                    $pintrestData = @simplexml_load_string($pintrestData);
                    if (empty($pintrestData))
                        return __tagembed__exitWithDanger("Validation Error", ["feed" => "User Not Found."]);
                    break;
                case 7:
                    if (in_array($__tagembed__feed_filter_id, [1, 71])):
                        $isUrl = false;
                        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data->feed))
                            $isUrl = true;
                        if ((empty($data->youtubeId) || empty($data->youtubeName)) && !$isUrl)
                            return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid Channel URL Or Tab On Search Icon"]);
                        if ($isUrl):
                            $data->youtubeId = explode('/', $data->feed);
                            $data->youtubeId = $data->youtubeId[4];
                            $data->youtubeName = "youtube";
                            if (empty($data->youtubeId) || empty($data->youtubeName))
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid Channel URL"]);
                        endif;
                    endif;
                    switch ($__tagembed__feed_filter_id):
                        case 1:
                        case 71:
                            $__tagembed__feed_input_data['youtubeId'] = $data->youtubeId;
                            $__tagembed__feed_input_data['youtubeName'] = $data->youtubeName;
                            break;
                        case 11:
                            if (empty($data->youtubePlaylist) && empty($data->youtubeId)):
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid Channel URL Or Tab On Search Icon"]);
                            elseif (empty($data->youtubePlaylist) && !empty($data->youtubeId)):
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Play List Not Found"]);
                            endif;
                            $data->youtubePlaylist = explode("#", $data->youtubePlaylist);
                            $__tagembed__feed_input_data['youtubeId'] = $data->youtubePlaylist[0];
                            $__tagembed__feed_input_data['youtubeName'] = $data->youtubePlaylist[1];
                            $__tagembed__feed_input_data['feed'] = $data->youtubePlaylist[1];
                            unset($data->youtubePlaylist);
                            break;
                    endswitch;
                    break;
                case 10:
                    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data->feed))
                        return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid URL"]);
                    switch ($__tagembed__feed_filter_id):
                        case 16:
                            $postUrl = parse_url($data->feed);
                            if (!strstr($postUrl['host'], 'linkedin'))
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Linkedin Post Url"]);
                            $postUrl = $data->feed;
                            $postUrl = rtrim($postUrl, '/');
                            preg_match("/[^\/]+$/", $postUrl, $postId);
                            $postId = $postId[0];
                            $postId = (explode("?", $postId)[0]);
                            $value1 = 'LinkedIn';
                            if (stripos($postId, "activity") !== false):
                                $postId = (explode("activity", $postId)[1]);
                                $value2 = "activity";
                            elseif (stripos($postId, "ugcPost") !== false):
                                $postId = (explode("ugcPost", $postId)[1]);
                                $value2 = "ugcPost";
                            else:
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Linkedin Post Url"]);
                            endif;
                            preg_match_all('!\d+!', $postId, $postId);
                            if (isset($postId[0][0]) && empty($postId[0][0]))
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Linkedin Post Url"]);
                            $value3 = $postId[0][0];
                            if (empty($value1) || empty($value2) || empty($value3))
                                return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Linkedin Post Url"]);
                            $__tagembed__feed_input_data['value1'] = $value1;
                            $__tagembed__feed_input_data['value2'] = $value2;
                            $__tagembed__feed_input_data['value3'] = $value3;
                            break;
                        case 17:
                            $url = parse_url($data->feed);
                            $companyPageUrl = $url['scheme'] . "://" . $url['host'];
                            $url = explode("/", $url['path']);
                            $companyPageUrl = $companyPageUrl . "/" . $url[1] . "/" . $url[2] . "/";
                            $__tagembed__feed_input_data['feed'] = $companyPageUrl;
                            $url[2] = str_replace("-", " ", "$url[2]");
                            $__tagembed__feed_input_data['page'] = ucwords($url[2], " ");
                            break;
                    endswitch;
                case 12:
                    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data->feed))
                        return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid URL"]);
                    $__tagembed__feed_input_data['name'] = $data->name;
                    break;
                case 18:
                    switch ($__tagembed__feed_filter_id):
                        case 26:
                            $__tagembed__feed_input_data['hashtagCaption'] = sanitize_key(isset($data->hashtagCaption) ? 1 : 0);
                            $__tagembed__feed_input_data['hashtagOlder'] = sanitize_key(isset($data->hashtagOlder) ? 1 : 0);
                            break;
                    endswitch;
                    $__tagembed__feed_input_data['auth'] = 1;
                    break;
                case 23:
                    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data->feed))
                        return __tagembed__exitWithDanger("Validation Error", ["feed" => "Enter Valid URL"]);
                    $airbnbListUrl = parse_url($data->feed);
                    if (strstr($airbnbListUrl['host'], 'airbnb')):
                        preg_match("/[^\/]+$/", $data->feed, $matches);
                        $__tagembed__feed_input_data['listId'] = explode("?", $matches[0])[0];
                    else:
                        return __tagembed__exitWithDanger("Validation Error", ["feed" => "'Enter Airbnb Url"]);
                    endif;
                    $__tagembed__feed_input_data['name'] = $data->name;
                    break;
            endswitch;
            unset($data);
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifeed/create', ['feedData' => $__tagembed__feed_input_data], ['Authorization:' . $__tagembed__user_details->accessToken]);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess(["__tagembed__requestCallBackUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL, "redirectUrl" => TAGEMBED_PLUGIN_API_URL . "apiauth/getauth", "__tagembed__feedData" => $response->__tagembed__feedData]);
            break;
        case "__tagembed__make_payment":
            if (empty($__tagembed__user_details) || empty($data->plan) || empty($data->price))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['plan'] = sanitize_key($data->plan);
            $param['price'] = sanitize_key($data->price);
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['email'] = $__tagembed__user_details->email;
            $param['name'] = $__tagembed__user_details->name;
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/getpaymentdetails', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess(["__tagembed__requestCallBackUrl" => TAGEMBED_PLUGIN_CALL_BACK_URL, "redirectUrl" => TAGEMBED_PLUGIN_API_URL . "apiaccount/makepayment", "__tagembed__paymentData" => $response->__tagembed__paymentData]);
            break;
        case "__tagembed__cancel_subscription":
            if (empty($__tagembed__user_details) || empty($data->plan))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['plan'] = sanitize_key($data->plan);
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['email'] = $__tagembed__user_details->email;
            $param['name'] = $__tagembed__user_details->name;
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/cancelsubscription', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__get_post":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || !isset($data->perPage) || !isset($data->offset) || !isset($data->postStatus))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['perPage'] = sanitize_key($data->perPage);
            $param['offset'] = sanitize_key($data->offset);
            $param['postStatus'] = sanitize_key($data->postStatus);
            $param['feedIds'] = $data->feedIds;
            $param['postType'] = $data->postType;
            $param['highlightFilter'] = sanitize_key($data->highlightFilter);
            $param['pinFilter'] = sanitize_key($data->pinFilter);
            $param['recentFilter'] = sanitize_key($data->recentFilter);
            $param['retweetFilter'] = sanitize_key($data->retweetFilter);
            $param['searchText'] = sanitize_text_field($data->searchText);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifilter/get', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__manage_post_status":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->postIds) || empty($data->postStatus))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['postIds'] = $data->postIds;
            $param['postStatus'] = sanitize_key($data->postStatus);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifilter/status', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__feed_for_search":
            if (empty($__tagembed__user_details) || empty($data->widgetId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifilter/getfeeds', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__manage_post_pin":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->postId) || !isset($data->pin))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['postId'] = $data->postId;
            $param['pin'] = sanitize_key($data->pin);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifilter/pin', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__manage_post_highlight":
            if (empty($__tagembed__user_details) || empty($data->widgetId) || empty($data->postId) || !isset($data->highlight))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['widgetId'] = sanitize_key($data->widgetId);
            $param['postId'] = $data->postId;
            $param['highlight'] = sanitize_key($data->highlight);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apifilter/highlight', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            unset($param);
            $response = __tagembed__manageApiResponse($response);
            $response = !empty($response->message) ? $response->message : 'Done';
            return __tagembed__exitWithSuccess(["message" => $response]);
            break;
        case "__tagembed__plugin_version":
            /* --Start-- Manage Param Data */
            $param = [];
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/pluginversion', $param, ['Authorization: __tagembed__']);
            $response = __tagembed__manageApiResponse($response);
            unset($param);
            $installedPluginVersion = get_file_data(__FILE__, array('Version' => 'Version'), false);
            $installedPluginVersion = $installedPluginVersion['Version'];
            $response->installedPluginVersion = $installedPluginVersion;
            $response->pluginUpgradeURL = admin_url() . "plugins.php";
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__get_en_user_id":
            if (empty($__tagembed__user_details))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/enuserid', $param, ['Authorization: __tagembed__']);
            $response = __tagembed__manageApiResponse($response);
            unset($param);
            if (!empty($response->userId))
                return __tagembed__exitWithSuccess(["shareLink" => "https://app.tagembed.com/apiauth/connections/" . $response->userId]);
            return __tagembed__exitWithDanger();
            break;
        case "__tagembed__share_link":
            if (empty($__tagembed__user_details) || empty($data->emailIds) || empty($data->enUserId))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            $param['userEmailId'] = sanitize_email($__tagembed__user_details->email);
            $param['userName'] = sanitize_text_field($__tagembed__user_details->name);
            $param['emailIds'] = sanitize_text_field($data->emailIds);
            $param['enUserId'] = sanitize_key($data->enUserId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiauth/sendconnectionemail', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            $response = __tagembed__manageApiResponse($response);
            unset($param);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__check_user_token":
            if (empty($__tagembed__user_details))
                return __tagembed__exitWithDanger();
            /* --Start-- Manage Param Data */
            $param['userId'] = sanitize_key($__tagembed__user_details->userId);
            /* --End-- Manage Param Data */
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/checkusertoken', $param, ['Authorization:' . $__tagembed__user_details->accessToken]);
            if ($response->head->code == 401 && !$response->head->status)
                tagembed_logout();
            unset($param);
            return __tagembed__exitWithSuccess($response);
            break;
        case "__tagembed__plugin_deactivate":
            /* --Start-- Manage Param Data */
            $__tagembed__user_details = __tagembed__userData();
            $param = [];
            $param['userId'] = !empty($__tagembed__user_details) ? sanitize_key($__tagembed__user_details->userId) : "";
            $param['userName'] = !empty($__tagembed__user_details) ? sanitize_text_field($__tagembed__user_details->name) : "";
            $param['userEmail'] = !empty($__tagembed__user_details) ? sanitize_email($__tagembed__user_details->email) : "";
            $param['pluginDeactivateReason'] = sanitize_text_field($data->pluginDeactivateReason);
            $param['otherReason'] = sanitize_text_field($data->otherReason);
            $param['betterPlugin'] = sanitize_text_field($data->betterPlugin);
            $param['userWebsiteUrl'] = get_site_url();
            /* --End-- Manage Param Data */
            __tagembed__dropDatabaseTablesForPlugin();
            deactivate_plugins(plugin_basename(__FILE__), true);
            $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/deactivateuserdata', $param, ['Authorization: __tagembed__']);
            $response = __tagembed__manageApiResponse($response);
            unset($param);
            return __tagembed__exitWithSuccess();
            break;
        default:
            return __tagembed__exitWithDanger();
    endswitch;
}
/* --End-- Manage Ajax Calls */
/* --Start-- Login */
function __tagembed__login($response) {
    global $wpdb;
    $return = false;
    $user = __tagembed__user($response->emailId);
    if (empty($user->email)) {
        if ($wpdb->insert('wp_tagembed_user', ["userId" => $response->userId, "name" => $response->name, "email" => $response->emailId, "accessToken" => $response->accessToken, "isLogin" => "yes"]))
            $return = true;
    } else {
        if ($wpdb->update('wp_tagembed_user', ["userId" => $response->userId, "name" => $response->name, "email" => $response->emailId, "accessToken" => $response->accessToken, "isLogin" => "yes",], ['email' => $response->emailId]))
            $return = true;
    }
    if ($return):
        if (count($response->collaboratorlist)):
            __tagembed__manageCollaborator($response->collaboratorlist, $response->userId);
        endif;
        __tagembed__manageActiveWidgetsUser($response->userId);
    endif;
    return $return;
}
/* --End-- Login */
/* --Start-- Logout */
function tagembed_logout() {
    global $wpdb;
    if ($wpdb->update('wp_tagembed_user', ["isLogin" => "no"], ["isLogin" => "yes"]))
        return true;
    return false;
}
/* --End-- Logout */
/* --Start--Manage Menues */
function __tagembed__menus($__tagembed__menu_condatation = []) {
    global $wpdb;
    if (empty($__tagembed__menu_condatation))
        return $wpdb->get_results("SELECT * FROM wp_tagembed_menus");
    if (array_key_exists('__tagembed__menu_condation', $__tagembed__menu_condatation))
        return $wpdb->get_results("SELECT * FROM wp_tagembed_menus WHERE " . $__tagembed__menu_condatation['__tagembed__menu_condation']);
    if (array_key_exists('__tagembed__menu_id', $__tagembed__menu_condatation)):
        if ($wpdb->update('wp_tagembed_menus', ["status" => 0], ["status" => 1]) && $wpdb->update('wp_tagembed_menus', ["status" => 1], ["id" => $__tagembed__menu_condatation['__tagembed__menu_id']]))
            return true;
        return false;
    endif;
}
/* --End--Manage Menues */
/* --Start-- Get User Details */
function __tagembed__user($email = null) {
    global $wpdb;
    $__tagembed__userResponse = "";
    if (empty($email)):
        $__tagembed__userResponse = $wpdb->get_results("SELECT * FROM wp_tagembed_user WHERE(isLogin = 'yes')");
    else:
        $__tagembed__userResponse = $wpdb->get_results("SELECT * FROM wp_tagembed_user WHERE(email = '" . $email . "')");
    endif;
    if (!empty($__tagembed__userResponse))
        return $__tagembed__userResponse[0];
    return;
}
function __tagembed__userData() {
    global $wpdb;
    $__tagembed__user_dataResponse = "";
    $__tagembed__user_dataResponse = $wpdb->get_results("SELECT * FROM wp_tagembed_user");
    if (!empty($__tagembed__user_dataResponse))
        return $__tagembed__user_dataResponse[0];
    return;
}
/* --End-- Get User Details */
/* --Start-- Get Collaborator Details */
function __tagembed__collaborator($userId) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_tagembed_collaborator WHERE(userId = '" . $userId . "')");
}
/* --End-- Get Collaborator Details */
/* --Start-- Manage Collaborator */
function __tagembed__manageCollaborator($collaboratorList, $userId) {
    global $wpdb;
    $prevCollaboratorList = __tagembed__convertObjectToArray(__tagembed__collaborator($userId));
    $collaboratorList = __tagembed__convertObjectToArray($collaboratorList);
    $collaboratorListIds = [];
    if (is_array($collaboratorList))
        $collaboratorListIds = array_column($collaboratorList, 'id');
    $prevCollaboratorListIds = [];
    if (is_array($prevCollaboratorList)):
        $prevCollaboratorListIds = array_column($prevCollaboratorList, 'collaboratorId');
        $commonCollaboratorIds = array_intersect($prevCollaboratorListIds, $collaboratorListIds);
        $prevCollaboratorListIds = array_diff($prevCollaboratorListIds, $commonCollaboratorIds);
        $collaboratorListIds = array_diff($collaboratorListIds, $commonCollaboratorIds);
    endif;
    if (count($prevCollaboratorListIds)):
        foreach ($prevCollaboratorListIds as $delId):
            if ($wpdb->delete('wp_tagembed_collaborator', ["collaboratorId" => $delId, "userId" => $userId]))
                $wpdb->delete('wp_tagembed_widget', ["userId" => $delId]);
        endforeach;
    endif;
    foreach ($collaboratorList as $key => $collaborator):
        if (in_array($collaborator['id'], $collaboratorListIds)):
            $wpdb->insert('wp_tagembed_collaborator', ["userId" => $userId, "collaboratorId" => $collaboratorList[$key]['id'], "name" => $collaboratorList[$key]['name']]);
        elseif (in_array($collaborator['id'], $commonCollaboratorIds)):
            $wpdb->update('wp_tagembed_collaborator', ["userId" => $userId, "name" => $collaboratorList[$key]['name'],], ['collaboratorId' => $collaborator['id'], "userId" => $userId]);
        endif;
    endforeach;
    return true;
}
/* --End-- Manage Collaborator */
/* --Start-- Get Widget */
function __tagembed__widgets() {
    $__tagembed__user_details = __tagembed__user();
    if (!empty($__tagembed__user_details)):
        $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiwidget/get', ['userId' => sanitize_key($__tagembed__user_details->userId)], ['Authorization:' . $__tagembed__user_details->accessToken]);
        if (!$response->head->status || $response->head->code != 200 || !$response->body || empty($response->body))
            return;
        return $response->body;
    endif;
}
/* --End-- Get Widget */
/* --Start-- Get Active Widget */
function __tagembed__activeWidget() {
    global $wpdb;
    $__tagembed__activeWidgetResponse = "";
    $__tagembed__activeWidgetResponse = $wpdb->get_results("SELECT * FROM wp_tagembed_active_widget");
    if (!empty($__tagembed__activeWidgetResponse))
        return $__tagembed__activeWidgetResponse[0]->widgetId;
    return;
}
/* --End-- Get Active Widget */
/* --Start-- Manage Active Widget User */
function __tagembed__manageActiveWidget($widgetId) {
    global $wpdb;
    $return = '';
    $activeWidgetUserId = __tagembed__activeWidget();
    if ($activeWidgetUserId == $widgetId)
        return true;
    if (empty($activeWidgetUserId)):
        $wpdb->insert('wp_tagembed_active_widget', ["widgetId" => $widgetId]);
        return true;
    else:
        $wpdb->update('wp_tagembed_active_widget', ["widgetId" => $widgetId], ['id' => 1]);
        return true;
    endif;
    return false;
}
/* --End-- Manage Active Widget User */
/* --Start-- Get Active Widget User */
function __tagembed__activeWidgetUser() {
    global $wpdb;
    $__tagembed__activeWidgetUserResponse = "";
    $__tagembed__activeWidgetUserResponse = $wpdb->get_results("SELECT * FROM wp_tagembed_active_widget_user");
    if (!empty($__tagembed__activeWidgetUserResponse))
        return $__tagembed__activeWidgetUserResponse[0]->userId;
    return;
}
/* --End-- Get Active Widget User */
/* --Start-- Manage Active Widget User */
function __tagembed__manageActiveWidgetsUser($userId) {
    global $wpdb;
    $return = '';
    $activeWidgetUserId = __tagembed__activeWidgetUser();
    if ($activeWidgetUserId == $userId)
        return true;
    if (empty($activeWidgetUserId)):
        $wpdb->insert('wp_tagembed_active_widget_user', ["userId" => $userId]);
        return true;
    else:
        $wpdb->update('wp_tagembed_active_widget_user', ["userId" => $userId], ['id' => 1]);
        return true;
    endif;
    return false;
}
/* --End-- Manage Active Widget User */
/* * ** DATABASE *** */
/* --Start-- Manage Database */
function __tagembed__createDatabaseTableForPlugin() {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_tagembed_user` (`id` int(11) NOT NULL AUTO_INCREMENT,`userId` varchar(100) NOT NULL,`name` varchar(100) NOT NULL,`email` varchar(100) NOT NULL,`accessToken` varchar(255) NOT NULL,`isLogin` enum('no', 'yes') NOT NULL,PRIMARY KEY(`id`)) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_tagembed_collaborator` (`id` int(11) NOT NULL AUTO_INCREMENT,`userId` varchar(100) NOT NULL,`collaboratorId` varchar(100) NOT NULL,`name` varchar(100) NOT NULL,PRIMARY KEY(`id`)) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_tagembed_active_widget_user` (`id` int(11) NOT NULL AUTO_INCREMENT,`userId` varchar(100) NOT NULL,PRIMARY KEY(`id`)) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_tagembed_menus` (`id` int(11) NOT NULL AUTO_INCREMENT,`name` varchar(100) NOT NULL,`status` tinyint(2) NOT NULL,`path` varchar(255) NOT NULL,PRIMARY KEY(`id`)) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_tagembed_active_widget` (`id` int(11) NOT NULL AUTO_INCREMENT,`widgetId` varchar(100) NOT NULL,PRIMARY KEY(`id`)) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    /* Manage Tagembed Plugin Menus */
    $__tagembed__menus = [['name' => 'Widget', 'status' => 0, 'path' => 'widget/widgetView'], ['name' => 'Add Feed', 'status' => 1, 'path' => 'feed/addView'], ['name' => 'Choose Theme', 'status' => 0, 'path' => 'theme/themeView'], ['name' => 'Filter', 'status' => 0, 'path' => 'filter/filterView'], ['name' => 'Customize', 'status' => 0, 'path' => 'customize/customizeView'], ['name' => 'Display', 'status' => 0, 'path' => 'display/displayView'], ['name' => 'Social Accounts', 'status' => 0, 'path' => 'socialAccount/socialAccountView'], ['name' => 'Support', 'status' => 0, 'path' => 'support/supportView'], ['name' => 'Upgrade', 'status' => 0, 'path' => 'upgrade/upgradeView']];
    foreach ($__tagembed__menus as $__tagembed__menu)
        $wpdb->insert('wp_tagembed_menus', ["name" => $__tagembed__menu['name'], "status" => $__tagembed__menu['status'], "path" => $__tagembed__menu['path']]);
}
function __tagembed__dropDatabaseTablesForPlugin() {
    global $wpdb;
    $wpdb->query("DROP table IF EXISTS  wp_tagembed_user");
    $wpdb->query("DROP table IF EXISTS  wp_tagembed_collaborator");
    $wpdb->query("DROP table IF EXISTS  wp_tagembed_active_widget_user");
    $wpdb->query("DROP table IF EXISTS  wp_tagembed_active_widget");
    $wpdb->query("DROP table IF EXISTS  wp_tagembed_menus");
}
/* --End-- Manage Database */
/* --Start-- Manage Active Deactive And Uninstall Webhook */
register_activation_hook(__FILE__, '__tagembed__pluginActivate');
function __tagembed__pluginActivate() {
    __tagembed__createDatabaseTableForPlugin();
    add_action('activated_plugin', '__tagembed__plginActivationRedirect');
}
register_uninstall_hook(__FILE__, '__tagembed__pluginUnistall');
function __tagembed__pluginUnistall() {
    __tagembed__dropDatabaseTablesForPlugin();
}
/* register_deactivation_hook(__FILE__, '__tagembed__pluginDeactivate');
  function __tagembed__pluginDeactivate() {
  __tagembed__dropDatabaseTablesForPlugin();
  } */
/* --End-- Manage Active Deactive And Uninstall Webhook */
/* --Start--Manage Redirect After Plugin Activate */
function __tagembed__plginActivationRedirect() {
    exit(wp_redirect(TAGEMBED_PLUGIN_CALL_BACK_URL));
}
/* --End--Manage Redirect After Plugin Activate */
/* --Start--Manage Setting Link */
function __tagembed__settingsLink($links) {
    array_unshift($links, '<a href=' . TAGEMBED_PLUGIN_CALL_BACK_URL . '>Settings</a>');
    return $links;
}
add_filter("plugin_action_links_" . plugin_basename(__FILE__), '__tagembed__settingsLink');
/* --End--Manage Setting Link */
/* --Start--Manage Database On Plugin Update Time */
function __tagembed__manageDatabaseOnPluginUpdateTime() {
    __tagembed__dropDatabaseTablesForPlugin();
    __tagembed__createDatabaseTableForPlugin();
}
add_action('upgrader_process_complete', '__tagembed__manageDatabaseOnPluginUpdateTime', 10, 2);
/* --End--Manage Database On Plugin Update Time */
/* --Start-- Manage Hide And Show Admin Notificationa */
function __tagembed__generalAdminNotice() {
    $__tagmebed__page_name = !empty($_GET['page']) ? $_GET['page'] : "";
    TRY {
        $response = __tagembed__wpApiCall(TAGEMBED_PLUGIN_API_URL . 'apiaccount/notification', [], ['Authorization: __tagembed__']);
        if ($response->head->status):
            $response = __tagembed__manageApiResponse($response);
            if (!empty($response->notifications) && is_array($response->notifications)):
                $htmlData = "";
                foreach ($response->notifications as $notifications):
                    if ($notifications->location == "tagembed"):
                        if ($__tagmebed__page_name != "tagembed")
                            continue;
                        $htmlData .= '<div class="notice notice-' . $notifications->type . ' is-dismissible">';
                        $htmlData .= '<p>' . $notifications->message . '</p>';
                        $htmlData .= '</div>';
                    elseif ($notifications->location == "all"):
                        $htmlData .= '<div class="notice notice-' . $notifications->type . ' is-dismissible">';
                        $htmlData .= '<p>' . $notifications->message . '</p>';
                        $htmlData .= '</div>';
                    endif;
                endforeach;
                echo $htmlData;
            endif;
        endif;
    } CATCH (Exception $e) {

    }
}
add_action('in_admin_header', '__tagembed__hideGeneralAdminNotice');
function __tagembed__hideGeneralAdminNotice() {
    $__tagmebed__page_name = !empty($_GET['page']) ? $_GET['page'] : "";
    if ($__tagmebed__page_name == "tagembed"):
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
        add_action('admin_notices', '__tagembed__generalAdminNotice');
    endif;
}
/* --End-- Manage Hide And Show Admin Notificationa */
/* --End-- Drop Database Table */
/* --Start-- Create Short Code */
add_shortcode("tagembed", "__tagembed__PluginShortCode");
function __tagembed__PluginShortCode($attr) {
    $widgetId = (isset($attr[1]) ? $attr[1] : '');
    $width = (isset($attr['width']) ? $attr['width'] : '');
    $height = (isset($attr['height']) ? $attr['height'] : '');
    $code = '<span class=""></span>';
    $code .= '<div style="width:' . $width . '; height:' . $height . ';overflow: auto;" class="tagembed-container">';
    $code .= '<div style="width:100%; height:100%;" class="tagembed-socialwall tagembed-analystic" data-wall-id="' . $widgetId . '" view-url="https://widget.tagembed.com/' . $widgetId . '"></div>';
    $code .= '</div>';
    return $code;
}
/* --End-- Create Short Code */



