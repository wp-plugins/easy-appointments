;(function ( $, window, document, undefined ) {
	
	var pluginName = "eaStandard",
	
	defaults = {
		overview_selector: "#ea-appointments-overview",
		overview_template: null
	};

	// The actual plugin constructor
	function Plugin ( element, options ) {
		this.element = element;
		this.$element = $(element);
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	$.extend(Plugin.prototype, {
		/**
		 * Plugin init
		 */
		init: function () {
			var plugin = this;

			this.settings.overview_template = _.template($(this.settings.overview_selector).html());

			this.$element.find('form').validate();

			// select change event
			this.$element.find('select').change(jQuery.proxy( this.getNextOptions, this ));

			// datePicker
			this.$element.find('.date').datepicker({
				onSelect : jQuery.proxy( plugin.dateChange, plugin ),
				dateFormat : 'yy-mm-dd',
				minDate: 0,
				firstDay: 1
			});

			// hide options with one choiche
			this.hideDefault();

			// time is selected
			this.$element.find('.time').on('click', '.time-value', function(element) {
				$(this).parent().children().removeClass('selected-time');
				$(this).addClass('selected-time');

				plugin.appSelected.apply(plugin);
			});

			// init blur next steps
			this.blurNextSteps(this.$element.find('.step:visible:first'));

			this.$element.find('.ea-submit').on('click', jQuery.proxy( plugin.finalComformation, plugin ));
			this.$element.find('.ea-cancel').on('click', jQuery.proxy( plugin.cancelApp, plugin ));
		},
		hideDefault: function () {
			var steps = this.$element.find('.step');

			steps.each(function(index, element) {
				var select = $(element).find('select');

				if(select.length < 1) {
					return;
				}

				var options = select.children('option');

				if(options.length !== 1) {
					return;
				}

				if(options.value !== '') {
					$(element).hide();
				}
			});
		},
		// get All previus step options
		getPrevousOptions: function( element ) {
			var step = element.parents( '.step' );
			
			var options = {};

			var data_prev = step.prevAll( '.step' );

			data_prev.each(function(index, elem){
				var option = $(elem).find( 'select,input' ).first();

				options[$(option).data('c')] = option.val();
			});

			return options;
		},
		/**
		 * Get next select option
		 */
		getNextOptions: function ( event ) {
			var current = $(event.target);

			var step = current.parent('.step');

			// blur next options
			this.blurNextSteps(step);

			// nothing selected
			if( current.val() === '' ) {
				return;
			}

			var options = {};

			options[current.data('c')] = current.val();

			var data_prev = step.prevAll('.step');

			data_prev.each(function(index, elem){
				var option = $(elem).find( 'select,input' ).first();

				options[$(option).data('c')] = option.val();
			});

			// hidden
			this.$element.find('.step:hidden').each(function(index, elem){
				var option = $(elem).find( 'select,input' ).first();

				options[$(option).data('c')] = option.val();
			});

			//only visible step
			var nextStep = step.nextAll( '.step:visible:first' );

			next = $(nextStep).find( 'select,input' );

			if(next.length === 0) {
				this.blurNextSteps(nextStep);
				//nextStep.removeClass('disabled');
				return;
			}

			options['next'] = next.data('c');

			this.callServer( options, next );
		},
		/**
		 * Standard call for select options (location, service, worker)
		 */
		callServer : function( options, next_element ) {
			var plugin = this;

			options['action'] = 'next_step';

			$.get(ea_ajaxurl, options, function(response) {
				next_element.empty();

				// default
				next_element.append('<option value="">-</option>');

				// options
				$.each(response, function(index, element) {
					var name = element.name;

					if('price' in element && ea_settings['price.hide'] !== '1') {
						name = element.name + ' - ' + element.price + next_element.data('currency');
					}

					next_element.append('<option value="' + element.id +'">' + name + '</option>');
				});

				// enabled
				next_element.parent().removeClass('disabled');

				plugin.scrollToElement(next_element.parent());
			}, 'json');
		},
		getCurrentStatus: function() {
			var options = $(this.element).find('select');
		},
		blurNextSteps: function( current ) {
			current.removeClass('disabled');

			var nextSteps = current.nextAll('.step:visible');

			nextSteps.each(function(index, element){
				$(element).addClass('disabled');
			});

			// if next step is calendar
			if (current.hasClass('calendar')) {
				var calendar = this.$element.find('.date');

				this.$element.find('.ui-datepicker-current-day').click();
				this.scrollToElement(calendar);
			}
		},
		/**
		 * Change of date - datepicker
		 */
		dateChange: function( dateString, calendar ) {
			var plugin = this;

			calendar = $(calendar.dpDiv).parents( '.date' );

			calendar.parent().next().addClass('disabled');

			var options = this.getPrevousOptions(calendar);

			options['action'] = 'date_selected';
			options['date'] = dateString;

			$.get(ea_ajaxurl, options, function(response) {

				next_element = $(calendar).parent().next('.step').children('.time');

				next_element.empty();

				$.each(response, function(index, element) {
					if(element.count > 0) {
						next_element.append('<div class="time-value" data-val="' + element.value +'">' + element.show + '</div>');
					} else {
						next_element.append('<div class="time-disabled">' + element.show + '</div>');
					}
				});

				if(response.length === 0) {
					next_element.html('<p class="time-message">Please select another day</p>');
				}

				// enabled
				next_element.parent().removeClass('disabled');

			}, 'json');
		},
		/**
		 * Appintment information - before user add personal
		 * information
		 */ 
		appSelected: function(element) {
			var plugin = this;

			// make pre reservation
			var options = {
				location : this.$element.find('[name="location"]').val(),
				service : this.$element.find('[name="service"]').val(),
				worker : this.$element.find('[name="worker"]').val(),
				date : this.$element.find('.date').datepicker().val(),
				start : this.$element.find('.selected-time').data('val'),
				action : 'res_appointment'
			}

			// for booking overview
			var booking_data = {};
			booking_data.location = this.$element.find('[name="location"] > option:selected').text();
			booking_data.service = this.$element.find('[name="service"] > option:selected').text();
			booking_data.worker =  this.$element.find('[name="worker"] > option:selected').text();
			booking_data.date = this.$element.find('.date').datepicker().val();
			booking_data.time = this.$element.find('.selected-time').text();

			$.get(ea_ajaxurl, options, function(response) {

				plugin.res_app = response.id;

				plugin.$element.find('.step').addClass('disabled');
				plugin.$element.find('.final').removeClass('disabled');

				plugin.scrollToElement(plugin.$element.find('.final'));

				// set overview cancel_appointment
				var overview_content = '';

				overview_content = plugin.settings.overview_template({data: booking_data, settings: ea_settings});

				$('#booking-overview').html(overview_content);

			}, 'json');
		},
		/**
		 * Comform appointment
		 */
		finalComformation: function(event) {
			event.preventDefault();

			var plugin = this;

			var form = this.$element.find('form');

			if(!form.valid()) {
				return;
			}

			// make pre reservation
			var options = {
				name : this.$element.find('[name="name"]').val(),
				email : this.$element.find('[name="email"]').val(),
				phone : this.$element.find('[name="phone"]').val(),
				description : this.$element.find('[name="description"]').datepicker().val(),
				id : this.res_app
			}

			options['action'] = 'final_appointment';

			$.get(ea_ajaxurl, options, function(response) {
				plugin.$element.find('.ea-submit').hide();
				plugin.$element.find('.ea-cancel').hide();
				plugin.$element.find('.final').append('<h4>' + ea_settings['trans.done_message'] + '</h4>');

			}, 'json');
		},
		/**
		 * Cancel appointment
		 */
		cancelApp : function(event) {
			event.preventDefault();

			var plugin = this;

			this.$element.find('.final').addClass('disabled').prevAll('.step').removeClass('disabled');

			var options = {
				id : this.res_app,
				action : 'cancel_appointment'
			}

			$.get(ea_ajaxurl, options, function(response) {
				if(response.data) {
					// remove selected time
					plugin.$element.find('.time').find('.selected-time').removeClass('selected-time');
					
					plugin.scrollToElement(plugin.$element.find('.date'));
					plugin.res_app = null;

				}
			}, 'json');

		},
		scrollToElement : function(element) {
			$('html, body').animate({
				scrollTop: ( element.offset().top - 20 )
			}, 500);
		}
	});
	
	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[ pluginName ] = function ( options ) {
		this.each(function() {
			if ( !$.data( this, "plugin_" + pluginName ) ) {
				$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
			}
		});
		// chain jQuery functions
		return this;
	};
})( jQuery, window, document );


(function($){
	$('.ea-standard').eaStandard();
})( jQuery );