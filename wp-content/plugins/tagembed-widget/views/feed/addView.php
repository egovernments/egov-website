<?php
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headView.php";
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headerView.php";
if (!empty($__tagembed__widgets)):
    if (TAGEMBED_PLUGIN_MODE == "live"):
        wp_enqueue_script('__script-networks-js', 'https://cdn.tagembed.com/wp-plugin/js/network/tagembed.networks.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__script-feed-create-js', 'https://cdn.tagembed.com/wp-plugin/js/feed/tagembed.feed.create.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__script-feed-js', 'https://cdn.tagembed.com/wp-plugin/js/feed/tagembed.feed.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
    else:
        wp_enqueue_script('__script-networks-js', TAGEMBED_PLUGIN_URL . '/assets/js/network/tagembed.networks.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__script-feed-create-js', TAGEMBED_PLUGIN_URL . '/assets/js/feed/tagembed.feed.create.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
        wp_enqueue_script('__script-feed-js', TAGEMBED_PLUGIN_URL . '/assets/js/feed/tagembed.feed.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
    endif;
    ?>
    <div style="" id="__tagembed__addfeed" class="__tagembed__tabcontent">
        <!--Start-- Network View-->
        <div class="__tagembed__sourcerow">
            <div class="__tagembed__ssleft">
                <h3>Network</h3>
                <div><b>NOTE: </b>Select any of the Network like Instagram, Facebook, Youtube, Airbnb, Reviews Etc.</div>
            </div>
            <div class="__tagembed__ssright __tagembed__ssource __tagembe__singline">
                <div>
                    <select name="__tagembed__networks" id="__tagembed__networks">
                        <option vlaue="">Select Network</option>
                    </select>
                    <span class="__tagembed__error">Error message here.</span>
                </div>
                <div class="__tagembed__copycode">
                    <div class="__tabembed__fromrow">
                        <span>Embed Short Code</span>
                        <div onclick="__tagembed__copyToShortCode();" id="__tagembed__shortCode" class="__tagembed__copyvalue"></div>
                        <span onclick="__tagembed__copyToShortCode();">
                            <i class="fa fa-files-o" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!--End-- Network View-->
        <!--Start-- Feed Filter View-->
        <div class="__tagembed__sourcerow" id="__tagembed__feed_filter_row" style="display:none;">
            <div class="__tagembed__ssleft ">
                <h3>Feed Filter</h3>
                <div><b>NOTE: </b>Select any of the Feed Filter like Handle, HashTag Etc.</div>
                <div><a href="javascript:void(0);" onclick="__tagembed__manageShareLinkPopup();"><b>I don't have account access!</b></a></div>
            </div>
            <div class="__tagembed__ssright __tagembed__ssource">
                <select name="__tagembed__feed" id="__tagembed__feed_filters">
                    <option vlaue="-1">Select Feed Filter</option>
                </select>
                <span id="" class="__tagembed__error">Error message here.</span>
            </div>
        </div>
        <!--End-- Feed Filter View-->
        <!--Start-- Feed View-->
        <div class="__tagembed__sourcerow" id="__tagembed__feed" style="display:none;">
            <div class="__tagembed__ssleft">
                <h3>Feeds</h3>
                <div><b>NOTE: </b> Manage Connected Feeds.</div>
            </div>
            <div class="__tagembed__ssright" id="__tagembed__feed_data"></div>
        </div>
        <!--Start-- Feed View-->
    </div>
<?php endif; ?>
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/common/shareLinkView.php"; ?>
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/footerView.php"; ?>
