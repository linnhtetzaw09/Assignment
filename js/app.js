$(document).ready(function(){

// start backtotop section

$(".btn-backtotops").hide();
$(window).scroll(function(){
    let getscrolltop = $(this).scrollTop();
        // console.log(getscrolltop);

        if(getscrolltop >= 370){
            $(".btn-backtotops").fadeIn(1000);
        }else{
            $(".btn-backtotops").fadeOut(1000);
        }
})

// end backtotop section


//start navbar
    $(window).scroll(function(){

        let getscrolltop = $(this).scrollTop();
        // console.log(getscrolltop);

        if(getscrolltop >= 200){
            $(".navbar").addClass("navmenus");
        }else{
            $(".navbar").removeClass("navmenus");
        }

    });


    $(".navbuttons").click(function(){
        $(this).toggleClass("crossxs");
    });

//end navbar


// start activity section

$(".activitylists").click(function () {

    $(this).addClass("activeitems").siblings().removeClass("activeitems");

    const filtervalue = $(this).data("filter");
    // console.log("Selected Filter:", filtervalue);

    $(".filters").hide(); 

    if (filtervalue === "all") {
        $(".filters").show('slide', 500);
    } else {
        $(".filters").filter("." + filtervalue).show('slide', 500);
    }
});

// end activity section


// start adv section

$(window).scroll(function(){

    let getscrolltop = $(this).scrollTop();
    // console.log(getscrolltop);

    if(getscrolltop >= 1200){
        $(".advimages").addClass("fromlefts");
        $(".advtexts").addClass("fromrights");
    }else{
        $(".advimages").removeClass("fromlefts");
        $(".advtexts").removeClass("fromrights");
    }

});

// end adv section

// start event section

// General function to show the event information
function showEventInfo(eventId) {
    $(`#${eventId}`).fadeIn();  // Smoothly show the event info for the specific event
}

// General function to hide the event information
function closeEventInfo(eventId) {
    $(`#${eventId}`).fadeOut();  // Smoothly hide the event info for the specific event
}

// Event listeners for each "About Event" button
$("#football").click(function() {
    showEventInfo("footballEventInfo");  // Show football event info
});

$("#tennis").click(function() {
    showEventInfo("tennisEventInfo");  // Show tennis event info
});

$("#swim").click(function() {
    showEventInfo("swimEventInfo");  // Show swim event info
});

$("#basket").click(function() {
    showEventInfo("basketEventInfo");  // Show basket event info
});

// Event listeners for all "Back" buttons
$(".back-btn").click(function() {
    const eventId = $(this).data("event");  // Retrieve the event ID stored in the data attribute
    closeEventInfo(eventId);  // Hide the specific event info
});


let buttons = document.getElementsByClassName("registerBtn");

for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
        // Redirect to index.html and scroll to the #contact section
        window.location.href = "index.html#contact";
    });
}


// start event section

// start announcement

$(".toggle-text").click(function(event) {
    event.preventDefault();

    const cardText = $(this).closest(".card-text");

    cardText.find(".truncated-text, .full-text").toggleClass("d-none");

    if ($(this).text() === "read more") {
        $(this).text("read less");
    } else {
        $(this).text("read more");
    }
});

// end announcement

// start footer section

const getyear = document.getElementById("getyear");
const getfullyear = new Date().getFullYear();
getyear.textContent = getfullyear;

// end footer section


});