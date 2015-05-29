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
		// admin panel script
		wp_register_script(
			'ea-front-end',
			EA_PLUGIN_URL . 'js/frontend.js',
			array( 'jquery', 'jquery-ui-datepicker' ),
			false,
			true
		);

		wp_register_style(
			'jquery-style',
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css'
		);

		wp_register_style(
			'ea-frontend-style',
			EA_PLUGIN_URL . 'css/eafront.css'
		);

		// admin style
		wp_register_style(
			'ea-admin-awesome-css',
			EA_PLUGIN_URL . 'css/font-awesome.css'
		);
	}

	/**
	 * 
	 */
	public function standard_app($attrs)
	{
		wp_enqueue_script( 'ea-validator' );
		wp_enqueue_script( 'ea-front-end' );
		wp_enqueue_style( 'jquery-style' );
		wp_enqueue_style( 'ea-frontend-style' );
		wp_enqueue_style( 'ea-admin-awesome-css' );

		ob_start();

		?>
<script type="text/javascript">
	var ea_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
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
			<h4>Personal information</h4>
			<small>Fields with * are required</small><br>
			<p><label>Email * : </label><input type="text" name="email" data-rule-required="true" data-rule-email="true" data-msg-email="Please enter a valid email address"></p>
			<p><label>Name * : </label><input type="text" name="name" data-rule-required="true" data-rule-minlength="3"></p>
			<p><label>Phone * : </label><input type="text" name="phone" data-rule-required="true" data-rule-minlength="3"></p>
			<textarea name="description"></textarea>
			<p>Booking overview</p>
			<div id="booking-overview"></div>
			<br>
			<button class="ea-btn ea-submit">Submit</button>
			<button class="ea-btn ea-cancel">Cancel</button>
		</div>
	</form>
</div>
		<?php

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

			echo "<option value='{$rows[0]->id}' selected='selected'>{$rows[0]->name}</option>";
			return;
		}

		echo "<option value='' selected='selected'>-</option>";

		foreach ($rows as $row) {
			echo "<option value='{$row->id}'>{$row->name}</option>";
		}

		// $this->generate_next_option = false;
	}
}