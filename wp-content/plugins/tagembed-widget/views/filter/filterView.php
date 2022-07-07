<?php
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headView.php";
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headerView.php";
if (TAGEMBED_PLUGIN_MODE == "live"):
    wp_enqueue_script('__script-filter-js', 'https://cdn.tagembed.com/wp-plugin/js/filter/tagembed.filter.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
else:
    wp_enqueue_script('__script-filter-js', TAGEMBED_PLUGIN_URL . '/assets/js/filter/tagembed.filter.script.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
endif;
/* IsoTop JS Use For Create Masonry Layout */
wp_enqueue_script('__script-isotope-layout-js', 'https://cdn.tagembed.com/wp-plugin/js/isotope/isotope.pkgd.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
wp_enqueue_script('__script-isotope-packery-js', 'https://cdn.tagembed.com/wp-plugin/js/isotope/packery-mode.pkgd.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
/* Lazy Loader Script */
wp_enqueue_script('__script-lazy-loading-js', 'https://cdn.tagembed.com/wp-plugin/js/lazyload.js', ['jquery'], TAGEMBED_PLUGIN_VERSION, true);
?>


<div  class="__tagembed__sourcerow __tagembed__filtermoderation" style="display:<?= empty($__tagembed__widgets) ? 'none' : ''; ?>;">
    <div class="__tagembed__tabheading">
        <div class="__tagembed__modcheckall">
            <input type="checkbox" id="__tagembed__filter_checkbox" onclick="__tagembed__manage_filter_by_checkbox();" />
            <a href="javascript:void(0);" onClick="__tagembed__show_post_according_filter(0);"><img src="https://cdn.tagembed.com/wp-plugin/images/refresh.png" alt="refresh" /></a>
        </div>
        <!--Start-- Manage Post Filter And Show Post Count -->
        <div class="__tagembed__modaction" >
            <ul class="__tagembed__modtype" id="__tagembed__view_filter_section">
                <li><a href="javascript:void(0);" id="__tagembed__filter_0" onclick="__tagembed__show_post_according_filter(0);" class="__tagembed__btnprimary __tagembed__btnactive"><span>All</span><i id="__tagembed__all_post_count">0</i></a></li>
                <li><a href="javascript:void(0);" id="__tagembed__filter_1" onclick="__tagembed__show_post_according_filter(1);" class="__tagembed__btnsuccess"><span>Public</span><i id="__tagembed__public_post_count">0</i></a></li>
                <li><a href="javascript:void(0);" id="__tagembed__filter_2" onclick="__tagembed__show_post_according_filter(2);" class="__tagembed__btnwarning"><span>Private</span><i id="__tagembed__private_post_count">0</i></a></li>
                <li><a href="javascript:void(0);" id="__tagembed__filter_3" onclick="__tagembed__show_post_according_filter(3);" class="__tagembed__btndanger"><span>Deleted</span><i id="__tagembed__deleted_post_count">0</i></a></li>
            </ul>
            <input type="hidden" id="__tagembed__post_filter_status" value="0"/>
            <!--End-- Manage Post Filter And Show Post Count -->
            <!--Start-- Manage Post Filter Button -->
            <ul class="__tagembed__modbtnaction" id="__tagembed__action_filter_section" style="display:none;">
                <li><a href="javascript:void(0);" class="__tagembed__btnsuccess" id="__tagembed__multiple_post_filter_1" onclick="__tagembed__manage_multiple_post_status(1);" ><span>Public</span></a></li>
                <li><a href="javascript:void(0);" class="__tagembed__btnwarning" id="__tagembed__multiple_post_filter_2" onclick="__tagembed__manage_multiple_post_status(2);"><span>Private</span></a></li>
                <li><a href="javascript:void(0);" class="__tagembed__btndanger" id="__tagembed__multiple_post_filter_3" onclick="__tagembed__manage_multiple_post_status(3);"><span>Delete</span></a></li>
                <li><a href="javascript:void(0);" class="__tagembed__btnsuccess" id="__tagembed__multiple_post_filter_4" onclick="__tagembed__manage_multiple_post_status(4);"><span>Restore</span></a></li>
                <li><a href="javascript:void(0);" class="__tagembed__btndanger" id="__tagembed__multiple_post_filter_5" onclick="__tagembed__manage_multiple_post_status(5);"><span>Permanent Delete</span></a></li>
            </ul>
            <!--End-- Manage Post Filter Button -->
        </div>
        <!--Start-- Manage Post Filter According Type  -->
        <div class="__tagembed__modfilter">

            <div class="__tagembed__modsearch">
                <input type="text" id="__tagembed_search_text" onkeyup="__tagembed__filter_post_by_text();" placeholde="Search feed" style="display:none;"/>
                <img  id="__tagembed__text_search_image" src="https://cdn.tagembed.com/libraries/loader/images/loader.gif" alt="loading" style="display:none;"/>
                <button id="__tagembed__text_search_btn"><i class="fas fa-search" onclick="__tagembed__hide_show_seach_box();"></i></button>
            </div>
            <a href="javascript:void(0);" onclick="__tagembed__manage_post_flter_hide_show();" class="__tagembed__filtericon">
                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Stockholm-icons / Text / Filter</title>
                <desc>Created with Sketch.</desc>
                <defs></defs>
                <g id="Stockholm-icons-/-Text-/-Filter" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" id="Path-33" fill="#000000"></path>
                </g>
                </svg>
            </a>
            <!--<div class="__tagembed__moddaterande">
                <div id="reportrange"><i class="fa fa-calendar"></i></div>
            </div>-->
            <div class="__tagembed__filgerarea" id="__tagembed__post_filter_section" style="display:none;">
                <div class="__tagembed__filleft"><ul id="__tagembed__feed_filter"></ul></div>
                <div class="__tagembed__filmid">
                    <ul>
                        <h4>Post Type</h4>
                        <li><label><input type="checkbox" id="__tagembed__post_filter_type_1" name="__tagembed__post_filter_type" value="1"/>Text Only</label></li>
                        <li><label><input type="checkbox" id="__tagembed__post_filter_type_2" name="__tagembed__post_filter_type" value="2,4"/>With Image</label></li>
                        <li><label><input type="checkbox" id="__tagembed__post_filter_type_3" name="__tagembed__post_filter_type" value="3,5"/>With Video</label></li>
                    </ul>
                </div>
                <div class="__tagembed__filright">
                    <ul>
                        <h4>Others</h4>
                        <li><label><input type="checkbox" id="__tagembed__highlight_filter" value="1" />Highlight Post</label></li>
                        <li><label><input type="checkbox" id="__tagembed__pin_filter" value="1" />Pinned to Top</label></li>
                        <li><label><input type="checkbox" id="__tagembed__recent_filter" value="1" />Recent</label></li>
                        <li><label><input type="checkbox" id="__tagembed__retweets_filter" value="1" />Retweets</label></li>
                    </ul>
                </div>
                <div class="__tagembed__filaction">
                    <button class="__tagembed__btn" onclick="__tagembed__get_post();">Search</button>
                    <button onclick="__tagembed__manage_post_flter_hide_show();" class="__tagembed__btn __tagembed__cancelbtn">Cancel</button>
                </div>
            </div>
        </div>
        <!--End-- Manage Post Filter According Type  -->
        <!--Start-- Manage Filter By Section-->
        <div class="__tagembed__filterby" id="__tagembed__filter_by_section" style="display:none;">
            <strong>Filter by</strong>
            <ul id="__tagembed__filter_by"></ul>
        </div>
        <!--End-- Manage Filter By Section-->
    </div>
    <div class="__tagembed__modsection  __tagembed__grid" id="__tagembed__filter_post_section"></div>  <!--Post Append Section-->
    <!--Start-- Manage Pagination  -->
    <div class="__tagembed__pager" id="__tagembed__post_filter_pagination" style="display: none;">
        <ul>
            <li>
                <input type="hidden" id="__tagembed__filter_post_offset" value="0"/>
                <span class="post_from" id="__tagembed__filter_post_start_at">0</span>
                <span> - </span>
                <span class="post_to" id="__tagembed__filter_post_end_at">0</span>
                <span class="of"> of </span>
                <span class="paginationOf" id="__tagembed__filter_post_count">0</span>
            </li>
            <li><span id="__tagembed__post_filter_pagination_previous_block"><a href="javascript:void(0);" id="__tagembed__post_filter_pagination_previous" onclick="__tagembed__post_filter_pagination('previous');" class="__tagembed__previous"><img src="https://cdn.tagembed.com/wp-plugin/images/next.png" alt="previous" /></a></span></li>
            <li><span id="__tagembed__post_filter_pagination_next_block" ><a href="javascript:void(0);" id="__tagembed__post_filter_pagination_next" onclick="__tagembed__post_filter_pagination('next');"><img src="https://cdn.tagembed.com/wp-plugin/images/next.png" alt="previous" /></a></span></li>
        </ul>
        <div class="__tagembed__pager-info">
            <select id="__tagembed__filter_post_perPage" onchange="__tagembed__post_filter_pagination_on_perPage_change();">
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>
    <!--End-- Manage Pagination  -->
</div>
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/footerView.php"; ?>
