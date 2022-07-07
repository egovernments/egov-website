<?php
/**
 * Options helper class.
 *
 * @package RT_Team
 */

namespace RT\Team\Helpers;

/**
 * Options helper class.
 */
class Options {
	public static function lan() {
		return array(
			'of' => esc_html__( 'of', 'tlp-tem-pro' ),
		);
	}

	public static function scColumns() {
		return array(
			1 => '1 Column',
			2 => '2 Column',
			3 => '3 Column',
			4 => '4 Column',
			5 => '5 Column',
			6 => '6 Column',
		);
	}

	public static function scLayout() {
		$layouts = array(
			'layout1'      => 'Layout 1',
			'layout2'      => 'Layout 2',
			'layout3'      => 'Layout 3',
			'layout4'      => 'Layout 4',
			'isotope-free' => 'Isotope Layout',
			'carousel1'    => 'Carousel (Slider Layout',
		);

		return apply_filters( 'rttm_team_layouts', $layouts );
	}

	public static function paginationType() {
		$paginationType = array(
			'pagination'      => esc_html__( 'Pagination', 'tlp-team' ),
			'pagination_ajax' => esc_html__( 'Ajax Number Pagination ( Only for Grid )', 'tlp-team' ),
			'load_more'       => esc_html__( 'Load more button (by ajax loading)', 'tlp-team' ),
			'load_on_scroll'  => esc_html__( 'Load more on scroll (by ajax loading)', 'tlp-team' ),
		);
		return apply_filters( 'tlp_pagination_type', $paginationType );
	}

	public static function exportFields() {
		return array(
			'export_field'  => array(
				'name'        => 'export_field',
				'id'          => 'export_field',
				'label'       => esc_html__( 'Export settings', 'tlp-team' ),
				'type'        => 'checkbox',
				'multiple'    => true,
				'alignment'   => 'vertical',
				'options'     => array(
					'members'    => 'All member',
					'short_code' => 'All Shortcode',
					'settings'   => 'Settings',
				),
				'default'     => array( 'members', 'settings' ),
				'description' => 'Select which you like to export',
			),
			'export_format' => array(
				'name'    => 'export_format',
				'id'      => 'export_format',
				'label'   => esc_html__( 'Export format', 'tlp-team' ),
				'type'    => 'radio',
				'options' => array(
					'json' => 'JSON',
					'xml'  => 'XML',
					'xlsx' => 'XLSX',
				),
				'default' => 'json',
			),
		);
	}

	public static function teamMemberInfoField() {
		$default = array(
			'short_bio'             => array(
				'label'       => esc_html__( 'Short Bio', 'tlp-team' ),
				'type'        => 'textarea',
				'attr'        => 'rows="5"',
				'description' => esc_html__( 'Add some short bio', 'tlp-team' ),
			),
			'experience_year'       => array(
				'label'       => esc_html__( 'Experience', 'tlp-team' ),
				'type'        => 'text',
				'is_pro'      => true,
				'description' => esc_html__( 'ex: 4 Years', 'tlp-team' ),
			),
			'email'                 => array(
				'label' => esc_html__( 'Email', 'tlp-team' ),
				'type'  => 'email',
			),
			'telephone'             => array(
				'label' => esc_html__( 'Telephone', 'tlp-team' ),
				'type'  => 'text',
			),
			'mobile'                => array(
				'label' => esc_html__( 'Mobile', 'tlp-team' ),
				'type'  => 'text',
			),
			'fax'                   => array(
				'label' => esc_html__( 'Fax', 'tlp-team' ),
				'type'  => 'text',
			),
			'web_url'               => array(
				'label' => esc_html__( 'Personal Web URL', 'tlp-team' ),
				'type'  => 'url',
			),
			'location'              => array(
				'label' => esc_html__( 'Location', 'tlp-team' ),
				'type'  => 'text',
			),
			'ttp_custom_detail_url' => array(
				'label'       => esc_html__( 'Custom Detail URL', 'tlp-team' ),
				'type'        => 'url',
				'is_pro'      => true,
				'description' => esc_html__( 'Add your custom URl for detail profile', 'tlp-team' ),
			),
		);

		return apply_filters( 'rttm_member_info_fields', $default );
	}

