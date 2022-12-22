//setup before functions
// todo prevent searching before loading js logic
let typingTimer;                //timer identifier
let doneTypingInterval = 1000;  //time in ms, 5 seconds for example
let input = $('input[name=search]');
//on keyup, start the countdown
input.on('keyup', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
});
//on keydown, clear the countdown
input.on('keydown', function () {
    clearTimeout(typingTimer);
});
//user is "finished typing," do something
function doneTyping() {
    let val = $('input[name=search]').val();
    if(val === "" && search !== ""){
        window.location = route ;
    }
}
$('input[name=search]').prop("disabled", false); // Element(s) are now enabled.
