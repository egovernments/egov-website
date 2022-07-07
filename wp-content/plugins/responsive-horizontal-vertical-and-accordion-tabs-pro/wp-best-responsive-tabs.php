<?php
/*
 * Plugin Name: WP Responsive Tabs horizontal vertical and accordion Tabs Pro
 * Plugin URI:https://www.i13websolution.com/product/best-wordpress-responsive-tabs-plugin/
 * Plugin URI:https://www.i13websolution.com
 * Description:This is beautiful responsive all in one tabs for wordpress sites/blogs. Add any number of tabs sets to your site. your tabs sets will be ready within few min. 
 * Author:I Thirteen Web Solution 
 * Version:2.20
 * Text Domain:responsive-horizontal-vertical-and-accordion-tabs
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; 
     
if (!defined('I13_RTHV_PSLUG')) {

    define('I13_RTHV_PSLUG', 'responsive-horizontal-vertical-and-accordion-tabs-pro');
}

if (!defined('I13_RTHV_PL_VERSION')) {

     define('I13_RTHV_PL_VERSION', '2.20');

}
add_filter ( 'widget_text', 'do_shortcode' );
add_action ( 'admin_menu', 'wrt_responsive_tabs_add_admin_menu' );

register_activation_hook ( __FILE__, 'wrt_wp_responsive_tabs_check_network' );
register_deactivation_hook(__FILE__,'wrt_wp_responsive_tabs_remove_access_capabilities');
add_action ( 'wp_enqueue_scripts', 'wrt_wp_responsive_tabs_load_styles_and_js' );
add_shortcode ( 'wrt_print_rt_wp_responsive_tabs', 'wrt_print_rt_wp_responsive_tabs_func' );
add_action('plugins_loaded', 'wrt_lang_for_wp_responsive_tabs');
add_action('wp_ajax_rt_get_tab_data_byid', 'wp_ajax_rt_get_tab_data_byid_callback');
add_action('wp_ajax_nopriv_rt_get_tab_data_byid', 'wp_ajax_rt_get_tab_data_byid_callback');
add_filter( 'user_has_cap', 'wrt_wp_responsive_tabs_admin_cap_list' , 10, 4 );
add_action('admin_init', 'wrt_wp_responsive_tabs_multisite_check_activated');

function wrt_lang_for_wp_responsive_tabs() {
            
            load_plugin_textdomain( 'responsive-horizontal-vertical-and-accordion-tabs', false, basename( dirname( __FILE__ ) ) . '/languages/' );
            add_filter( 'map_meta_cap',  'map_wrt_wp_responsive_tabs_meta_caps', 10, 4 );
    }


function map_wrt_wp_responsive_tabs_meta_caps( array $caps, $cap, $user_id, array $args  ) {
        
       
        if ( ! in_array( $cap, array(
                                        'wrt_responsive_tabs_view_tab_sets',
                                        'wrt_responsive_tabs_add_tab_set',
                                        'wrt_responsive_tabs_edit_tab_set',
                                        'wrt_responsive_tabs_delete_tab_set',
                                        'wrt_responsive_tabs_view_tabs',
                                        'wrt_responsive_tabs_add_tab',
                                        'wrt_responsive_tabs_edit_tab',
                                        'wrt_responsive_tabs_delete_tab',
                                        'wrt_responsive_tabs_preview_tab_set'
                                      
                                    ), true ) ) {
            
			return $caps;
         }

       
         
   
        $caps = array();

        switch ( $cap ) {
            
                 case 'wrt_responsive_tabs_view_tab_sets':
                        $caps[] = 'wrt_responsive_tabs_view_tab_sets';
                        break;
              
                 case 'wrt_responsive_tabs_add_tab_set':
                        $caps[] = 'wrt_responsive_tabs_add_tab_set';
                        break;
              
                case 'wrt_responsive_tabs_edit_tab_set':
                        $caps[] = 'wrt_responsive_tabs_edit_tab_set';
                        break;
              
                case 'wrt_responsive_tabs_delete_tab_set':
                        $caps[] = 'wrt_responsive_tabs_delete_tab_set';
                        break;
              
                case 'wrt_responsive_tabs_view_tabs':
                        $caps[] = 'wrt_responsive_tabs_view_tabs';
                        break;
              
                case 'wrt_responsive_tabs_add_tab':
                        $caps[] = 'wrt_responsive_tabs_add_tab';
                        break;
              
                case 'wrt_responsive_tabs_edit_tab':
                        $caps[] = 'wrt_responsive_tabs_edit_tab';
                        break;
                    
                case 'wrt_responsive_tabs_delete_tab':
                        $caps[] = 'wrt_responsive_tabs_delete_tab';
                        break;
              
                case 'wrt_responsive_tabs_preview_tab_set':
                        $caps[] = 'wrt_responsive_tabs_preview_tab_set';
                        break;
                    
             
                default:
                        
                        $caps[] = 'do_not_allow';
                        break;
        }

      
     return apply_filters( 'rts_responsive_thumbnail_slider_meta_caps', $caps, $cap, $user_id, $args );
}


 function wrt_wp_responsive_tabs_admin_cap_list($allcaps, $caps, $args, $user){
        
        
        if ( ! in_array( 'administrator', $user->roles ) ) {
            
            return $allcaps;
        }
        else{
            
            if(!isset($allcaps['wrt_responsive_tabs_view_tab_sets'])){
                
                $allcaps['wrt_responsive_tabs_view_tab_sets']=true;
            }
            
            if(!isset($allcaps['wrt_responsive_tabs_add_tab_set'])){
                
                $allcaps['wrt_responsive_tabs_add_tab_set']=true;
            }
            
            if(!isset($allcaps['wrt_responsive_tabs_edit_tab_set'])){
                
                $allcaps['wrt_responsive_tabs_edit_tab_set']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_delete_tab_set'])){
                
                $allcaps['wrt_responsive_tabs_delete_tab_set']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_view_tabs'])){
                
                $allcaps['wrt_responsive_tabs_view_tabs']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_add_tab'])){
                
                $allcaps['wrt_responsive_tabs_add_tab']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_edit_tab'])){
                
                $allcaps['wrt_responsive_tabs_edit_tab']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_delete_tab'])){
                
                $allcaps['wrt_responsive_tabs_delete_tab']=true;
            }
            if(!isset($allcaps['wrt_responsive_tabs_preview_tab_set'])){
                
                $allcaps['wrt_responsive_tabs_preview_tab_set']=true;
            }
           
         
        }
        
        return $allcaps;
        
    }

function  wrt_wp_responsive_tabs_add_access_capabilities() {
     
    // Capabilities for all roles.
    $roles = array( 'administrator' );
    foreach ( $roles as $role ) {
        
            $role = get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }
         
            
            if(!$role->has_cap( 'wrt_responsive_tabs_view_tab_sets' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_view_tab_sets' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_add_tab_set' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_add_tab_set' );
            }
         
            
            if(!$role->has_cap( 'wrt_responsive_tabs_edit_tab_set' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_edit_tab_set' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_delete_tab_set' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_delete_tab_set' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_view_tabs' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_view_tabs' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_add_tab' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_add_tab' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_edit_tab' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_edit_tab' );
            }
            if(!$role->has_cap( 'wrt_responsive_tabs_delete_tab' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_delete_tab' );
            }
            
            if(!$role->has_cap( 'wrt_responsive_tabs_preview_tab_set' ) ){
            
                    $role->add_cap( 'wrt_responsive_tabs_preview_tab_set' );
            }
         
            
         
    }
    
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}

function wrt_wp_responsive_tabs_remove_access_capabilities(){
    
    global $wp_roles;

    if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
    }

    foreach ( $wp_roles->roles as $role => $details ) {
            $role = $wp_roles->get_role( $role );
            if ( empty( $role ) ) {
                    continue;
            }

            $role->remove_cap( 'wrt_responsive_tabs_view_tab_sets' );
            $role->remove_cap( 'wrt_responsive_tabs_add_tab_set' );
            $role->remove_cap( 'wrt_responsive_tabs_edit_tab_set' );
            $role->remove_cap( 'wrt_responsive_tabs_delete_tab_set' );
            $role->remove_cap( 'wrt_responsive_tabs_view_tabs' );
            $role->remove_cap( 'wrt_responsive_tabs_add_tab' );
            $role->remove_cap( 'wrt_responsive_tabs_edit_tab' );
            $role->remove_cap( 'wrt_responsive_tabs_delete_tab' );
            $role->remove_cap( 'wrt_responsive_tabs_preview_tab_set' );
          
       

    }

    // Refresh current set of capabilities of the user, to be able to directly use the new caps.
    $user = wp_get_current_user();
    $user->get_role_caps();
    
}    
function wrt_responsive_tabs_add_admin_init() {
    
        
	$url = plugin_dir_url ( __FILE__ );
	
	wp_enqueue_style( 'admincss', plugins_url('/css/admincss.css', __FILE__) );
	wp_enqueue_style( 'wrt_bootstrap-nv-only.min', plugins_url('/css/wrt_bootstrap-nv-only.min.css', __FILE__) );
	wp_enqueue_style( 'wrt_easy-responsive-tabs', plugins_url('/css/wrt_easy-responsive-tabs.css', __FILE__) );
	wp_enqueue_style( 'wrt_jquery.scrolling-tabs', plugins_url('/css/wrt_jquery.scrolling-tabs.css', __FILE__) );
	wp_enqueue_style( 'wrt_select2.min', plugins_url('/css/wrt_select2.min.css', __FILE__) );
	wp_enqueue_style( 'wrt_fontawesome-all.min', plugins_url('/css/fontawesome/css/wrt_fontawesome-all.min.css', __FILE__) );
	wp_enqueue_style( 'wrt_v4-shims.min', plugins_url('/css/fontawesome/css/wrt_v4-shims.min.css', __FILE__) );
	wp_enqueue_style( 'wrt_brands.min', plugins_url('/css/fontawesome/css/wrt_brands.min.css', __FILE__) );
        wp_enqueue_script('jquery');         
        wp_enqueue_script("jquery-ui-core");
        wp_enqueue_script('wrt_bootstrap-nva-only.min',plugins_url('/js/wrt_bootstrap-nva-only.min.js', __FILE__));
        wp_enqueue_script('wrt_jquery.easyResponsiveTabs',plugins_url('/js/wrt_jquery.easyResponsiveTabs.js', __FILE__));
        wp_enqueue_script('wrt_jquery.scrolling-tabs',plugins_url('/js/wrt_jquery.scrolling-tabs.js', __FILE__));
        wp_enqueue_script('wrt_jquery.validate',plugins_url('/js/wrt_jquery.validate.js', __FILE__));
        wp_enqueue_script('wrt_select2.min',plugins_url('/js/wrt_select2.min.js', __FILE__));
        
       
	wrt_wp_responsive_full_tabs_admin_scripts_init();
}

function wrt_wp_responsive_tabs_load_styles_and_js() {
    if (! is_admin ()) {

            wp_register_style ( 'wrt_bootstrap-nv-only.min', plugins_url ( '/css/wrt_bootstrap-nv-only.min.css', __FILE__ ),array(),'2.14' );
            wp_register_style ( 'wrt_easy-responsive-tabs', plugins_url ( '/css/wrt_easy-responsive-tabs.css', __FILE__ ),array(),'2.11'  );
            wp_register_style ( 'wrt_jquery.scrolling-tabs', plugins_url ( '/css/wrt_jquery.scrolling-tabs.css', __FILE__ ),array(),'2.11'  );
            wp_register_style( 'wrt_fontawesome-all.min', plugins_url('/css/fontawesome/css/wrt_fontawesome-all.min.css', __FILE__),array(),'2.11');
            wp_register_style( 'wrt_v4-shims.min', plugins_url('/css/fontawesome/css/wrt_v4-shims.min.css', __FILE__),array(),'2.11'  );
            wp_register_style( 'wrt_brands.min', plugins_url('/css/fontawesome/css/wrt_brands.min.css', __FILE__),array(),'2.11'  );
        
            wp_register_script ( 'wrt_bootstrap-nva-only.min', plugins_url ( '/js/wrt_bootstrap-nva-only.min.js', __FILE__ ) ,array('jquery'),'2.11' );
            wp_register_script ( 'wrt_jquery.easyResponsiveTabs', plugins_url ( '/js/wrt_jquery.easyResponsiveTabs.js', __FILE__ ) ,array('jquery'),'2.11' );
            wp_register_script ( 'wrt_jquery.scrolling-tabs', plugins_url ( '/js/wrt_jquery.scrolling-tabs.js', __FILE__ ) ,array('jquery'),'2.11' );
         

       }
}


 function wrt_wp_responsive_tabs_multisite_check_activated() {
    
            global $wpdb;
           $activated = get_site_option('i13_responsive_tabs_multisite_activated');

            if($activated == false) {
                    return false;
            } else {
                    $sql = "SELECT blog_id FROM $wpdb->blogs";
                    $blog_ids = $wpdb->get_col($sql);
                    foreach($blog_ids as $blog_id) {
                            if(!in_array($blog_id, $activated)) {
                                    switch_to_blog($blog_id);
                                    wrt_wp_responsive_tabs_install();
                                    $activated[] = $blog_id;
                            }
                    }
                    restore_current_blog();
                    update_site_option('i13_responsive_tabs_multisite_activated', $activated);
            }
            
 } 

function wrt_wp_responsive_tabs_check_network($network_wide) {
    
	if(is_multisite() && $network_wide) { 
        // running on multi site with network install
                global $wpdb;
                $activated = array();
                $sql = "SELECT blog_id FROM $wpdb->blogs";
                $blog_ids = $wpdb->get_col($sql);
                foreach($blog_ids as $blog_id) {
                        switch_to_blog($blog_id);
                        wrt_wp_responsive_tabs_install();
                        $activated[] = $blog_id;
                }
                restore_current_blog();
                update_site_option('i13_responsive_tabs_multisite_activated', $activated);


        } else { 

                wrt_wp_responsive_tabs_install();
        }
    } 



function wrt_wp_responsive_tabs_install() {
    
	global $wpdb;
	$table_name = $wpdb->prefix . "wrt_tabs";
	$table_name2 = $wpdb->prefix . "wrt_tabs_settings";
	
        $charset_collate = $wpdb->get_charset_collate();
        
	$sql = "CREATE TABLE " . $table_name . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `tab_title` varchar(200) NOT NULL,
        `fonto_icon` varchar(200) NOT NULL DEFAULT '',
        `tab_description` text  DEFAULT NULL ,
        `createdon` datetime NOT NULL, 
        `is_default` tinyint(1) NOT NULL DEFAULT '0',
        `morder` int(11) NOT NULL DEFAULT '0',
        `gtab_id` int(11) NOT NULL DEFAULT '1',
        `is_link` tinyint(1) NOT NULL DEFAULT '0',
        `link` varchar(500) NOT NULL DEFAULT '',
         PRIMARY KEY (`id`)
        ) $charset_collate; ". 
        "CREATE TABLE " . $table_name2 . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(200) NOT NULL,
        `type` int(1) NOT NULL DEFAULT '1',
        `activetab_bg` varchar(10)  DEFAULT '#ffffff' ,
        `inactive_bg` varchar(10)  DEFAULT '#00aadd' ,
        `ac_border_color` varchar(10)  DEFAULT '#81d742' ,
        `tab_fcolor` varchar(10) DEFAULT '#ffffff' ,
        `tab_a_fcolor` varchar(10) DEFAULT '#428bca' ,
        `tab_ccolor` varchar(10) DEFAULT '#000000' ,
        `scroll_edge` tinyint(1) NOT NULL DEFAULT '0',
        `use_ajax` tinyint(1) NOT NULL DEFAULT '0',
        `additional_css` text  DEFAULT NULL,
        `createdon` datetime NOT NULL, 
         PRIMARY KEY (`id`)
        ) $charset_collate";

        
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta ( $sql );

        if(wrt_table_column_exists($table_name,'fonto_icon')==false){
            
           $wpdb->query("ALTER TABLE $table_name ADD `fonto_icon` varchar(200) NOT NULL DEFAULT '' ");
        }
        
        if(wrt_table_column_exists($table_name,'is_link')==false){
            
           $wpdb->query("ALTER TABLE $table_name ADD `is_link` tinyint(1) NOT NULL DEFAULT '1' ");
        }
        
        if(wrt_table_column_exists($table_name,'link')==false){
            
           $wpdb->query("ALTER TABLE $table_name ADD `link` varchar(500) NOT NULL DEFAULT '' ");
        }
        
        if(wrt_table_column_exists($table_name2,'scroll_edge')==false){
            
           $wpdb->query("ALTER TABLE $table_name2 ADD `scroll_edge` tinyint(1) NOT NULL DEFAULT '0' ");
        }
        
        if(wrt_table_column_exists($table_name2,'use_ajax')==false){
            
           $wpdb->query("ALTER TABLE $table_name2 ADD `use_ajax` tinyint(1) NOT NULL DEFAULT '0' ");
        }
        
        if(wrt_table_column_exists($table_name2,'additional_css')==false){
            
           $wpdb->query("ALTER TABLE $table_name2 ADD `additional_css` text  DEFAULT NULL ");
        }
        
        wrt_wp_responsive_tabs_add_access_capabilities();
        
}

function wrt_table_column_exists( $table_name, $column_name ) {
       
	global $wpdb;
	$column = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
		DB_NAME, $table_name, $column_name
	) );
	if ( ! empty( $column ) ) {
		return true;
	}
	return false;
        
 } 
 
function wrt_responsive_tabs_add_admin_menu() {
    
	$hook_suffix = add_menu_page ( __( 'Responsive Tabs','responsive-horizontal-vertical-and-accordion-tabs') , __ ( 'Responsive Tabs','responsive-horizontal-vertical-and-accordion-tabs' ), 'wrt_responsive_tabs_view_tab_sets', 'rt_wp_responsive_tabs', 'rt_wp_responsive_wp_admin_options_func' );
	$hook_suffix=add_submenu_page ( 'rt_wp_responsive_tabs', __ ( 'Tab Sets','responsive-horizontal-vertical-and-accordion-tabs' ), __ ( 'Tab Sets','responsive-horizontal-vertical-and-accordion-tabs' ), 'wrt_responsive_tabs_view_tab_sets', 'rt_wp_responsive_tabs', 'rt_wp_responsive_wp_admin_options_func' );
	$hook_suffix_image=add_submenu_page ( 'rt_wp_responsive_tabs', __ ( 'Manage Tabs','responsive-horizontal-vertical-and-accordion-tabs' ), __ ( 'Manage Tabs','responsive-horizontal-vertical-and-accordion-tabs' ), 'wrt_responsive_tabs_view_tabs', 'rt_wp_responsive_tabs_management', 'rt_wp_responsive_tabs_data_management' );
	$hook_suffix_prev=add_submenu_page ( 'rt_wp_responsive_tabs', __ ( 'Preview Slider','responsive-horizontal-vertical-and-accordion-tabs' ), __ ( 'Preview Tabs','responsive-horizontal-vertical-and-accordion-tabs' ), 'wrt_responsive_tabs_preview_tab_set', 'rt_wp_responsive_tabs_preview', 'wrt_rt_wp_responsive_tabs_preview_func' );
	
	add_action( 'load-' . $hook_suffix , 'wrt_responsive_tabs_add_admin_init' );
	add_action( 'load-' . $hook_suffix_image , 'wrt_responsive_tabs_add_admin_init' );
	add_action( 'load-' . $hook_suffix_prev , 'wrt_responsive_tabs_add_admin_init' );
        
        wrt_wp_responsive_full_tabs_admin_scripts_init();
	
}

function wp_ajax_rt_get_tab_data_byid_callback(){
    
       global $wpdb;
       $retrieved_nonce='';
        if (isset($_POST['vNonce']) and $_POST['vNonce'] != '') {

           $retrieved_nonce = $_POST['vNonce'];
        }
        if (!wp_verify_nonce($retrieved_nonce, 'vNonce')) {


           wp_die('Security check fail');
        }
        
       $tab_id = 0;
	if (isset ( $_POST ['tab_id'] ) and intval($_POST ['tab_id']) > 0) {
            
		$tab_id = intval((trim ( $_POST ['tab_id'] )));
	} 
        
        $query = "SELECT tab_description FROM " . $wpdb->prefix . "wrt_tabs WHERE id=$tab_id";
   	$row = $wpdb->get_row ( $query, ARRAY_A );
        $description='';
        if(is_array($row) and sizeof($row)>0){
            
            $description=$row['tab_description'];
        }
        
       if(class_exists('WPBMap') ){
		   
	  WPBMap::addAllMappedShortcodes();
	 }
	
      echo  do_shortcode(apply_filters('the_content', wp_unslash($description)));
      exit;
   
}

function rt_wp_responsive_wp_admin_options_func() {
    
        $url='admin.php?page=rt_wp_responsive_tabs';
        $order_by='id';
        $order_pos="asc";
        
        if(isset($_GET['order_by'])){
        
               if(sanitize_sql_orderby($_GET['order_by'])){
                   
                    $order_by=trim($_GET['order_by']); 
                }
                else{

                    $order_by=' id ';
                }
        }
        
        if(isset($_GET['order_pos'])){
        
           $order_pos=trim(sanitize_text_field($_GET['order_pos'])); 
        }
        
        $search_term_='';
        if(isset($_GET['search_term'])){
        
           $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
        }
        
        
        
	$action = 'gridview';
	if (isset ( $_GET ['action'] ) and $_GET ['action'] != '') {
		
		$action = trim (sanitize_text_field($_GET ['action'] ));
	}
	if (strtolower ( $action ) == strtolower ( 'gridview' )) {
            
              if ( ! current_user_can( 'wrt_responsive_tabs_view_tab_sets' ) ) {

                    wp_die( __( "Access Denied", "responsive-horizontal-vertical-and-accordion-tabs" ) );

               } 
            
            ?>
            <div class="wrap">
                    
            <?php
            $url = plugin_dir_url(__FILE__);  
             ?> 
        
            <div style="width: 100%;">
                            <div style="float: left; width: 100%;">
                                <?php
                            $messages = get_option ( 'wrt_responsive_tabs_msg' );
                            $type = '';
                            $message = '';
                            if (isset ( $messages ['type'] ) and $messages ['type'] != "") {

                                    $type = $messages ['type'];
                                    $message = $messages ['message'];
                            }

                            if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                            else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
       

                            update_option ( 'wrt_responsive_tabs_msg', array () );
                            ?>    
                                <div class="icon32 icon32-posts-post" id="icon-edit">
                                            <br>
                                    </div>
                                    <h2>
                                            <?php echo __('Manage Tab Sets','responsive-horizontal-vertical-and-accordion-tabs');?> <a class="button add-new-h2"href="admin.php?page=rt_wp_responsive_tabs&action=addedit"><?php echo __('Add New','responsive-horizontal-vertical-and-accordion-tabs');?></a>
                                    </h2>
                                    <br />
                                    
                                    <form method="POST" action="admin.php?page=rt_wp_responsive_tabs&action=deleteselected" id="posts-filter" onkeypress="return event.keyCode != 13;">
                                            <div class="alignleft actions">
                                                    <select name="action_upper" id="action_upper">
                                                            <option selected="selected" value="-1"><?php echo __("Bulk Actions",'responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option value="delete"><?php echo __('delete','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                    </select> 
                                                    <input type="submit" value="<?php echo __('Apply','responsive-horizontal-vertical-and-accordion-tabs');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
                                            </div>
                                            <div style="clear: both;"></div>
                                            <br />
                                            <?php
                                                $setacrionpage='admin.php?page=rt_wp_responsive_tabs';

                                                if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                                                 $setacrionpage.='&order_by='.sanitize_text_field($_GET['order_by']);   
                                                }

                                                if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                                                 $setacrionpage.='&order_pos='.sanitize_text_field($_GET['order_pos']);   
                                                }

                                                $seval="";
                                                if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                                                 $seval=trim(sanitize_text_field($_GET['search_term']));   
                                                }

                                            ?>
                                            <div style="padding-top:5px;padding-bottom:5px">
                                                <b><?php echo __( 'Search','responsive-horizontal-vertical-and-accordion-tabs');?> : </b>
                                                  <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Search','responsive-horizontal-vertical-and-accordion-tabs');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Reset Search','responsive-horizontal-vertical-and-accordion-tabs');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                                            </div>  
                                            <script type="text/javascript" >
                                                jQuery('#search_term').on("keyup", function(e) {
                                                       if (e.which == 13) {
                                                  
                                                           SearchredirectTO();
                                                       }
                                                  });   
                                             function SearchredirectTO(){
                                               var redirectto='<?php echo $setacrionpage; ?>';
                                               var searchval=jQuery('#search_term').val();
                                               redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                                               window.location.href=redirectto;
                                             }
                                            function ResetSearch(){

                                                 var redirectto='<?php echo $setacrionpage; ?>';
                                                 window.location.href=redirectto;
                                                 exit;
                                            }
                                            </script>
                                            <div id="no-more-tables">
                                          <table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf wp-list-table widefat">
                                           <thead>
  

                                                <tr>
                                                        <th class="manage-column column-cb check-column"><input
                                                                type="checkbox" /></th>
                                                        <?php if($order_by=="id" and $order_pos=="asc"):?>

                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __("Id",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                        <?php else:?>
                                                            <?php if($order_by=="id"):?>
                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Id",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                            <?php else:?>
                                                                <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Id",'responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                            <?php endif;?>    
                                                        <?php endif;?>   

                                                        <?php if($order_by=="name" and $order_pos=="asc"):?>

                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=name&order_pos=desc<?php echo $search_term_;?>"><?php echo __("Name",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                        <?php else:?>
                                                            <?php if($order_by=="name"):?>
                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=name&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Name",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                            <?php else:?>
                                                                <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=name&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Name",'responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                            <?php endif;?>    
                                                        <?php endif;?>   

                                                        <?php if($order_by=="createdon" and $order_pos=="asc"):?>

                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __("Created On",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                        <?php else:?>
                                                            <?php if($order_by=="createdon"):?>
                                                        <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Created On",'responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                            <?php else:?>
                                                                <th><a href="admin.php?page=rt_wp_responsive_tabs&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __("Created On",'responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                            <?php endif;?>    
                                                        <?php endif;?>   

                                                        <th><?php echo __("Shortcode",'responsive-horizontal-vertical-and-accordion-tabs');?></th>
                                                        <th><?php echo __("Manage Tabs",'responsive-horizontal-vertical-and-accordion-tabs');?></th>
                                                        <th><?php echo __("Edit",'responsive-horizontal-vertical-and-accordion-tabs');?></th>
                                                        <th><?php echo __("Delete",'responsive-horizontal-vertical-and-accordion-tabs');?></th>
                                                </tr>
                                        </thead>

                                        <tbody id="the-list">
                                                <?php

                                                global $wpdb;
                                                $search_term='';
                                                if(isset($_GET['search_term'])){

                                                   $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
                                                }


                                                $query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs_settings ";
                                                $queryCount = "SELECT count(*) FROM " . $wpdb->prefix . "wrt_tabs_settings ";
                                                if($search_term!=''){
                                                   $query.=" where id like '%$search_term%' or name like '%$search_term%' "; 
                                                   $queryCount.=" where id like '%$search_term%' or name like '%$search_term%' "; 
                                                }

                                                $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                                                $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                                                $query.=" order by $order_by $order_pos";

                                                $rowsCount=$wpdb->get_var($queryCount);


                                                if ($rowsCount > 0) {

                                                        global $wp_rewrite;
                                                        $rows_per_page = 15;

                                                        $current = (isset ( $_GET ['paged'] )) ? intval(($_GET ['paged'])) : 1;
                                                        $pagination_args = array (
                                                                        'base' => @add_query_arg ( 'paged', '%#%' ),
                                                                        'format' => '',
                                                                        'total' => ceil ( $rowsCount / $rows_per_page ),
                                                                        'current' => $current,
                                                                        'show_all' => false,
                                                                        'type' => 'plain' 
                                                        );

                                                        $offset = ($current - 1) * $rows_per_page;
                                                        $query.=" limit $offset, $rows_per_page";
                                                        $rows = $wpdb->get_results ( $query);

                                                        $delRecNonce = wp_create_nonce('delete_tabset');
                                                        foreach($rows as $row) {

                                                                $id = $row->id;
                                                                $editlink = "admin.php?page=rt_wp_responsive_tabs&action=addedit&id=$id";
                                                                $deletelink = "admin.php?page=rt_wp_responsive_tabs&action=delete&id=$id&nonce=$delRecNonce";
                                                                $manageMedia = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$id";
                                                                ?>
                                                                      <tr valign="top" id="">
                                                                            <td class="alignCenter check-column" data-title="<?php echo __("Select Record",'responsive-horizontal-vertical-and-accordion-tabs');?>"><input type="checkbox" value="<?php echo $id ?>" name="thumbnails[]"></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Id",'responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo intval($row->id); ?></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Name",'responsive-horizontal-vertical-and-accordion-tabs');?>"><strong><?php echo esc_html($row->name); ?></strong></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Created On",'responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo esc_html($row->createdon); ?></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("ShortCode",'responsive-horizontal-vertical-and-accordion-tabs');?>" scope="col"><span><input type="text" spellcheck="false" onclick="this.focus(); this.select()" readonly="readonly" style="width: 100%; height: 29px; background-color: #EEEEEE" value='[wrt_print_rt_wp_responsive_tabs tabset_id="<?php echo intval($row->id); ?>"]'></span></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Manage Tabs",'responsive-horizontal-vertical-and-accordion-tabs');?>" scope="col"><strong><a href='<?php echo $manageMedia; ?>' title="<?php echo __("Manage Tabs",'responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo __("Manage Tabs",'responsive-horizontal-vertical-and-accordion-tabs');?></a></strong></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Edit",'responsive-horizontal-vertical-and-accordion-tabs');?>"><strong><a href='<?php echo esc_html($editlink); ?>' title="<?php echo __("Edit",'responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo __("Edit",'responsive-horizontal-vertical-and-accordion-tabs');?></a></strong></td>
                                                                            <td class="alignCenter" data-title="<?php echo __("Delete",'responsive-horizontal-vertical-and-accordion-tabs');?>"><strong><a  href='<?php echo esc_html($deletelink); ?>' onclick="return confirmDelete();" title="<?php echo __("Delete",'responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo __("Delete",'responsive-horizontal-vertical-and-accordion-tabs');?></a> </strong></td>
                                                                       </tr>
                                                                            <?php
                                                        }
                                                } else {
                                                        ?><tr valign="top" id="">
                                                                <td colspan="9" data-title="<?php echo __("No Records",'responsive-horizontal-vertical-and-accordion-tabs');?>" align="center"><strong><?php echo __("No Tab Sets Found",'responsive-horizontal-vertical-and-accordion-tabs');?></strong></td>
                                                        </tr>
                                            <?php
                                                }
                                                ?>      
                                                    </tbody>
                                                    </table>


                                                    </div>
                                               <?php
                                                if ($rowsCount > 0) {
                                                        echo "<div class='pagination' style='padding-top:10px'>";
                                                        echo paginate_links ( $pagination_args );
                                                        echo "</div>";
                                                }
                                                ?>
                                    <br />
                                            <div class="alignleft actions">
                                                    <select name="action" id="action_bottom"> 
                                                            <option selected="selected" value="-1"><?php echo __("Bulk Actions",'responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option value="delete"><?php echo __("delete",'responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                    </select> 
                                                <?php wp_nonce_field('action_settings_mass_delete', 'mass_delete_nonce'); ?>
                                                <input type="submit" value="<?php echo __("Apply",'responsive-horizontal-vertical-and-accordion-tabs');?>" class="button-secondary action" id="deleteselected" name="deleteselected" onclick="return confirmDelete_bulk();">
                                            </div>

                                    </form>
                                    <script type="text/JavaScript">

                                     function  confirmDelete_bulk(){
                                                
                                        var topval=document.getElementById("action_bottom").value;
                                        var bottomVal=document.getElementById("action_upper").value;

                                        if(topval=='delete' || bottomVal=='delete'){


                                            var agree=confirm('<?php echo __("Are you sure you want to delete selected tabs Sets ? All tabs related to this tab Sets also removed.",'responsive-horizontal-vertical-and-accordion-tabs');?>');
                                            if (agree)
                                             return true ;
                                            else
                                             return false;
                                          }
                                     }
                                
                                    function  confirmDelete(){
                                    var agree=confirm("<?php echo __("Are you sure you want to delete this tab sets ? All tabs related to this sets also removed.",'responsive-horizontal-vertical-and-accordion-tabs');?>");
                                    if (agree)
                                        return true ;
                                    else
                                        return false;
                                    }
                                </script>

                                    <br class="clear">
                            </div>
                            <div style="clear: both;"></div>
                            <?php $url = plugin_dir_url(__FILE__); ?>
                        </div>
            </div>
	<div class="clear"></div> 
            <?php
	} 
        else if(strtolower($action)==strtolower('addedit')){

           
        if(isset($_POST['btnsave'])){

            if ( !check_admin_referer( 'action_image_add_edit','add_edit_image_nonce')){

                  wp_die('Security check fail'); 
              }

            $name=trim(sanitize_text_field($_POST['name']));  
            $activetab_bg=sanitize_text_field($_POST['activetab_bg']); 
            $inactive_bg=sanitize_text_field($_POST['inactive_bg']); 
            $ac_border_color=sanitize_text_field($_POST['ac_border_color']); 
            $tab_fcolor=sanitize_text_field($_POST['tab_fcolor']); 
            $tab_a_fcolor=sanitize_text_field($_POST['tab_a_fcolor']); 
            $tab_ccolor=sanitize_text_field($_POST['tab_ccolor']); 
            $additional_css=sanitize_textarea_field($_POST['additional_css']); 
            $type=intval($_POST['type']); 
             
            $scroll_edge=0;
             if(isset($_POST['scroll_edge'])){
                            
                $scroll_edge=1;

             }
           
            $use_ajax=0;
             if(isset($_POST['use_ajax'])){
                            
                $use_ajax=1;

             }
           
            $createdOn = date ( 'Y-m-d h:i:s' );
            if (function_exists ( 'date_i18n' )) {

                    $createdOn = date_i18n ( 'Y-m-d' . ' ' . get_option ( 'time_format' ), false, false );
                    if (get_option ( 'time_format' ) == 'H:i')
                            $createdOn = date ( 'Y-m-d H:i:s', strtotime ( $createdOn ) );
                    else
                            $createdOn = date ( 'Y-m-d h:i:s', strtotime ( $createdOn ) );
            }
           
            global $wpdb;
            
            if(isset($_POST['tabid'])){
                
                   if ( ! current_user_can( 'wrt_responsive_tabs_edit_tab_set' ) ) {

                        $location='admin.php?page=rt_wp_responsive_tabs';
                        $wrt_responsive_tabs_msg=array();
                        $wrt_responsive_tabs_msg['type']='err';
                        $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                        update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                     }

                    $tabid=(int)$_POST['tabid'];
                    
                    
                     $wpdb->update(
                           
                                $wpdb->prefix.'wrt_tabs_settings',

                                array( 
                                        'name' => $name, 
                                        'type'=>$type,
                                        'activetab_bg' => $activetab_bg,
                                        'inactive_bg'=> $inactive_bg,
                                        'ac_border_color'=>$ac_border_color,
                                        'tab_fcolor'=>$tab_fcolor,
                                        'tab_a_fcolor'=>$tab_a_fcolor,
                                        'tab_ccolor'=>$tab_ccolor,
                                        'scroll_edge'=>$scroll_edge,
                                        'use_ajax'=>$use_ajax,
                                        'additional_css'=>$additional_css,

                                    ),
                                   array( 
                                    'id' => $tabid,          // where clause(s)
                                   ), 
                                   array( '%s','%d','%s','%s','%s','%s','%s','%s','%d','%d','%s' ),
                                   array( 
                                            '%d'
                                    )
                                );
                   
                        $wrt_responsive_tabs_msg=array();
                        $wrt_responsive_tabs_msg['type']='succ';
                        $wrt_responsive_tabs_msg['message']=__('Tab set updated successfully.','responsive-horizontal-vertical-and-accordion-tabs');
                        update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
        
            }
            else{
                
                        if ( ! current_user_can( 'wrt_responsive_tabs_add_tab_set' ) ) {

                            $location='admin.php?page=rt_wp_responsive_tabs';
                            $wrt_responsive_tabs_msg=array();
                            $wrt_responsive_tabs_msg['type']='err';
                            $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                            update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                            echo "<script type='text/javascript'> location.href='$location';</script>";     
                            exit;   

                         }
                         
                         
                        $wpdb->insert(
                           
                            $wpdb->prefix.'wrt_tabs_settings',

                            array( 
                                    'name' => $name, 
                                    'type'=>$type,
                                    'activetab_bg' => $activetab_bg,
                                    'inactive_bg'=> $inactive_bg,
                                    'ac_border_color'=>$ac_border_color,
                                    'tab_fcolor'=>$tab_fcolor,
                                    'tab_a_fcolor'=>$tab_a_fcolor,
                                    'tab_ccolor'=>$tab_ccolor,
                                    'scroll_edge'=>$scroll_edge,
                                    'use_ajax'=>$use_ajax,
                                    'additional_css'=>$additional_css,
                                    'createdon'=>$createdOn,

                                ),
                               array( '%s','%d','%s','%s','%s','%s','%s','%s','%d', '%d','%s','%s' )
                              
                            ); 
                     
                        $wrt_responsive_tabs_msg=array();
                        $wrt_responsive_tabs_msg['type']='succ';
                        $wrt_responsive_tabs_msg['message']=__('Tab set added successfully.','responsive-horizontal-vertical-and-accordion-tabs');
                        update_option('wp_vgallery_thumbnail_msg', $wrt_responsive_tabs_msg);
                
            }
            
            
            
            $location='admin.php?page=rt_wp_responsive_tabs';
             echo "<script type='text/javascript'> location.href='$location';</script>";
             exit;



        }  
        
         if(isset($_GET['id'])){

                global $wpdb;
                $id= intval($_GET['id']);
                $query="SELECT * FROM ".$wpdb->prefix."wrt_tabs_settings WHERE id=$id";
                $settings_  = $wpdb->get_row($query,ARRAY_A);
                
                if ( ! current_user_can( 'wrt_responsive_tabs_edit_tab_set' ) ) {

                    $location='admin.php?page=rt_wp_responsive_tabs';
                    $wrt_responsive_tabs_msg=array();
                    $wrt_responsive_tabs_msg['type']='err';
                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                 }

                if(!is_array($settings_)){

                     $settings=array(
                            'name'=>'',
                            'activetab_bg' => '#ffffff',
                            'inactive_bg' =>'#00aadd',
                            'ac_border_color' =>'#81d742',
                            'tab_fcolor'=>'#ffffff',
                            'tab_a_fcolor'=>'#428bca',
                            'tab_ccolor'=>'#000000',
                            'type' =>'3',
                            'scroll_edge' =>'0',
                            'use_ajax' =>'0',
                            'additional_css' =>'',
                        );
                     
                     

                }
                else{

                    
                        
                      $settings=array(
                            'name'=>sanitize_text_field($settings_['name']),
                            'activetab_bg' => sanitize_text_field($settings_['activetab_bg']),
                            'inactive_bg' =>sanitize_text_field($settings_['inactive_bg']),
                            'ac_border_color' =>sanitize_text_field($settings_['ac_border_color']),
                            'tab_fcolor' =>sanitize_text_field($settings_['tab_fcolor']),
                            'tab_a_fcolor' =>sanitize_text_field($settings_['tab_a_fcolor']),
                            'tab_ccolor' =>sanitize_text_field($settings_['tab_ccolor']),
                            'type' =>intval($settings_['type']),
                            'scroll_edge' =>intval($settings_['scroll_edge']),
                            'use_ajax' =>intval($settings_['use_ajax']),
                            'additional_css' =>wp_unslash($settings_['additional_css'])
                      
                        );
                      
                  

                }

            }else{

                
                  if ( ! current_user_can( 'wrt_responsive_tabs_add_tab_set' ) ) {

                        $location='admin.php?page=rt_wp_responsive_tabs';
                        $wrt_responsive_tabs_msg=array();
                        $wrt_responsive_tabs_msg['type']='err';
                        $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                        update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                        exit;   

                     }
                     
                 $settings=array(
                                'name'=>'',
                                'activetab_bg' => '#ffffff',
                                'inactive_bg' =>'#00aadd',
                                'ac_border_color' =>'#81d742',
                                'tab_fcolor'=>'#ffffff',
                                'tab_a_fcolor'=>'#428bca',
                                'tab_ccolor'=>'#000000',
                                'type' =>'3',
                                'scroll_edge' =>'0',
                                'use_ajax' =>'0',
                                'additional_css' =>''
                        );

            }
        
        

    ?>      
    <div style="width: 100%;">  
        <div style="float:left;width:100%;">
            <div class="wrap">
                 
                <?php
                    $messages=get_option('wrt_responsive_tabs_msg'); 
                    $type='';
                    $message='';
                    if(isset($messages['type']) and $messages['type']!=""){

                        $type=$messages['type'];
                        $message=$messages['message'];

                    }  


                    if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                    else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
       


                    update_option('wrt_responsive_tabs_msg', array());     
                ?>      

                <?php if(isset($_GET['id']) and intval($_GET['id']>0)):?> 
                  
                    <h2><?php echo __("Update Tab Set",'responsive-horizontal-vertical-and-accordion-tabs');?></h2>
                    
                <?php else:?>    
                
                    <h2><?php echo __("Add Tab Set",'responsive-horizontal-vertical-and-accordion-tabs');?></h2>
                    
                <?php endif;?>    
                    
                <div id="poststuff">   
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content" >
                                <form method="post" action="" id="scrollersettiings" name="scrollersettiings" >
                                    
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="link_name"><?php echo __('Name','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="name" size="30" name="name" value="<?php echo $settings['name']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox" id="slider_easing" style="width:100%;">
                                        <h3><label><?php echo __( 'Type','responsive-horizontal-vertical-and-accordion-tabs');?></label></h3>
                                        <div class="inside">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <select name="type" id="type">
                                                            <option value=""><?php echo __( 'Select','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option <?php if ($settings['type'] == "3") { ?> selected="selected" <?php } ?> value="3"><?php echo __( 'Responsive Horizontal Scrollable Tabs','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option <?php if ($settings['type'] == "4") { ?> selected="selected" <?php } ?> value="4"><?php echo __( 'Responsive Horizontal Tabs','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option <?php if ($settings['type'] == "2") { ?> selected="selected" <?php } ?> value="2"><?php echo __( 'Responsive Vertical Tabs','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            <option <?php if ($settings['type'] == "5") { ?> selected="selected" <?php } ?> value="5"><?php echo __( 'Responsive Accordion Tabs','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                            
                                                            </select>
                                                        <div style="clear: both"></div>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div style="clear:both"></div>

                                        </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="activetab_bg"><?php echo __('Active Tab Background Color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="activetab_bg" size="30" name="activetab_bg" value="<?php echo $settings['activetab_bg']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="inactive_bg"><?php echo __('Inactive Tab Background Color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="inactive_bg" size="30" name="inactive_bg" value="<?php echo $settings['inactive_bg']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="ac_border_color"><?php echo __('Border Color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="ac_border_color" size="30" name="ac_border_color" value="<?php echo $settings['ac_border_color']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="tab_fcolor"><?php echo __('Tab font color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="tab_fcolor" size="30" name="tab_fcolor" value="<?php echo $settings['tab_fcolor']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="tab_a_fcolor"><?php echo __('Active Tab font color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="tab_a_fcolor" size="30" name="tab_a_fcolor" value="<?php echo $settings['tab_a_fcolor']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="tab_ccolor"><?php echo __('Tab Content color','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                            <input class="input-text" type="text" id="tab_ccolor" size="30" name="tab_ccolor" value="<?php echo $settings['tab_ccolor']; ?>">
                                                    </div>
                                                    <div style="clear: both"></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox scroll_edge_div" id="namediv" <?php if(intval($settings['type'])==3): ?> style="width:100%;display:block" <?php else:?> style="width:100%;display:none" <?php endif;?> >
                                            <h3>
                                                    <label for="scroll_edge"><?php echo __('Scroll to tab edge ?','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                              <input type="checkbox" id="scroll_edge" size="30" name="scroll_edge" value="" <?php if($settings['scroll_edge']==1){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __('Scroll to tab edge ?','responsive-horizontal-vertical-and-accordion-tabs');?>  

                                                    </div>
                                                    <div style="clear: both"><?php echo __('Set if you want to force full-width tabs to display at the left scroll arrow.','responsive-horizontal-vertical-and-accordion-tabs');?> </div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox use_ajax_div" id="namediv" >
                                            <h3>
                                                    <label for="use_ajax"><?php echo __('Use Ajax ?','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                              <input type="checkbox" id="use_ajax" size="30" name="use_ajax" value="" <?php if($settings['use_ajax']==1){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __('Set true if you want tab content load first time from ajax','responsive-horizontal-vertical-and-accordion-tabs');?>  

                                                    </div>
                                                    <div style="clear: both"> </div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                    <div class="stuffbox" id="namediv" style="width: 100%">
                                            <h3>
                                                    <label for="additional_css"><?php echo __('Additional CSS','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                    </label>
                                            </h3>
                                            <div class="inside">
                                                    <div>
                                                             <textarea style="width:100%;height:300px" id="additional_css" size="50" name="additional_css" ><?php echo wp_unslash($settings['additional_css']);?></textarea>
                                                    </div>
                                                     <div style="clear:both;font-size: 12px;color:black"><?php echo __("Don't, use style tag. Just add css",'responsive-horizontal-vertical-and-accordion-tabs');?></div>
                                                    <div></div>
                                                    <div style="clear: both"></div>
                                            </div>
                                    </div>
                                     <?php wp_nonce_field('action_image_add_edit','add_edit_image_nonce'); ?>
                                                         <?php if(isset($_GET['id']) and (int) $_GET['id']>0){ ?> 
                                                            <input type="hidden" name="tabid" id="tabid" value="<?php echo intval($_GET['id']);?>">
                                                            <?php
                                                            } 
                                                        ?>  
                                                        <input type="submit"  name="btnsave" id="btnsave" value="<?php echo __("Save Changes",'responsive-horizontal-vertical-and-accordion-tabs');?>" class="button-primary">    
                                                        &nbsp;&nbsp;<input type="button"
										name="cancle" id="cancle" value="<?php echo __('Cancel','responsive-horizontal-vertical-and-accordion-tabs');?>"
										class="button-primary"
										onclick="location.href = 'admin.php?page=rt_wp_responsive_tabs'">

                                </form>
                                <script type="text/javascript">

                                    
                                    jQuery("#type" ).change(function() {
                                       
                                        if(parseInt(jQuery(this).val())==3){

                                            jQuery(".scroll_edge_div").show();
                                        }
                                        else{


                                            jQuery(".scroll_edge_div").hide();
                                       }
                                       
                                     })
                                    
                                
                                    jQuery(document).ready(function() {

                                            jQuery("#scrollersettiings").validate({
                                                    rules: {
                                                         
                                                         name: {
                                                            required:true,
                                                            maxlength:250
                                                        },  
                                                         type: {
                                                            required:true,
                                                            number:true,
                                                        },  
                                                        activetab_bg: {
                                                            required:true,
                                                            maxlength:7
                                                        },
                                                        inactive_bg: {
                                                            required:true,
                                                            maxlength:7
                                                        },
                                                        ac_border_color: {
                                                            required:true,
                                                            maxlength:7
                                                        },
                                                        tab_fcolor: {
                                                            required:true,
                                                            maxlength:7
                                                        },
                                                        tab_a_fcolor: {
                                                            required:true,
                                                            maxlength:7
                                                        },
                                                        tab_ccolor: {
                                                            required:true,
                                                            maxlength:7
                                                        }
                                                        

                                                    },
                                                    errorClass: "image_error",
                                                    errorPlacement: function(error, element) {
                                                        error.appendTo( element.next().next());
                                                    } 


                                            })
                                            
                                             jQuery('#activetab_bg').wpColorPicker();
                                             jQuery('#inactive_bg').wpColorPicker();
                                             jQuery('#ac_border_color').wpColorPicker();
                                             jQuery('#tab_fcolor').wpColorPicker();
                                             jQuery('#tab_a_fcolor').wpColorPicker();
                                             jQuery('#tab_ccolor').wpColorPicker();
                                    });

                                </script> 

                            </div>
                            
                       <div class="clear"></div>
                    </div>                                              

                </div>  
            </div>      
        </div>
        <div class="clear"></div></div>  
        
        <?php
        }
        else if (strtolower ( $action ) == strtolower ( 'delete' )) {
		
                 $retrieved_nonce = '';

                if (isset($_GET['nonce']) and $_GET['nonce'] != '') {

                    $retrieved_nonce = $_GET['nonce'];
                }
                if (!wp_verify_nonce($retrieved_nonce, 'delete_tabset')) {


                    wp_die('Security check fail');
                }
                
                 if ( ! current_user_can( 'wrt_responsive_tabs_delete_tab_set' ) ) {

                    $location='admin.php?page=rt_wp_responsive_tabs';
                    $wrt_responsive_tabs_msg=array();
                    $wrt_responsive_tabs_msg['type']='err';
                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                 }
                 
		global $wpdb;
		$location = "admin.php?page=rt_wp_responsive_tabs";
		$deleteId = intval(sanitize_text_field($_GET ['id']));
		
		
		try {
			
                        
			$query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs WHERE gtab_id=$deleteId";
			$myrows = $wpdb->get_results ( $query );
			
			foreach ( $myrows as $myrow ) {
				
				if (is_object ( $myrow )) {
					
					
                                        $wpdb->delete($wpdb->prefix . "wrt_tabs", array('id' => $myrow->id), array('%d'));


				}
			}
			
                        $wpdb->delete($wpdb->prefix . "wrt_tabs_settings", array('id' => $deleteId), array('%d'));
                         
			
			$wrt_responsive_tabs_msg = array ();
			$wrt_responsive_tabs_msg ['type'] = 'succ';
			$wrt_responsive_tabs_msg ['message'] = __('Tab set deleted successfully.','responsive-horizontal-vertical-and-accordion-tabs');
			update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
                        
		} catch ( Exception $e ) {
			
			$wrt_responsive_tabs_msg = array ();
			$wrt_responsive_tabs_msg ['type'] = 'err';
			$wrt_responsive_tabs_msg ['message'] = __('Error while deleting tab set.','responsive-horizontal-vertical-and-accordion-tabs');
			update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
		}
		
		echo "<script type='text/javascript'> location.href='$location';</script>";
		exit ();
	} 
        else if (strtolower ( $action ) == strtolower ( 'deleteselected' )) {
		
               if (!check_admin_referer('action_settings_mass_delete', 'mass_delete_nonce')) {

                        wp_die('Security check fail');
                    }
                    
                 if ( ! current_user_can( 'wrt_responsive_tabs_delete_tab_set' ) ) {

                    $location='admin.php?page=rt_wp_responsive_tabs';
                    $wrt_responsive_tabs_msg=array();
                    $wrt_responsive_tabs_msg['type']='err';
                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                }
                
		global $wpdb;
		
		$location = "admin.php?page=rt_wp_responsive_tabs";
		if (isset ( $_POST ) and isset ( $_POST ['deleteselected'] ) and ($_POST ['action'] == 'delete' or $_POST ['action_upper'] == 'delete')) {
			
			if (sizeof ( $_POST ['thumbnails'] ) > 0) {
				
				$deleteto = $_POST ['thumbnails'];
				$implode = implode ( ',', $deleteto );
				
				try {
					
					foreach ( $deleteto as $deleteId ) {
						
                                            $deleteId=intval(sanitize_text_field($deleteId));
                                            


						$query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs WHERE gtab_id=$deleteId";
						$myrows = $wpdb->get_results ( $query );
						
						foreach ( $myrows as $myrow ) {
							
							if (is_object ( $myrow )) {
								
								
                                                               $wpdb->delete($wpdb->prefix . "wrt_tabs", array('id' => $myrow->id), array('%d'));
                       
								
							}
						}
						
                                                $wpdb->delete($wpdb->prefix . "wrt_tabs_settings", array('id' => $deleteId), array('%d'));
                                                
					}
                                        
					$wrt_responsive_tabs_msg = array ();
					$wrt_responsive_tabs_msg ['type'] = 'succ';
					$wrt_responsive_tabs_msg ['message'] = __('Selected tab sets deleted successfully.','responsive-horizontal-vertical-and-accordion-tabs');
					update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
                                        
				} catch ( Exception $e ) {
					
					$wrt_responsive_tabs_msg = array ();
					$wrt_responsive_tabs_msg ['type'] = 'err';
					$wrt_responsive_tabs_msg ['message'] = __('Error while deleting tab sets.','responsive-horizontal-vertical-and-accordion-tabs');
					update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
				}
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			} else {
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			}
		} else {
			
			echo "<script type='text/javascript'> location.href='$location';</script>";
			exit ();
		}
	}
        
}

add_filter('plugins_api', 'i13_pro_responsive_tabs_info', 10, 3);

/*
 * $res empty at this step
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */
function i13_pro_responsive_tabs_info( $res, $action, $args ){

        $plugin_slug = I13_RTHV_PSLUG;


        // do nothing if this is not about getting plugin information
        if( 'plugin_information' !== $action ) {
                return $res;
        }

         // do nothing if it is not our plugin
        if( $plugin_slug !== $args->slug ) {

                return $res;
        }


        // trying to get from cache first
       if( false == $remote = get_transient( 'i13_update_' . $plugin_slug ) ) {


                $remote = wp_remote_get( add_query_arg( array(
                                'lic_key' => urlencode( base64_encode($_SERVER['SERVER_ADDR'])),
                                'up_info'=>urlencode('wp-23'),
                                'sk'=>urlencode('0mEE84fC7knyx8IM8UPqSjBoFjyeFKyE'),
                            ), 'https://i13websolution.com/u/p/d/getjson.php' ), array(
                                'timeout' => 50,
                                'headers' => array(
                                        'Accept' => 'application/json'
                                )
                        )
                );



                if ( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
                        set_transient( 'i13_update_' . $plugin_slug, $remote, 3600 ); // 1 hours cache
                }

        }

        if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {

                $remote = json_decode( $remote['body'] );
                $res = new stdClass();

                $res->name = $remote->name;
                $res->slug = $plugin_slug;
                $res->version = $remote->version;
                $res->tested = $remote->tested;
                $res->requires = $remote->requires;
                $res->author = '<a href="https://i13websolution.com/">Niks</a>';
                $res->author_profile = 'https://profiles.wordpress.org/nik00726';
                $res->download_link = $remote->download_url;
                $res->trunk = $remote->download_url;
                $res->requires_php = $remote->requires_php;
                $res->last_updated = $remote->last_updated;
                $res->sections = array(
                        'description' => $remote->sections->description,
                        'changelog' => $remote->sections->changelog
                );
                $res->banners = array(
                        'low' =>$remote->banners->low,
                );

                return $res;

        }

        return $res;

}

