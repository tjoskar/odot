/*=============================
=            Views            =
=============================*/

App.Views.SubItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#subItem-template').html()),

  events : {
    'mouseenter'                             : 'hover',
    'mouseleave'                             : 'hover',
    'click .icon-trash'                      : 'deleteSubItem',
    'mouseenter .subitem-checkbox-holder'    : 'hoverCheckbox',
    'mouseleave .subitem-checkbox-holder'    : 'hoverCheckbox',
    'click .subitem-checkbox-holder'         : 'clickCheckbox'
  },

  initialize: function () {
    this.model.on("change:title", this.render, this);
    vent.on('subItem:update', this.updateSubItem, this);
    vent.on('subItem:delete', this.socketDeleteSubItem, this);
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  hoverCheckbox: function(e) {
    $(e.currentTarget).find('.icon-check-empty, .icon-check').toggleClass('hide');
  },

  clickCheckbox: function(e) {
    this.model.toogleCompleted();
    this.model.save();
    this.render();
  },

  hover: function() {
    this.$el.find('.subitem-button-holder').toggleClass('hide');
  },

  deleteSubItem: function(e) {
    e.preventDefault();
    this.model.destroy();
    this.remove();
  },

  socketDeleteSubItem: function(model)
  {
    if (model.id == this.model.get('id'))
    {
      this.model.destroy({silent: true});
      this.remove();
    }
  },

  updateSubItem: function(model) {
    if (model.id == this.model.get('id'))
    {
        this.model.set(model);
        this.render();
    }
  }
});