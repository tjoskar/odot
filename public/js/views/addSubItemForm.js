/*=============================
=            Views            =
=============================*/

//View to handle "add sub items"
App.Views.AddSubItemsForm = Backbone.View.extend({
  events: {
    'focus input': 'inputChange'
  },

  inputs: null,
  parentEl: null,

  initialize: function() {
    this.parentEl = this.model.parentEl;
    this.inputs = [];
    this.newInput(true);
  },

  render: function() {
    this.parentEl.find('.sub-items').append( this.el );
  },

  inputChange: function() {
    var inputs = this.$el.find('input');
    var emptyInput = 0;               // Number of empty inputs
    inputs.each(function() {
      if( ! $(this).val() )
      {
        console.log('yes');
        emptyInput++;
      }
    });

    if(emptyInput <= 1)
      this.newInput(false);
  },

  newInput: function(hidden) {
    console.log('Add new input ');
    var newInput = '<input class="add-sub-item" data-id="'+ this.inputs.length +'" placeholder="Add subitem...">';
    if (hidden)
      newInput = '<input class="add-sub-item hidden" data-id="'+ this.inputs.length +'" placeholder="Add subitem...">';
    this.$el.append(newInput);
  }
});