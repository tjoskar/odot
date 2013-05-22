/*=============================
=            Views            =
=============================*/

App.Views.Alert = Backbone.View.extend({
  className: 'alert-box',
  template: _.template("<%= msg %>"),
  timer: null,

  events : {
    "click" : "click"
  },

  initialize: function()
  {
    $("#alert-box-holder").prepend( this.render().el ).show('slow');    // Display the alert dialog

    if (this.model.get('timeout'))                                      // Remove the dialog after this.model.timeout
    {                                                                   // if this.model.timeout has a valid value
      var self = this;
      this.timer = setTimeout(function() {
        self.$el.fadeOut(1000, function() {
          self.remove();
        });
      }, this.model.get('timeout'));
    }

  },

  render: function()
  {
    this.$el.html( this.template( this.model.toJSON() ));
    if (this.model.get('type'))
    {
      this.$el.addClass( this.model.get('type') );                      // Add some style to the dialog
    }

    return this;
  },

  click: function(e)                                                    // Remove the dialog if the user click on it
  {
    this.model.destroy();
    this.remove();
  }

});