add_filter('site_transient_update_plugins', 'i13_responsive_tabs_push_update' );

function i13_responsive_tabs_push_update( $transient ){

        if ( empty($transient->checked ) ) {
            return $transient;
        }


        // trying to get from cache first, to disable cache comment 10,20,21,22,24
        if( false == $remote = get_transient( 'i13_upgrade_'.I13_RTHV_PSLUG ) ) {

                 $remote = wp_remote_get( add_query_arg( array(
                                'lic_key' => urlencode( base64_encode($_SERVER['SERVER_ADDR'])),
                                'up_info'=>urlencode('wp-23'),
                                'sk'=>urlencode('0mEE84fC7knyx8IM8UPqSjBoFjyeFKyE'),
                            ), 'https://i13websolution.com/u/p/d/getjson.php' ), array(
                                'timeout' => 50,
                                'headers' => array(
                                        'Accept' => 'application/json'
                                )
                        )
                );


                if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
                        set_transient( 'i13_upgrade_'.I13_RTHV_PSLUG, $remote, 3600 ); // 1 hours cache
                }

        }

        if( $remote && !is_wp_error($remote)) {

                $remote = json_decode( $remote['body'] );

                // your installed plugin version should be on the line below! You can obtain it dynamically of course 
                if( $remote && version_compare( I13_RTHV_PL_VERSION, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {

                        $res = new stdClass();
                        $res->slug = I13_RTHV_PSLUG;
                        $res->plugin = 'responsive-horizontal-vertical-and-accordion-tabs-pro/wp-best-responsive-tabs.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
                        $res->new_version = $remote->version;
                        $res->tested = $remote->tested;
                        $res->package = $remote->download_url;
                        $transient->response[$res->plugin] = $res;
                        //$transient->checked[$res->plugin] = $remote->version;
                }
                 else{
                        
                            
                             $res = new stdClass();
                             $res->slug = I13_RTHV_PSLUG;
                             $res->plugin = 'responsive-horizontal-vertical-and-accordion-tabs-pro/wp-best-responsive-tabs.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
                            $res->new_version = $remote->version;
                            $res->update=0;
                            $transient->no_update[$res->plugin]=$res;
                        
                        
                    }

        }
        return $transient;
}

add_action( 'upgrader_process_complete', 'i13_responsive_tabs_update', 10, 2 );

function i13_responsive_tabs_update( $upgrader_object, $options ) {
        if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
                // just clean the cache when new plugin version is installed
                delete_transient( 'i13_upgrade_'.I13_RTHV_PSLUG );
        }
}