	public static function socialLink() {
		$socialLinks = array(
			'facebook'   => 'Facebook',
			'twitter'    => 'Twitter',
			'linkedin'   => 'LinkedIn',
			'youtube'    => 'Youtube',
			'instagram'  => 'Instagram',
			'pinterest'  => 'Pinterest',
			'soundcloud' => 'Soundcloud',
			'bandcamp'   => 'Bandcamp',
			'envelope-o' => 'Email',
			'globe'      => 'Website',
			'xing'       => 'Xing',
		);

		return apply_filters( 'tlp_team_social_links', $socialLinks );
	}

	public static function tlpOverlayBg() {
		return array(
			'0.1' => '10 %',
			'0.2' => '20 %',
			'0.3' => '30 %',
			'0.4' => '40 %',
			'0.5' => '50 %',
			'0.6' => '60 %',
			'0.7' => '70 %',
			'0.8' => '80 %',
			'0.9' => '90 %',
		);
	}

	public static function scAvailableFields() {

		$sc_avaiable_fiels = array(
			'name'        => esc_html__( 'Name', 'tlp-team' ),
			'designation' => esc_html__( 'Designation', 'tlp-team' ),
			'short_bio'   => esc_html__( 'Short biography', 'tlp-team' ),
			'content'     => __( 'Content Details', 'tlp-team' ),
			'email'       => esc_html__( 'Email', 'tlp-team' ),
			'web_url'     => esc_html__( 'Web Url', 'tlp-team' ),
			'telephone'   => esc_html__( 'Telephone', 'tlp-team' ),
			'mobile'      => esc_html__( 'Mobile', 'tlp-team' ),
			'fax'         => esc_html__( 'Fax', 'tlp-team' ),
			'location'    => esc_html__( 'Location', 'tlp-team' ),
			'social'      => esc_html__( 'Social Link', 'tlp-team' ),
		);
		return apply_filters( 'rttm_sc_avaiable_fiels', $sc_avaiable_fiels );
	}

	public static function get_sc_field_selection_meta() {
		return array(
			'ttp_selected_field' => array(
				'label'       => esc_html__( 'Select the field', 'tlp-team' ),
				'alignment'   => 'vertical',
				'type'        => 'checkbox',
				'holderClass' => 'rttm-selected-field',
				'multiple'    => true,
				'default'     => array_keys( self::scAvailableFields() ),
				'options'     => self::scAvailableFields(),
				'description' => esc_html__( 'Check the field which you want to display. Note: Some field are not available for some layout', 'tlp-team' ),
			),
		);
	}

