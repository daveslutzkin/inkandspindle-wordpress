//	http://www.thefutureoftheweb.com/blog/image-onload-isnt-being-called
function loadImage( src, onload ) {
    var img = new Image();

    img.onload = onload;
    img.src = src;

    return img;
}


//	http://stackoverflow.com/a/11508164/373932
function hexToRgb( hex ) {
	// hex must without the #
    var bigint = parseInt( hex, 16 ),
    	r = ( bigint >> 16 ) & 255,
    	g = ( bigint >> 8 ) & 255,
    	b = bigint & 255;

    return { 'r' : r, 'g' : g, 'b' : b }; //r + "," + g + "," + b;
}




var Filters = {};


Filters.brighten = function( imagedata, amount ){
	if ( typeof amount === 'undefined' ) { amount = 127; }
	var d = imagedata;
	for ( var i=0; i<d.length; i+=4 ) {
		d[i]   += amount;
		d[i+1] += amount;
		d[i+2] += amount;
	}
}


Filters.selectiveBrighten = function( imagedata, amount ){
	var p = imagedata,
		v = 0;
	
	for ( var i=0; i<p.length; i+=4 ) {
		// Where the rgb value tends towards darkness (that is, 0s across r, g & b) we want to fill with that corresponding % intensity of our rgb colour.
		// 765 = 255 * 3
		v = ( p[i] + p[i+1] + p[i+2] ) / 765; // this gives us % fill/black for that pixel.
		p[i+0] += amount*v*255; // - v * (255 - p[i+0]);
		p[i+1] += amount*v*255; // - v * (255 - p[i+1]);
		p[i+2] += amount*v*255; // - v * (255 - p[i+2]);

	}
	//console.log( p );
	//return p;
}


Filters.threshold = function( imagedata, threshold) {
  var p = imagedata;
  for (var i=0; i<p.length; i+=4) {
    var r = p[i];
    var g = p[i+1];
    var b = p[i+2];
    var v = (0.2126*r + 0.7152*g + 0.0722*b >= threshold) ? 255 : 0;
    p[i] = p[i+1] = p[i+2] = v
  }
};



Filters.uniformColourise = function( imagedata, hexColor ){
	var rgb = hexToRgb( hexColor ),
		level = 50;
	
	var d = imagedata;
	for ( var i=0; i<d.length; i+=4 ) {
		d[i+0] -= (d[i+0] - rgb.r) * (level / 100);
		d[i+1] -= (d[i+1] - rgb.g) * (level / 100);
		d[i+2] -= (d[i+2] - rgb.b) * (level / 100);
	}
	//return d;
}


Filters.selectiveColourise = function( imagedata, hexColor ){
	var p = imagedata,
		rgb = hexToRgb( hexColor ),
		v = 0;
	
	for ( var i=0; i<p.length; i+=4 ) {
		// Where the rgb value tends towards darkness (that is, 0s across r, g & b) we want to fill with that corresponding % intensity of our rgb colour.
		// 765 = 255 * 3
		v = ( 765 - p[i] - p[i+1] - p[i+2] ) / 765; // this gives us % fill/black for that pixel.
		p[i+0] = 255 - v * (255 - rgb.r);
		p[i+1] = 255 - v * (255 - rgb.g);
		p[i+2] = 255 - v * (255 - rgb.b);

	}
	//console.log( p );
	//return p;
}


Filters.multiply = function( bottomImageData, topImageData, opacity ){
	// Multiply Formula: (Bottom Color) * (Top Color) / 255
	var d = bottomImageData, l = topImageData;//,
//		opacity =  255 - opacity * 255;
	var opacity = 0.5;
				
	for ( var i=0; i<d.length; i+=4 ) {
		// Brighten (reduces strength of overlay):
//		l[i]   += 100; //opacity;
//		l[i+1] += 100; //opacity;
//		l[i+2] += 100; //opacity;

//		l[i+0] =  255 - opacity*l[i+0]; // * opacity;// + 255*opacity;
//	    l[i+1] =  255 - opacity*l[i+1]; // * opacity;// + 255*opacity;
//	    l[i+2] =  255 - opacity*l[i+2]; // * opacity;// + 255*opacity;

		// Multiply:
		d[i]   = d[i]   * l[i]   / 255;	//adjustment;
		d[i+1] = d[i+1] * l[i+1] / 255;	//adjustment;
		d[i+2] = d[i+2] * l[i+2] / 255;	//adjustment;

	}
//	return d;
}

Filters.whitePigment = function( bottomImageData, topImageData, opacity ){
	var d = bottomImageData, l = topImageData, 
		opacity = 255 - opacity * 255;
	
	for ( var i=0; i<d.length; i+=4 ) {
		// Invert
		l[i]   = 255 - l[i];
		l[i+1] = 255 - l[i+1];
		l[i+2] = 255 - l[i+2];
	
		// Darken (reduces strength of overlay): 
		l[i]   -= opacity;
		l[i+1] -= opacity;
		l[i+2] -= opacity;
		
		// Screen:
		d[i]   = 255 - ( (255 - d[i]  )*(255 - l[i]  ) )/255;
		d[i+1] = 255 - ( (255 - d[i+1])*(255 - l[i+1]) )/255;
		d[i+2] = 255 - ( (255 - d[i+2])*(255 - l[i+2]) )/255;
	}
	//return d;
}
