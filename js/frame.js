SVGElement.prototype.getTransformToElement = SVGElement.prototype.getTransformToElement || function(toElement) {  
    return toElement.getScreenCTM().inverse().multiply(this.getScreenCTM());  
}; 
$(document).ready(function(){
	$("#maintable").load("/index.php/main/maintable");
});