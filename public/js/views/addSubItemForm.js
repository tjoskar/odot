/*=============================
=            Views            =
=============================*/

//View to handle "add sub items"
App.Views.AddSubItemsForm = Backbone.View.extend({
  events: {
    'keypress': 'keypress'
  },

  input: null,
  parent: null,

  initialize: function() {
    this.parent = this.model.parent;
  },

  render: function() {
    this.parent.$el.find('.sub-items').append( this.el );
  },

  keypress: function(e)
  {
    if (e.keyCode == 13 || e.keyCode == 9) // enter or tab
    {
      var title      = this.input.val();
      var newSubitem = new App.Models.SubItem({title: title, list_id: getLastVisitedListId(), item_id: this.parent.model.id});
      var that       = this;

      if (newSubitem.isValid())
      {
        newSubitem.save().then(function() {
          that.parent.subItemsCollection.add(newSubitem);
        });
      }
      else
      {
        app.alert('An error occurred', 'alert');
      }

      // Generate a new input field
      this.newInput();
    }

  },

  stopEdit: function() {
    this.$el.empty(); // Empty the view ie. remove all input fields
  },

  newInput: function() {
    this.input = $('<input class="add-sub-item" placeholder="Add subitem...">');
    this.$el.append(this.input);
    this.input.focus();
  }
});