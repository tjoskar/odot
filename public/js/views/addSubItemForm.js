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
  newSubitem: null,

  initialize: function() {
    this.parent = this.model.parent;

    vent.on('subItem:createFromForm', this.createFromForm, this);
    vent.on('subItem:create', this.addItem, this);
  },

  render: function() {
    this.parent.$el.find('.sub-items').append( this.el );
  },

  keypress: function(e)
  {
    if (e.keyCode == 13 || e.keyCode == 9) // enter or tab
    {
      d('save');
      var title       = this.input.val();
      this.newSubitem = new App.Models.SubItem({title: title, list_id: getLastVisitedListId(), item_id: this.parent.model.id});

      if (this.newSubitem.isValid())
      {
        this.newSubitem.save();
      }
      else
      {
        app.alert('An error occurred', 'alert');
      }

      // Generate a new input field
      this.newInput();
    }

  },

  stopEdit: function()
  {
    this.$el.empty(); // Empty the view, ie. remove all input fields for this item
  },

  newInput: function()
  {
    this.input = $('<input class="add-sub-item" placeholder="Add subitem...">');
    this.$el.append(this.input);
    this.input.focus();
  },

  createFromForm: function(args)
  {
    if (args.item_id == this.parent.model.get('id'))
    {
      this.newSubitem.set(args);
      this.parent.subItemsCollection.add(this.newSubitem);
    }
  },

  addItem: function(model)
  {
    if (model.item_id == this.parent.model.get('id'))
    {
      var newSubItem = new App.Models.SubItem(model);
      this.parent.subItemsCollection.add(newSubItem);
      this.parent.subItemsView.render();
    }
  }
});