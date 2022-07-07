<?php
/**
 * Public Controller Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Controllers;

use RT\Team\Widgets as Widgets;
use RT\Team\Controllers\Frontend as Frontend;
use RT\Team\Abstracts\AbstractController as Controller;

/**
 * Admin Controller Class.
 */
class FrontendController extends Controller {
	use \RT\Team\Traits\SingletonTrait;

	/**
	 * Classes to include.
	 *
	 * @return array
	 */
	public function classes() {
		$classes = array();

		$classes[] = Widgets\Vc\VcAddon::class;
		$classes[] = Frontend\CustomCSS::class;
		$classes[] = Frontend\Shortcode::class;
		$classes[] = Frontend\Template::class;
		$classes[] = Frontend\Ajax\LoadMore::class;
		$classes[] = Frontend\ElementorAddons::class;

		return $classes;
	}
}
