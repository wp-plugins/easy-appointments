<?php

require_once EA_SRC_DIR . 'dbmodels.php';

/**
 * 
 */
class EAFrontend
{

	/**
	 * 
	 */
	var $generate_next_option = true;

	/**
	 * 
	 */
	function __construct()
	{
		// register JS
		//$this->init();
		add_action( 'wp_enqueue_scripts', array( $this, 'init' ));
		// add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );

		// add shortcode standard
		add_shortcode('ea_standard', array($this, 'standard_app'));

		// bootstrap form
		add_shortcode('ea_bootstrap', array($this, 'ea_bootstrap'));
	}

	/**
	 * Front end init
	 */
	public function init()
	{

		// start session
		if (!headers_sent() && !session_id()) {
			session_start();
		}

		wp_register_script(
			'ea-validator',
			'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js',
			array( 'jquery' ),
			false,
			true
		);

		wp_register_script(
			'ea-datepicker-localization',
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js',
			array( 'jquery', 'jquery-ui-datepicker' ),
			false,
			true
		);

		// frontend standard script
		wp_register_script(
			'ea-front-end',
			EA_PLUGIN_URL . 'js/frontend.js',
			array( 'jquery', 'jquery-ui-datepicker', 'ea-datepicker-localization' ),
			false,
			true
		);

		// bootstrap script
		wp_register_script(
			'ea-bootstrap',
			EA_PLUGIN_URL . 'components/bootstrap/js/bootstrap.js',
			array(),
			false,
			true
		);

		// frontend standard script
		wp_register_script(
			'ea-front-bootstrap',
			EA_PLUGIN_URL . 'js/frontend-bootstrap.js',
			array( 'jquery', 'jquery-ui-datepicker', 'ea-datepicker-localization' ),
			false,
			true
		);

		wp_register_style(
			'jquery-style',
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css'
		);


		wp_register_style(
			'ea-bootstrap',
			EA_PLUGIN_URL . 'components/bootstrap/ea-css/bootstrap.css'
		);

		wp_register_style(
			'ea-bootstrap-select',
			EA_PLUGIN_URL . 'components/bootstrap-select/css/bootstrap-select.css'
		);

		wp_register_style(
			'ea-frontend-style',
			EA_PLUGIN_URL . 'css/eafront.css'
		);

		wp_register_style(
			'ea-frontend-bootstrap',
			EA_PLUGIN_URL . 'css/eafront-bootstrap.css'
		);

		// admin style
		wp_register_style(
			'ea-admin-awesome-css',
			EA_PLUGIN_URL . 'css/font-awesome.css'
		);
	}

	/**
	 * Standard widget
	 */
	public function standard_app($attrs)
	{

		$settings = EALogic::get_options();
		$settings['trans.please-select-new-date'] = __('Please select another day', 'easy-appointments');
		$settings['trans.date-time'] = __('Date & time', 'easy-appointments');
		$settings['trans.price'] = __('Price', 'easy-appointments');

		wp_localize_script( 'ea-front-end', 'ea_settings', $settings );

		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'ea-validator' );
		wp_enqueue_script( 'ea-front-end' );
		//wp_enqueue_script( 'ea-datepicker-localization' );
		wp_enqueue_style( 'jquery-style' );
		wp_enqueue_style( 'ea-frontend-style' );
		wp_enqueue_style( 'ea-admin-awesome-css' );

		ob_start();

		// require tempalte
		require EA_SRC_DIR . 'templates/booking.overview.tpl.php';

