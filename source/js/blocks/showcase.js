
var init_showcase = function(){
  var elms = document.getElementsByClassName( 'splide' );
  for ( var i = 0; i < elms.length; i++ ) {
    new Splide( elms[ i ] ).mount();
  }
}

document.addEventListener('DOMContentLoaded', function() {
  init_showcase();
});

// Initialize dynamic block preview (editor).
if (window.acf) {
  window.acf.addAction('render_block_preview/type=showcase', init_showcase);
}