/*=============================
=            Views            =
=============================*/

App.Views.Alert = Backbone.View.extend({
  className: 'alert-box',
  template: _.template("<%= msg %>"),
  timer: null,

  initialize: function() {
    $("#alert-box-holder").prepend( this.render().el ).show('slow');

    var that = this;
    this.timer = setTimeout(function() {
      that.$el.fadeOut(1000, function() {
        that.remove();
      });
    }, 3000);
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    if (this.model.get('type'))
    {
      this.$el.addClass( this.model.get('type') );
    }

    return this;
  },

  events : {
    "click" : "click"
  },

  click: function(e) {
    this.model.destroy();
    this.remove();
  }

});