function rt_wp_responsive_tabs_data_management() {
    
        $tabid = 0;
	if (isset ( $_GET ['tabid'] ) and $_GET ['tabid'] > 0) {
		// do nothing
		
		$tabid = intval(sanitize_text_field( $_GET ['tabid'] ));
                
	} else {
		
		$wrt_responsive_tabs_msg = array ();
		$wrt_responsive_tabs_msg ['type'] = 'err';
		$wrt_responsive_tabs_msg ['message'] = __('Please select tab set. Click on "Manage Tabs" of your desired tab set.','responsive-horizontal-vertical-and-accordion-tabs');
		update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
		$location = 'admin.php?page=rt_wp_responsive_tabs';
		echo "<script type='text/javascript'> location.href='$location';</script>";
		exit ();
	}
        
	$action = 'gridview';
	global $wpdb;
	
        $location = "admin.php?page=rt_wp_responsive_tabs&tabid=$tabid";
        
	if (isset ( $_GET ['action'] ) and $_GET ['action'] != '') {
		
		$action = trim ( sanitize_text_field($_GET ['action'] ));
                
               
	}
        
       
	?>

        <?php
	if (strtolower ( $action ) == strtolower ( 'gridview' )) {
		
		$wpcurrentdir = dirname ( __FILE__ );
		$wpcurrentdir = str_replace ( "\\", "/", $wpcurrentdir );
		
		$uploads = wp_upload_dir ();
		$baseurl = $uploads ['baseurl'];
		$baseurl .= '/responsive-horizontal-vertical-and-accordion-tabs/';
                
                if ( ! current_user_can( 'wrt_responsive_tabs_view_tabs' ) ) {

                    wp_die( __( "Access Denied", "responsive-horizontal-vertical-and-accordion-tabs" ) );

                } 
                
		?> 
            <div class="wrap">
                <?php
		$messages = get_option ( 'wrt_responsive_tabs_msg' );
		$type = '';
		$message = '';
		if (isset ( $messages ['type'] ) and $messages ['type'] != "") {
			
			$type = $messages ['type'];
			$message = $messages ['message'];
		}
		
		 if(trim($type)=='err'){ echo "<div class='notice notice-error is-dismissible'><p>"; echo $message; echo "</p></div>";}
                 else if(trim($type)=='succ'){ echo "<div class='notice notice-success is-dismissible'><p>"; echo $message; echo "</p></div>";}
       
		
		update_option ( 'wrt_responsive_tabs_msg', array () );
		?>

                  <div id="poststuff" >
                    <div id="post-body" class="metabox-holder columns-2">
                        <div style="" id="post-body-content" >
				<div class="icon32 icon32-posts-post" id="icon-edit">
					<br>
				</div>
				<h2>
					<?php echo __('Tabs','responsive-horizontal-vertical-and-accordion-tabs');?><a class="button add-new-h2" href="admin.php?page=rt_wp_responsive_tabs_management&action=addedit&tabid=<?php echo $tabid; ?>"><?php echo __('Add New','responsive-horizontal-vertical-and-accordion-tabs');?></a>
				</h2>
				<br />

				<form method="POST"
					action="admin.php?page=rt_wp_responsive_tabs_management&action=deleteselected&tabid=<?php echo $tabid; ?>"
					id="posts-filter" onkeypress="return event.keyCode != 13;">
					<div class="alignleft actions">
						<select name="action_upper" id="action_upper">
							<option selected="selected" value="-1"><?php echo __('Bulk Actions','responsive-horizontal-vertical-and-accordion-tabs');?></option>
							<option value="delete"><?php echo __('delete','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                        <option value="order_update"><?php echo __( 'Update Order','responsive-horizontal-vertical-and-accordion-tabs');?></option>
						</select> <input type="submit" value="<?php echo __('Apply','responsive-horizontal-vertical-and-accordion-tabs');?>"
							class="button-secondary action" id="deleteselected"
							name="deleteselected" onclick="return confirmDelete_bulk();">
					</div>
                                      <?php
                                        

                                             $setacrionpage="admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";

                                             if(isset($_GET['order_by']) and $_GET['order_by']!=""){
                                               $setacrionpage.='&order_by='.sanitize_text_field($_GET['order_by']);   
                                             }

                                             if(isset($_GET['order_pos']) and $_GET['order_pos']!=""){
                                              $setacrionpage.='&order_pos='.sanitize_text_field($_GET['order_pos']);   
                                             }

                                             $seval="";
                                             if(isset($_GET['search_term']) and $_GET['search_term']!=""){
                                              $seval=trim(sanitize_text_field($_GET['search_term']));   
                                             }

                                         ?>
					<br class="clear">
                                                    <?php
							global $wpdb;
                                                       
							
                                                        
                                                        $order_by='id';
                                                        $order_pos="asc";

                                                        if(isset($_GET['order_by']) and sanitize_sql_orderby($_GET['order_by'])!==false){

                                                           $order_by=trim($_GET['order_by']); 
                                                        }

                                                        if(isset($_GET['order_pos'])){

                                                           $order_pos=trim(sanitize_text_field($_GET['order_pos'])); 
                                                        }
                                                         $search_term='';
                                                        if(isset($_GET['search_term'])){

                                                           $search_term= sanitize_text_field(esc_sql($_GET['search_term']));
                                                        }
                                                        
                                                         $search_term_='';
                                                        if(isset($_GET['search_term'])){

                                                           $search_term_='&search_term='.urlencode(sanitize_text_field($_GET['search_term']));
                                                        }

                                                        
                                                        $query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs where gtab_id=$tabid ";
                                                        $queryCount = "SELECT count(*) FROM " . $wpdb->prefix . "wrt_tabs where gtab_id=$tabid ";
                                                        if($search_term!=''){
                                                           $query.=" and ( id like '%$search_term%' or tab_title like '%$search_term%' ) "; 
                                                           $queryCount.=" and ( id like '%$search_term%' or tab_title like '%$search_term%' ) "; 
                                                        }

                                                        $order_by=sanitize_text_field(sanitize_sql_orderby($order_by));
                                                        $order_pos=sanitize_text_field(sanitize_sql_orderby($order_pos));

                                                        $query.=" order by $order_by $order_pos";

                                                        $rowsCount=$wpdb->get_var($queryCount);
               
							?>
                                            
                                            <div style="padding-top:5px;padding-bottom:5px">
                                                <b><?php echo __( 'Search','responsive-horizontal-vertical-and-accordion-tabs');?> : </b>
                                                  <input type="text" value="<?php echo $seval;?>" id="search_term" name="search_term">&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Search','responsive-horizontal-vertical-and-accordion-tabs');?>' name='searchusrsubmit' class='button-primary' id='searchusrsubmit' onclick="SearchredirectTO();" >&nbsp;
                                                  <input type='button'  value='<?php echo __( 'Reset Search','responsive-horizontal-vertical-and-accordion-tabs');?>' name='searchreset' class='button-primary' id='searchreset' onclick="ResetSearch();" >
                                            </div>  
                                            <script type="text/javascript" >
                                                jQuery('#search_term').on("keyup", function(e) {
                                                       if (e.which == 13) {
                                                  
                                                           SearchredirectTO();
                                                       }
                                                  });   
                                             function SearchredirectTO(){
                                               var redirectto='<?php echo $setacrionpage; ?>';
                                               var searchval=jQuery('#search_term').val();
                                               redirectto=redirectto+'&search_term='+jQuery.trim(encodeURIComponent(searchval));  
                                               window.location.href=redirectto;
                                             }
                                            function ResetSearch(){

                                                 var redirectto='<?php echo $setacrionpage; ?>';
                                                 window.location.href=redirectto;
                                                 exit;
                                            }
                                            </script>            
                                             <div id="no-more-tables">
						<table cellspacing="0" id="gridTbl" class="table-bordered table-striped table-condensed cf wp-list-table widefat">
							<thead>
								<tr>
									<th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
									 <?php if($order_by=="id" and $order_pos=="asc"):?>
                                                                               
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Id','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <?php if($order_by=="id"):?>
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                                <?php else:?>
                                                                                    <th><a href="<?php echo $setacrionpage;?>&order_by=id&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Id','responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                                                <?php endif;?>    
                                                                            <?php endif;?>  
                                                                        
                                                                        <?php if($order_by=="tab_title" and $order_pos=="asc"):?>

                                                                             <th><a href="<?php echo $setacrionpage;?>&order_by=tab_title&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Title','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                        <?php else:?>
                                                                            <?php if($order_by=="tab_title"):?>
                                                                        <th><a href="<?php echo $setacrionpage;?>&order_by=tab_title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <th><a href="<?php echo $setacrionpage;?>&order_by=tab_title&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Title','responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                                            <?php endif;?>    
                                                                        <?php endif;?>  
									  <?php if($order_by=="morder" and $order_pos=="asc"):?>
                                                                               
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=morder&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Display Order','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <?php if($order_by=="morder"):?>
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=morder&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Display Order','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                                <?php else:?>
                                                                                    <th><a href="<?php echo $setacrionpage;?>&order_by=morder&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Display Order','responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                                                <?php endif;?>    
                                                                            <?php endif;?>  
								            
                                                                           
									  <?php if($order_by=="createdon" and $order_pos=="asc"):?>
                                                                               
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=desc<?php echo $search_term_;?>"><?php echo __('Published On','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/desc.png', __FILE__); ?>"/></a></th>
                                                                            <?php else:?>
                                                                                <?php if($order_by=="createdon"):?>
                                                                            <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','responsive-horizontal-vertical-and-accordion-tabs');?><img style="vertical-align:middle" src="<?php echo plugins_url('/images/asc.png', __FILE__); ?>"/></a></th>
                                                                                <?php else:?>
                                                                                    <th><a href="<?php echo $setacrionpage;?>&order_by=createdon&order_pos=asc<?php echo $search_term_;?>"><?php echo __('Published On','responsive-horizontal-vertical-and-accordion-tabs');?></a></th>
                                                                                <?php endif;?>    
                                                                            <?php endif;?>  
								                         
									
									<th><span><?php echo __('Edit','responsive-horizontal-vertical-and-accordion-tabs');?></span></th>
									<th><span><?php echo __('Delete','responsive-horizontal-vertical-and-accordion-tabs');?></span></th>
								</tr>
							</thead>

							<tbody id="the-list">
                                                            <?php
								if ($rowsCount > 0) {
									
									global $wp_rewrite;
									$rows_per_page = 15;
									
									$current = (isset($_GET ['paged'])) ? intval(sanitize_text_field($_GET ['paged'])) : 1;
									$pagination_args = array (
											'base' => @add_query_arg ( 'paged', '%#%' ),
											'format' => '',
											'total' => ceil ( $rowsCount / $rows_per_page ),
											'current' => $current,
											'show_all' => false,
											'type' => 'plain' 
									);
									
									$offset = ($current - 1) * $rows_per_page;
                                            
                                                                        $query.=" limit $offset, $rows_per_page";
                                                                        $rows = $wpdb->get_results ( $query,ARRAY_A);
                                                                        
									$delRecNonce = wp_create_nonce('delete_tab');
									foreach($rows as $row) {
										
										
										$id = intval($row ['id']);
										$editlink = "admin.php?page=rt_wp_responsive_tabs_management&action=addedit&id=$id&tabid=$tabid";
										$deletelink = "admin.php?page=rt_wp_responsive_tabs_management&action=delete&id=$id&nonce=$delRecNonce&tabid=$tabid";
										

										?>
                                                                        <tr valign="top">
                                                                            <td class="alignCenter check-column" data-title="Select Record"><input
                                                                                    type="checkbox" value="<?php echo $row['id'] ?>"
                                                                                    name="thumbnails[]"></td>
                                                                            <td data-title="<?php echo __('Id','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter"><?php echo intval($row['id']); ?></td>
                                                                            <td data-title="<?php echo __('Title','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter">
                                                                               <div>
                                                                                            <strong><?php echo esc_html($row['tab_title']); ?></strong>
                                                                                    </div>
                                                                            </td>
                                                                            
                                                                             <td data-title="<?php echo __('Display Order','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter">
                                                                                   <input name="order[<?php echo intval($row['id']);?>]" onclick="this.focus(); this.select()" style="width:80px" type="number" value="<?php echo intval($row['morder']); ?>" />
                                                                             </td>
                                                                            <td data-title="<?php echo __('Published On','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter"><?php echo esc_html($row['createdon']); ?></td>
                                                                            <td data-title="<?php echo __('Edit','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter"><strong><a href='<?php echo esc_url($editlink); ?>' title="<?php echo __('Edit','responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo __('Edit','responsive-horizontal-vertical-and-accordion-tabs');?></a></strong></td>
                                                                            <td data-title="<?php echo __('Delete','responsive-horizontal-vertical-and-accordion-tabs');?>" class="alignCenter"><strong><a href='<?php echo esc_url($deletelink); ?>' onclick="return confirmDelete();" title="<?php echo __('Delete','responsive-horizontal-vertical-and-accordion-tabs');?>"><?php echo __('Delete','responsive-horizontal-vertical-and-accordion-tabs');?></a> </strong></td>
                                                                    </tr>
                                                                    <?php
                                                                            }
                                                                    } else {
                                                                            ?>
                                                                    <tr valign="top" class=""
                                                                            id="">
                                                                            <td colspan="9" data-title="<?php echo __('No Records','responsive-horizontal-vertical-and-accordion-tabs');?>" align="center"><strong><?php echo __('No Tabs','responsive-horizontal-vertical-and-accordion-tabs');?></strong></td>
                                                                    </tr>
                                                                 <?php
								}
								?>      
                                                        </tbody>
						</table>
					</div>
                                         <?php
                                            if ($rowsCount > 0) {
                                                    echo "<div class='pagination' style='padding-top:10px'>";
                                                    echo paginate_links ( $pagination_args );
                                                    echo "</div>";
                                            }
                                            ?>
                                         <br />
					<div class="alignleft actions">
						<select name="action" id="action_bottom">
							<option selected="selected" value="-1"><?php echo __('Bulk Actions','responsive-horizontal-vertical-and-accordion-tabs');?></option>
							<option value="delete"><?php echo __('Delete','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                                                        <option value="order_update"><?php echo __( 'Update Order','responsive-horizontal-vertical-and-accordion-tabs');?></option>
						</select> 
                                               <?php wp_nonce_field('action_settings_mass_delete', 'mass_delete_nonce'); ?>
                                                <input type="submit" value="<?php echo __('Apply','responsive-horizontal-vertical-and-accordion-tabs');?>"
							class="button-secondary action" id="deleteselected"
							name="deleteselected" onclick="return confirmDelete_bulk();">
					</div>

				</form>
				<script type="text/JavaScript">

                                        function  confirmDelete_bulk(){
                                                        var topval=document.getElementById("action_bottom").value;
                                                        var bottomVal=document.getElementById("action_upper").value;

                                                        if(topval=='delete' || bottomVal=='delete'){


                                                            var agree=confirm("<?php echo __('Are you sure you want to delete selected tabs?','responsive-horizontal-vertical-and-accordion-tabs');?>");
                                                            if (agree)
                                                                return true ;
                                                            else
                                                                return false;
                                                        }
                                                 }

                                        function  confirmDelete(){
                                         var agree=confirm("<?php echo __('Are you sure you want to delete this tab?','responsive-horizontal-vertical-and-accordion-tabs');?>");
                                         if (agree)
                                             return true ;
                                        else
                                            return false;
                                        }
                             </script>
                        </div>
                        
                        <br class="clear">
			</div>
			<div style="clear: both;"></div>
                    <?php $url = plugin_dir_url(__FILE__); ?>


                </div>
		<h3><?php echo __('To print this tab sets into WordPress Post/Page use below code','responsive-horizontal-vertical-and-accordion-tabs');?></h3>
		<input type="text"
			value='[wrt_print_rt_wp_responsive_tabs tabset_id="<?php echo intval($tabid); ?>"] '
			style="width: 400px; height: 30px"
			onclick="this.focus(); this.select()" />
		<div class="clear"></div>
		<h3><?php echo __('To print this tab sets into WordPress theme/template PHP files use below code','responsive-horizontal-vertical-and-accordion-tabs');?></h3>
                <?php
		$shortcode = '[wrt_print_rt_wp_responsive_tabs tabset_id="'.intval($tabid).'"]';
		?>
                <input type="text"
			value="&lt;?php echo do_shortcode('<?php echo htmlentities($shortcode, ENT_QUOTES); ?>'); ?&gt;"
			style="width: 400px; height: 30px"
			onclick="this.focus(); this.select()" />
            </div>    
		<div class="clear"></div>
                
    <?php
                
	} else if (strtolower ( $action ) == strtolower ( 'addedit' )) {
		$url = plugin_dir_url ( __FILE__ );
		$vNonce = wp_create_nonce('vNonce');
		
                $tabid="0";
                if(isset($_GET['tabid']) and $_GET['tabid']!=""){
                 $tabid=intval(sanitize_text_field($_GET['tabid']));   
                }
		if (isset ( $_POST ['btnsave'] )) {
			
                       if (!check_admin_referer('action_image_add_edit', 'add_edit_image_nonce')) {

                            wp_die('Security check fail');
                        }
			
                        $tab_title = trim ( sanitize_text_field($_POST ['tab_title'] )) ;
                        if(isset($_POST ['fonto_icon'])){
                            
                            $fonto_icon = trim ( sanitize_text_field($_POST ['fonto_icon'] )) ;
                        }
                        else{
                            $fonto_icon = '';
                        }
                        $morder = trim ( intval(sanitize_text_field($_POST ['morder'] ))) ;
                        $link = trim(sanitize_text_field($_POST ['link'] ));
                        $is_default=0;
                        $is_link=0;
                        if(isset($_POST['is_default'])){
                            
                            $is_default=1;
                             $wpdb->update(
                           
                                $wpdb->prefix.'wrt_tabs',

                                array( 
                                        'is_default' => 0, 
                                  
                                    ),
                                   array( 
                                    'gtab_id' => $tabid,          // where clause(s)
                                   ), 
                                   array('%d'),
                                   array( 
                                       
                                        '%d'
                                    )
                                );
                            
                        }
                        
                        if(isset($_POST['is_link'])){
                            
                            $is_link=1;
                            
                        }
                       
                        
                        $tab_description = trim (wpautop($_POST ['tab_description'] )) ;
                        $createdOn = date ( 'Y-m-d h:i:s' );
                        if (function_exists ( 'date_i18n' )) {

                                $createdOn = date_i18n ( 'Y-m-d' . ' ' . get_option ( 'time_format' ), false, false );
                                if (get_option ( 'time_format' ) == 'H:i')
                                        $createdOn = date ( 'Y-m-d H:i:s', strtotime ( $createdOn ) );
                                else
                                        $createdOn = date ( 'Y-m-d h:i:s', strtotime ( $createdOn ) );
                            }
			
			   
			
			$location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
				// edit save
			if (isset ( $_POST ['tabid'] ) and intval($_POST ['tabid'])>0) {
				
                              if ( ! current_user_can( 'wrt_responsive_tabs_edit_tab' ) ) {

                                    $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                                    $wrt_responsive_tabs_msg=array();
                                    $wrt_responsive_tabs_msg['type']='err';
                                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                                    exit;   

                                }
                                
				try {
						
						$tabid=intval(sanitize_text_field($_POST ['tabid']));
						
                                                 
                                               
                                                 $wpdb->update(
                           
                                                    $wpdb->prefix.'wrt_tabs',
                                                         
                                                    array( 
                                                            'tab_title' => $tab_title, 
                                                            'fonto_icon'=>$fonto_icon,
                                                            'morder' => $morder,
                                                            'is_default'=> $is_default,
                                                            'tab_description'=>$tab_description,
                                                            'is_link'=>$is_link,
                                                            'link'=>$link
                                                            
                                                        ),
                                                       array( 
                                                        'id' => $tabid,          // where clause(s)
                                                       ), 
                                                       array( '%s','%s','%d','%d','%s','%d','%s' ),
                                                       array( 
                                                                '%d'
                                                        )
                                                    );
							
                                                 
							
                                                $wrt_responsive_tabs_msg = array ();
						$wrt_responsive_tabs_msg ['type'] = 'succ';
						$wrt_responsive_tabs_msg ['message'] = __('Tab updated successfully.','responsive-horizontal-vertical-and-accordion-tabs');
						update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
                                                
					} catch ( Exception $e ) {
							
						$wrt_responsive_tabs_msg = array ();
                                                $wrt_responsive_tabs_msg ['type'] = 'err';
                                                $wrt_responsive_tabs_msg ['message'] = __('Error while updating tab','responsive-horizontal-vertical-and-accordion-tabs');
                                                 update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
				     }

				
				
			} else {
				
                                  if ( ! current_user_can( 'wrt_responsive_tabs_add_tab' ) ) {

                                        $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                                        $wrt_responsive_tabs_msg=array();
                                        $wrt_responsive_tabs_msg['type']='err';
                                        $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                                        update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                                        exit;   

                                    }
                 
                                    $createdOn = date ( 'Y-m-d h:i:s' );
                                    if (function_exists ( 'date_i18n' )) {

                                            $createdOn = date_i18n ( 'Y-m-d' . ' ' . get_option ( 'time_format' ), false, false );
                                            if (get_option ( 'time_format' ) == 'H:i')
                                                    $createdOn = date ( 'Y-m-d H:i:s', strtotime ( $createdOn ) );
                                            else
                                                    $createdOn = date ( 'Y-m-d h:i:s', strtotime ( $createdOn ) );
                                    }

                                    try {
					
					   $wpdb->insert(
                                                $wpdb->prefix."wrt_tabs",
                                                array( 'tab_title' => $tab_title,'fonto_icon'=>$fonto_icon, 'morder' => $morder,'is_default'=> $is_default,'tab_description'=>$tab_description,'createdon'=>$createdOn,'gtab_id'=>$tabid,'is_link'=>$is_link,'link'=>$link),
                                                array( '%s', '%s','%d','%d','%s','%s' ,'%d','%d','%s')
                                            );
                                        
                                        
					
					$wrt_responsive_tabs_msg = array ();
					$wrt_responsive_tabs_msg ['type'] = 'succ';
					$wrt_responsive_tabs_msg ['message'] = __('New tab added successfully.','responsive-horizontal-vertical-and-accordion-tabs');
					
                                        update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
                                        
				} catch ( Exception $e ) {
					
					$wrt_responsive_tabs_msg = array ();
					$wrt_responsive_tabs_msg ['type'] = 'err';
					$wrt_responsive_tabs_msg ['message'] = __('Error while adding tab','responsive-horizontal-vertical-and-accordion-tabs');
					update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
				}
				
				
			}
                       
                          
                       
                   
                   

                    
                    echo "<script type='text/javascript'> location.href='$location';</script>";
                    exit ();
                   
                   
		} else {
			
			$uploads = wp_upload_dir ();
			$baseurl = $uploads ['baseurl'];
			$baseurl .= '/responsive-horizontal-vertical-and-accordion-tabs/';
			?>
         <div style="float: left; width: 100%;">
	       <div class="wrap">
                
                
	    	<?php
		    	if (isset ( $_GET ['id'] ) and intval($_GET ['id']) > 0) {
				
                            
                              if ( ! current_user_can( 'wrt_responsive_tabs_edit_tab' ) ) {

                                    $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                                    $wrt_responsive_tabs_msg=array();
                                    $wrt_responsive_tabs_msg['type']='err';
                                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                                    exit;   

                                }
                                
				$id = intval(sanitize_text_field($_GET ['id']));
				$query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs WHERE gtab_id=$tabid and id=$id";
				
				$myrow = $wpdb->get_row ( $query );
				
				if (is_object ( $myrow )) {
				
                
					$title =  wp_unslash(esc_html($myrow->tab_title));
					$fonto_icon =  wp_unslash(esc_html($myrow->fonto_icon));
					$tab_description = wp_unslash($myrow->tab_description);
					$gtab_id = sanitize_text_field($myrow->gtab_id);
                                        $is_default=esc_html($myrow->is_default);
                                        $is_link=esc_html($myrow->is_link);
                                        $link=esc_html($myrow->link);
                                        $morder=esc_html($myrow->morder);
                                        
					
					
					
				}
				?>
	         <h2><?php echo __('Update Tab','responsive-horizontal-vertical-and-accordion-tabs');?></h2><?php
			} else {
				
                            
                                 if ( ! current_user_can( 'wrt_responsive_tabs_add_tab' ) ) {

                                        $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                                        $wrt_responsive_tabs_msg=array();
                                        $wrt_responsive_tabs_msg['type']='err';
                                        $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                                        update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                                        echo "<script type='text/javascript'> location.href='$location';</script>";     
                                        exit;   

                                    }
                                    
				$title = '';
                                $tab_description = '';
                                $morder='';
                                $is_default=0;
                                $fonto_icon='';
                                $is_link=0;
                                $link='';
                               
                                
				?>
                 <h2><?php echo __('Add Tab','responsive-horizontal-vertical-and-accordion-tabs');?></h2>
                   <?php } ?>
                   <br />
					<div id="poststuff">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="post-body-content">
                                                            
                                                                    
                                                                   <form method="post" action="" id="addimage_" name="addimage_" enctype="multipart/form-data" >
                                                                    
                                                                        <div class="stuffbox" id="namediv" style="width: 100%">
										<h3>
											<label for="link_name"><?php echo __('Tab Title','responsive-horizontal-vertical-and-accordion-tabs');?> 
											</label>
										</h3>
										<div class="inside">
											<div>
												<input type="text" id="title" size="30" name="tab_title" value="<?php echo $title; ?>">
											</div>
											<div style="clear: both"></div>
											<div></div>
											<div style="clear: both"></div>
										</div>
									</div>
									<div class="stuffbox" id="namediv" style="width: 100%">
										<h3>
											<label for="link_name"> <?php echo __('Font Awesome Icon','responsive-horizontal-vertical-and-accordion-tabs');?> 
											</label>
										</h3>
										<div class="inside">
											<div>
                                                                                           <select name="fonto_icon" id="fonto_icon"></select>
											</div>
											<div style="clear: both"></div>
											<div></div>
											<div style="clear: both"></div>

										</div>
									</div>
                                                                       
									<div class="stuffbox" id="namediv" style="width: 100%">
										<h3>
											<label for="link_name"> <?php echo __('Tab Order','responsive-horizontal-vertical-and-accordion-tabs');?> 
											</label>
										</h3>
										<div class="inside">
											<div>
												<input type="text" id="morder" size="30"
													name="morder" value="<?php echo $morder; ?>"
													style="width: 50px;">
											</div>
											<div style="clear: both"></div>
											<div></div>
											<div style="clear: both"></div>

										</div>
									</div>
                                                                        
                                                                       
                                                                       <div class="stuffbox cont_editor" id="namediv" style="width:100%" >
                                                                            <h3><label for="link_name"><?php echo __('Tab Content','responsive-horizontal-vertical-and-accordion-tabs'); ?></label></h3>
                                                                            <div class="inside">
                                                                                <?php wp_editor( $tab_description, 'tab_description' );?>
                                                                                <div>
                                                                                <input type="hidden" name="editor_val" id="editor_val" />
                                                                                </div>
                                                                                <div style="clear: both;"></div><div></div>
                                                                                <div></div>
                                                                                <div style="clear:both"></div>
                                                                               
                                                                            </div>
                                                                        </div>
                                                                       <div class="stuffbox" id="namediv" style="width: 100%">
                                                                                <h3>
                                                                                        <label for="is_default"><?php echo __('Is Default Selected Tab?','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                                                        </label>
                                                                                </h3>
                                                                                <div class="inside">
                                                                                        <div>
                                                                                                  <input type="checkbox" id="is_default" size="30" name="is_default" value="" <?php if($is_default==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __('Is Default Selected Tab?','responsive-horizontal-vertical-and-accordion-tabs');?>  

                                                                                        </div>
                                                                                        <div style="clear: both"></div>
                                                                                        <div></div>
                                                                                        <div style="clear: both"></div>
                                                                                </div>
                                                                        </div>
									<div class="stuffbox" id="namediv" style="width: 100%">
                                                                                <h3>
                                                                                        <label for="is_link"><?php echo __('Is External Link','responsive-horizontal-vertical-and-accordion-tabs');?> 
                                                                                        </label>
                                                                                </h3>
                                                                                <div class="inside">
                                                                                        <div>
                                                                                                  <input type="checkbox" id="is_link" size="30" name="is_link" value="" <?php if($is_link==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;<?php echo __('Redirect on click to tab','responsive-horizontal-vertical-and-accordion-tabs');?>  

                                                                                        </div>
                                                                                        <div style="clear: both"></div>
                                                                                        <div></div>
                                                                                        <div style="clear: both"></div>
                                                                                </div>
                                                                        </div>
                                                                       <div class="stuffbox" id="namediv" style="width: 100%">
										<h3>
											<label for="link"><?php echo __('Redirection Link','responsive-horizontal-vertical-and-accordion-tabs');?> 
											</label>
										</h3>
										<div class="inside">
											<div>
												<input type="text" id="link"  name="link" value="<?php echo $link; ?>">
											</div>
											<div style="clear: both"></div>
											<div></div>
											<div style="clear: both"></div>
										</div>
									</div>
                                                                        <?php if (isset($_GET['id']) and intval(sanitize_text_field($_GET['id'])) > 0) { ?> 
										 <input type="hidden" name="tabid" id="tabid" value="<?php echo intval(sanitize_text_field($_GET['id'])); ?>">
                                                                         <?php
										}
										?>
                                                                            <?php wp_nonce_field('action_image_add_edit', 'add_edit_image_nonce'); ?>      
                                                                            <input type="submit"
										onclick="" name="btnsave" id="btnsave" value="<?php echo __('Save Changes','responsive-horizontal-vertical-and-accordion-tabs');?>"
										class="button-primary">&nbsp;&nbsp;<input type="button"
										name="cancle" id="cancle" value="<?php echo __('Cancel','responsive-horizontal-vertical-and-accordion-tabs');?>"
										class="button-primary"
										onclick="location.href = 'admin.php?page=rt_wp_responsive_tabs_management&tabid=<?php echo $tabid;?>'">

								</form>
                                                                   
								<script type="text/javascript">

                                                                    var  icons=["fa-asymmetrik","fa-audible","fa-avianex","fa-aws","fa-bimobject","fa-bity","fa-blackberry","fa-blogger","fa-blogger-b","fa-buromobelexperte","fa-cc-amazon-pay","fa-buromobelexperte","fa-centercode","fa-cloudscale","fa-cloudsmith","fa-cloudversify","fa-cpanel","fa-creative-commons-by","fa-creative-commons-nc","fa-creative-commons-nc-eu","fa-creative-commons-nc-jp","fa-creative-commons-nd","fa-creative-commons-pd","fa-creative-commons-pd-alt","fa-creative-commons-remix","fa-creative-commons-sa","fa-creative-commons-sampling","fa-creative-commons-sampling-plus","fa-creative-commons-share","fa-css3-alt","fa-cuttlefish","fa-d-and-d","fa-deploydog","fa-deskpro","fa-digital-ocean","fa-discord","fa-dochub","fa-docker","fa-draft2digital","fa-dribbble-square","fa-dyalog","fa-earlybirds","fa-ebay","fa-elementor","fa-ello",
                                                                                    "fa-erlang","fa-ethereum","fa-facebook-messenger","fa-first-order-alt","fa-firstdraft","fa-flipboard","fa-font-awesome-alt","fa-font-awesome-logo-full","fa-fonticons-fi","fa-fort-awesome-alt","fa-freebsd","fa-fulcrum","fa-galactic-republic","fa-galactic-senate","fa-gitkraken","fa-gofore","fa-goodreads","fa-goodreads-g","fa-google-drive","fa-google-play","fa-google-plus-g","fa-gripfire","fa-grunt","fa-gulp","fa-hacker-news-square","fa-hackerrank","fa-hips","fa-hire-a-helper","fa-hooli","fa-hornbill",
                                                                                    "fa-hotjar","fa-hubspot","fa-itunes","fa-itunes-note","fa-java","fa-jedi-order","fa-jenkins","fa-joget","fa-js","fa-js-square","fa-kaggle","fa-keybase","fa-keycdn","fa-kickstarter","fa-kickstarter-k","fa-korvue","fa-laravel","fa-linkedin-in","fa-lyft","fa-magento","fa-mailchimp","fa-mandalorian","fa-markdown","fa-mastodon","fa-medium-m",
                                                                                    "fa-medrt","fa-megaport","fa-microsoft","fa-mix","fa-mizuni","fa-monero","fa-napster","fa-neos","fa-nimblr","fa-node-js","fa-npm","fa-ns8","fa-nutritionix","fa-old-republic","fa-page4","fa-palfed","fa-patreon","fa-periscope","fa-phabricator","fa-phoenix-framework","fa-phoenix-squadron","fa-php","fa-pied-piper-hat","fa-playstation","fa-pushed","fa-python","fa-quinscape","fa-r-project","fa-readme","fa-rendact","fa-replyd","fa-researchgate","fa-resolving","fa-rev","fa-rocketchat","fa-rockrms","fa-schlix","fa-searchengin","fa-sellcast","fa-servicestack","fa-shopware","fa-sistrix","fa-sith","fa-slack-hash","fa-speakap","fa-steam-symbol","fa-sticker-mule",
                                                                                    "fa-stripe","fa-stripe-s","fa-studiovinari","fa-supple","fa-teamspeak","fa-telegram-plane","fa-the-red-yeti","fa-themeco","fa-trade-federation","fa-typo3","fa-vimeo-v","fa-weebly","fa-wix","fa-wolf-pack-battalion","fa-zhihu",
                                                                                    "fa-angrycreative","fa-app-store","fa-app-store-ios","fa-apper","fa-staylinked","fa-squarespace","fa-red-river","fa-medapps","fa-line","fa-discourse","fa-amazon-pay",
                                                                                    "fa-amilia","fa-alipay","fa-affiliatetheme","fa-algolia","fa-adversal","fa-accusoft","fa-accessible-icon"];

                                                                    
                                                                    (function(jQuery) {
                                                                        jQuery(function() {
                                                                            var fonts = <?php echo file_get_contents(plugin_dir_path( __FILE__ ).'/js/font-o.json');?>

                                                                            function formatIcon (font) {
                                                                              if (!font.id) { return font.text; }
                                                                              
                                                                                if(jQuery.inArray(font.id,icons)!='-1'){
                                                                                   
                                                                                   ic=  '<i class=" fab fa-2x '+ font.id+' "></i>  ';
                                                                                   
                                                                               }   
                                                                               else{
                                                                                   
                                                                                     ic=  '<i  class=" fa far fas fa-2x '+ font.id+' "></i>  ';
                                                                               }  
                                                                              var $fonthmlt = jQuery(
                                                                                      
                                                                                ic +
                                                                                '<span class="flag-text">'+ font.text+"</span>"
                                                                              );
                                                                              return $fonthmlt;
                                                                            };

                                                                            //Assuming you have a select element with name country
                                                                            // e.g. <select name="name"></select>

                                                                            jQuery("[name='fonto_icon']").select2({
                                                                                placeholder: "Select icon",
                                                                                templateResult: formatIcon,
                                                                                data: fonts
                                                                            });
            
            
                                                                                });
                                                                        })(jQuery);       
                                                                        
                                                                     
                                                                    
                                                                    jQuery("#is_link").change(function() {
                                                                        if(this.checked) {
                                                                            
                                                                            if(jQuery('#is_default').prop('checked')){
                                                                                
                                                                                alert("<?php echo __('Default tab can not be a link','responsive-horizontal-vertical-and-accordion-tabs');?>")
                                                                                jQuery('#is_link').prop('checked',false);
                                                                            }
                                                                            
                                                                        }
                                                                    });

                                                                    jQuery(document).ready(function() {

                                                                        jQuery('#fonto_icon').val('<?php echo $fonto_icon;?>').trigger('change');
                                                                       // jQuery('#fonto_icon').select2().select2('val','<?php echo $fonto_icon;?>');

                                                                        jQuery.validator.setDefaults({ 
                                                                            ignore: [],
                                                                            // any other default options and/or rules
                                                                        });
                                                                        jQuery.validator.addMethod("chkCont", function(value, element) {
                                            
                                                                                var editorcontent=tinyMCE.get('tab_description').getContent();

                                                                                if (editorcontent.length){
                                                                                  return true;
                                                                                }
                                                                                else{
                                                                                   return false;
                                                                                }


                                                                          },
                                                                               "Please enter tab content"
                                                                          );
                                                                     
                                                                         
                                                                         
                                                                           jQuery("#addimage_").validate({
                                                                            rules: {
                                                                             tab_title:{
                                                                               required:true  
                                                                             },
                                                                             
                                                                             morder:{
                                                                                digits:true,
                                                                                maxlength:15
                                                                             }
                                                                             
                                                                             
                                                                            },
                                                                             errorClass: "image_error",
                                                                             errorPlacement: function(error, element) {
                                                                             error.appendTo(element.parent().next().next());
                                                                             }
                                                                         })
                                                                           
                                                                           
                                                                         
                                                                     });
                                                                     
                                                                   
                                                                 </script>

							</div>
                                                        
						</div>
					</div>
				</div>
			</div>
<?php
		}
	} else if (strtolower ( $action ) == strtolower ( 'delete' )) {
		
             $retrieved_nonce = '';

              if(isset($_GET['nonce']) and $_GET['nonce']!=''){

                  $retrieved_nonce=$_GET['nonce'];

              }
              $tabid='';
              if(isset($_GET['tabid']) and $_GET['tabid']!=''){

                  $tabid=intval($_GET['tabid']);

              }
              if (!wp_verify_nonce($retrieved_nonce, 'delete_tab' ) ){


                  wp_die('Security check fail'); 
              }

		 if ( ! current_user_can( 'wrt_responsive_tabs_delete_tab' ) ) {

                    $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                    $wrt_responsive_tabs_msg=array();
                    $wrt_responsive_tabs_msg['type']='err';
                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                }
		
		
		$location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
		$deleteId = (int) intval(sanitize_text_field($_GET ['id']));
		
		try {
			
			$query = "SELECT * FROM " . $wpdb->prefix . "wrt_tabs WHERE id=$deleteId ";
			$myrow = $wpdb->get_row ( $query );
			
			if (is_object ( $myrow )) {
				
                                $wpdb->delete($wpdb->prefix . "wrt_tabs", array('id' => $deleteId), array('%d'));
                                
				$wrt_responsive_tabs_msg = array ();
				$wrt_responsive_tabs_msg ['type'] = 'succ';
				$wrt_responsive_tabs_msg ['message'] =  __('Tab deleted successfully.','responsive-horizontal-vertical-and-accordion-tabs');
				update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
			}
		} catch ( Exception $e ) {
			
			$wrt_responsive_tabs_msg = array ();
			$wrt_responsive_tabs_msg ['type'] = 'err';
			$wrt_responsive_tabs_msg ['message'] =  __('Error while deleting tab.','responsive-horizontal-vertical-and-accordion-tabs');
			update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
		}
		
		echo "<script type='text/javascript'> location.href='$location';</script>";
		exit ();
	} 
        else if (strtolower ( $action ) == strtolower ( 'deleteselected' )) {
		
                if(!check_admin_referer('action_settings_mass_delete','mass_delete_nonce')){

                        wp_die('Security check fail'); 
                  }

		$tabid='';
               if(isset($_GET['tabid']) and $_GET['tabid']!=''){

                  $tabid=intval($_GET['tabid']);

               }
              
               if ( ! current_user_can( 'wrt_responsive_tabs_delete_tab' ) ) {

                    $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                    $wrt_responsive_tabs_msg=array();
                    $wrt_responsive_tabs_msg['type']='err';
                    $wrt_responsive_tabs_msg['message']=__('Access Denied. Please contact your administrator.','responsive-horizontal-vertical-and-accordion-tabs');
                    update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                    echo "<script type='text/javascript'> location.href='$location';</script>";     
                    exit;   

                }
		$location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
		
                if (isset($_POST) and isset($_POST ['deleteselected']) and ( $_POST ['action'] == 'order_update' or $_POST ['action_upper'] == 'order_update')) {
                    
                         if ( ! current_user_can( 'wrt_responsive_tabs_edit_tab' ) ) {

                            $location = "admin.php?page=rt_wp_responsive_tabs_management&tabid=$tabid";
                            $wrt_responsive_tabs_msg = array ();
                            $wrt_responsive_tabs_msg ['type'] = 'err';
                            $wrt_responsive_tabs_msg ['message'] = __('Access Denied. Please contact your administrator','responsive-horizontal-vertical-and-accordion-tabs');
                            update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
                            echo "<script type='text/javascript'> location.href='$location';</script>";
                            exit (); 


                        }
                        if(isset($_POST['order']) and sizeof($_POST['order'])){
                            
                            global $wpdb;
                            foreach($_POST['order'] as $k=>$v){
                                
                                $k=intval($k);
                                $v=intval($v);
                             
                               $wpdb->update(
                           
                                $wpdb->prefix.'wrt_tabs',

                                array( 
                                        'morder' => $v, 
                                  
                                    ),
                                   array( 
                                    'id' => $k,          // where clause(s)
                                   ), 
                                   array('%d'),
                                   array( 
                                       
                                        '%d'
                                    )
                                );
                                 
                          

                                
                            }
                            
                            $wrt_responsive_tabs_msg = array();
                            $wrt_responsive_tabs_msg ['type'] = 'succ';
                            $wrt_responsive_tabs_msg ['message'] = __('Tabs order updated successfully.','responsive-horizontal-vertical-and-accordion-tabs');
                            update_option('wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg);
                            
                        }
                        

                        echo "<script type='text/javascript'> location.href='$location';</script>";
                        exit();
                        
                    }
                    else if (isset ( $_POST ) and isset ( $_POST ['deleteselected'] ) and (sanitize_text_field($_POST ['action']) == 'delete' or sanitize_text_field($_POST ['action_upper']) == 'delete')) {
			
				
			if (sizeof ( $_POST ['thumbnails'] ) > 0) {
				
                                
				$deleteto = $_POST ['thumbnails'];
				
				try {
					
					foreach ( $deleteto as $tab ) {
						
                                                $tab=intval($tab);
                                                
                                                $wpdb->delete($wpdb->prefix . "wrt_tabs", array('id' => $tab), array('%d'));
                                                $wrt_responsive_tabs_msg = array ();
                                                $wrt_responsive_tabs_msg ['type'] = 'succ';
                                                $wrt_responsive_tabs_msg ['message'] = __('selected tabs deleted successfully.','responsive-horizontal-vertical-and-accordion-tabs');
                                                update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
						
					}
                                        
				} catch ( Exception $e ) {
					
					$wrt_responsive_tabs_msg = array ();
					$wrt_responsive_tabs_msg ['type'] = 'err';
					$wrt_responsive_tabs_msg ['message'] = __('Error while deleting tabs.','responsive-horizontal-vertical-and-accordion-tabs');
					update_option ( 'wrt_responsive_tabs_msg', $wrt_responsive_tabs_msg );
				}
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			} else {
				
				echo "<script type='text/javascript'> location.href='$location';</script>";
				exit ();
			}
		} else {
			
			echo "<script type='text/javascript'> location.href='$location';</script>";
			exit ();
		}
	}
}

function wrt_rt_wp_responsive_tabs_preview_func(){

           global $wpdb;
           $query="SELECT * FROM ".$wpdb->prefix."wrt_tabs_settings order by createdon desc";
           $rows=$wpdb->get_results($query,'ARRAY_A');
        
           $tabid=0;
           if(isset($_GET['tabid']) and $_GET['tabid']>0){
              $tabid=(int)(trim($_GET['tabid']));
            }
           
           $query="SELECT * FROM ".$wpdb->prefix."wrt_tabs WHERE gtab_id=$tabid";
           $settings  = $wpdb->get_row($query,ARRAY_A);            
           
           $rand_Numb=uniqid('psc_thumnail_slider');
           $rand_Num_td=uniqid('psc_divSliderMain');
           $rand_var_name=uniqid('rand_');
      
           $location="admin.php?page=rt_wp_responsive_tabs_preview&tabid=";                  
           
           //$wpcurrentdir=dirname(__FILE__);
           //$wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
           //$settings=get_option('thumbnail_slider_settings');    
           
    
                                      
           
     ?>     
       <div style="width: 100%;">  
            <div style="float:left;width:100%;">
                <div class="wrap">
                        <h2><?php __('Tabs Preview','responsive-horizontal-vertical-and-accordion-tabs');?></h2>
                <br/>
                <b><?php echo __( 'Select Tab Set','responsive-horizontal-vertical-and-accordion-tabs');?>:</b>
                <select name="tabs" id="tabs" onchange="location.href='<?php echo $location;?>'+this.value">
                <option value="" ><?php echo __('Select','responsive-horizontal-vertical-and-accordion-tabs');?></option>
                    <?php foreach($rows as $row){?>
                       <option <?php if($tabid==$row['id']){?>selected="selected" <?php } ?>  value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                    <?php }?>
                </select>
                <?php if(is_array($settings)){?>
                <div id="poststuff">
                  <div id="post-body" class="metabox-holder ">
                    
                      <?php echo wrt_print_rt_wp_responsive_tabs_func(array('tabset_id'=>$tabid));?> 
                      
                </div>                                      
                <div class="clear"></div>
                </div>
                <?php if(is_array($settings)){?>

                    <h3><?php echo __( 'To print this tab sets into WordPress Post/Page use below code','responsive-horizontal-vertical-and-accordion-tabs');?></h3>
                    <input type="text" value='[wrt_print_rt_wp_responsive_tabs tabset_id="<?php echo $tabid;?>"] ' style="width: 400px;height: 30px" onclick="this.focus();this.select()" />
                    <div class="clear"></div>
                    <h3><?php echo __( 'To print this tab sets into WordPress theme/template PHP files use below code','responsive-horizontal-vertical-and-accordion-tabs');?></h3>
                    <?php
                        $shortcode='[wrt_print_rt_wp_responsive_tabs tabset_id="'.$tabid.'"]';
                    ?>
                    <input type="text" value="&lt;?php echo do_shortcode('<?php echo htmlentities($shortcode, ENT_QUOTES); ?>'); ?&gt;" style="width: 400px;height: 30px" onclick="this.focus();this.select()" />

                <?php } ?>
                <div class="clear"></div>
             </div>  
            </div>
       </div>  
    <?php                
      }
    
}
    
function wrt_print_rt_wp_responsive_tabs_func($atts){

        global $wpdb;
        extract(shortcode_atts(array('tabset_id' => 0,), $atts));
        $query="SELECT * FROM ".$wpdb->prefix."wrt_tabs_settings WHERE id=$tabset_id";
        $settings  = $wpdb->get_row($query,ARRAY_A);            
        
        $rand2=uniqid('wrt_');
        $default='';
        $loaderImg=plugins_url( 'images/bx_loader.gif', __FILE__ ); 
        $vNonce = wp_create_nonce('vNonce');
        
        wp_enqueue_style ( 'wrt_bootstrap-nv-only.min' );
        wp_enqueue_style ( 'wrt_easy-responsive-tabs' );
        wp_enqueue_style ( 'wrt_jquery.scrolling-tabs' );
        wp_enqueue_style( 'wrt_fontawesome-all.min');
        wp_enqueue_style( 'wrt_v4-shims.min' );
        wp_enqueue_style( 'wrt_brands.min');

        wp_enqueue_script('jquery'); 
        wp_enqueue_script ( 'wrt_bootstrap-nva-only.min');
        wp_enqueue_script ( 'wrt_jquery.easyResponsiveTabs' );
        wp_enqueue_script ( 'wrt_jquery.scrolling-tabs' );

        ob_start();
        $flag=false;
        $li_tab_class=uniqid('li_');
        $defaultSelected=null;
        $font_os_brands=["fa-asymmetrik","fa-audible","fa-avianex","fa-aws","fa-bimobject","fa-bity","fa-blackberry","fa-blogger","fa-blogger-b","fa-buromobelexperte","fa-cc-amazon-pay","fa-buromobelexperte","fa-centercode","fa-cloudscale","fa-cloudsmith","fa-cloudversify","fa-cpanel","fa-creative-commons-by","fa-creative-commons-nc","fa-creative-commons-nc-eu","fa-creative-commons-nc-jp","fa-creative-commons-nd","fa-creative-commons-pd","fa-creative-commons-pd-alt","fa-creative-commons-remix","fa-creative-commons-sa","fa-creative-commons-sampling","fa-creative-commons-sampling-plus","fa-creative-commons-share","fa-css3-alt","fa-cuttlefish","fa-d-and-d","fa-deploydog","fa-deskpro","fa-digital-ocean","fa-discord","fa-dochub","fa-docker","fa-draft2digital","fa-dribbble-square","fa-dyalog","fa-earlybirds","fa-ebay","fa-elementor","fa-ello",
                        "fa-erlang","fa-ethereum","fa-facebook-messenger","fa-first-order-alt","fa-firstdraft","fa-flipboard","fa-font-awesome-alt","fa-font-awesome-logo-full","fa-fonticons-fi","fa-fort-awesome-alt","fa-freebsd","fa-fulcrum","fa-galactic-republic","fa-galactic-senate","fa-gitkraken","fa-gofore","fa-goodreads","fa-goodreads-g","fa-google-drive","fa-google-play","fa-google-plus-g","fa-gripfire","fa-grunt","fa-gulp","fa-hacker-news-square","fa-hackerrank","fa-hips","fa-hire-a-helper","fa-hooli","fa-hornbill",
                        "fa-hotjar","fa-hubspot","fa-itunes","fa-itunes-note","fa-java","fa-jedi-order","fa-jenkins","fa-joget","fa-js","fa-js-square","fa-kaggle","fa-keybase","fa-keycdn","fa-kickstarter","fa-kickstarter-k","fa-korvue","fa-laravel","fa-linkedin-in","fa-lyft","fa-magento","fa-mailchimp","fa-mandalorian","fa-markdown","fa-mastodon","fa-medium-m",
                        "fa-medrt","fa-megaport","fa-microsoft","fa-mix","fa-mizuni","fa-monero","fa-napster","fa-neos","fa-nimblr","fa-node-js","fa-npm","fa-ns8","fa-nutritionix","fa-old-republic","fa-page4","fa-palfed","fa-patreon","fa-periscope","fa-phabricator","fa-phoenix-framework","fa-phoenix-squadron","fa-php","fa-pied-piper-hat","fa-playstation","fa-pushed","fa-python","fa-quinscape","fa-r-project","fa-readme","fa-rendact","fa-replyd","fa-researchgate","fa-resolving","fa-rev","fa-rocketchat","fa-rockrms","fa-schlix","fa-searchengin","fa-sellcast","fa-servicestack","fa-shopware","fa-sistrix","fa-sith","fa-slack-hash","fa-speakap","fa-steam-symbol","fa-sticker-mule",
                        "fa-stripe","fa-stripe-s","fa-studiovinari","fa-supple","fa-teamspeak","fa-telegram-plane","fa-the-red-yeti","fa-themeco","fa-trade-federation","fa-typo3","fa-vimeo-v","fa-weebly","fa-wix","fa-wolf-pack-battalion","fa-zhihu",
                        "fa-angrycreative","fa-app-store","fa-app-store-ios","fa-apper","fa-staylinked","fa-squarespace","fa-red-river","fa-medapps","fa-line","fa-discourse","fa-amazon-pay",
                        "fa-amilia","fa-alipay","fa-affiliatetheme","fa-algolia","fa-adversal","fa-accusoft","fa-accessible-icon"];
        ?>
       <?php if(is_array($settings) and sizeof($settings)>0):?>
                
            <?php  $rand='tab_set'.$settings['id'];?>    
            <?php $type=$settings['type'];?>
                
            <?php if($type==2 or $type==5):?>

               <!-- wrt_print_rt_wp_responsive_tabs_func --><!-- wrt_print_rt_wp_responsive_tabs_style --><style>

                    .<?php echo $rand;?> .vresp-tabs-list{margin-left: 0px}
                    .<?php echo $rand;?> a{box-shadow:none;border-bottom:none}
                    .<?php echo $rand;?> h2heading.resp-tab-active span.resp-arrow{border-bottom:12px solid <?php echo $settings['tab_a_fcolor'];?>}
                    .<?php echo $rand;?> .vresp-tab-active span.resp-arrow{border-bottom:12px solid <?php echo $settings['tab_a_fcolor'];?>}
                    .<?php echo $rand;?> .resp-arrow{border-top:12px solid <?php echo $settings['tab_fcolor'];?>}
                    .<?php echo $rand;?> .resp-tab-content{color:<?php echo $settings['tab_ccolor'];?>;border:1px solid  <?php echo $settings['ac_border_color'];?>}
                    .<?php echo $rand;?> .vresp-tab-item{color:<?php echo $settings['tab_fcolor'];?>;background-color: <?php echo $settings['inactive_bg'];?>;}
                    .<?php echo $rand;?> .vresp-tab-content{color:<?php echo $settings['tab_ccolor'];?>;border-color: <?php echo $settings['ac_border_color'];?>}
                    .<?php echo $rand;?> .vresp-tabs-container{background-color: <?php echo $settings['activetab_bg'];?>}
                    .<?php echo $rand;?> .vresp-tabs-container h2heading{}
                    .<?php echo $rand;?> .vresp-tab-active{color:<?php echo $settings['tab_fcolor'];?>;border-color:1px solid  <?php echo $settings['ac_border_color'];?>;margin-right:-1px;margin-top:2px; border-right:none !important}
                    .<?php echo $rand;?> .resp-accordion.vresp-tab-active{color:<?php echo $settings['tab_fcolor'];?>;border-color:1px solid  <?php echo $settings['ac_border_color'];?>;margin-right:0px;margin-top:0px; }

                    .<?php echo $rand;?> .vresp-tab-content-active{color:<?php echo $settings['tab_ccolor'];?>;background-color:<?php echo $settings['activetab_bg'];?> }
                    .<?php echo $rand2;?> .resp-accordion{color:<?php echo $settings['tab_fcolor'];?>;}
                    .<?php echo $rand2;?> .resp-accordion.vresp-tab-active{color:<?php echo $settings['tab_fcolor'];?>;border-right:1px solid  <?php echo $settings['ac_border_color'];?> !important }
                     .<?php echo $rand;?> .vresp-tab-item:hover{color:<?php echo $settings['tab_a_fcolor'];?>;background-color: <?php echo $settings['activetab_bg'];?>;border-left:4px solid  <?php echo $settings['ac_border_color'];?> !important ;border-top:1px solid  <?php echo $settings['ac_border_color'];?>;border-bottom:1px solid  <?php echo $settings['ac_border_color'];?>;padding:14px 14px;transition:none}
                     .<?php echo $rand;?> .vresp-tab-active{color:<?php echo $settings['tab_a_fcolor'];?>;background-color: <?php echo $settings['activetab_bg'];?>}
                     
                    @media only screen and (max-width: 768px) {
                        
                        .<?php echo $rand;?>  h2heading{background-color: <?php echo $settings['inactive_bg'];?>}
                        .<?php echo $rand;?> .vresp-tabs-container{background-color:unset }
                        .<?php echo $rand;?> .resp-accordion.vresp-tab-active{
                            
                           background-color: <?php echo $settings['activetab_bg'];?> ;
                            border-top:3px solid <?php echo $settings['ac_border_color'];?>;
                           margin-top: 0px;
                           color:<?php echo $settings['tab_a_fcolor'];?>;
                        }
                    }
                    .<?php echo $rand;?> .resp-accordion.resp-tab-active{
                            
                           background-color: <?php echo $settings['activetab_bg'];?> ;
                           border-top:3px solid <?php echo $settings['ac_border_color'];?>;
                           margin-top: 0px;
                           color:<?php echo $settings['tab_a_fcolor'];?>;
                        }
                        .<?php echo $rand;?> .resp-accordion.resp-tab-active:first-child{
                            
                           border-top:4px solid <?php echo $settings['ac_border_color'];?>;
                         
                        }
                        
                        <?php if($type==5):?>
                            .<?php echo $rand;?> .resp-tab-content-active{

                                background-color: <?php echo $settings['activetab_bg'];?> ;
                            }

                             .<?php echo $rand;?> .resp-accordion{

                                 background-color:<?php echo $settings['inactive_bg'];?>;
                                 color:<?php echo $settings['tab_fcolor'];?>;
                             }
                         <?php endif;?>
                </style><!-- end wrt_print_rt_wp_responsive_tabs_style -->

            <?php elseif($type==1):?>       
                <!-- wrt_print_rt_wp_responsive_tabs_style --><style>

                    .<?php echo $rand;?> a{box-shadow:none;border-bottom:none}
                    .<?php echo $rand;?> h2heading.resp-accordion{color:<?php echo $settings['tab_fcolor'];?>}
                    .<?php echo $rand;?> .resp-tab-active span.resp-arrow{border-bottom:12px solid <?php echo $settings['tab_a_fcolor'];?>}
                    .<?php echo $rand;?> .resp-arrow{border-top:12px solid <?php echo $settings['tab_fcolor'];?>}
                 
                    .<?php echo $rand;?> .resp-tab-item{color:<?php echo $settings['tab_fcolor'];?>; background-color: <?php echo $settings['inactive_bg'];?>;border-top:2px solid <?php echo $settings['inactive_bg'];?> !important;border-bottom:1px solid <?php echo $settings['ac_border_color'];?>;top: 2px;position:relative}
                    .<?php echo $rand;?> .resp-tab-content{color:<?php echo $settings['tab_ccolor'];?>;border-color: <?php echo $settings['ac_border_color'];?>}
                    .<?php echo $rand;?> .resp-tabs-container{background-color: <?php echo $settings['activetab_bg'];?>}
                    .<?php echo $rand;?> .resp-tab-active{color:<?php echo $settings['tab_a_fcolor'];?>;border-color:1px solid  <?php echo $settings['ac_border_color'];?>;margin-bottom:-1px;margin-top:2px; border-bottom:none ;top: 0px}

                    .<?php echo $rand;?> .resp-tab-content-active{background-color:<?php echo $settings['activetab_bg'];?> }
                    .<?php echo $rand;?> .resp-tab-active{border-bottom:none !important;background-color:<?php echo $settings['activetab_bg'];?> ;border-top:3px solid <?php echo $settings['ac_border_color'];?> !important;padding-left:14px;}
                    .<?php echo $rand;?> .resp-tab-item:hover{color: <?php echo $settings['tab_a_fcolor'];?>; background-color: <?php echo $settings['activetab_bg'];?>;border-top:3px solid <?php echo $settings['ac_border_color'];?> !important;top:2px;padding-top:12px;border-top:3px solid <?php echo $settings['ac_border_color'];?>;margin-top: 0px;border-left:1px solid <?php echo $settings['ac_border_color'];?>;border-right: 1px solid <?php echo $settings['ac_border_color'];?>;padding-left:13px;transition:none}
                    .<?php echo $rand;?> .resp-accordion{background-color:<?php echo $settings['inactive_bg'];?>;}
                       
                    @media only screen and (max-width: 768px) {
                        
                        .<?php echo $rand;?> .resp-tabs-container{background-color:unset }
                        .<?php echo $rand;?> .resp-accordion.resp-tab-active{
                            
                           background-color: <?php echo $settings['activetab_bg'];?> ;
                           border-top:0px solid <?php echo $settings['ac_border_color'];?>;
                           margin-top: 0px;
                           color: <?php echo $settings['tab_a_fcolor'];?>;
                        }
                        .<?php echo $rand;?> .resp-accordion.resp-tab-active:first-child{
                            
                           background-color: <?php echo $settings['activetab_bg'];?> ;
                           border-top:1px solid <?php echo $settings['ac_border_color'];?>;
                           margin-top: 0px;
                           color: <?php echo $settings['tab_a_fcolor'];?>;
                        }
                    }
                </style><!-- end wrt_print_rt_wp_responsive_tabs_style -->  
            <?php endif;?>    
       
              <?php
              
                  $query="SELECT * FROM ".$wpdb->prefix."wrt_tabs WHERE gtab_id=$tabset_id order by morder asc, createdon desc";
                  $rows  = $wpdb->get_results($query,ARRAY_A);  
                  
                  $query="SELECT id FROM ".$wpdb->prefix."wrt_tabs WHERE gtab_id=$tabset_id and is_default=1 limit 1";
                  $rw  = $wpdb->get_row($query,ARRAY_A);  
                  if(is_array($rw) and sizeof($rw)>0){
                      
                     $defaultSelected= $rw['id'];
                  }
                  
                ?>
                
             <?php if($type==1 or $type==2 or $type==5):?>
                <div  class="<?php echo $rand2;?> <?php echo $tabset_id;?>_Tab"  style="visibility: hidden">
                    
                     <div id="<?php echo $rand; ?>_overlay" class="overlay_" style="background: #fff url('<?php echo $loaderImg; ?>') no-repeat scroll 50% 50%;" ></div>
                   
                    <div id="<?php echo $rand;?>" class="<?php echo $rand;?>">
                        
                      <ul  class="<?php if($type==2):?>vresp-tabs-list<?php else:?>resp-tabs-list <?php endif;?> hor_<?php echo $rand;?>">
                         <?php foreach($rows as $r):?>    
                          <li data-isajaxloaded="0" data-tabid="<?php echo $r['id'];?>" <?php if($r['is_link']):?> onclick="window.location.href='<?php echo $r['link'];?>';" <?php endif;?>  >
                                  <?php 
                                  
                                   $ic='';
                                   if(trim($r['fonto_icon'])!=""){
                                      
                                      $selectedIcon=trim($r['fonto_icon']);
                                      
                                       if(in_array($selectedIcon,$font_os_brands)){
                                           
                                            $ic=  "<i  class='fa-additional-css fab fa-1x $selectedIcon'></i> ";
                                                                                   
                                        }   
                                        else{
                                                $ic=  "<i class='fa-additional-css fa far fas  $selectedIcon'></i> ";            
                                                
                                          }  
                                   }
                                  ?>
                                  
                                  <?php echo $ic.trim(wp_unslash($r['tab_title']));?>
                              </li> 
                          <?php endforeach;?>
                      </ul>
                      <div class="<?php if($type==2):?>vresp-tabs-container<?php else:?> resp-tabs-container<?php endif;?> hor_<?php echo $rand;?>">

                          <?php foreach($rows as $r):?>  

                              <div id="tab_<?php echo $rand;?>_<?php echo $r['id'];?>">
                                 <?php echo wpautop(wp_unslash($r['tab_description']));?>
                              </div>

                          <?php endforeach;?>


                      </div>
              </div>
            </div>         
            <!-- wrt_print_rt_wp_responsive_tabs_script --><script type="text/javascript">
             
             
               <?php $intval= uniqid('interval_');?>
               
                    var <?php echo $intval;?> = setInterval(function() {

                    if(document.readyState === 'complete') {

                       clearInterval(<?php echo $intval;?>);
                       
                                
                         jQuery('.<?php echo $rand;?>').easyResponsiveTabs({

                             type: '<?php if($type==1):?>default<?php elseif($type==2):?>vertical<?php elseif($type==5):?>accordion<?php endif;?>', //Types: default, vertical, accordion
                             width: 'auto', //auto or any width like 600px
                             fit: true, // 100% fit in a container
                             closed: 'accordion', // Start closed if in accordion view
                             tabidentify: 'hor_<?php echo $rand;?>', // The tab groups identifier
                             active_border_color: '<?php echo $settings['ac_border_color'];?>',
                             active_content_border_color: '<?php echo $settings['ac_border_color'];?>',
                             activetab_bg: '<?php echo $settings['activetab_bg'];?>',
                             inactive_bg: '<?php echo $settings['inactive_bg'];?>'

                         });

                       <?php if($type==2):?>
                          jQuery(".<?php echo $rand;?>").find(".vresp-tabs-container").css("minHeight",jQuery(".<?php echo $rand;?>").find(".vresp-tabs-list").height()+5);
                       <?php endif;?> 

                       <?php if($type==1 or $type==2 or $type==5):?>

                           setTimeout(function(){ 

                               <?php if(isset($_GET['selected_tab']) and intval($_GET['selected_tab'])>0 ):?>
                                      <?php $defaultSelected=intval($_GET['selected_tab']); ?>
                               <?php endif;?>  
                                   
                                    if(jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"] a').length>0 && jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"] a').is(":visible")){
                                       
                                       jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"] a').trigger('click');
                                    }
                                    else if(jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"]').length>0 && jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"]').is(":visible")){
                                        
                                        jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $defaultSelected;?>"]').trigger('click');
                                    }
                                    
                                    if(jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $defaultSelected;?>"]').length>0 && jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $defaultSelected;?>"]').is(":visible")){
                                        
                                        jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $defaultSelected;?>"]').trigger('click');
                                    }
                                    
                                   jQuery(".<?php echo $rand;?>").css('visibility', 'visible'); 

                            }, 200);




                       <?php endif;?>    

                       <?php if($settings['use_ajax']):?>

                          jQuery(document).on("click","li.hor_<?php echo $rand;?>,h2heading.hor_<?php echo $rand;?>", function(e){

                               var tabid=jQuery(this).data("tabid"); 
                               var isajaxloaded=jQuery(this).data("isajaxloaded"); 
                               var thisele=this;

                               var tabContId="tab_<?php echo $rand;?>_"+tabid;


                               if(isajaxloaded=="0"){

                                    jQuery("#<?php echo $rand; ?>_overlay").css("width", jQuery("#<?php echo $rand; ?>").width());
                                    jQuery("#<?php echo $rand; ?>_overlay").css("height", jQuery("#<?php echo $rand; ?>").height());

                                    e.preventDefault();
                                    var data = {
                                            'action': 'rt_get_tab_data_byid',
                                            'tab_id':tabid,
                                            'vNonce':'<?php echo $vNonce;?>'
                                    };

                                    jQuery.ajax({
                                      type: "POST",
                                      url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                      data: data,
                                      success: function(response){

                                            jQuery("#"+tabContId).html(response);
                                            jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                            jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                            jQuery(thisele).data("isajaxloaded","1"); 

                                            if(jQuery(thisele).hasClass('resp-accordion')){
                                               jQuery('html, body').animate({
                                                     scrollTop: (jQuery('.hor_<?php echo $rand;?> [data-tabid='+tabid+']').first().offset().top+200)
                                                 },1500);

                                             }  

                                      },
                                      error: function(XMLHttpRequest, textStatus, errorThrown) {
                                         jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                         jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                      }
                                    });


                                  }else{

                                       if(jQuery(thisele).hasClass('resp-accordion')){
                                           jQuery('html, body').animate({
                                                 scrollTop: (jQuery('.hor_<?php echo $rand;?> [data-tabid='+tabid+']').first().offset().top+200)
                                             },1500);

                                         } 
                                  }


                         });  
                         <?php endif;?>

                   }    
                }, 100);
            </script><!-- end wrt_print_rt_wp_responsive_tabs_script -->
          <?php elseif($type==3):?>
                
                <!-- wrt_print_rt_wp_responsive_tabs_style --><style>
                    
                    .<?php echo $rand;?> .nav-tabs{border:none}
                       .<?php echo $rand;?> a{box-shadow:none;border-bottom:none}
                     .<?php echo $rand;?>  .bordered-tab-contents{
                         border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                         border-left: 1px solid <?php echo $settings['ac_border_color'];?>;
                         border-right: 1px solid <?php echo $settings['ac_border_color'];?>;
                         color:<?php echo $settings['tab_ccolor'];?>;
                         top:0px;
                         position: relative;
                         background-color:<?php echo $settings['activetab_bg'];?>  ;
                     }  
                    
                    .<?php echo $rand;?>  .bordered-tab-contents > .tab-content > .tab-pane1 {
                        border-left: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-right: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                        color:<?php echo $settings['tab_ccolor'];?>;
                    }
                    
                   
                    .<?php echo $rand;?> .nav-tabs > li.active > a, .<?php echo $rand;?>  .nav-tabs > li.active > a:hover, .<?php echo $rand;?>  .nav-tabs > li.active > a:focus{
                        
                         border-top: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-left: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-right: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-bottom-color:transparent;
                         top:0px;
                         padding-left:13px;
                         padding-right:13px;
                         color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                    }
                    
                    .<?php echo $rand;?>  .nav-tabs a{color:<?php echo $settings['tab_fcolor'];?>;}
                   .<?php echo $rand;?>  .nav-tabs{color:<?php echo $settings['tab_fcolor'];?>;}
                   .<?php echo $rand;?> .nav-tabs > li > a:hover{color:<?php echo $settings['tab_fcolor'];?>;border-color:none;border-bottom: 0px;transition:none}
                   .<?php echo $rand;?>  .scrtabs-tab-container{background-color:<?php echo $settings['inactive_bg'];?>;color:<?php echo $settings['tab_ccolor'];?>;border:1px solid <?php echo $settings['ac_border_color'];?>;}
                   .<?php echo $rand;?>  .nav-tabs > li.active > a, .<?php echo $rand;?>  .nav-tabs > li.active > a:hover, .<?php echo $rand;?>  .nav-tabs > li.active > a:focus{
                   
                     background-color:<?php echo $settings['activetab_bg'];?>  ;
                     color:<?php echo $settings['tab_a_fcolor'];?>;
                     transition:none;
                     
                     
                   }
                   .<?php echo $rand;?> .nav-tabs > li{
                       
                      border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>; 
                      min-height:42px;
                      background-color:<?php echo $settings['inactive_bg'];?>
                   }
                   
                   
                   
                   .<?php echo $rand;?> .bordered-tab-contents{
                       
                       color:<?php echo $settings['tab_ccolor'];?>;
                           
                   }
                   .<?php echo $rand;?>  .nav-tabs >li.active a,.<?php echo $rand;?>  .nav-tabs >li.active a:focus,.<?php echo $rand;?>  .nav-tabs >li:hover,.<?php echo $rand;?>  .nav-tabs >li.rtdropdown.open a.rtdropdown-toggle{
                       
                        background-color:<?php echo $settings['activetab_bg'];?>;
                        border-border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: <?php echo $settings['inactive_bg'];?>;
                        border-top: 3px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: transparent;
                        border-left: 1px solid <?php echo $settings['ac_border_color'];?>; 
                        border-right: 1px solid <?php echo $settings['ac_border_color'];?>;     
                        top: 0px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                        
                       
                        
                   }
                   
                   .<?php echo $rand;?>  .nav-tabs > li > a:hover{border:unset}
                   .<?php echo $rand;?>  .nav-tabs >li:hover a,{
                       
                        background-color:<?php echo $settings['activetab_bg'];?>;
                        border-border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: <?php echo $settings['inactive_bg'];?>;
                        border-bottom-color: transparent;
                        top: 0px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                   }
                   
                   .<?php echo $rand;?> .nav > li > a:hover, .<?php echo $rand;?> .nav > li > a:focus{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>;
                   }
                   
                   .<?php echo $rand;?>  .nav-tabs >li.active:hover{
                       
                       border-top: unset;
                       border-left:unset;
                       border-right:unset;
                       
                   }
                   
                   .<?php echo $rand;?>  .nav-tabs >li.rtdropdown.open a.rtdropdown-toggle{
                   
                         top: 0px;
                   }
                  
                   
                   .<?php echo $rand;?>  .nav-tabs >li.LiTab a:hover{
                       
                       padding-left:13px;
                        padding-right:13px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                        
                   }
                 
                   
                  
              
                   
                   .<?php echo $rand;?> .nav .open > a, .<?php echo $rand;?> .nav .open > a:hover, .<?php echo $rand;?> .nav .open > a:focus{
                       
                        background-color:<?php echo $settings['activetab_bg'];?>;
                        border: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-bottom:none;
                         color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                   }
                   
                   .<?php echo $rand;?> .rtdropdown-menu > li > a,.<?php echo $rand;?> .rtdropdown-menu > li > a:hover,  .<?php echo $rand;?>  .rtdropdown-menu > li > a:focus{
                       
                     border:none;
                     transition:none;
                     
                     
                   }
                   
                   
                   
                    
                    .<?php echo $rand;?> .nav-tabs > li.active{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>;
                        border-border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: <?php echo $settings['inactive_bg'];?>;
                        border-bottom-color: transparent;
                        top: 0px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                   }
            
                   .<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-left{
                       
                       background-color:<?php echo $settings['inactive_bg'];?> ; 
                       color:<?php echo $settings['tab_fcolor'];?>;
                       border-right:0px;
                       border-left:0px;
                       border-top:0px;
                       border-bottom:1px solid <?php echo $settings['ac_border_color'];?>;
                     }
                   .<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-left:hover{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>  ;
                       color:<?php echo $settings['tab_fcolor'];?>;
                       border-color:<?php echo $settings['ac_border_color'];?>;
                       border-right:1px solid <?php echo $settings['ac_border_color'];?>;
                       transition:none;
                           
                   }
                   
                   .<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-right{
                       
                       background-color:<?php echo $settings['inactive_bg'];?> ; 
                       color:<?php echo $settings['tab_fcolor'];?>;
                       border-right:0px;
                       border-left:0px;
                       border-top:0px;
                       border-bottom:0px;
                       border-bottom:1px solid <?php echo $settings['ac_border_color'];?>;
                   }
                   .<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-right:hover{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>  ;
                       color:<?php echo $settings['tab_fcolor'];?>;
                       border-color:<?php echo $settings['ac_border_color'];?>;
                       border-left:1px solid <?php echo $settings['ac_border_color'];?>;
                       transition:none;
                           
                   }
                   
                   
                   .<?php echo $rand;?> .scrtabs-tab-container .scrtabs-tab-scroll-arrow .span_right{
                       
                       border-left:10px solid <?php echo $settings['tab_fcolor'];?>;
                   }
                   .<?php echo $rand;?> .scrtabs-tab-container .scrtabs-tab-scroll-arrow .span_left{
                       
                       border-right:10px solid <?php echo $settings['tab_fcolor'];?>;
                   }
                   
                   .<?php echo $rand;?> .scrtabs-tab-container .scrtabs-tab-scroll-arrow:hover .span_right{
                       
                       border-left:10px solid <?php echo $settings['tab_a_fcolor'];?>;
                       transition:none;
                       
                   }
                   
                   .<?php echo $rand;?> .scrtabs-tab-container .scrtabs-tab-scroll-arrow:hover .span_left{
                       
                       border-right:10px solid <?php echo $settings['tab_a_fcolor'];?>;
                       transition:none;
                       
                   }
                    .<?php echo $rand;?> .nav-tabs > li > a{border-radius: 1px}
                   
                   .<?php echo $rand;?> .nav-tabs > li:first-child.active{top:0px}
            
                   </style><!-- end wrt_print_rt_wp_responsive_tabs_style -->
                   <div class="btabs <?php echo $rand;?> <?php echo $tabset_id;?>_Tab" id="<?php echo $rand;?>" style="visibility: hidden">

                    <div id="<?php echo $rand; ?>_overlay" class="overlay_" style="background: #fff url('<?php echo $loaderImg; ?>') no-repeat scroll 50% 50%;" ></div>
                                
                    <div class="tab-main-container">
                    <ul class="nav nav-tabs btab" role="tablist">
                        
                        <?php foreach($rows as $k=>$r):?>    
                             <?php if($defaultSelected==null){
                                   
                                 $r['is_default']=1;
                                 $rows[$k]=$r;
                                 $defaultSelected=$r['id'];
                               }
                               ?>
                              <?php 

                                $ic='';
                                if(trim($r['fonto_icon'])!=""){

                                   $selectedIcon=trim($r['fonto_icon']);

                                    if(in_array($selectedIcon,$font_os_brands)){

                                         $ic=  "<i  class='fa-additional-css fab fa-1x $selectedIcon'></i> ";

                                     }   
                                     else{
                                             $ic=  "<i class='fa-additional-css fa far fas  $selectedIcon'></i> ";            

                                       }  
                                }
                               ?>
                              <li role="presentation" data-isajaxloaded="0"  data-tabid="<?php echo $r['id'];?>" <?php if($r['is_default']):?> <?php $flag=true;?>class="active LiTab" <?php else:?>class="LiTab" <?php endif;?>>
                                 <a href="#tab_<?php echo $rand;?>_<?php echo $r['id'];?>" class="LiTab_Anchor" role="tab" data-toggle="tab" data-tabid="<?php echo $r['id'];?>"  <?php if($r['is_link']):?> onclick="window.location.href='<?php echo $r['link'];?>';" <?php endif;?> ><?php echo $ic.trim(wp_unslash($r['tab_title']));?></a>
                             </li>
                          <?php endforeach;?>  
                      
                    </ul>
                    <!-- Tab panes -->
                    <div class="bordered-tab-contents">
                            <div class="tab-content">
                                <?php foreach($rows as $r):?>  
                                     <div role="tabpanel" class="tab-pane <?php if($r['is_default']):?> active <?php endif;?>" id="tab_<?php echo $rand;?>_<?php echo $r['id'];?>"><?php echo wpautop(wp_unslash($r['tab_description']));?></div>
                                <?php endforeach;?>
                            </div>
                      </div>
                     </div>
                </div>
              
                <!-- wrt_print_rt_wp_responsive_tabs_script --><script>
                    
                   <?php $intval= uniqid('interval_');?>
               
                    var <?php echo $intval;?> = setInterval(function() {

                    if(document.readyState === 'complete') {

                       clearInterval(<?php echo $intval;?>);
                   
               
                        


                       jQuery('#<?php echo $rand;?> .nav-tabs').scrollingTabs({'scrollToTabEdge':<?php if($settings['scroll_edge']==1):?>true<?php else:?>false<?php endif;?>,'forceActiveTab':true});



                       setTimeout(function(){ 

                           jQuery(".<?php echo $rand;?>").css('visibility', 'visible'); 
                           setBorder<?php echo $rand;?>();


                        }, 300);

                       function setBorder<?php echo $rand;?>(){

                            if (jQuery('#<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-left').is(":visible")) {

                               if (jQuery("#<?php echo $rand;?> .nav-tabs > li.active").is(":first-child")) {

                                   jQuery('#<?php echo $rand;?> .nav-tabs > li:first-child.active a').css('borderLeft','none');

                               }
                               else{

                                    jQuery('#<?php echo $rand;?> .nav-tabs > li:first-child.active a').css('borderLeft','none');

                               }
                           }
                           else{

                               jQuery('#<?php echo $rand;?> .nav-tabs > li:first-child.active a').css('borderLeft','none');


                           }


                            if (jQuery('#<?php echo $rand;?> .scrtabs-js-tab-scroll-arrow-right').is(":visible")) {

                               if (jQuery("#<?php echo $rand;?> .nav-tabs > li.active").is(":last-child")) {

                                   jQuery('#<?php echo $rand;?> .nav-tabs > li:last-child.active a').css('borderRight','none');

                               }
                               else{

                                    jQuery('#<?php echo $rand;?> .nav-tabs > li:last-child.active a').css('borderRight','none');

                               }
                           }
                           else{

                               jQuery('#<?php echo $rand;?> .nav-tabs > li:last-child.active a').css('borderRight','none');


                           }


                       }

                       <?php if($settings['use_ajax']):?>
                           jQuery(document).on("click","#<?php echo $rand;?> .LiTab", function(e){

                              var tabid=jQuery(this).data("tabid"); 
                              var isajaxloaded=jQuery(this).data("isajaxloaded"); 
                              var thisele=this;
                              setBorder<?php echo $rand;?>();

                              var tabContId="tab_<?php echo $rand;?>_"+tabid;


                              if(isajaxloaded=="0"){

                                   jQuery("#<?php echo $rand; ?>_overlay").css("width", jQuery("#<?php echo $rand; ?>").width());
                                   jQuery("#<?php echo $rand; ?>_overlay").css("height", jQuery("#<?php echo $rand; ?>").height());

                                   e.preventDefault();
                                   var data = {
                                           'action': 'rt_get_tab_data_byid',
                                           'tab_id':tabid,
                                           'vNonce':'<?php echo $vNonce;?>'
                                   };

                                   jQuery.ajax({
                                     type: "POST",
                                     url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                     data: data,
                                     success: function(response){

                                           jQuery("#"+tabContId).html(response);
                                           jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                           jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                           jQuery(thisele).data("isajaxloaded","1"); 
                                     },
                                     error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                        jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                     }
                                   });

                                 }


                            });
                        <?php endif;?>

                       var timer<?php echo $rand;?>;
                       jQuery(window).bind('resize', function(){

                               clearTimeout(timer<?php echo $rand;?>);
                               timer<?php echo $rand;?> = setTimeout(onResize<?php echo $rand;?>, 600);
                       });

                       function onResize<?php echo $rand;?>(){

                         setBorder<?php echo $rand;?>();

                       }



                       <?php if(isset($_GET['selected_tab']) and intval($_GET['selected_tab'])>0 ):?>

                           <?php $newSelected=intval($_GET['selected_tab']); ?>

                             setTimeout(function(){ 
                                   // jQuery('#<?php echo $rand;?> .nav-tabs > li.active').removeClass('active');
                                    //jQuery('#<?php echo $rand;?> .nav-tabs').find("[data-tabid='<?php echo $newSelected;?>']").addClass('active'); 

                                    if(jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $newSelected;?>"] a').length>0){

                                        jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $newSelected;?>"] a').trigger('click');
                                     }
                                     if(jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $newSelected;?>"]').length>0){

                                         jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $newSelected;?>"]').trigger('click');
                                     }
                                }, 200);

                      <?php endif;?>
                  }    
                }, 100);
    
                </script><!-- end wrt_print_rt_wp_responsive_tabs_script -->
                
           <?php elseif($type==4):?>  
                
                 <!-- wrt_print_rt_wp_responsive_tabs_style --><style>
                     .<?php echo $rand;?> .nav-tabs{border:none}
                     .<?php echo $rand;?> a{box-shadow:none;border-bottom:none}
                     .<?php echo $rand;?>  .bordered-tab-contents{
                         border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                         border-left: 1px solid <?php echo $settings['ac_border_color'];?>;
                         border-right: 1px solid <?php echo $settings['ac_border_color'];?>;
                         border-top: 1px solid <?php echo $settings['ac_border_color'];?>;
                         color:<?php echo $settings['tab_ccolor'];?>;
                     }  
                    
                    .<?php echo $rand;?>  .bordered-tab-contents > .tab-content > .tab-pane1 {
                        border-left: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-right: 1px solid <?php echo $settings['ac_border_color'];?>;
                        color:<?php echo $settings['tab_ccolor'];?>;
                    }
                    
                   
                    .<?php echo $rand;?> .nav-tabs > li.active > a, .<?php echo $rand;?>  .nav-tabs > li.active > a:hover, .<?php echo $rand;?>  .nav-tabs > li.active > a:focus{
                        
                         border-top: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-left: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-right: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-top:3px solid <?php echo $settings['ac_border_color'];?>; 
                         border-bottom-color:transparent;
                         top:1px;
                         padding-left:13px;
                         padding-right:13px;
                         color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                    }
                    
                    .<?php echo $rand;?>  .nav-tabs a{color:<?php echo $settings['tab_fcolor'];?>;}
                   .<?php echo $rand;?>  .nav-tabs{color:<?php echo $settings['tab_fcolor'];?>;background-color:<?php echo $settings['inactive_bg'];?>}
                   .<?php echo $rand;?> .nav-tabs > li > a:hover{color:<?php echo $settings['tab_fcolor'];?>;border-color:none;border-bottom: 0px;transition:none}
                   .<?php echo $rand;?>  .scrtabs-tab-container{color:<?php echo $settings['tab_ccolor'];?>;background-color:<?php echo $settings['inactive_bg'];?>;border:1px solid <?php echo $settings['ac_border_color'];?>;border-top:none;border-right:none;border-left:none}
                   .<?php echo $rand;?>  .nav-tabs > li.active > a, .<?php echo $rand;?>  .nav-tabs > li.active > a:hover, .<?php echo $rand;?>  .nav-tabs > li.active > a:focus{
                   
                     background-color:<?php echo $settings['activetab_bg'];?>  ;
                     color:<?php echo $settings['tab_a_fcolor'];?>;
                     transition:none;
                     
                     
                   }
                   .<?php echo $rand;?> .bordered-tab-contents{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>  ;
                       color:<?php echo $settings['tab_ccolor'];?>;
                           
                   }
                   .<?php echo $rand;?>  .nav-tabs >li a:hover,.<?php echo $rand;?>  .nav-tabs >li.rtdropdown.open a.rtdropdown-toggle{
                       
                        background-color:<?php echo $settings['activetab_bg'];?>;
                        border-border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: <?php echo $settings['inactive_bg'];?>;
                        border-top: 3px solid <?php echo $settings['ac_border_color'];?>;
                        border-bottom-color: transparent;
                        border-left: 1px solid <?php echo $settings['ac_border_color'];?>; 
                        border-right: 1px solid <?php echo $settings['ac_border_color'];?>;     
                        top: 1px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                        
                       
                        
                   }
                   
                   .<?php echo $rand;?>  .nav-tabs >li.rtdropdown.open a.rtdropdown-toggle{
                   
                         top: 0px;
                   }
                  
                 
                  
                   
                   .<?php echo $rand;?>  .nav-tabs >li.LiTab a:hover{
                       
                       padding-left:13px;
                        padding-right:13px;
                        color:<?php echo $settings['tab_a_fcolor'];?>;
                        transition:none;
                        
                   }
                 
                   
                  
              
                   
                   .<?php echo $rand;?> .nav .open > a, .<?php echo $rand;?> .nav .open > a:hover, .<?php echo $rand;?> .nav .open > a:focus{
                       
                        background-color:<?php echo $settings['activetab_bg'];?>;
                        border: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         border-bottom:none;
                         color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                   }
                   
                   .<?php echo $rand;?> .rtdropdown-menu > li > a,.<?php echo $rand;?> .rtdropdown-menu > li > a:hover,  .<?php echo $rand;?>  .rtdropdown-menu > li > a:focus{
                       
                     border:none;
                     transition:none;
                     
                     
                   }
                   .<?php echo $rand;?> .nav-tabs > li > a{border-radius: 1px}
                   
                   .<?php echo $rand;?> .nav-tabs > li:first-child.active{top:0px}
                   
                   
                   .<?php echo $rand;?> .nav-tabs > li .rtdropdown-menu li a{
                       
                       background-color:<?php echo $settings['inactive_bg'];?>;
                       border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>; 
                       padding:3px 20px;
                       color:<?php echo $settings['tab_fcolor'];?>;
                       white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
                        white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
                        white-space: -pre-wrap;      /* Opera 4-6 */
                        white-space: -o-pre-wrap;    /* Opera 7 */
                        white-space: pre-wrap;       /* css-3 */
                        word-wrap: break-word;       /* Internet Explorer 5.5+ */
                        white-space: normal;
                        min-width:250px     
                       
                    }
                   .<?php echo $rand;?> .nav-tabs > li .rtdropdown-menu li a:hover,.<?php echo $rand;?> .nav-tabs > li .rtdropdown-menu li.active a{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>;
                       border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>; 
                       padding:3px 20px;
                       color:<?php echo $settings['tab_a_fcolor'];?>;
                       
                    }
                   .<?php echo $rand;?> .nav-tabs > li .rtdropdown-menu {
                       
                       background-color:<?php echo $settings['inactive_bg'];?>;
                       border-top: 1px solid <?php echo $settings['ac_border_color'];?>; 
                       color:<?php echo $settings['tab_fcolor'];?>;
                       
                    }
                    
                   .<?php echo $rand;?> .nav-tabs > li.active .rtdropdown-menu li.active a,.<?php echo $rand;?> .nav-tabs > li.active .rtdropdown-menu li.active a:hover{
                       
                       background-color:<?php echo $settings['activetab_bg'];?>;
                       border-bottom: 1px solid <?php echo $settings['ac_border_color'];?>; 
                       padding:3px 20px;
                       color:<?php echo $settings['tab_a_fcolor'];?>;
                   }
                   
                   .<?php echo $rand;?> .nav-tabs > li .rtdropdown-menu li:hover {
                       
                       color:<?php echo $settings['tab_a_fcolor'];?>;
                   }
                   
                   .<?php echo $rand;?> .nav-tabs > li.active .rtdropdown-menu li.active:first-child a{
                         border-top: 1px solid <?php echo $settings['ac_border_color'];?>; 
                         color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                    }
                   
                   .<?php echo $rand;?> .arrowdown{
                       
                      border-color:<?php echo $settings['tab_fcolor'];?>; 
                      cursor:pointer;
                   }
                   
                   .<?php echo $rand;?> .arrowdown:hover{
                       
                      border-color:<?php echo $settings['tab_a_fcolor'];?>;
                      transition:none;
                   }
                   .<?php echo $rand;?> .arrowdown:hover:before{
                       
                      border-color:<?php echo $settings['tab_a_fcolor'];?>;
                      transition:none;
                   }
                   .<?php echo $rand;?> .arrowdown:before{
                       
                      border-color:<?php echo $settings['tab_fcolor'];?>; 
                   }
                   
                    .<?php echo $rand;?> .nav-tabs > li.active .arrowdown{
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                    }
                    .<?php echo $rand;?> .nav-tabs > li.active .arrowdown:before{
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                    }
                    
                    .<?php echo $rand;?> .nav-tabs > li:hover .arrowdown{
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                    }
                    .<?php echo $rand;?> .nav-tabs > li:hover .arrowdown:before{
                        
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                         transition:none;
                    }
                    
                    .<?php echo $rand;?> .nav-tabs > li.rtdropdown.open .arrowdown{
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                    }
                    .<?php echo $rand;?> .nav-tabs > li.rtdropdown.open .arrowdown:before{
                         border-color:<?php echo $settings['tab_a_fcolor'];?>;
                    }
                   
                   </style><!-- end wrt_print_rt_wp_responsive_tabs_style -->
                   <div class="resptabs btabs <?php echo $rand;?> <?php echo $tabset_id;?>_Tab" id="<?php echo $rand;?>" style="visibility: hidden">
                    <div id="<?php echo $rand; ?>_overlay" class="overlay_" style="background: #fff url('<?php echo $loaderImg; ?>') no-repeat scroll 50% 50%;" ></div>
                  
                    <div class="tab-main-container">
                    <ul class="nav nav-tabs btab ul<?php echo $rand;?>" role="tablist">
                        
                        <?php foreach($rows as $k=> $r):?>    
                               <?php if($defaultSelected==null){
                                   
                                 $r['is_default']=1;
                                 $rows[$k]=$r;
                                 $defaultSelected=$r['id'];
                               }
                               ?>
                               <?php 

                                $ic='';
                                if(trim($r['fonto_icon'])!=""){

                                   $selectedIcon=trim($r['fonto_icon']);

                                    if(in_array($selectedIcon,$font_os_brands)){

                                         $ic=  "<i  class='fa-additional-css fab fa-1x $selectedIcon'></i> ";

                                     }   
                                     else{
                                             $ic=  "<i class='fa-additional-css fa far fas  $selectedIcon'></i> ";            

                                       }  
                                }
                               ?>
                                <?php if($r['is_default']):?>
                                    <?php $default=$rand."_".$r['id'];?>
                                <?php endif;?>
                                <li role="presentation"  data-isajaxloaded="0"  data-tabid="<?php echo $r['id'];?>" <?php if($r['is_default']):?> <?php $flag=true;?> class="<?php echo $rand."_".$r['id'];?> active LiTab <?php echo $li_tab_class;?>" <?php else:?>class="<?php echo $rand."_".$r['id'];?> LiTab <?php echo $li_tab_class;?>" <?php endif;?>>
                                    <a href="#tab_<?php echo $rand;?>_<?php echo $r['id'];?>"  class="LiTab_Anchor" role="tab" data-toggle="tab" data-tabid="<?php echo $r['id'];?>"  <?php if($r['is_link']):?> onclick="window.location.href='<?php echo $r['link'];?>';" <?php endif;?> >
                                        <?php echo $ic.trim(wp_unslash($r['tab_title']));?>
                                    </a>
                                </li>
                          <?php endforeach;?>  
                      
                    </ul>

                    <!-- Tab panes -->
                    <div class="bordered-tab-contents">
                            <div class="tab-content">
                                <?php foreach($rows as $r):?>  
                                     <div role="tabpanel" class=" tab-pane <?php if($r['is_default']):?> active <?php endif;?>" id="tab_<?php echo $rand;?>_<?php echo $r['id'];?>" ><?php echo wpautop(wp_unslash($r['tab_description']));?></div>
                                <?php endforeach;?>
                            </div>
                      </div>
                     </div>
                </div>
              
                <!-- wrt_print_rt_wp_responsive_tabs_script --><script>
                    
                    var orgUl<?php echo $rand;?>='';
                     var activeTab<?php echo $rand;?>='';
                     
                     function changeLiToMenu<?php echo $rand;?>(activeLi){
                         
                        var flag=false;
                        var width=0; 
                        var width_=0; 
                        var menuWidth=50;
                        var mainconWidth=jQuery(" #<?php echo $rand;?> .tab-main-container").width();
                        
                        jQuery( "#<?php echo $rand;?> .ul<?php echo $rand;?>" ).html(orgUl<?php echo $rand;?>.html());
                        
                        jQuery( ".<?php echo $li_tab_class;?>" ).each(function( index ) {
                            
                          width_=width_+jQuery(this).width();
                          
                        });   
                        
                        if(width_>mainconWidth){
                        
                                    jQuery( ".<?php echo $li_tab_class;?>" ).each(function( index ) {

                                      width=width+jQuery(this).width();
                                      if(width+menuWidth>mainconWidth){


                                          jQuery(this).remove();
                                          if(flag==false){

                                                var rtdropdownMarkup = '<li class="rtdropdown responsivetabs rtdropdown">'
                                              + '<a href="#" class="rtdropdown-toggle" data-toggle="rtdropdown"><span class="arrowdown"></span></a>'
                                              + '<ul class="rtdropdown-menu ';
                                              if(index==0){
                                                  
                                                    rtdropdownMarkup+=' rtdropdown-menu-left rtdropdown-menu<?php echo $rand;?>">'
                                                   + '</ul></li>';
                                                }
                                              else{
                                                  
                                                     rtdropdownMarkup+=' rtdropdown-menu-right rtdropdown-menu<?php echo $rand;?>">'
                                                   + '</ul></li>';
                                              }  
                                              $rtdropdown = jQuery(rtdropdownMarkup);
                                              jQuery( "#<?php echo $rand;?> .nav-tabs").append($rtdropdown);
                                              jQuery(".rtdropdown-menu<?php echo $rand;?>").append(jQuery(this).clone());
                                              flag=true;
                                          }
                                          else{

                                              jQuery(".rtdropdown-menu<?php echo $rand;?>").append(jQuery(this).clone());
                                          }

                                      }
                                    
                                    });  
                                    
                                    if(activeLi!=''){
                                    
                                            jQuery("."+activeLi+' a').trigger('click');
                                            setTimeout(function(){ 
                                            
                                                if(jQuery("."+activeLi+' a').parent().parent().parent().hasClass('responsivetabs')){
                                                    
                                                    jQuery("."+activeLi+' a').parent().parent().parent().addClass('active')
                                                    jQuery("."+activeLi+' a').attr('aria-expanded','true');
                                                }
    
                                            }, 50);


                                      }  
                         }
                         
                        
                        
                     }
                  
                    <?php $intval= uniqid('interval_');?>
               
                    var <?php echo $intval;?> = setInterval(function() {

                    if(document.readyState === 'complete') {

                       clearInterval(<?php echo $intval;?>);
                     

                        orgUl<?php echo $rand;?>=jQuery(" #<?php echo $rand;?> .nav-tabs").clone();



                         <?php if($flag==false):?>

                         <?php endif;?>  

                         changeLiToMenu<?php echo $rand;?>('<?php echo $default;?>');
                         setTimeout(function(){ 

                            jQuery(".<?php echo $rand;?>").css('visibility', 'visible');

                          }, 500);


                        jQuery(document).on("click", "#<?php echo $rand;?>  li.<?php echo $li_tab_class;?>", function(e){


                            if(activeTab<?php echo $rand;?>!="" && !jQuery(this).hasClass(activeTab<?php echo $rand;?>)){
                                jQuery('.'+activeTab<?php echo $rand;?>).removeClass('active');
                            }

                             jQuery( "#<?php echo $rand;?> .LiTab" ).each(function( index ) {

                                  if(!jQuery(this).hasClass(activeTab<?php echo $rand;?>) && ! jQuery(this).hasClass('rtdropdown')){
                                      jQuery(this).removeClass('active');
                                  }
                             });

                             jQuery(e.target).parent().addClass('active');

                            activeLi<?php echo $rand;?>=jQuery(this).prop('classList');
                            classes<?php echo $rand;?> = activeLi<?php echo $rand;?>.toString().split(" ");
                            activeTab<?php echo $rand;?>=classes<?php echo $rand;?>[0];

                            <?php if($settings['use_ajax']):?>

                                var tabid=jQuery(this).data("tabid"); 
                                var isajaxloaded=jQuery(this).data("isajaxloaded"); 
                                var thisele=this;

                                var tabContId="tab_<?php echo $rand;?>_"+tabid;



                                if(isajaxloaded=="0"){

                                     jQuery("#<?php echo $rand; ?>_overlay").css("width", jQuery("#<?php echo $rand; ?>").width());
                                     jQuery("#<?php echo $rand; ?>_overlay").css("height", jQuery("#<?php echo $rand; ?>").height());

                                     e.preventDefault();
                                     var data = {
                                             'action': 'rt_get_tab_data_byid',
                                             'tab_id':tabid,
                                             'vNonce':'<?php echo $vNonce;?>'
                                     };

                                     jQuery.ajax({
                                       type: "POST",
                                       url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                       data: data,
                                       success: function(response){

                                             jQuery("#"+tabContId).html(response);
                                             jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                             jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                             jQuery(thisele).data("isajaxloaded","1"); 
                                       },
                                       error: function(XMLHttpRequest, textStatus, errorThrown) {
                                          jQuery("#<?php echo $rand; ?>_overlay").css("width", "0px");
                                          jQuery("#<?php echo $rand; ?>_overlay").css("height", "0px");

                                       }
                                     });

                                   }

                                <?php endif;?>   

                        });

                         jQuery(document).on("click", "#<?php echo $rand;?> .rtdropdown-toggle", function(){


                             if(jQuery("#<?php echo $rand;?> .responsivetabs ul.rtdropdown-menu").offset().left<jQuery("#<?php echo $rand;?>").offset().left){

                                 jQuery("#<?php echo $rand;?> .responsivetabs ul.rtdropdown-menu").removeClass('rtdropdown-menu-right');
                                 jQuery("#<?php echo $rand;?> .responsivetabs ul.rtdropdown-menu").addClass('rtdropdown-menu-left');
                             }

                        });

                        jQuery(document).on("click", "#<?php echo $rand;?> .responsivetabs ul.rtdropdown-menu<?php echo $rand;?>.rtdropdown-menu-right li.LiTab", function(){

                             jQuery( "#<?php echo $rand;?> .LiTab" ).each(function( index ) {

                                  if(!jQuery(this).hasClass(activeTab<?php echo $rand;?>)){
                                      jQuery(this).removeClass('active');
                                  }
                             });

                              jQuery("#<?php echo $rand;?> .responsivetabs").addClass('active');

                        });

                        var timer<?php echo $rand;?>;
                        var width<?php echo $rand;?> = jQuery(window).width();
                          jQuery(window).bind('resize', function(){

                           if(jQuery(window).width() != width<?php echo $rand;?>){


                                  width<?php echo $rand;?> = jQuery(window).width();
                                  clearTimeout(timer<?php echo $rand;?>);
                                  timer<?php echo $rand;?> = setTimeout(onResize_<?php echo $rand;?>, 500);

                              }   
                          });

                        function onResize_<?php echo $rand;?>(){


                          changeLiToMenu<?php echo $rand;?>(activeTab<?php echo $rand;?>);

                        }

                         <?php if(isset($_GET['selected_tab']) and intval($_GET['selected_tab'])>0 ):?>

                            <?php $newSelected=intval($_GET['selected_tab']); ?>

                            setTimeout(function(){ 
                                    jQuery('#<?php echo $rand;?> .nav-tabs > li.active').removeClass('active');
                                    jQuery('#<?php echo $rand;?> .nav-tabs').find("[data-tabid='<?php echo $newSelected;?>']").addClass('active'); 

                                    if(jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $newSelected;?>"] a').length>0){

                                       jQuery(".<?php echo $rand;?>").find('li[data-tabid="<?php echo $newSelected;?>"] a').trigger('click');
                                    }
                                    if(jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $newSelected;?>"]').length>0){

                                        jQuery(".<?php echo $rand;?>").find('h2heading[data-tabid="<?php echo $newSelected;?>"]').trigger('click');
                                    }
                               }, 200);


                       <?php endif;?>
                    
                  }    
                }, 100);  
                 
                </script><!-- end wrt_print_rt_wp_responsive_tabs_script -->
               
                
          <?php endif;?>    
          <?php if(trim($settings['additional_css'])!=''):?>      
            <!-- wrt_print_rt_wp_responsive_tabs_style --><style>

             <?php echo html_entity_decode($settings['additional_css'],ENT_QUOTES);?>   

          </style><!-- end wrt_print_rt_wp_responsive_tabs_style -->   
         <?php  endif;?>
<!-- end wrt_print_rt_wp_responsive_tabs_func -->
<?php endif;?>
    <?php
        $output = do_shortcode(ob_get_clean());
        return $output;
}
    

function wrt_e_gallery_get_wp_version() {
	global $wp_version;
	return $wp_version;
}

// also we will add an option function that will check for plugin admin page or not
function wrt_responsive_tabs_is_plugin_page() {
	$server_uri = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	
	foreach ( array ('rt_wp_responsive_tabs','rt_wp_responsive_tabs'
	) as $allowURI ) {
		if (stristr ( $server_uri, $allowURI ))
			return true;
	}
	return false;
}

// add media WP scripts
function wrt_wp_responsive_full_tabs_admin_scripts_init() {
    
	if (wrt_responsive_tabs_is_plugin_page ()) {
		// double check for WordPress version and function exists
		if (function_exists ( 'wp_enqueue_media' ) && version_compare ( wrt_e_gallery_get_wp_version (), '3.5', '>=' )) {
			// call for new media manager
                    
			wp_enqueue_media ();
		}
		wp_enqueue_style ( 'media' );
                 wp_enqueue_style( 'wp-color-picker' );
                 wp_enqueue_script( 'wp-color-picker' );
                 
                
	}
}

   function wrt_responsive_tabs_remove_extra_p_tags($content){

        if(strpos($content, 'wrt_print_rt_wp_responsive_tabs_script')!==false){
        
            
            $pattern = "/<!-- wrt_print_rt_wp_responsive_tabs_script -->(.*)<!-- end wrt_print_rt_wp_responsive_tabs_script -->/Uis"; 
            $content = preg_replace_callback($pattern, function($matches) {


               $altered = str_replace("<p>","",$matches[1]);
               $altered = str_replace("</p>","",$altered);
              
                $altered=str_replace("&#038;","&",$altered);
                $altered=str_replace("&#8221;",'"',$altered);
              

              return @str_replace($matches[1], $altered, $matches[0]);
            }, $content);

              
            
        }
        
        $content = str_replace("<p><!-- wrt_print_rt_wp_responsive_tabs_script -->","<!-- wrt_print_rt_wp_responsive_tabs_script -->",$content);
        $content = str_replace("<!-- end wrt_print_rt_wp_responsive_tabs_script --></p>","<!-- end wrt_print_rt_wp_responsive_tabs_script -->",$content);
        
        
        if(strpos($content, 'wrt_print_rt_wp_responsive_tabs_style')!==false){
        
            
            $pattern = "/<!-- wrt_print_rt_wp_responsive_tabs_style -->(.*)<!-- end wrt_print_rt_wp_responsive_tabs_style -->/Uis"; 
            $content = preg_replace_callback($pattern, function($matches) {


               $altered = str_replace("<p>","",$matches[1]);
               $altered = str_replace("</p>","",$altered);
              
                $altered=str_replace("&#038;","&",$altered);
                $altered=str_replace("&#8221;",'"',$altered);
              

              return @str_replace($matches[1], $altered, $matches[0]);
            }, $content);

              
            
        }
        
        $content = str_replace("<p><!-- wrt_print_rt_wp_responsive_tabs_style -->","<!-- wrt_print_rt_wp_responsive_tabs_style -->",$content);
        $content = str_replace("<!-- end wrt_print_rt_wp_responsive_tabs_style --></p>","<!-- end wrt_print_rt_wp_responsive_tabs_style -->",$content);
        
        
        return $content;
  }

  add_filter('widget_text_content', 'wrt_responsive_tabs_remove_extra_p_tags', 999);
  add_filter('the_content', 'wrt_responsive_tabs_remove_extra_p_tags', 999);
  
  //remove_filter('the_content', 'wpautop');
  //add_filter('the_content', 'wpautop', 12);
?>