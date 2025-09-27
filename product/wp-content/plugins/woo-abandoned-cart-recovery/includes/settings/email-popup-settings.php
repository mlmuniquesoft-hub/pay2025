<?php
/**
 * Created by PhpStorm.
 * User: Villatheme-Thanh
 * Date: 13-06-19
 * Time: 9:55 AM
 */

namespace WACV\Inc\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Email_Popup_Settings extends Admin_Settings {

	protected static $instance = null;

	public function __construct() {

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function setting_page() {
		?>
        <div id="" class="vi-ui bottom attached tab segment tab-admin" data-tab="fifth">
            <h4><?php esc_html_e( 'Pop-up config', 'woo-abandoned-cart-recovery' ) ?></h4>
            <table class="wacv-table">
				<?php
				$this->get_pro_version( __( 'Appear on', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Email required', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Dismiss time', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Redirect after Add to cart', 'woo-abandoned-cart-recovery' ) );
				?>
            </table>

            <h4><?php esc_html_e( 'Design', 'woo-abandoned-cart-recovery' ) ?></h4>
            <table class="wacv-table">
				<?php
				$this->get_pro_version( __( 'Template', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Title', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Sub title', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Add to cart', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Invalid email notice', 'woo-abandoned-cart-recovery' ) );
				$this->get_pro_version( __( 'Color settings', 'woo-abandoned-cart-recovery' ) );
				?>
            </table>
        </div>
		<?php
	}

}
