;(function ( $, window, document, undefined ) {
	
	var pluginName = "eaBootstrap",
	
	defaults = {
		main_selector: '#ea-bootstrap-main',
		main_template: null,
		overview_selector: "#ea-appointments-overview",
		overview_template: null,
		store: {},
		ajaxCount: 0
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

			plugin.settings.main_template = _.template($(plugin.settings.main_selector).html());
			plugin.settings.overview_template = _.template($(plugin.settings.overview_selector).html());

			this.$element.html(plugin.settings.main_template({settings:ea_settings}));

			this.$element.find('form').validate();

			// select change event
			this.$element.find('select').not('.custom-field').change(jQuery.proxy( this.getNextOptions, this ));

			jQuery.datepicker.setDefaults( $.datepicker.regional[ea_settings.datepicker] );

			// datePicker
			this.$element.find('.date').datepicker({
				onSelect : jQuery.proxy( plugin.dateChange, plugin ),
				dateFormat : 'yy-mm-dd',
				minDate: 0,
				firstDay: 1,
				// on month change event
				onChangeMonthYear: function(year, month, widget) {
					plugin.selectChange(month, year);
				},
				// add class to every field
				beforeShowDay: function(date) {
					var month = date.getMonth() + 1;
					var days = date.getDate();

					if(month < 10) {
						month = '0' + month;
					}

					if(days < 10) {
						days = '0' + days;
					}

					var response = [true, date.getFullYear() + '-' + month + '-' + days, ''];

					return response;
				}
			});

			// hide options with one choiche
			this.hideDefault();

			// time is selected
			this.$element.find('.ea-bootstrap').on('click', '.time-value', function(element) {
				$(this).parent().children().removeClass('selected-time');
				$(this).addClass('selected-time');

				plugin.appSelected.apply(plugin);
			});

			// init blur next steps
			this.blurNextSteps(this.$element.find('.step:visible:first'), true);

			this.$element.find('.ea-submit').on('click', jQuery.proxy( plugin.finalComformation, plugin ));
			this.$element.find('.ea-cancel').on('click', jQuery.proxy( plugin.cancelApp, plugin ));
		},
		hideDefault: function () {
			var steps = this.$element.find('.step');

			steps.each(function(index, element) {
				var select = $(element).find('select').not('.custom-field');

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

			var step = current.closest('.step');

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

			options.next = next.data('c');

			this.callServer( options, next );
		},
		/**
		 * Standard call for select options (location, service, worker)
		 */
		callServer : function( options, next_element ) {
			var plugin = this;

			options.action = 'ea_next_step';

			this.placeLoader(next_element.parent());

			$.get(ea_ajaxurl, options, function(response) {
				next_element.empty();

				// default
				next_element.append('<option value="">-</option>');

				// options
				$.each(response, function(index, element) {
					var name = element.name;
					var $option = $('<option value="' + element.id +'">' + name + '</option>');

					if('price' in element && ea_settings['price.hide'] !== '1') {
						$option.text(element.name + ' - ' + element.price + next_element.data('currency'));
						$option.data('price', element.price);
					}

					next_element.append($option);
				});

				// enabled
				next_element.closest('.step').removeClass('disabled');

				plugin.removeLoader();

				plugin.scrollToElement(next_element.parent());
			}, 'json');
		},
		placeLoader: function($element) {
			if(++this.settings.ajaxCount !== 1) {
				return;
			}

			var width = $element.width();
			var height = $element.height();
			$('#ea-loader').prependTo($element);
			$('#ea-loader').css({
				'width': width,
				'height': height
			});
			$('#ea-loader').show();
		},
		removeLoader: function(){
			if(--this.settings.ajaxCount > 1){
				return;
			}

			this.settings.ajaxCount = 0;

			$('#ea-loader').hide();
		},
		getCurrentStatus: function() {
			var options = $(this.element).find('select').not('.custom-field');
		},
		blurNextSteps: function( current, dontScroll ) {
			// check if there is scroll param
			dontScroll = dontScroll || false;

			current.removeClass('disabled');

			var nextSteps = current.nextAll('.step:visible');

			var nextParentSteps = current.parent().nextAll('.step:visible');

			$.merge(nextSteps, nextParentSteps);
			// find all next steps in secound column

			nextSteps.each(function(index, element){
				$(element).addClass('disabled');
			});

			// if next step is calendar
			if (current.hasClass('calendar')) {

				var calendar = this.$element.find('.date');

				this.selectChange();

				if(!dontScroll) {
					this.scrollToElement(calendar);
				}
			}
		},
		/**
		 * Change of date - datepicker
		 */
		dateChange: function( dateString, calendar ) {
			var plugin = this, next_element, calendarEl;

			calendarEl = $(calendar.dpDiv).parents( '.date' );

			calendarEl.parent().next().addClass('disabled');

			var options = this.getPrevousOptions(calendarEl);

			options.action = 'ea_date_selected';
			options.date = dateString;

			this.placeLoader(calendarEl);

			$.get(ea_ajaxurl, options, function(response) {

				next_element = $(document.createElement('div'))
							.addClass('time well well-lg');

				$.each(response, function(index, element) {
					if(element.count > 0) {
						next_element.append('<div class="time-value" data-val="' + element.value +'">' + element.show + '</div>');
					} else {
						next_element.append('<div class="time-disabled">' + element.show + '</div>');
					}
				});

				if(response.length === 0) {
					next_element.html('<p class="time-message">' + ea_settings['trans.please-select-new-date'] + '</p>');
				}

				var newRow = $(document.createElement('tr'))
							.addClass('time-row')
							.append('<td colspan="7" />');

				newRow.find('td').append(next_element);

				$(calendar.dpDiv).find('.ui-datepicker-current-day').closest('tr').after(newRow);

				// enabled
				next_element.parent().removeClass('disabled');

			}, 'json')
			.always(function() {
				plugin.refreshData(plugin.settings.store);
				plugin.removeLoader();
			});
		},
		selectChange: function(month, year) {
			var self = this;
			self.placeLoader(self.$element.find('.calendar'));

			var simulateClick = false;

			if(typeof month === 'undefined' || typeof year === 'undefined') {
				var currentDate = this.$element.find('.date').datepicker('getDate');

				month = currentDate.getMonth() + 1;
				year  = currentDate.getFullYear();

				simulateClick = true;
			}

			// check is all filled
			if(this.checkStatus()) {
				var selects = this.$element.find('select').not('.custom-field');

				var fields = selects.serializeArray();

				fields.push({ 'name' : 'action', 'value': 'ea_month_status' });
				fields.push({ 'name' : 'month', 'value': month });
				fields.push({ 'name' : 'year', 'value': year });

				$.get(ea_ajaxurl, fields, function(result) {
					self.settings.store = result;
					self.refreshData(result);

					if(simulateClick) {
						self.$element.find('.ui-datepicker-current-day').filter('.free').click();
					}
				}, 'json');
			}
		},
		refreshData: function(data) {

			var datepicker = this.$element.find('.date');

			$.each(data, function(key, status){

				var td = datepicker.find('.' + key);

				td.addClass(status);
			});

			this.removeLoader();
		},
		/**
		 * Is everything selected
		 * @return {boolean} Is ready for sending data
		 */
		checkStatus: function() {
			var selects = this.$element.find('select').not('.custom-field');

			var isComplete = true;

			selects.each(function(index, element) {
				isComplete = isComplete && $(element).val() !== '';
			});

			return isComplete;
		},
		/**
		 * Appintment information - before user add personal
		 * information
		 */ 
		appSelected: function(element) {
			var plugin = this;

			this.placeLoader(this.$element.find('.selected-time'));

			// make pre reservation
			var options = {
				location : this.$element.find('[name="location"]').val(),
				service : this.$element.find('[name="service"]').val(),
				worker : this.$element.find('[name="worker"]').val(),
				date : this.$element.find('.date').datepicker().val(),
				start : this.$element.find('.selected-time').data('val'),
				action : 'ea_res_appointment'
			};

			// for booking overview
			var booking_data = {};
			booking_data.location = this.$element.find('[name="location"] > option:selected').text();
			booking_data.service = this.$element.find('[name="service"] > option:selected').text();
			booking_data.worker =  this.$element.find('[name="worker"] > option:selected').text();
			booking_data.date = this.$element.find('.date').datepicker().val();
			booking_data.time = this.$element.find('.selected-time').text();
			booking_data.price = this.$element.find('[name="service"] > option:selected').data('price');

			$.get(ea_ajaxurl, options, function(response) {
				plugin.res_app = response.id;

				plugin.$element.find('.step').addClass('disabled');
				plugin.$element.find('.final').removeClass('disabled');

				plugin.scrollToElement(plugin.$element.find('.final'));

				// set overview cancel_appointment
				var overview_content = '';

				overview_content = plugin.settings.overview_template({data: booking_data, settings: ea_settings});

				plugin.$element.find('#booking-overview').html(overview_content);

			}, 'json')
			.fail(function(response) {
				alert(response.responseJSON.message);
			})
			.always(function() {
				plugin.removeLoader();
			});
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

			this.$element.find('.ea-submit').prop('disabled', true);

			// make pre reservation
			var options = {
				id : this.res_app
			};

			this.$element.find('.custom-field').each(function(index, element){
				var name = $(element).attr('name');
				options[name] = $(element).val();
			});

			options.action = 'ea_final_appointment';

			$.get(ea_ajaxurl, options, function(response) {
				plugin.$element.find('.ea-submit').hide();
				plugin.$element.find('.ea-cancel').hide();
				plugin.$element.find('.final').append('<h3>' + ea_settings['trans.done_message'] + '</h3>');
				plugin.$element.find('form').find('input,select,textarea').prop('disabled', true);
			}, 'json')
			.fail(function(){
				plugin.find('.ea-submit').prop('disabled', false);
			});
		},
		/**
		 * Cancel appointment
		 */
		cancelApp : function(event) {
			event.preventDefault();

			var plugin = this;

			this.$element.find('.final').addClass('disabled');
			this.$element.find('.step:not(.final)').prevAll('.step').removeClass('disabled');

			var options = {
				id : this.res_app,
				action : 'ea_cancel_appointment'
			};

			$.get(ea_ajaxurl, options, function(response) {
				if(response.data) {
					// remove selected time
					plugin.$element.find('.time').find('.selected-time').removeClass('selected-time');
					
					//plugin.scrollToElement(plugin.$element.find('.date'));
					plugin.chooseStep();
					plugin.res_app = null;

				}
			}, 'json');
		},
		chooseStep : function () {
			var plugin = this;
			var $temp;

			switch(ea_settings['cancel.scroll']) {
				case 'calendar':
					plugin.scrollToElement(plugin.$element.find('.date'));
					break;
				case 'worker' :
					$temp = plugin.$element.find('[name="worker"]');
					$temp.val('');
					$temp.change();
					$temp.closest('.step').nextAll('.step').find('select').val('');
					this.$element.find('.time-row').remove();
					plugin.scrollToElement($temp);
					break;
				case 'service' :
					$temp = plugin.$element.find('[name="service"]');
					$temp.val('');
					$temp.change();
					$temp.closest('.step').nextAll('.step').find('select').val('');
					this.$element.find('.time-row').remove();
					plugin.scrollToElement($temp);
					break;
				case 'location' : 
					$temp = plugin.$element.find('[name="location"]');
					$temp.val('');
					$temp.change();
					$temp.closest('.step').nextAll('.step').find('select').val('');
					this.$element.find('.time-row').remove();
					plugin.scrollToElement($temp);
					break;
				case 'pagetop':
					break;
			}
		},
		scrollToElement : function(element) {
			if(ea_settings.scroll_off === 'true') {
				return;
			}

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
	$('.ea-bootstrap').eaBootstrap();
})( jQuery );