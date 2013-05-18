/*=============================================
=            Model for 'alert box'            =
=============================================*/

App.Models.Alert = Backbone.Model.extend({
  defaults: {
    msg: '',
    type: '' // alert (red), success (green) or '' (blue)
  }
});
