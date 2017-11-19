<?php
/**
 * Admin Settings Page
 */

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Eael_Contact_Form_7_Admin_Settings {

	private $is_pro = false;

	/**
	 * Contains Default Component keys
	 * @var array
	 * @since 2.3.0
	 */
	public $eael_default_keys = [ 'contact-form-7', 'count-down', 'creative-btn', 'fancy-text', 'img-comparison', 'instagram-gallery', 'interactive-promo',  'lightbox', 'post-block', 'post-grid', 'post-timeline', 'product-grid', 'team-members', 'testimonial-slider', 'testimonials', 'testimonials', 'weforms', 'static-product', 'call-to-action', 'flip-box', 'info-box', 'dual-header', 'price-table', 'flip-carousel', 'interactive-cards', 'ninja-form', 'gravity-form' ];

	/**
	 * Will Contain All Components Default Values
	 * @var array
	 * @since 2.3.0
	 */
	private $eael_default_settings;

	/**
	 * Will Contain User End Settings Value
	 * @var array
	 * @since 2.3.0
	 */
	private $eael_settings;

	/**
	 * Will Contains Settings Values Fetched From DB
	 * @var array
	 * @since 2.3.0
	 */
	private $eael_get_settings;

	/**
	 * Initializing all default hooks and functions
	 * @param
	 * @return void
	 * @since 1.1.2
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'create_eael_admin_menu' ) );
		add_action( 'init', array( $this, 'enqueue_eael_admin_scripts' ) );

	}

	/**
	 * Loading all essential scripts
	 * @param
	 * @return void
	 * @since 1.1.2
	 */
	public function enqueue_eael_admin_scripts() {

		if( isset( $_GET['page'] ) && $_GET['page'] == 'eael-settings' ) {
			wp_enqueue_style( 'essential_addons_elementor-admin-css', plugins_url( '/', __FILE__ ).'assets/css/admin.css' );
			wp_enqueue_style( 'font-awesome-css', plugins_url( '/', __FILE__ ).'assets/vendor/font-awesome/css/font-awesome.min.css' );
			wp_enqueue_style( 'essential_addons_elementor-sweetalert2-css', plugins_url( '/', __FILE__ ).'assets/vendor/sweetalert2/css/sweetalert2.min.css' );

			// wp_enqueue_script( "jquery-ui-tabs" );
			wp_enqueue_script( 'essential_addons_elementor-admin-js', plugins_url( '/', __FILE__ ).'assets/js/admin.js', array( 'jquery', 'jquery-ui-tabs' ), '1.0', true );
			wp_enqueue_script( 'essential_addons_core-js', plugins_url( '/', __FILE__ ).'assets/vendor/sweetalert2/js/core.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'essential_addons_sweetalert2-js', plugins_url( '/', __FILE__ ).'assets/vendor/sweetalert2/js/sweetalert2.min.js', array( 'jquery', 'essential_addons_core-js' ), '1.0', true );
		}

	}

	/**
	 * Create an admin menu.
	 * @param
	 * @return void
	 * @since 1.1.2
	 */
	public function create_eael_admin_menu() {

		add_menu_page(
			'Elementor Contact Form 7',
			'Elementor Contact Form 7',
			'manage_options',
			'eael-settings',
			array( $this, 'eael_contact_form_7_admin_settings_page' ),
			plugins_url( '/', __FILE__ ).'/assets/images/ea-icon.png',
			199
		);

	}

	/**
	 * Create settings page.
	 * @param
	 * @return void
	 * @since 1.1.2
	 */
	public function eael_contact_form_7_admin_settings_page() {

		$js_info = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'essential_addons_elementor-admin-js', 'settings', $js_info );

	   /**
	    * This section will handle the "eael_save_settings" array. If any new settings options is added
	    * then it will matches with the older array and then if it founds anything new then it will update the entire array.
	    */
	   $this->eael_default_settings = array_fill_keys( $this->eael_default_keys, true );
	   $this->eael_get_settings = get_option( 'eael_save_settings', $this->eael_default_settings );
	   $eael_new_settings = array_diff_key( $this->eael_default_settings, $this->eael_get_settings );
	   if( ! empty( $eael_new_settings ) ) {
	   	$eael_updated_settings = array_merge( $this->eael_get_settings, $eael_new_settings );
	   	update_option( 'eael_save_settings', $eael_updated_settings );
	   }
	   $this->eael_get_settings = get_option( 'eael_save_settings', $this->eael_default_settings );
		?>
		<div class="wrap">
			<div class="response-wrap"></div>
		  	<form action="" method="POST" id="eael-settings" name="eael-settings">
		  		<div class="eael-header-bar">
					<div class="eael-header-left">
						<h4 class="title"><?php _e( 'Elementor Contact Form 7', 'elementor-contact-form-7' ); ?></h4>
					</div>
				</div>
				<div class="eael-header-bar-after">
					<div class="eael-header-left">
						<h4 class="title-2"><?php _e( 'Install all elements in a single plugin!', 'elementor-contact-form-7' ); ?></h4>
					</div>
					<div class="eael-header-right">
						<a href="https://essential-addons.com/elementor/" target="_blank" class="button eael-btn">Install Now</a>
					</div>
				</div>
			  	<div class="eael-settings-tabs">
			    	<div id="elements" class="eael-settings-tab">
				      	<div class="row">
				      		<div class="col-full">
					            <!-- Content Element Starts -->
					            <h4>Content Elements</h4>
					            <table class="form-table">
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Info Box', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Info Box', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="info-box" name="info-box" disabled>
					                            <label for="info-box" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Team Member', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Team Member', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="team-members" name="team-members" disabled>
					                            <label for="team-members" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Flip Box', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Flip Box', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="flip-box" name="flip-box" disabled>
					                            <label for="flip-box" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Dual Color Header', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Dual Color Header', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="dual-header" name="dual-header" disabled>
					                            <label for="dual-header" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Creative Button', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Creative Button', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="creative-btn" name="creative-btn" disabled>
					                            <label for="creative-btn" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Testimonial Slider', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Testimonial Slider', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="testimonial-slider" name="testimonial-slider" disabled>
					                            <label for="testimonial-slider" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Testimonials', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Testimonials', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="testimonials" name="testimonials" disabled>
					                            <label for="testimonials" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					            </table>
					            <!-- Content Element Ends -->
					            <!-- Dynamic Content Element Starts -->
					            <h4>Dynamic Content Elements</h4>
					            <table class="form-table">
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Post Grid', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Post Grid', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="post-grid" name="post-grid" disabled>
					                            <label for="post-grid" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Post Timeline', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Post Timeline', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="post-timeline" name="post-timeline" disabled>
					                            <label for="post-timeline" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Post Block', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Post Block', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="post-block" name="post-block" disabled>
					                            <label for="post-block" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Instagram Gallery', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Instagram Gallery', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="instagram-gallery" name="instagram-gallery" disabled>
					                            <label for="instagram-gallery" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Woo Product Grid', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Woo Product Grid', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="product-grid" name="product-grid" disabled>
					                            <label for="product-grid" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Content Timeline', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Content Timeline', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="content-timeline" name="content-timeline" disabled>
					                            <label for="content-timeline" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					            </table>
					            <!-- Dynamic Content Element Ends -->
					            <!-- Creative Element Starts -->
					            <h4>Creative Elements</h4>
					            <table class="form-table">
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Fancy Text', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Fancy Text', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="fancy-text" name="fancy-text" disabled>
					                            <label for="fancy-text" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Interactive Promo', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Interactive Promo', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="interactive-promo" name="interactive-promo" disabled>
					                            <label for="interactive-promo" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Count Down', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Count Down', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="count-down" name="count-down" disabled>
					                            <label for="count-down" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Lightbox', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Lightbox', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="lightbox" name="lightbox" disabled>
					                            <label for="lightbox" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Static Product', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Static Product', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="static-product" name="static-product" disabled>
					                            <label for="static-product" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Image Comparison', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Image Comparison', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="img-comparison" name="img-comparison" disabled>
					                            <label for="img-comparison" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Flip Carousel', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Flip Carousel', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="flip-carousel" name="flip-carousel" disabled>
					                            <label for="flip-carousel" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Interactive Cards', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Interactive Cards', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="interactive-cards" name="interactive-cards" disabled>
					                            <label for="interactive-cards" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					            </table>
					            <!-- Creative Element Ends -->
					            <!-- Marketing Elements Starts -->
					            <h4>Marketing Elements</h4>
					            <table class="form-table">
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Call To Action', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Call To Action', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="call-to-action" name="call-to-action" disabled>
					                            <label for="call-to-action" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Pricing Table', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Pricing Table', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="price-table" name="price-table" disabled>
					                            <label for="price-table" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					            </table>
					            <!-- Marketing Elements Ends -->
					            <!-- Form Styler Elements Starts -->
					            <h4>Form Styler Elements</h4>
					            <table class="form-table">
					                <tr>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'We-Forms', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate WeForms', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="weforms" name="weforms" disabled>
					                            <label for="weforms" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Contact Form 7', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactivate Contact Form 7', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="contact-form-7" name="contact-form-7" disabled >
					                            <label for="contact-form-7" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Ninja Form', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Ninja Form', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="ninja-form" name="ninja-form" disabled>
					                            <label for="ninja-form" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                    <td>
					                        <div class="eael-checkbox">
					                            <p class="title">
					                                <?php _e( 'Gravity Form', 'essential-addons-elementor' ) ?>
					                            </p>
					                            <p class="desc">
					                                <?php _e( 'Activate / Deactive Gravity Form', 'essential-addons-elementor' ); ?>
					                            </p>
					                            <input type="checkbox" id="gravity-form" name="gravity-form" disabled>
					                            <label for="gravity-form" class="<?php if( (bool) $this->is_pro === false ) : echo 'eael-get-pro'; endif; ?>"></label>
					                        </div>
					                    </td>
					                </tr>
					            </table>
					            <!-- Form Styler Elements Ends -->
					        </div>
				      	</div>
			    	</div>
			  	</div>
		  	</form>
		</div>
		<?php

	}

}

new Eael_Contact_Form_7_Admin_Settings();