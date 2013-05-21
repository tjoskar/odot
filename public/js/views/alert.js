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

    d(this.model.get('timeout'));

    if (this.model.get('timeout'))
    {
      var self = this;
      this.timer = setTimeout(function() {
        self.$el.fadeOut(1000, function() {
          self.remove();                                                  // Remove the dialog
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
