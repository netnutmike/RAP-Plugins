var GB_BoxStarted = 0;
var GB_BoxDelay = 2;
if (document.cookie.indexOf("ExitGrabber=") == -1) {
	AJS.AEV(document,'mousemove',GB_GetMouseY);
}
function GB_GetMouseY(e) {
    GB_tempY = document.all? event.clientY: e.pageY - document.body.scrollTop - document.documentElement.scrollTop;
    if (GB_tempY < 0) GB_tempY = 0;
    if (20 > GB_tempY && 0 > --GB_BoxDelay) {
        if (0 == GB_BoxStarted) {
            GB_BoxStarted = 1;
            var GB_url = 'bot.html'
            var options = {
                width: 407,
                height: 260,
                fullscreen: false,
				center_win: true,
                show_loading: false
            }
            var win = new GB_Window(options);
            return win.show(GB_url);
        }
	}
}
