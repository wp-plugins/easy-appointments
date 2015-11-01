(function($) {

    var EA = {};

    /**
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
     * Single field
     */
    EA.Field = Backbone.Model.extend({

    	defaults : {
    		type: 'INPUT',
    		slug: '',
    		label: '',
    		default_value: '',
    		validation: false,
    		mixed: '',
    		visible: true,
    		required: false,
    		position: 10,
    	},
    	url: function() { return ajaxurl+'?action=ea_field&id=' + encodeURIComponent(this.id); },
    	toJSON: function() {
    		var attrs = _.clone( this.attributes );
    		//console.log(attrs);
    		return attrs;
    	}
    });    /**
     * Connections collection
     */
    EA.Fields = Backbone.Collection.extend({
        url : ajaxurl+'?action=ea_fields',
        model: EA.Field
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
     * Locations main view
     */
    EA.LocationView = Backbone.View.extend({

        tagName:  "tr",

        // show template
        template_show : _.template( $("#ea-tpl-locations-row").html() ),

        // edit template
        template_edit : _.template( $("#ea-tpl-locations-row-edit").html() ),

        template : null,

        events: {
            "click .btn-edit"   : "edit",
            "dblclick"          : "edit",
            "click .btn-del"    : "removeItem",
            "click .btn-save"   : "save",
            "click .btn-cancel" : "cancel",
            "keydown input"     : "keydownEvent"
        },

        initialize: function (options) {
            this.template = this.template_show;
            this.render();

            this.parent = options.parent;
        },

        render: function () {

            var renderedContent = this.template( { row : this.model.toJSON() } );

            $(this.el).html( renderedContent );

            this.$el.addClass('ea-row');

            return this;
        },

        edit: function() {
            // Edit class
            this.$el.addClass('ea-editing');

            this.template = this.template_edit;
            this.render();

            this.$el.find('input:first').focus();
        },

        save: function() {
            var location = this.model;
            var view = this;

            $.each(this.$el.find('input'), function(index, elem){
                location.set($(elem).data('prop'), $(elem).val());
            });

            this.parent.showMessage('Saving...');

            // Saves location
            location.save(null, {
                success: function(model, response) {
                    view.render();
                    model.collection.cacheData();
                    view.parent.showMessage('Saved...');
                }
            });

            this.$el.removeClass('ea-editing');

            this.template = this.template_show;
            this.render();
        },

        cancel: function() {
            // If is new remove model/view
            if(this.model.isNew()) {
                this.parent.showMessage('New canceled');

                this.model.destroy();
                this.remove();
            } else {
                this.parent.showMessage('Edit canceled');

                this.$el.removeClass('ea-editing');

                this.template = this.template_show;
                this.render();
            }
        },

        // Delets model and view
        removeItem: function() {
            var view = this;

            if(confirm('Are you sure?')) {
                view.parent.showMessage('Deleting...');

                this.model.destroy({
                    success: function(model, response) {
                        view.remove();
                        view.parent.showMessage('Done...');
                    },
                    error: function(model, response) {
                        view.parent.showMessage('Error...');
                    }
                });
            }
        },

        //
        keydownEvent: function(e) {
            switch (e.which) {
                // esc
                case 27 :
                    this.cancel();
                break;
            }
        }
    });    // Main tamplate
    EA.LocationsView = Backbone.View.extend({
        //el: $("#wpbody-content"),

        template : _.template( $("#ea-tpl-locations-table").html() ),

        rowsView : null,

        events : {
            "click .add-new" : "addNew",
            "click .refresh-list" : "refreshList"
        },

        initialize: function () {
            // Get pre chache data
            if(typeof eaData !== 'undefined'){
                this.collection = new EA.Locations(eaData.Locations);
            } else {
                this.collection = new EA.Locations();
            }

            // Table draw
            this.render();

            // Bind the reset event
            this.collection.bind("reset", this.render, this);

            // if there is no data in cache
            if( this.collection.length === 0 ) {
                // Get data from server
                this.collection.fetch( {reset:true} );
            }
        },

        render: function () {

            this.$el.empty(); // clear the element to make sure you don't double your contact view

            this.$el.html( this.template );

            var self = this; // so you can use this inside the each function

            this.collection.each(function(location) { // iterate through the collection
                var locationView = new EA.LocationView({
                    model: location,
                    parent: self
                });

                self.$el.find("#ea-locations").append(locationView.$el);
            });

            return this;
        },

        addNew: function(e) {
            e.preventDefault();

            var location = new EA.Location();
            var self = this;

            this.collection.add(location, {at: 0});

            var locationView = new EA.LocationView({
                model: location,
                parent: self
            });

            this.$el.find("#ea-locations").prepend(locationView.$el);

            locationView.edit();
        },

        refreshList: function(e) {
            e.preventDefault();

            var that = this;

            this.showMessage('Loading table...', true);

            this.collection.fetch( {reset:true}, {
                error: function(response){
                    that.showMessage('');
                    alert('Error, try refresh again.');
                },
                success: function(){
                    that.showMessage('');
                }
            });
        },

        destroy_view: function() {

            // COMPLETELY UNBIND THE VIEW
            this.undelegateEvents();

            this.$el.removeData().unbind();

            // Remove view from DOM
            this.remove();
            Backbone.View.prototype.remove.call(this);

        },

        showMessage: function(text, hold) {
            var onHold = hold || false;

            if(onHold) {
                this.$el.find('#status-msg').text(text).show();
            } else {
                this.$el.find('#status-msg').text(text).show().delay(2000).fadeOut();
            }
        }
    });    /**
     * Services main view
     */
    EA.ServiceView = Backbone.View.extend({

        tagName:  "tr",

        // show template
        template_show : _.template( $("#ea-tpl-services-row").html() ),

        // edit template
        template_edit : _.template( $("#ea-tpl-services-row-edit").html() ),

        template : null,

        events: {
            "click .btn-edit"   : "edit",
            "dblclick"          : "edit",
            "click .btn-del"    : "removeItem",
            "click .btn-save"   : "save",
            "click .btn-cancel" : "cancel",
            "keydown input"     : "keydownEvent"
        },

        initialize: function (options) {
            this.template = this.template_show;

            this.parent = options.parent;
            this.render();
        },

        render: function () {

            var renderedContent = this.template( { row : this.model.toJSON() } );

            $(this.el).html( renderedContent );

            this.$el.addClass('ea-row');

            return this;
        },

        edit: function() {
            // Edit class
            this.$el.addClass('ea-editing');

            this.template = this.template_edit;
            this.render();

            this.$el.find('input:first').focus();
        },

        save: function() {
            var service = this.model;
            var view = this;

            $.each(this.$el.find('input'), function(index, elem){
                service.set($(elem).data('prop'), $(elem).val());
            });

            this.parent.showMessage('Saving...');

            // Saves Service
            service.save(null, {
                success: function(model, response) {
                    view.render();
                    model.collection.cacheData();
                    view.parent.showMessage('Saved...');
                }
            });

            this.$el.removeClass('ea-editing');

            this.template = this.template_show;
            this.render();
        },

        cancel: function() {
            // If is new remove model/view
            if(this.model.isNew()) {
                this.model.destroy();
                this.remove();

                this.parent.showMessage('New canceled');

            } else {

                this.$el.removeClass('ea-editing');

                this.template = this.template_show;
                this.render();

                this.parent.showMessage('Edit canceled');
            }
        },

        // Delets model and view
        removeItem: function() {
            var view = this;

            if(confirm('Are you sure?')) {
                view.parent.showMessage('Deleting...');

                this.model.destroy({
                    success: function(model, response) {
                        view.remove();
                        view.parent.showMessage('Done...');
                    },
                    error: function(model, response) {
                        view.parent.showMessage('Error...');
                    }
                });
            }
        },

        //
        keydownEvent: function(e) {
            switch (e.which) {
                // esc
                case 27 :
                    this.cancel();
                break;
            }
        }
    });    // Main tamplate
    EA.ServicesView = Backbone.View.extend({
        //el: $("#wpbody-content"),

        template : _.template( $("#ea-tpl-services-table").html() ),

        rowsView : null,

        events : {
            "click .add-new" : "addNew",
            "click .refresh-list" : "refreshList"
        },

        initialize: function () {
            // Get pre chache data
            if(typeof eaData !== 'undefined'){
                this.collection = new EA.Services(eaData.Services);
            } else {
                this.collection = new EA.Services();
            }

            // Table draw
            this.render();

            // Bind the reset event
            this.collection.bind("reset", this.render, this);

            // if there is no data in cache
            if( this.collection.length == 0 ) {
                // Get data from server
                this.collection.fetch( {reset:true} );
            }
        },

        render: function () {

            this.$el.empty(); // clear the element to make sure you don't double your contact view

            this.$el.html( this.template );

            var self = this; // so you can use this inside the each function

            this.collection.each(function(service) { // iterate through the collection
                var serviceView = new EA.ServiceView({
                    model: service,
                    parent: self
                });

                self.$el.find("#ea-services").append(serviceView.$el);
            });

            if(typeof eaData !== 'undefined') {
                eaData.Services = this.collection.toJSON();
            }

            return this;
        },

        addNew: function(e) {
            e.preventDefault();

            var service = new EA.Service();
            var self = this;

            this.collection.add(service, {at: 0});

            var serviceView = new EA.ServiceView({
                model: service,
                parent: self
            });

            this.$el.find("#ea-services").prepend(serviceView.$el);

            serviceView.edit();
        },

        refreshList: function(e) {
            e.preventDefault();

            var that = this;

            this.showMessage('Loading table...', true);

            this.collection.fetch( {reset:true}, {
                error: function(response) {
                    that.showMessage('');
                    alert('Error, try refresh again.');
                },
                success: function() {
                    that.showMessage('');
                }
            });
        },

        destroy_view: function() {
            // COMPLETELY UNBIND THE VIEW
            this.undelegateEvents();

            this.$el.removeData().unbind();

            // Remove view from DOM
            this.remove();
            Backbone.View.prototype.remove.call(this);
        },

        showMessage: function(text, hold) {
            var onHold = hold || false;

            if(onHold) {
                this.$el.find('#status-msg').text(text).show();
            } else {
                this.$el.find('#status-msg').text(text).show().delay(2000).fadeOut();
            }
        }
    });    /**
     * Worker main view
     */
    EA.WorkerView = Backbone.View.extend({

        tagName:  "tr",

        // show template
        template_show : _.template( $("#ea-tpl-worker-row").html() ),

        // edit template
        template_edit : _.template( $("#ea-tpl-worker-row-edit").html() ),

        template : null,

        events: {
            "click .btn-edit"   : "edit",
            "dblclick"          : "edit",
            "click .btn-del"    : "removeItem",
            "click .btn-save"   : "save",
            "click .btn-cancel" : "cancel",
            "keydown input"     : "keydownEvent"
        },

        initialize: function (options) {
            this.template = this.template_show;
            this.parent = options.parent;

            this.render();
        },

        render: function () {

            var renderedContent = this.template( { row : this.model.toJSON() } );

            $(this.el).html( renderedContent );

            this.$el.addClass('ea-row');

            return this;
        },

        edit: function() {
            // Edit class
            this.$el.addClass('ea-editing');

            this.template = this.template_edit;
            this.render();

            this.$el.find('input:first').focus();
        },

        save: function() {
            var worker = this.model;
            var view = this;

            $.each(this.$el.find('input'), function(index, elem){
                worker.set($(elem).data('prop'), $(elem).val());
            });

            this.parent.showMessage('Saving...');

            // Saves Worker
            worker.save(null, {
                success: function(model, response) {
                    view.render();
                    model.collection.cacheData();
                    view.parent.showMessage('Saved...');
                }
            });

            this.$el.removeClass('ea-editing');

            this.template = this.template_show;
            this.render();
        },

        cancel: function() {
            // If is new remove model/view
            if(this.model.isNew()) {
                this.parent.showMessage('New canceled');

                this.model.destroy();
                this.remove();

            } else {
                this.parent.showMessage('Edit canceled');

                this.$el.removeClass('ea-editing');

                this.template = this.template_show;
                this.render();
            }
        },

        // Delets model and view
        removeItem: function() {
            var view = this;

            if(confirm('Are you sure?')) {
                view.parent.showMessage('Deleting...');

                view.model.destroy({
                    success: function(model, response) {
                        view.remove();
                        view.parent.showMessage('Done...');
                    },
                    error: function(model, response) {
                        view.parent.showMessage('Error...');
                    }
                });
            }
        },

        //
        keydownEvent: function(e) {
            switch (e.which) {
                // esc
                case 27 :
                    this.cancel();
                break;
            }
        }
    });    // Main tamplate
    EA.StaffView = Backbone.View.extend({

    	template : _.template( $("#ea-tpl-staff-table").html() ),

    	rowsView : null,

    	events : {
    		"click .add-new" : "addNew",
    		"click .refresh-list" : "refreshList"
    	},

    	initialize: function () {

    		// Get pre chache data
    		if(typeof eaData !== 'undefined'){
    			this.collection = new EA.Workers(eaData.Workers);
    		} else {
    			this.collection = new EA.Workers();
    		}

    		// Table draw
    		this.render();

    		// Bind the reset event
    		this.collection.bind("reset", this.render, this);

    		// if there is no data in cache
    		if( this.collection.length == 0 ) {
    			// Get data from server
    			this.collection.fetch( {reset:true} );
    		}
    	},

    	render: function () {

    		this.$el.empty(); // clear the element to make sure you don't double your contact view

    		this.$el.html( this.template );

    		var self = this; // so you can use this inside the each function

    		this.collection.each(function(worker) { // iterate through the collection
    			var workerView = new EA.WorkerView({
    				model: worker,
    				parent: self
    			});

    			self.$el.find("#ea-staff").append(workerView.$el);
    		});

    		return this;
    	},

    	addNew: function(e) {
    		e.preventDefault();

    		var worker = new EA.Worker();
    		var self = this;

    		this.collection.add(worker, {at: 0});

    		var workerView = new EA.WorkerView({
    			model: worker,
    			parent: self
    		});

    		this.$el.find("#ea-staff").prepend(workerView.$el);

    		workerView.edit();
    	},

    	refreshList: function(e) {
    		e.preventDefault();

    		this.showMessage('Loading table...', true);

    		this.collection.fetch( {reset:true}, {
    			error: function(response){
    				that.showMessage('');
    				alert('Error, try refresh again.');
    			},
    			success: function(){
    				that.showMessage('');
    			}
    		});
    	},

    	destroy_view: function() {
    		// COMPLETELY UNBIND THE VIEW
    		this.undelegateEvents();

    		this.$el.removeData().unbind();

    		// Remove view from DOM
    		this.remove();
    		Backbone.View.prototype.remove.call(this);
    	},

    	showMessage: function(text, hold) {
    		var onHold = hold || false;

    		if(onHold) {
    			this.$el.find('#status-msg').text(text).show();
    		} else {
    			this.$el.find('#status-msg').text(text).show().delay(2000).fadeOut();
    		}
    	}
    });    /**
     *
     */
    EA.ConnectionView = Backbone.View.extend({
        tagName:  "tr",

        // show template
        template_show : _.template( $("#ea-tpl-connection-row").html() ),

        // edit template
        template_edit : _.template( $("#ea-tpl-connection-row-edit").html() ),

        template : null,

        locations : null,
        services : null,
        workers : null,

        events: {
            "click .btn-edit"   : "edit",
            "dblclick"          : "edit",
            "click .btn-del"    : "removeItem",
            "click .btn-save"   : "save",
            "click .btn-clone"  : "clone",
            "click .btn-cancel" : "cancel",
            "keydown input"     : "keydownEvent",
            "keydown select"    : "keydownEvent"
        },

        initialize: function (options) {
            this.template = this.template_show;
            this.parent = options.parent;
        },

        render: function () {
            var self = this;

            //after save split days of week
            if(!$.isArray(this.model.get('day_of_week'))) {
                this.model.set('day_of_week', this.model.get('day_of_week').split(','));
            }

            var renderedContent = this.template( {
                row       : this.model.toJSON(),
                locations : self.locations.toJSON(),
                services  : self.services.toJSON(),
                workers   : self.workers.toJSON()
            } );

            $(this.el).html( renderedContent );

            this.$el.addClass('ea-row');

            return this;
        },

        edit: function() {
            // Edit class
            this.$el.addClass('ea-editing');

            this.template = this.template_edit;

            this.render();

            this.$el.find(".day-from").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1
            });

            this.$el.find(".time-from").timepicker();

            this.$el.find(".day-to").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1
            });

            this.$el.find(".time-to").timepicker();

            this.$el.find('select, input').first().focus();
        },

        save: function() {
            var connection = this.model;
            var view = this;

            $.each(this.$el.find('input, select'), function(index, elem){
                connection.set($(elem).data('prop'), $(elem).val());
            });

            this.parent.showMessage('Saving...');

            // Saves connection
            connection.save(null, {
                success: function(model, response) {
                    view.render();
                    view.parent.showMessage('Saved...');
                }
            });

            this.$el.removeClass('ea-editing');

            this.template = this.template_show;
            this.render();
        },

        clone: function () {
            var connection = this.model;
            var clone = connection.clone();

            clone.set('id', null);

            clone.save(null, {
                success: function(model, response) {
                    connection.collection.fetch( {reset:true} );
                }
            });
        },

        cancel: function() {
            // If is new remove model/view
            if(this.model.isNew()) {
                this.parent.showMessage('New canceled');

                this.model.destroy();
                this.remove();
            } else {
                this.parent.showMessage('Edit canceled');

                this.$el.removeClass('ea-editing');

                this.template = this.template_show;
                this.render();
            }
        },

        // Delets model and view
        removeItem: function() {
            var view = this;

            if(confirm('Are you sure?')) {
                view.parent.showMessage('Deleting...');

                this.model.destroy({
                    success: function(model, response) {
                        view.remove();
                        view.parent.showMessage('Done...');
                    },
                    error: function(model, response) {
                        view.parent.showMessage('Error...');
                    }
                });
            }
        },

        setData: function(locations, services, workers) {
            this.locations = locations;
            this.services  = services;
            this.workers   = workers;
        },

        //
        keydownEvent: function(e) {
            switch (e.which) {
                // esc
                case 27 :
                    this.cancel();
                break;
            }
        }
    });    // Main tamplate
    EA.ConnectionsView = Backbone.View.extend({

        template : _.template( $("#ea-tpl-connections-table").html() ),

        rowsView : null,

        events : {
            "click .add-new" : "addNew",
            "click .refresh-list" : "refreshList"
        },

        locations : null,
        services : null,
        workers : null,

        initialize: function () {
            jQuery.datepicker.setDefaults( $.datepicker.regional[ea_settings.datepicker] );

            // Empty array of connections
            this.collection = new EA.Connections();

            if(typeof eaData !== 'undefined'){
                // In page cache
                this.locations  = new EA.Locations(eaData.Locations);
                this.services   = new EA.Services(eaData.Services);
                this.workers    = new EA.Workers(eaData.Workers);
            } else {
                // Get from server
                this.locations  = new EA.Locations();
                this.services   = new EA.Services();
                this.workers    = new EA.Workers();

                this.locations.fetch();
                this.services.fetch();
                this.workers.fetch();
            }

            // Table draw
            this.render();

            // Bind the reset event
            this.collection.bind("reset", this.render, this);

            this.showMessage('Table loading...', true);
            // Get data from server
            this.collection.fetch( {reset:true}, {
                success : function () {
                    this.showMessage('Loading table...');
                }
            } );
        },

        render: function () {

            this.$el.empty(); // clear the element to make sure you don't double your contact view

            this.$el.html( this.template );

            var self = this; // so you can use this inside the each function

            this.collection.each(function(connection) { // iterate through the collection
                var connectionView = new EA.ConnectionView({
                    model: connection,
                    parent: self
                });

                connectionView.setData(
                    self.locations,
                    self.services,
                    self.workers
                );

                connectionView.render();

                self.$el.find("#ea-connections").append(connectionView.$el);
            });

            return this;
        },

        addNew: function(e) {
            e.preventDefault();

            var connection = new EA.Connection();
            var self = this;

            this.collection.add(connection, {at: 0});

            var connectionView = new EA.ConnectionView({
                model: connection,
                parent: self
            });

            connectionView.setData(
                this.locations,
                this.services,
                this.workers
            );

            this.$el.find("#ea-connections").prepend(connectionView.$el);

            connectionView.edit();
        },

        refreshList: function(e) {
            e.preventDefault();

            this.showMessage('Loading table...', true);

            this.collection.fetch( {reset:true}, {
                error: function(response){
                    that.showMessage('');
                    alert('Error, try refresh again.');
                },
                success: function(){
                    that.showMessage('');
                }
            });
        },

        destroy_view: function() {

            // COMPLETELY UNBIND THE VIEW
            this.undelegateEvents();

            this.$el.removeData().unbind();

            // Remove view from DOM
            this.remove();
            Backbone.View.prototype.remove.call(this);

        },

        showMessage: function(text, hold) {
            var onHold = hold || false;

            if(onHold) {
                this.$el.find('#status-msg').text(text).show();
            } else {
                this.$el.find('#status-msg').text(text).show().delay(2000).fadeOut();
            }
        }
    });    // Main tamplate
    EA.CustumizeView = Backbone.View.extend({

        template : _.template( $("#ea-tpl-custumize").html() ),
        template_fields : _.template($("#ea-tpl-custom-forms").html()),
        template_options : _.template($("#ea-tpl-custom-form-options").html()),

        events: {
            "click .btn-save-settings" : "saveSettings",
            "click .btn-add-field" : "addCustomFiled",
            "click .single-field-options" : "fieldOptions",
            "click .add-select-option" : "addSelectOption",
            "click .item-save" : "apply",
            "click .item-delete": "deleteOption",
            "click .remove-select-option": "removeSelectedOption",
        },

        initialize: function () {

            this.collection = new EA.Settings();

            this.fields = new EA.Fields();
            this.fields.comparator = 'position';

            // Table draw
    //      this.render();

            // Bind the reset event
            this.collection.bind("reset", this.render, this);
            this.fields.bind("reset", this.renderFields, this);

            // if there is no data in cache
            this.collection.fetch( {reset:true} );
            this.fields.fetch( {reset:true} );
        },

        render: function () {
            var obj = this;
            this.$el.empty(); // clear the element to make sure you don't double your contact view

            var content = this.template( { settings : this.collection.toJSON() } );

            this.$el.html( content );

            this.renderFields();

            this.$el.find('#custom-fields').sortable({
                placeholder: 'sortable-placeholder',
                update : function(event, ui) {
                    obj.reorder();
                }
            });
            //this.$el.find('#custom-fields').disableSelection();

            return this;
        },

        saveSettings: function() {
            var fields = this.$el.find('.field');

            var newSettings = new EA.Settings();

            this.collection.each(function(model, index) {
                var key = model.get('ea_key');

                var input = fields.filter('[data-key="' + key + '"]');

                if(input.is('[type="checkbox"]')) {
                    if(input.is(':checked')) {
                        model.set('ea_value', 1);
                    } else {
                        model.set('ea_value', 0);
                    }
                } else {
                    model.set('ea_value', input.val());
                }
            });

            var wrapper = new EA.SettingsWrapper({options: this.collection, fields: this.fields});
            wrapper.save( null, {
                error: function(response){
                    alert('There has been some error. Please try later.');
                },
                success: function(){
                    alert('Settings saved!');
                }
            });
        },

        addCustomFiled: function(e) {
            var obj = this;
            var $btn = $(e.currentTarget);
            var $row = $btn.closest('th');
            var name = $row.find('input').val();
            var type = $row.find('select').val();

            var field = new EA.Field({
                label:name,
                type:type,
                position: obj.fields.length + 1
            });

            this.fields.add(field);

            var $html = this.template_fields({item : field.toJSON()});
            $ul = this.$el.find('#custom-fields');
            $ul.append($html);

            $row.find('input').val('');

            $ul.find('.single-field-options:last').click();
        },

        renderFields: function() {
            var obj = this, $ul, tags = [];

            $ul = this.$el.find('#custom-fields');

            $ul.empty();

            this.fields.sort();

            this.fields.each(function(model, index) {
                var o = model.toJSON();

                var $html = obj.template_fields({item : o});
                $ul.append($html);

                tags.push('#' + o.slug + '#');
            });

            this.$el.find('#custom-tags').html(tags.join(', '));
        },

        fieldOptions: function(e) {
            e.preventDefault();
            var $btn = $(e.currentTarget);
            var $li = $btn.closest('li');
            var name = $li.data('name');
            var element = this.fields.findWhere({label:name});

            if($btn.find('i').hasClass('fa-chevron-down')) {
                // open
                $btn.find('i').removeClass('fa-chevron-down');
                $btn.find('i').addClass('fa-chevron-up');

                var o = element.toJSON();

                if(o.type === 'SELECT') {
                    if(o.mixed !== '' ) {
                        o.options = o.mixed.split(',');
                    } else {
                        o.options = ['-'];
                    }
                }

                $html = this.template_options({item:o});
                $li.append($html);

                this.$el.find('#custom-fields').sortable('disable');

                $li.find('.select-options').sortable();
            } else {
                // close
                $btn.find('i').removeClass('fa-chevron-up');
                $btn.find('i').addClass('fa-chevron-down');
                $li.find('.field-settings').remove();
                this.$el.find('#custom-fields').sortable('enable');
            }

            return false;
        },

        addSelectOption: function(e) {
            e.preventDefault();
            var $btn = $(e.currentTarget);
            var value = $btn.prevAll('input').val();
            var cont = $btn.closest('.field-settings');

            cont.find('.select-options').append('<li data-element="'+ value + '">'+ value + '<a href="#" class="remove-select-option"><i class="fa fa-trash-o"></i></a></li>');

            // delete option
            $btn.prevAll('input').val('');
        },

        apply: function(e) {
            e.preventDefault();

            var $btn = $(e.currentTarget);
            var $li = $btn.closest('li');
            var name = $li.data('name');
            var element = this.fields.findWhere({label:name});

            var options = [];

            $li.find('.select-options > li').each(function(index, el) {
                options.push($(el).text().trim());
            });

            element.set('label', $li.find('.field-label').val());
            element.set('required', $li.find('.required').is(":checked"));
            element.set('visible', $li.find('.visible').is(":checked"));

            if(options.length > 0) {
                element.set('mixed', options.join(','));
            }

            $li.closest('ul').sortable('enable');

            element.save( null, {
                error: function(response){
                    alert('There has been some error.');
                }
            });


            this.renderFields();
        },

        deleteOption: function(e) {
            e.preventDefault();

            var obj = this;

            var $btn = $(e.currentTarget);
            var $li = $btn.closest('li');
            var name = $li.data('name');
            var element = this.fields.findWhere({label:name});

            this.fields.remove(element);

            element.destroy({
                success: function(model, response) {
                    obj.renderFields();
                },
                error: function() {
                    alert('Error on delete!');
                }
            });
        },

        removeSelectedOption: function(e) {
            e.preventDefault();
            var $btn = $(e.currentTarget);

            $btn.closest('li').remove();
        },

        reorder: function() {
            var obj = this;
            var $ul = this.$el.find('#custom-fields');

            $lis = $ul.children();

            var count = 1;

            $lis.each(function(index, el) {
                var name = $(el).data('name');
                var element = obj.fields.findWhere({label:name});

                element.set('position', count++);
            });
        },

        destroy_view: function() {

            // COMPLETELY UNBIND THE VIEW
            this.undelegateEvents();

            this.$el.removeData().unbind();

            // Remove view from DOM
            this.remove();
            Backbone.View.prototype.remove.call(this);
        },
    });    /**
     * Main Admin View
     * Renders Admin tab panel
     *
     **/
    EA.MainView = Backbone.View.extend({
        el : $('#wpbody-content'),

        template : _.template( $("#ea-settings-main").html() ),

        events : {
            "click #tab-header li a" : "select"
        },

        initialize: function () {

            this.render();

        },

        render: function () {

            this.$el.empty();

            this.$el.html( this.template );

            return this;
        },

        addContainer: function () {

            if( this.$el.find('#tab-content').length > 0 ) {
                return;
            }

            this.$el.children('.wrap').append(
                $( document.createElement('div') )
                    .attr( 'id', 'tab-content' )
            );
        },

        select: function(e) {
            // console.log(e);
            var element = $(e.target);

            this.$el.find('#tab-header li').removeClass('tab-selected');

            element.parents('li:first').addClass('tab-selected');
        },

        selectHash: function(hash) {
            if(hash === '') {
                hash = '#locations/';
            }

            this.$el.find('[href="' + hash + '"]').click();
        }
    });
    var mainView = new EA.MainView();

	EA.AppRouter = Backbone.Router.extend({
	    current: null,
	    routes: {
	    	"custumize":"custumize",
	        "staff/": "staff",
	        "services/": "services",
	        "connection/": "connections",
	        "locations/": "location",
	        "custumize/": "custumize",
	        "": 'location'
	    },

	    initialize: function () {
	        var currentHash = window.location.hash;

	        mainView.selectHash(currentHash);
	    },

	    clearState : function() {
	        if(this.current != null) {
	            this.current.destroy_view();

	            // FIX
	            mainView.addContainer();
	        }
	    },
	    setState: function(newState) {
	    	this.current = newState;
	        // FIX back/forward navigation
	        var hash = window.location.hash;

	        if(hash === '') {
	            hash = '#locations/';
	        }

	        var tab = mainView.$el.find('[href="' + hash + '"]')[0];

	        mainView.select({ target : tab});

	    }
	});

	// Instantiate the router
	var app_router = new EA.AppRouter;

	// Services
	app_router.on('route:services', function () {
	    this.clearState();

	    var services = new EA.ServicesView({
	        el: '#tab-content'
	    });

	    this.setState(services);
	});

	// Locations
	app_router.on('route:location', function () {
	    this.clearState();

	    var locations = new EA.LocationsView({
	        el: '#tab-content'
	    });

	    this.setState(locations);
	});

	// Staff
	app_router.on('route:staff', function () {
	    this.clearState();

	    var staff = new EA.StaffView({
	        el: '#tab-content'
	    });

	    this.setState(staff);
	});

	// Connections
	app_router.on('route:connections', function () {
	    this.clearState();

	    var connections = new EA.ConnectionsView({
	        el: '#tab-content'
	    });

	    this.setState(connections);
	});

	// Connections
	app_router.on('route:custumize', function () {
	    this.clearState();

	    var custumize = new EA.CustumizeView({
	        el: '#tab-content'
	    });

	    this.setState(custumize);
	});

	// Start Backbone history a necessary step for bookmarkable URL's
	Backbone.history.start();
}(jQuery));