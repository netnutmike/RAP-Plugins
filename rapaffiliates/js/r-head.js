<!-- loading prototype/other js into header upon loading page -->
function addScriptTag( id, src ) {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.id = id;
    script.type = 'text/javascript';
    script.src = src;
    head.appendChild(script);
}
function addCssLink( url ) {
    var head = document.getElementsByTagName('head')[0];
     var link = document.createElement("link");
                link.setAttribute("type", "text/css");
                link.setAttribute("rel", "stylesheet");
                link.setAttribute("href", url);
                link.setAttribute("media", "screen");
                head.appendChild(link);
}
function myPageLoad() {
    var scripts = [
		'http://scrnch.me/plugins/jquery.alphanumeric.js',
		'http://scrnch.me/plugins/jquery.validate.js',
		'addons/extrakick/kunaki/js/plugins/colors.js',
		'addons/extrakick/kunaki/js/plugins/scrollto.min.js',
		'addons/extrakick/kunaki/js/plugins/localscroll.min.js',
		'addons/extrakick/kunaki/js/plugins/quickpager.jquery.js'
    ];
    for (var i=0,size=scripts.length; i < size; ++i) {
        addScriptTag( 'script_'+i, scripts[i] );
    }
}
function msAddScript( url )
{
    eltScript = document.createElement("script");
    eltScript.setAttribute("type", "text/javascript");
    if( url.indexOf('?') > -1)
        url += '&';
    else
        url += '?';
    url += 'rand=' + Math.random();
    eltScript.setAttribute("src", url);
    document.getElementsByTagName('head')[0].appendChild(eltScript);
}
