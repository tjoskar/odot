/*=============================================
=            Model for 'alert box'            =
=============================================*/

App.Models.Alert = Backbone.Model.extend({
  defaults: {
    msg: '',
    type: '',       // Can either be alert (red), sucess (green) or '' (blue)
    timeout: 3000   // Default timeout
  }
});