	public static function get_sc_layout_settings_meta_fields() {
		$rttm_layout_options = array(
			'layout_type'                   => array(
				'type'    => 'radio-image',
				'label'   => esc_html__( 'Layout type', 'review-schema' ),
				'id'      => 'rttm-layout-type',
				'options' => array(
					array(
						'name'  => 'Grid Layout',
						'value' => 'grid',
						'img'   => TLP_TEAM_PLUGIN_URL . '/assets/images/grid.png',
					),
					array(
						'name'  => 'List Layout',
						'value' => 'list',
						'img'   => TLP_TEAM_PLUGIN_URL . '/assets/images/list.png',
					),
					array(
						'name'  => 'Slider Layout',
						'value' => 'slider',
						'img'   => TLP_TEAM_PLUGIN_URL . '/assets/images/slider.png',
					),
					array(
						'name'  => 'Isotope Layout',
						'value' => 'isotope',
						'img'   => TLP_TEAM_PLUGIN_URL . '/assets/images/isotope.png',
					),
				),
			),
			'layout'                        => array(
				'type'        => 'radio-image',
				'label'       => esc_html__( 'Layout style', 'review-schema' ),
				'description' => esc_html__( 'Click to the Layout name to see live demo', 'review-schema' ),
				'id'          => 'rttm-style',
				'options'     => array(),
			),
			'ttp_column'                    => array(
				'type'    => 'multiple_options',
				'label'   => esc_html__( 'Column', 'tlp-team' ),
				'options' => array(
					'desktop' => array(
						'type'    => 'select',
						'class'   => 'tlp-select',
						'label'   => esc_html__( 'Desktop', 'tlp-team' ),
						'options' => self::scColumns(),
						'default' => 4,
					),
					'tab'     => array(
						'type'    => 'select',
						'class'   => 'tlp-select',
						'label'   => esc_html__( 'Tab', 'tlp-team' ),
						'options' => self::scColumns(),
						'default' => 2,
					),
					'mobile'  => array(
						'type'    => 'select',
						'class'   => 'tlp-select',
						'label'   => esc_html__( 'Mobile', 'tlp-team' ),
						'options' => self::scColumns(),
						'default' => 1,
					),
				),
			),
			'ttl_image_column'              => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Image column', 'tlp-team' ),
				'class'       => 'tlp-select',
				'holderClass' => 'ttp-hidden',
				'default'     => 4,
				'options'     => self::scColumns(),
				'description' => 'Content column will calculate automatically',
			),
			'ttp_carousel_speed'            => array(
				'label'       => __( 'Speed', 'tlp-team' ),
				'holderClass' => 'ttp-hidden ttp-carousel-item',
				'type'        => 'number',
				'default'     => 250,
				'description' => __( 'Auto play Speed in milliseconds', 'tlp-team' ),
			),
			'ttp_carousel_options'          => array(
				'label'       => __( 'Carousel Options', 'tlp-team' ),
				'holderClass' => 'ttp-hidden ttp-carousel-item',
				'type'        => 'checkbox',
				'multiple'    => true,
				'alignment'   => 'vertical',
				'options'     => self::owlProperty(),
				'default'     => array( 'autoplay', 'arrows', 'dots', 'responsive', 'infinite' ),
			),
			'ttp_carousel_autoplay_timeout' => array(
				'label'       => __( 'Autoplay timeout', 'tlp-team' ),
				'holderClass' => 'ttp-hidden ttp-carousel-item ttp-carousel-auto-play-timeout',
				'type'        => 'number',
				'default'     => 5000,
				'description' => __( 'Autoplay interval timeout', 'tlp-team' ),
			),
			'ttp_filter'                    => array(
				'type'        => 'checkbox',
				'label'       => 'Filter',
				'holderClass' => 'sc-ttp-grid-filter ttp-hidden',
				'multiple'    => true,
				'is_pro'      => true,
				'alignment'   => 'vertical',
				'options'     => self::ttp_filter_list(),
			),
			'ttp_filter_taxonomy'           => array(
				'type'        => 'select',
				'label'       => 'Taxonomy Filter',
				'holderClass' => 'sc-ttp-grid-filter sc-ttp-filter-item ttp-hidden',
				'class'       => 'tlp-select',
				'is_pro'      => true,
				'options'     => Fns::rt_get_all_taxonomy_by_post_type(),
			),
			'ttp_pagination'                => array(
				'type'        => 'switch',
				'label'       => esc_html__( 'Pagination', 'tlp-team' ),
				'holderClass' => 'ttp-pagination-item pagination ttp-hidden',
				'optionLabel' => esc_html__( 'Enable', 'tlp-team' ),
				'option'      => 1,
			),
			'ttp_pagination_type'           => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Pagination type', 'tlp-team' ),
				'holderClass' => 'ttp-pagination-item ttp-hidden',
				'alignment'   => 'vertical',
				'is_pro'      => true,
				'default'     => 'pagination',
				'options'     => self::paginationType(),
			),
			'ttp_posts_per_page'            => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Display per page', 'tlp-team' ),
				'holderClass' => 'ttp-pagination-item ttp-hidden',
				'default'     => 5,
				'description' => esc_html__(
					'If value of Limit setting is not blank (empty), this value should be smaller than Limit value.',
					'tlp-team'
				),
			),
			'ttp_image'                     => array(
				'type'        => 'switch',
				'label'       => esc_html__( 'Feature Image Disable', 'tlp-team' ),
				'optionLabel' => esc_html__( 'Disable', 'tlp-team' ),
				'option'      => 1,
			),
			'image_style'                   => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Image style', 'tlp-team' ),
				'alignment'   => 'vertical',
				'description' => __( "Select image style for layout. <br> <strong>Note:</strong> All layouts don't support rounded style.", 'tlp-team' ),
				'default'     => 'normal',
				'options'     => self::scImgStyle(),
			),
			'ttp_image_size'                => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Image Size', 'tlp-team' ),
				'class'       => 'tlp-select',
				'holderClass' => 'ttp-feature-image-option ttp-hidden',
				'options'     => Fns::get_image_sizes(),
			),
			'ttp_custom_image_size'         => array(
				'type'        => 'image_size',
				'label'       => esc_html__( 'Custom Image Size', 'tlp-team' ),
				'holderClass' => 'ttp-feature-image-option ttp-hidden',
			),
			'character_limit'               => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Short description limit', 'tlp-team' ),
				'description' => __(
					"Short description limit only integer number is allowed, Leave it blank for full text.<br> <span style='color: red;'>Also HTML TAGS will not work if you use limit.</span>",
					'tlp-team'
				),
			),
			'ttp_after_short_desc_text'     => array(
				'type'        => 'text',
				'label'       => 'After Short Description',
				'description' => 'Add something after short description.',
			),
			'ttp_detail_page_link'          => array(
				'type'        => 'switch',
				'label'       => esc_html__( 'Detail page link', 'tlp-team' ),
				'optionLabel' => esc_html__( 'Enable', 'tlp-team' ),
				'default'     => 1,
				'option'      => 1,
			),
		);

		return apply_filters( 'rttm_layout_options', $rttm_layout_options );
	}

	public static function owlProperty() {
		$owlProperty = array(
			'loop'               => esc_html__( 'Loop', 'tlp-team' ),
			'autoplay'           => esc_html__( 'Auto Play', 'tlp-team' ),
			'autoplayHoverPause' => esc_html__( 'Pause on mouse hover', 'tlp-team' ),
			'nav'                => esc_html__( 'Nav Button', 'tlp-team' ),
			'dots'               => esc_html__( 'Pagination', 'tlp-team' ),
			'auto_height'        => esc_html__( 'Auto Height', 'tlp-team' ),
			'lazy_load'          => esc_html__( 'Lazy Load', 'tlp-team' ),
			'rtl'                => esc_html__( 'Right to left (RTL)', 'tlp-team' ),
		);
		return apply_filters( 'tlp_owl_property', $owlProperty );
	}

	public static function swiperProperty() {
		$swiperProperty = array(
			'loop'               => esc_html__( 'Loop', 'tlp-team' ),
			'autoplay'           => esc_html__( 'Auto Play', 'tlp-team' ),
			'autoplayHoverPause' => esc_html__( 'Pause on mouse hover', 'tlp-team' ),
			'nav'                => esc_html__( 'Nav Button', 'tlp-team' ),
			'dots'               => esc_html__( 'Pagination', 'tlp-team' ),
			'autoHeight'         => esc_html__( 'Auto Height', 'tlp-team' ),
			'lazyLoad'           => esc_html__( 'Lazy Load', 'tlp-team' ),
			'rtl'                => esc_html__( 'Right to left (RTL)', 'tlp-team' ),
		);
		return apply_filters( 'tlp_swiper_property', $swiperProperty );
	}

	public static function ttp_filter_list() {
		return array(
			'_taxonomy_filter' => 'Taxonomy filter',
			'_order_by'        => 'Order - Sort retrieved posts by parameter',
			'_sort_order'      => 'Sort Order - Designates the ascending or descending order of the "orderby" parameter',
			'_search'          => 'Search filter',
		);
	}

	public static function scImgStyle() {
		return array(
			'normal' => 'Normal',
			'round'  => 'Round',
		);
	}

	public static function get_sc_query_filter_meta_fields() {

		return array(
			'ttp_post__in'          => array(
				'label'       => esc_html__( 'Include only', 'tlp-team' ),
				'type'        => 'select',
				// "class"     => "tlp-select",
				'class'       => 'rttm-select2',
				'description' => esc_html__(
					'Select the member you want to display',
					'tlp-team'
				),
				'multiple'    => true,
				'options'     => Fns::getMemberList(),
			),
			'ttp_post__not_in'      => array(
				'label'       => esc_html__( 'Exclude', 'tlp-team' ),
				'type'        => 'select',
				'class'       => 'rttm-select2',
				'description' => esc_html__(
					'Select the member you want to hide',
					'tlp-team'
				),
				'multiple'    => true,
				'options'     => Fns::getMemberList(),
			),
			'ttp_limit'             => array(
				'label'       => esc_html__( 'Limit', 'tlp-team' ),
				'type'        => 'number',
				'description' => esc_html__(
					'The number of posts to show. Set empty to show all found posts.',
					'tlp-team'
				),
			),
			'ttp_departments'       => array(
				'label'       => esc_html__( 'Departments', 'tlp-team' ),
				'type'        => 'select',
				'class'       => 'rttm-select2',
				'multiple'    => true,
				'description' => esc_html__(
					'Select the department you want to filter, Leave it blank for all department',
					'tlp-team'
				),
				'options'     => Fns::getAllTermsByTaxonomyName( 'department' ),
			),
			'ttp_designations'      => array(
				'label'       => esc_html__( 'Designations', 'tlp-team' ),
				'type'        => 'select',
				'class'       => 'rttm-select2',
				'multiple'    => true,
				'is_pro'      => true,
				'description' => esc_html__( 'Select the designation you want to filter, Leave it blank for all designation', 'tlp-team' ),
				'options'     => Fns::getAllTermsByTaxonomyName( 'designation' ),
			),
			'ttp_taxonomy_relation' => array(
				'label'       => esc_html__( 'Taxonomy relation', 'tlp-team' ),
				'type'        => 'select',
				'is_pro'      => true,
				'class'       => 'tlp-select',
				'description' => esc_html__( 'Select this option if you select more than one taxonomy like department , designation and skill', 'tlp-team' ),
				'options'     => self::scTaxonomyRelation(),
			),
			'order_by'              => array(
				'label'   => esc_html__( 'Order By', 'tlp-team' ),
				'type'    => 'select',
				'class'   => 'tlp-select',
				'default' => 'title',
				'options' => self::scOrderBy(),
			),
			'order'                 => array(
				'label'     => esc_html__( 'Order', 'tlp-team' ),
				'type'      => 'radio',
				'options'   => self::scOrder(),
				'default'   => 'ASC',
				'alignment' => 'vertical',
			),
		);
	}

	public static function get_sc_field_style_meta() {
		$style_fields = array(
			'ttp_parent_class' => array(
				'type'        => 'text',
				'label'       => 'Parent class',
				'class'       => 'medium-text',
				'description' => 'Parent class for adding custom css',
			),
			'primary_color'    => array(
				'type'    => 'text',
				'label'   => 'Primary Color',
				'class'   => 'tlp-color',
				'default' => '#0367bf',
			),
			'ttp_button_style' => array(
				'type'    => 'multiple_options',
				'label'   => 'Button color',
				'options' => array(
					'bg'         => array(
						'type'  => 'color',
						'label' => 'Background',
					),
					'hover_bg'   => array(
						'type'  => 'color',
						'label' => 'Hover background',
					),
					'active_bg'  => array(
						'type'  => 'color',
						'label' => 'Active background',
					),
					'text'       => array(
						'type'  => 'color',
						'label' => 'Text',
					),
					'hover_text' => array(
						'type'  => 'color',
						'label' => 'Hover text',
					),
					'border'     => array(
						'type'  => 'color',
						'label' => 'Border',
					),
				),
			),
			'name'             => array(
				'type'    => 'multiple_options',
				'label'   => esc_html__( 'Name', 'tlp-team' ),
				'options' => self::scStyleOptions(),
			),
			'designation'      => array(
				'type'    => 'multiple_options',
				'label'   => esc_html__( 'Designation', 'tlp-team' ),
				'options' => self::scStyleOptions(),
			),
			'short_bio'        => array(
				'type'    => 'multiple_options',
				'label'   => esc_html__( 'Short biography', 'tlp-team' ),
				'options' => self::scStyleOptions(),
			),
			// 'social_icon_bg'   => array(
			// 	'type'        => 'text',
			// 	'label'       => 'Social icon BG Color',
			// 	'class'       => 'tlp-color',
			// 	'description' => 'Please set social icon background color',
			// ),
		);
		return apply_filters( 'rttm_style_fields', $style_fields );
	}

	public static function scTaxonomyRelation() {
		return array(
			'OR'  => 'OR Relation',
			'AND' => 'AND Relation',
		);
	}

	public static function scOrderBy() {
		return array(
			'menu_order' => 'Menu Order',
			'title'      => 'Name',
			'ID'         => 'ID',
			'date'       => 'Date',
			'rand'       => 'Random',
		);
	}

	public static function scOrder() {
		return array(
			'ASC'  => esc_html__( 'Ascending', 'tlp-team' ),
			'DESC' => esc_html__( 'Descending', 'tlp-team' ),
		);
	}


	public static function imageCropType() {
		return array(
			'soft' => esc_html__( 'Soft Crop', 'tlp-team' ),
			'hard' => esc_html__( 'Hard Crop', 'tlp-team' ),
		);
	}

	public static function colorSizeAlignmentWeight() {
		return array_keys( self::scAvailableFields() );
	}

	public static function tlpTeamDetailFieldSelection() {

		$settings = get_option( rttlp_team()->options['settings'] );

		return array(
			'detail_page_wrapper'   => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Content type', 'tlp-team' ),
				'class'   => 'tlp-select',
				'is_pro'  => true,
				'options' => self::pageWrapperList(),
				'value'   => ! empty( $settings['detail_page_wrapper'] ) ? $settings['detail_page_wrapper'] : 'rt-container',
			),
			'detail_image_column'   => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Image column', 'tlp-team' ),
				'class'       => 'tlp-select',
				'is_pro'      => true,
				'options'     => self::scColumns(),
				'value'       => ! empty( $settings['detail_image_column'] ) ? $settings['detail_image_column'] : 5,
				'description' => esc_html__( 'Content column will calculate automatically', 'tlp-team' ),
			),
			'detail_page_fields'    => array(
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Field Selection', 'tlp-team' ),
				'description' => esc_html__( 'This will apply only single team page', 'tlp-team' ),
				'alignment'   => 'vertical',
				'multiple'    => true,
				'options'     => self::detailAvailableFields(),
				'value'       => ! empty( $settings['detail_page_fields'] ) ? $settings['detail_page_fields'] : array( 'name', 'designation', 'short_bio', 'email', 'web_url', 'telephone', 'mobile', 'fax', 'location', 'social' ),
			),
			'detail_allow_comments' => array(
				'type'        => 'switch',
				'label'       => esc_html__( 'Comments', 'tlp-team' ),
				'is_pro'      => true,
				'description' => esc_html__( 'Allow comments to team member details page', 'tlp-team' ),
				'optionLabel' => esc_html__( 'Enable', 'tlp-team' ),
				'option'      => 1,
				'value'       => ! empty( $settings['detail_allow_comments'] ) ? 1 : false,
			),
		);
	}

	public static function tlpTeamCustomCssField() {

		$settings = get_option( rttlp_team()->options['settings'] );

		return array(
			'custom_css' => array(
				'type'        => 'custom_css',
				'id'          => 'custom-css',
				'holderClass' => 'full',
				'description' => esc_html__( "<span style='color: red;'>Please use default customizer to add your css. This option is deprecated.</span>", 'tlp-team' ),
				'value'       => isset( $settings['custom_css'] ) ? trim( $settings['custom_css'] ) : null,
			),
		);
	}

	public static function rtTeamLicenceField() {

		$settings       = get_option( rttlp_team()->options['settings'] );
		$status         = ! empty( $settings['license_status'] ) && $settings['license_status'] === 'valid' ? true : false;
		$license_status = ! empty( $settings['license_key'] ) ? sprintf(
			"<span class='license-status'>%s</span>",
			$status ? "<input type='submit' class='button-secondary rt-team-licensing-btn danger' name='license_deactivate' value='Deactivate License'/>"
				: "<input type='submit' class='button-secondary rt-team-licensing-btn button-primary' name='license_activate' value='Activate License'/>"
		) : ' ';

		return array(
			'license_key' => array(
				'type'        => 'text',
				'name'        => 'license_key',
				'attr'        => 'style="min-width:300px;"',
				'label'       => 'Enter your license key',
				'description' => $license_status,
				'id'          => 'license_key',
				'value'       => isset( $settings['license_key'] ) ? $settings['license_key'] : '',
			),
		);
	}

	public static function tlpTeamGeneralSettingFields() {

		$settings = get_option( rttlp_team()->options['settings'] );

		return array(
			'slug' => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Slug', 'tlp-team' ),
				'id'          => 'team-slug',
				'description' => esc_html__( 'Slug configuration', 'tlp-team' ),
				'attr'        => "style='width:100px;'",
				'value'       => ! empty( $settings['slug'] ) ? trim( $settings['slug'] ) : null,
			),
		);
	}

	public static function detailAvailableFields() {
		$fields = self::scAvailableFields();
		return apply_filters( 'rttm_settings_avaiable_fields', $fields );
	}

	public static function scStyleOptions( $items = array( 'color', 'hover_color', 'size', 'weight', 'align' ) ) {
		$fields = array();
		if ( in_array( 'color', $items ) ) {
			$fields['color'] = array(
				'type'     => 'color',
				'col_size' => 4,
				'label'    => esc_html__( 'Color', 'tlp-team' ),
			);
		}
		if ( in_array( 'hover_color', $items ) ) {
			$fields['hover_color'] = array(
				'type'     => 'color',
				'col_size' => 4,
				'label'    => esc_html__( 'Hover color', 'tlp-team' ),
			);
		}
		if ( in_array( 'size', $items ) ) {
			$fields['size'] = array(
				'type'     => 'select',
				'label'    => esc_html__( 'Font size', 'tlp-team' ),
				'col_size' => 4,
				'class'    => 'tlp-select',
				'blank'    => esc_html__( 'Default', 'tlp-team' ),
				'options'  => self::scFontSize(),
			);
		}
		if ( in_array( 'weight', $items ) ) {
			$fields['weight'] = array(
				'type'     => 'select',
				'label'    => esc_html__( 'Weight', 'tlp-team' ),
				'col_size' => 4,
				'class'    => 'tlp-select',
				'blank'    => esc_html__( 'Default', 'tlp-team' ),
				'options'  => self::scTextWeight(),
			);
		}
		if ( in_array( 'align', $items ) ) {
			$fields['align'] = array(
				'type'     => 'select',
				'label'    => esc_html__( 'Alignment', 'tlp-team' ),
				'col_size' => 4,
				'blank'    => esc_html__( 'Default', 'tlp-team' ),
				'class'    => 'tlp-select',
				'options'  => self::scAlignment(),
			);
		}

		return $fields;
	}

	public static function pageWrapperList() {
		return array(
			'rt-container'       => esc_html__( 'Container', 'tlp-team' ),
			'rt-container-fluid' => esc_html__( 'Container fluid', 'tlp-team' ),
		);
	}

	public static function scFontSize() {
		$num = array();
		for ( $i = 10; $i <= 60; $i++ ) {
			$num[ $i ] = $i . 'px';
		}

		return $num;
	}

	public static function scTextWeight() {
		return array(
			'normal'  => 'Normal',
			'bold'    => 'Bold',
			'bolder'  => 'Bolder',
			'lighter' => 'Lighter',
			'inherit' => 'Inherit',
			'initial' => 'Initial',
			'unset'   => 'Unset',
			100       => '100',
			200       => '200',
			300       => '300',
			400       => '400',
			500       => '500',
			600       => '600',
			700       => '700',
			800       => '800',
			900       => '900',
		);
	}

	public static function scAlignment() {
		return array(
			'left'    => 'Left',
			'right'   => 'Right',
			'center'  => 'Center',
			'justify' => 'Justify',
		);
	}
}
