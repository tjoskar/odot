/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.Alert = Backbone.Model.extend({
  defaults: {
    msg: '',
    type: '' // alert, success or ''
  }
});
