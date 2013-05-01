/*=============================
=            Views            =
=============================*/

//View to handle the "add item" input form
App.Views.AddItemForm = Backbone.View.extend({
  el: $('form.add-task'),

  events: {
    "submit" : "addNewItem"
  },

  addNewItem: function(e) {
    e.preventDefault();
    var inputField = this.$el.find('input');
    var title = inputField.val().trim();
    var newItem = new App.Models.Item({title: title, list_id: app.currentListId});

    if (newItem.isValid()) {
      newItem.save().then(function() {
        app.itemsView.collection.add(newItem);
        //app.listsView.showAllLists();
        inputField.val('');
      });
    }
  },

  initialize: function() {
    console.log("initialize addItemForm");
    d(this.el);
  }
});