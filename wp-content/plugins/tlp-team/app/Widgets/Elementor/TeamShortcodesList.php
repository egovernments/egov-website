<?php
/**
 * VC Addon Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Widgets\Elementor;

use RT\Team\Helpers\Fns;
use Elementor\Widget_Base as Elementor;
use Elementor\Controls_Manager as Controls;

/**
 * VC Addon Widget.
 */
class TeamShortcodesList extends Elementor {

	public function get_name() {
		return 'tlp-team';
	}

	public function get_title() {
		return esc_html__( 'TLP Team', 'tlp-team' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'general' );
	}

	public function get_script_depends() {
		return array(
			'tlp-image-load-js',
			'tlp-isotope-js',
			'ttp-swiper',
			'rt-pagination',
			'tlp-scrollbar',
			'rt-tooltip',
			'tlp-actual-height-js',
			'tlp-team-js',
		);

	}

	public function get_style_depends() {
		return array(
			'tlp-scrollbar',
			'tlp-swiper',
			'rt-pagination',
			'tlp-fontawsome',
			'rt-team-css',
			'rt-team-sc',
		);
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'TLP Team', 'tlp-team' ),
				'tab'   => Controls::TAB_CONTENT,
			)
		);

		$this->add_control(
			'short_code_id',
			array(
				'type'    => Controls::SELECT2,
				'id'      => 'short_code_id',
				'label'   => esc_html__( 'Shortcode', 'tlp-team' ),
				'options' => Fns::getTTPShortcodeList(),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( isset( $settings['short_code_id'] ) && ! empty( $settings['short_code_id'] ) && $id = absint( $settings['short_code_id'] ) ) {
			echo do_shortcode( '[tlpteam id="' . $id . '" ]' );
		} else {
			esc_html_e( 'Please select a shortcode from the list.', 'tlp-team' );
		}

		$this->edit_mode_script();
	}


	/**
	 * Elementor Edit mode need some extra js for isotop reinitialize
	 *
	 * @return mixed
	 */
	public function edit_mode_script() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
			<script>
				initTlpTeam();
			</script>
			<?php
		}
	}
}
