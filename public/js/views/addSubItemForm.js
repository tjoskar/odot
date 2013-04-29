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
    //this.newInput(true);
  },

  render: function() {
    this.parent.$el.find('.sub-items').append( this.el );
  },

  keypress: function(e) {

    if (e.keyCode == 13 || e.keyCode == 9) // enter or tab
    {
      console.log('Add subitem');
      var title = this.input.val();
      console.log('Title: ' + title);
      var newSubitem = new App.Models.SubItem({title: title, list_id: this.parent.model.listID, item_id: this.parent.model.id});
      var that = this;

      if (newSubitem)
        newSubitem.save().then(function() {
          that.parent.subItemsCollection.add(newSubitem);
          //that.parent.renderSubItems();
        });
      this.newInput();
    }

  },

  // inputChange: function() {
  //   var inputs = this.$el.find('input');
  //   var emptyInput = 0;               // Number of empty inputs
  //   inputs.each(function() {
  //     if( ! $(this).val() )
  //     {
  //       console.log('yes');
  //       emptyInput++;
  //     }
  //   });

  //   if(emptyInput <= 1)
  //     this.newInput(false);
  // },

  newInput: function(hidden) {
    console.log('Add new input ');
    this.input = $('<input class="add-sub-item" placeholder="Add subitem...">');
    if (hidden)
      this.input = $('<input class="add-sub-item hidden" placeholder="Add subitem...">');
    this.$el.append(this.input);
    this.input.focus();
  }
});