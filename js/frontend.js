/**
 *	File:	 frontend javasript of the module "smooth gallery"
 *	Version: 1.0.2
 *	Date:	 2010-07-09
 *	Author:	 Dietrich Roland Pehlke (Aldus)
 *
 *	1.0.2	Modify the code to center the popup window in the middle of this window,
 *			instead of center it on the main-window (if two are available).
 *			Also some bugfixing the "wrong" html-code.
 *
 *	1.0.1	Add some code to center the pop up window on the screen.
 *	
 *	1.0.0	Outsource the script from the modul-php-code to get the frontend valid.
 *
 */
var funcList = new Array();
var previewWin = null;
		
function opnWin (link, w,h) {
	if (previewWin) previewWin.close();
	/**
	 *  set some vars
	 */
	var wo = window;
	var w_left = wo.screenX;
	var w_top = wo.screenY;
	
	h = h - 20; 
	var x= 0;
	var y= 0;
	
	if (w < screen.availWidth || h < screen.availHeight) {
		
		/**
		 *	the following corrections could be differ from
		 *	the target browser - this one is used for an IE ...
		 *
		 */
		x = (wo.innerWidth -w -12)/2 + w_left;
		y = (wo.innerHeight-h - 104)/2 + w_top;

		/**
		 *	Make sure, that the window is in the left, top corner, so the 
		 *	users can find the "close" icons ...
		 *
		
		if (x < 0 || y < 0) {
			x=0;
			y=0;
		}
		*/
	}

	previewWin= open("#", "image_preview","toolbar=no,menubar=no,location=no,scrollbars=auto,resizable=yes,status=yes,width="+w+",height="+h+",left="+x+",top="+y+"");
	previewWin.document.write("<html><head></head><body style='margin: 0px;'><a href='javascript:this.close();' title='click to close'><img border='0' alt='detail' src='"+link+"' /></a></body></html");
	previewWin.document.close();
}
		
function rollGalleries() {
	var cnt;
	for (cnt=0; cnt<funcList.length; cnt++) {
		if (funcList[cnt] != undefined) eval(funcList[cnt]);
	}
}