<?php
/**
 * Elementor Addons Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Controllers\Frontend;

use Elementor\Plugin as Elementor;
use RT\Team\Widgets\Elementor as Widgets;

/**
 * Elementor Addons Class.
 */
class ElementorAddons {
	use \RT\Team\Traits\SingletonTrait;

	/**
	 * Class Init.
	 *
	 * @return void
	 */
	protected function init() {
		if ( did_action( 'elementor/loaded' ) ) {
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register' ) );
		}
	}

	/**
	 * Elementor Widgets.
	 *
	 * @return void
	 */
	public function register() {
		$widgets = array(
			Widgets\TeamShortcodesList::class,
		);

		foreach ( $widgets as $widget ) {
			$manager = Elementor::instance()->widgets_manager;
			$manager->register_widget_type( new $widget() );
		}
	}
}
