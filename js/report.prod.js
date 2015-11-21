(function($) {

    var EA = {};

    Backbone.ajax = function() {
        var args = Array.prototype.slice.call(arguments, 0)[0];
        var change = {};

        if(args.type === 'PUT' || args.type === 'DELETE') {
            change.type = 'POST';
            change.url = args.url + '&_method=' + args.type;
        }

        var newArgs = _.extend(args, change);
        return Backbone.$.ajax.apply(Backbone.$, [newArgs]);
    };    /**
     * Single location
     */
    EA.Location = Backbone.Model.extend({
        defaults : {
            name:"",
            address: "",
            location: "",
            cord: null
        },

        url: function() { return ajaxurl+'?action=ea_location&id=' + encodeURIComponent(this.id) },

        toJSON : function() {
            var attrs = _.clone( this.attributes );
            return attrs;
        }
    });    /**
     * Service model
     */
    EA.Service = Backbone.Model.extend({
        defaults : {
            name:"",
            duration: 60,
            price: 10
        },
        url : function() {
            return ajaxurl+'?action=ea_service&id=' + this.id;
        },
        toJSON : function() {
            var attrs = _.clone( this.attributes );
            return attrs;
        }
    });    /**
     * Service model
     */
    EA.Worker = Backbone.Model.extend({
        defaults : {
            name:"",
            description : "",
            email: "",
            phone: ""
        },
        url : function() {
            return ajaxurl+'?action=ea_worker&id=' + this.id;
        },
        toJSON : function() {
            var attrs = _.clone( this.attributes );
            return attrs;
        }
    });    /**
     * Single connection
     */
    EA.Connection = Backbone.Model.extend({
        defaults : {
            group_id : null,
            location : null,
            service : null,
            worker : null,
            day_of_week : [],
            time_from : null,
            time_to : null,
            day_from : '2015-01-01',
            day_to : '2020-01-01',
            is_working : 0
        },

        url: function() { return ajaxurl+'?action=ea_connection&id=' + encodeURIComponent(this.id) },

        toJSON: function() {
            var attrs = _.clone( this.attributes );
            //console.log(attrs);
            return attrs;
        },

        parse: function(data, options) {

            if(typeof data.day_of_week !== "undefined" && data.day_of_week != null) {
                data.day_of_week = data.day_of_week.split(',');
            } else {
                // console.log(this.get('day_of_week').split(','));
                this.set('day_of_week', this.get('day_of_week'));
            }

    		if(typeof data.time_from !== "undefined" && typeof data.time_to !== "undefined") {

    			if(data.time_from.length === 8) {
    				data.time_from = data.time_from.substring(0, 5);
    			}

    			if(data.time_to.length === 8) {
    		            data.time_to = data.time_to.substring(0, 5);
    	        }
        	}

            return data;
        },

        save: function(attrs, options) {
            options || (options = {});
            attrs || (attrs = _.clone(this.attributes));

            attrs.day_of_week = attrs.day_of_week.join(',');

            return Backbone.Model.prototype.save.call(this, attrs, options);
        }
    });    /**
     * Service model
     */
    EA.Setting = Backbone.Model.extend({
        defaults : {
            ea_key:"",
            ea_value : "",
            type: ""
        },
        url : function() {
            return ajaxurl+'?action=ea_setting&id=' + this.id;
        },
        toJSON : function() {
            var attrs = _.clone( this.attributes );
            return attrs;
        },
        parse: function(data, options) {
            // console.log(data);
            return data;
        }
    });    /**
     * Locations collection
     */
    EA.Locations = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_locations',
        model: EA.Location,
        cacheData: function() {
            if(typeof eaData !== 'undefined') {
                eaData.Locations = this.toJSON();
            }
        }
    });    /**
     * Services collection
     */
    EA.Services = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_services',
        model: EA.Service,
        parse: function(response) {
        	// console.log(response);
        	return response;
      	},
      	cacheData: function() {
            if(typeof eaData !== 'undefined') {
                eaData.Services = this.toJSON();
            }
        }
    });    /**
     * Workers collection
     */
    EA.Workers = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_workers',
        model: EA.Worker,
        cacheData: function() {
            if(typeof eaData !== 'undefined') {
                eaData.Workers = this.toJSON();
            }
        }
    });    /**
     * Connections collection
     */
    EA.Connections = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_connections',
        model: EA.Connection
    });    /**
     * Settings collection
     */
    EA.Settings = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_settings',
        model: EA.Setting
    });

    /**
     * Wrapper around settings data
     */
    EA.SettingsWrapper = Backbone.Model.extend({
    	url : ajaxurl+'?action=ea_settings',
    	/*toJSON : function() {
    		return this.model.toJSON();
    	}*/
    });    /**
     * Main Report View
     * Renders Report Admin page
     *
     **/
    EA.ReportView = Backbone.View.extend({
    	el : $('#wpbody-content'),

    	template : _.template( $("#ea-report-main").html() ),

    	events : {
    		"click .report"  : "reportSelected"
    	},

    	initialize: function () {
    		this.render();

    	},

    	render: function () {
    		this.$el.empty();

    		this.$el.html( this.template());

    		return this;
    	},

    	reportSelected: function(elem) {
    		var report = $(elem.currentTarget).data('report');

    		switch (report) {
    			case 'overview' :
    				var rep = new EA.OverviewReportView();
    				var output = rep.render();

    				this.$el.find('#report-content').html(output.$el);
    				break;
    		}
    	},
    });    /**
     * Overvire report view
     */
    EA.OverviewReportView = Backbone.View.extend({

    	template : _.template( $("#ea-report-overview").html() ),

    	events : {
    		'change select' : 'selectChange',
    		'click .refresh': 'selectChange'
    	},

    	initialize: function () {
    		jQuery.datepicker.setDefaults( $.datepicker.regional[ea_settings.datepicker] );

    		this.render();
    	},

    	render: function() {
    		var view = this;

    		this.$el.empty();

    		this.$el.html( this.template({ cache: eaData }) );

    		this.$el.find('.datepicker').datepicker({
    			firstDay: 1,
    			dayNamesMin: $.datepicker.regional[ea_settings.datepicker].dayNames,
    			onChangeMonthYear: function(year, month, widget) {
    				view.selectChange(month, year);
    			},

    			beforeShowDay: function(date) {
    				var month = date.getMonth() + 1;
    				var days = date.getDate();

    				if(month < 10) {
    					month = '0' + month;
    				}

    				if(days < 10) {
    					days = '0' + days;
    				}

    				var response = [false, date.getFullYear() + '-' + month + '-' + days, ''];

    				return response;
    			}
    		});

    		return this;
    	},

    	selectChange: function(month, year) {
    		var self = this;

    		if(typeof month === 'undefined' || typeof year === 'undefined') {
    			var currentDate = this.$el.find('.datepicker').datepicker('getDate');

    			month = currentDate.getMonth() + 1;
    			year  = currentDate.getFullYear();
    		}

    		// check is all filled
    		if(this.checkStatus()) {
    			var selects = this.$el.find('select');

    			var fields = selects.serializeArray();

    			fields.push({ 'name' : 'action', 'value': 'ea_report' });
    			fields.push({ 'name' : 'report', 'value': 'overview' });
    			fields.push({ 'name' : 'month', 'value': month });
    			fields.push({ 'name' : 'year', 'value': year });

    			$.get(ajaxurl, fields, function(result) {
    				self.refreshData(result);
    			}, 'json');
    		}
    	},
    	/**
    	 * Is everything selected
    	 * @return {boolean} Is ready for sending data
    	 */
    	checkStatus: function() {
    		var selects = this.$el.find('select');

    		var isComplete = true;

    		selects.each(function(index, element) {
    			isComplete = isComplete && $(element).val() !== '';
    		});

    		return isComplete;
    	},

    	refreshData: function(data) {
    		var datepicker = this.$el.find('.datepicker');

    		$.each(data, function(key, slots){
    			var td = datepicker.find('.' + key);
    			td.find('.single-item').remove();

    			if(slots.length === 0) {
    				td.addClass('empty-day');
    				return;
    			} else {
    				td.removeClass('empty-day');
    			}

    			var itemElement;
    			for (var i = 0; i < slots.length; i++) {

    				itemElement = $(document.createElement('div'))
    					.text(slots[i].show + ' - x ' + slots[i].count	)
    					.addClass('single-item')
    					.addClass('free-items-' + slots[i].count)
    					.data('value', slots[i].value)
    					.appendTo(td);

    				if(slots[i].count < 0) {
    					itemElement.addClass('error-booking');
    				}
    			}
    		});
    	}
    });
    var mainView = new EA.ReportView();

}(jQuery));