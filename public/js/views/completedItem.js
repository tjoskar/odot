/*=============================
=            Views            =
=============================*/

App.Views.CompletedItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#completed-item-template').html()),

  events : {
    'mouseenter .item-checkbox-holder' : 'hoverCheckbox',
    'mouseleave .item-checkbox-holder' : 'hoverCheckbox',
    'click .item-checkbox-holder'      : 'clickCheckbox'
  },

  initialize: function()
  {
    this.model.on("remove", this.removeView, this);                   // Remove this view if the model removes
    vent.on('item:update', this.updateItem, this);                    // This event is trigged by the server when an item should be updated
  },

  render: function()
  {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  hoverCheckbox: function(e)
  {
    $(e.currentTarget).find('.icon-check-empty, .icon-check').toggleClass('hide');
  },

  clickCheckbox: function(e)                                          // Mark the item as uncompleted
  {
    this.stopListening();
    this.model.toogleCompleted();
    this.model.save();
    vent.trigger('item:uncompleted', this.model.toJSON());
    this.model.destroy({reportToServer: false});
    this.remove();
  },

  updateItem: function(model)
  {
    if (this.model.get('id') == model.id)
    {
      if (this.model.get('completed') != model.completed)
      {
        this.stopListening();
        vent.trigger('item:uncompleted', model);                      // Send an event to items.js
        this.model.destroy({reportToServer: false});
        this.remove();
      }
    }
  },

  removeView: function()                                              // Called when the model is removed
  {
    this.remove();
  }
});
