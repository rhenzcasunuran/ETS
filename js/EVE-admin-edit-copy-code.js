var eventCode = document.querySelector("#display-code");
var eye = document.querySelector("#revealCode");
var eventCodeCode = eventCode.textContent;
  
function copyCode(element) {
// Show tooltip
$(element).tooltip('show');
  
// Hide tooltip after a delay
setTimeout(function() {
    $(element).tooltip('hide');
}, 1500); // Adjust the delay as needed
var range = document.createRange();
navigator.clipboard.writeText(eventCodeCode);
$(element).removeAttr('data-toggle').removeAttr('title').off('mouseenter mouseleave');
}
  
eye.addEventListener("click", function(){
if(eye.classList.toggle("reveal")){
    eye.classList.remove("bx-hide");
    eye.classList.add("bx-show");
    eventCode.style.webkitTextSecurity = "none";
}
else{
    eye.classList.remove("bx-show");
    eye.classList.add("bx-hide");
    eventCode.style.webkitTextSecurity = "disc";
}
});