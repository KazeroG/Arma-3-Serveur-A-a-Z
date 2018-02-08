// Source: http://stackoverflow.com/questions/5736398/how-to-calculate-the-svg-path-for-an-arc-of-a-circle#answer-18473154
function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
  var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;

  return {
    x: centerX + (radius * Math.cos(angleInRadians)),
    y: centerY + (radius * Math.sin(angleInRadians))
  };
}

function describeArc(x, y, radius, startAngle, endAngle){

    var start = polarToCartesian(x, y, radius, endAngle);
    var end = polarToCartesian(x, y, radius, startAngle);

    var arcSweep = endAngle - startAngle <= 180 ? "0" : "1";

    var d = [
        "M", start.x, start.y, 
        "A", radius, radius, 0, arcSweep, 0, end.x, end.y
    ].join(" ");

    return d;       
}

// Our animated pie function:
var fatAnimatedPie = document.getElementById("fatAnimatedPie");
var thinAnimatedPie = document.getElementById("thinAnimatedPie");
var pieAngle = 20; // deg
var round = 1;

setInterval( drawFatPie, 1000/60 );
function drawFatPie() {
  // Reset angles after a full circle
  //pieAngle >== 360 && round++ && (pieAngle = 0);
  
  if ( pieAngle >= 360 ){
    pieAngle = 0;

    if ( round == 1 || round == 4 )
      fatAnimatedPie.classList.add('hidden');
    else
      fatAnimatedPie.classList.remove('hidden');
    
    round += 1;
    if ( round > 4 )
      round = 1;
  }
  
  switch (round) {
    case 1:
      thinAnimatedPie.setAttribute("d", describeArc(125, 125, 43, pieAngle, 359));
      break;
    case 2:
      thinAnimatedPie.setAttribute("d", describeArc(125, 125, 43, 0, pieAngle));
      break;
    case 3:
      fatAnimatedPie.setAttribute("d", describeArc(125, 125, 43, 0, pieAngle));
      break;
    case 4:
      fatAnimatedPie.setAttribute("d", describeArc(125, 125, 43, pieAngle, 359));
      break;
  }
  
  pieAngle += 2;
}

// Inner Ring Arcs
var r = 90; //rotation in deg
var l = 50; // section length in deg
document.getElementById("ringInner1").setAttribute("d", describeArc(125, 125, 32, 0, l));
document.getElementById("ringInner2").setAttribute("d", describeArc(125, 125, 32, 0+r, l+r));
document.getElementById("ringInner3").setAttribute("d", describeArc(125, 125, 32, 0+r+r, l+r+r));
document.getElementById("ringInner4").setAttribute("d", describeArc(125, 125, 32, 0+r+r+r, l+r+r+r));

// Pixel ticker
r = -8;
document.getElementById("pixel1").setAttribute("d", describeArc(125, 125, 28, 0, -6));
document.getElementById("pixel2").setAttribute("d", describeArc(125, 125, 28, 0+r, -6+r));
document.getElementById("pixel3").setAttribute("d", describeArc(125, 125, 28, 0+r+r, -6+r+r));
document.getElementById("pixel4").setAttribute("d", describeArc(125, 125, 28, 0+r+r+r, -6+r+r+r));
document.getElementById("pixel5").setAttribute("d", describeArc(125, 125, 28, 0+r+r+r+r, -6+r+r+r+r));
document.getElementById("pixel6").setAttribute("d", describeArc(125, 125, 28, 0+r+r+r+r+r, -6+r+r+r+r+r));

// Change pixel
var pixels = document.getElementById("groupPixels").children;
var currentPixel = 1;
setInterval( changePixel, 1000 );

function changePixel() {
  if ( pixels[currentPixel].classList.contains('active') )
    pixels[currentPixel].classList.remove('active');
  
  currentPixel = (currentPixel < 5) ? currentPixel + 1 : 0;
  pixels[currentPixel].classList.add('active');
}

// Traveling line
document.getElementById("travelingLine").setAttribute("d", describeArc(125, 125, 59, 0, 10));