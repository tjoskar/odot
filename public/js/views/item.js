/*=============================
=            Views            =
=============================*/

App.Views.Item = Backbone.View.extend({
  tagName: 'li',
  template: _.template(
    '<h3><i class="icon-circle-blank"></i><%= title %></h3>' +
    '<div class="item-button-holder"><i class="icon-cog"></i></div>' +
    '<% if( !_.isEmpty(sub_items) ) { %>' +
      '<div class="sub-items">' +
        '<p class="item-description"><%= description %> </p>' +
        '<ul>' +
          '<% _.each(sub_items, function(sub_item) { %>' +
            '<li>' +
              '<p><%= sub_item.title %></p>' +
              '<div class="item-button-holder"><i class="icon-cog"></i>' +
            '</li>' +
          '<% }); %>' +
        '</ul>' +
      '</div>' +
    '<% } %>' +
    '<div class="item-settings">' +

    '</div>'
    ),

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  events : {
    "click h3" : "showSubitem",
    "click .icon-cog" : "showItemSettings"
  },

  showSubitem: function() {
    $(this.el).find('.item-settings').slideUp("slow");
    $(this.el).find('.sub-items').slideToggle("slow");
  },

  showItemSettings: function() {
    $(this.el).find('.sub-items').slideUp("slow");
    $(this.el).find('.item-settings').slideToggle("slow");
  }
});