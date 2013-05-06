/*=============================
=            Views            =
=============================*/

App.Views.Alert = Backbone.View.extend({
  className: 'alert-box',
  template: _.template("<%= msg %>"),
  timer: null,

  initialize: function() {
    d(this.model);
    return;
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
    if (this.model.type)
      this.$el.addClass( this.model.type );
    return this;
  },

  events : {
    "click" : "click"
  },

  click: function(e) {
    //this.model.destroy();
    this.remove();
  }

});