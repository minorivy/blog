var cb = function() {
	var fa_css = document.createElement('link'); fa_css.rel = 'stylesheet';
	fa_css.href = 'https://use.fontawesome.com/releases/v5.8.1/css/all.css';
	var insert_fa_css = document.getElementsByTagName('title')[0];
	insert_fa_css.parentNode.appendChild(fa_css, insert_fa_css);
};
var raf = requestAnimationFrame || mozRequestAnimationFrame ||
	webkitRequestAnimationFrame || msRequestAnimationFrame;
if (raf) raf(cb);
else window.addEventListener('load', cb);