		?>
<script type="text/javascript">
	var ea_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<div class="ea-standard">
	<form>
		<div class="step">
			<div class="block"></div>
			<label class="ea-label"><?php echo EALogic::get_option_value("trans.location")?></label><select name="location" data-c="location" class="filter"><?php $this->get_options("locations")?></select>
		</div>
		<div class="step">
			<div class="block"></div>
			<label class="ea-label"><?php echo EALogic::get_option_value("trans.service")?></label><select name="service" data-c="service" class="filter" data-currency="<?php echo EALogic::get_option_value("trans.currency")?>"><?php $this->get_options("services")?></select>
		</div>
		<div class="step">
			<div class="block"></div>
			<label class="ea-label"><?php echo EALogic::get_option_value("trans.worker")?></label><select name="worker" data-c="worker" class="filter"><?php $this->get_options("staff")?></select>
		</div>
		<div class="step calendar" class="filter">
			<div class="block"></div>
			<div class="date"></div>
		</div>
		<div class="step" class="filter">
			<div class="block"></div>
			<div class="time"></div>
		</div>
		<div class="step final">
			<div class="block"></div>
			<p class="section"><?php _e('Personal information', 'easy-appointments'); ?></p>
			<small><?php _e('Fields with * are required', 'easy-appointments'); ?></small><br>
			<p><label><?php _e('Email', 'easy-appointments'); ?> * : </label><input type="text" name="email" data-rule-required="true" data-rule-email="true" data-msg-required="<?php _e('This field is required.', 'easy-appointments'); ?>" data-msg-email="<?php _e('Please enter a valid email address', 'easy-appointments'); ?>"></p>
			<p><label><?php _e('Name', 'easy-appointments'); ?> * : </label><input type="text" name="name" data-rule-required="true" data-rule-minlength="3" data-msg-required="<?php _e('This field is required.', 'easy-appointments'); ?>" data-msg-minlength="<?php _e('Please enter at least 3 characters.', 'easy-appointments'); ?>"></p>
			<p><label><?php _e('Phone', 'easy-appointments'); ?> * : </label><input type="text" name="phone" data-rule-required="true" data-rule-minlength="3" data-msg-required="<?php _e('This field is required.', 'easy-appointments'); ?>" data-msg-minlength="<?php _e('Please enter at least 3 digits.', 'easy-appointments'); ?>"></p>
			<textarea class="description" name="description"></textarea>
			<br>
			<p class="section"><?php _e('Booking overview', 'easy-appointments'); ?></p>
			<div id="booking-overview"></div>
			<button class="ea-btn ea-submit"><?php _e('Submit', 'easy-appointments');?></button>
			<button class="ea-btn ea-cancel"><?php _e('Cancel', 'easy-appointments');?></button>
		</div>
	</form>
</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Bootstrap
	 */
	public function ea_bootstrap($attrs) {
		$settings = EALogic::get_options();

		if(is_array($attrs) && array_key_exists('width', $attrs)) {
			$settings['width'] = $attrs['width'] . 'px';
		} else {
			$settings['width'] = '400px';
		}

		$settings['trans.please-select-new-date'] = __('Please select another day', 'easy-appointments');
		$settings['trans.personal-informations'] = __('Personal information', 'easy-appointments');
		$settings['trans.field-required'] = __('This field is required.', 'easy-appointments');
		$settings['trans.error-email'] = __('Please enter a valid email address', 'easy-appointments');
		$settings['trans.error-name'] = __('Please enter at least 3 characters.', 'easy-appointments');
		$settings['trans.error-phone'] = __('Please enter at least 3 digits.', 'easy-appointments');
		$settings['trans.fields'] = __('Fields with * are required', 'easy-appointments');
		$settings['trans.email'] = __('Email', 'easy-appointments');
		$settings['trans.name'] = __('Name', 'easy-appointments');
		$settings['trans.phone'] = __('Phone', 'easy-appointments');
		$settings['trans.comment'] = __('Comment', 'easy-appointments');
		$settings['trans.overview-message'] = __('Please check your appointment details below and confirm:', 'easy-appointments');
		$settings['trans.booking-overview'] = __('Booking overview', 'easy-appointments');
		$settings['trans.date-time'] = __('Date & time', 'easy-appointments');
		$settings['trans.submit'] = __('Submit', 'easy-appointments');
		$settings['trans.cancel'] = __('Cancel', 'easy-appointments');
		$settings['trans.price'] = __('Price', 'easy-appointments');

		wp_localize_script( 'ea-front-bootstrap', 'ea_settings', $settings );

		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'ea-validator' );
		wp_enqueue_script( 'ea-bootstrap' );
		// wp_enqueue_script( 'ea-datepicker-localization' );
		// wp_enqueue_script( 'ea-bootstrap-select' );
		wp_enqueue_script( 'ea-front-bootstrap' );
		wp_enqueue_style( 'ea-bootstrap' );
		// wp_enqueue_style( 'ea-bootstrap-select' );
		// wp_enqueue_style( 'ea-frontend-style' );
		wp_enqueue_style( 'ea-admin-awesome-css' );
		wp_enqueue_style( 'ea-frontend-bootstrap' );


		ob_start();

		require EA_SRC_DIR . 'templates/ea_bootstrap.tpl.php';
		require EA_SRC_DIR . 'templates/booking.overview.tpl.php';

		?><div class="ea-bootstrap bootstrap" /><?php
		return ob_get_clean();
	}

	/**
	 * 
	 */
	private function get_options($type) 
	{
		if(!$this->generate_next_option) {
			return;
		}

		$dbmod = new EADBModels;

		$rows = $dbmod->get_all_rows("ea_$type");

		// If there is only one result
		if(count($rows) == 1) {
			$price = !empty($rows[0]->price) ? " data-price='{$rows[0]->price}'" : '';
			echo "<option value='{$rows[0]->id}' selected='selected'$price>{$rows[0]->name}</option>";
			return;
		}

		echo "<option value='' selected='selected'>-</option>";

		foreach ($rows as $row) {
			$price = !empty($row->price) ? " data-price='{$row->price}'" : '';
			echo "<option value='{$row->id}'$price>{$row->name}</option>";
		}

		$this->generate_next_option = false;
	}
}