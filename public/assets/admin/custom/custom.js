// Duplicate -> Custom Fields childrens 
var i = 0; //Increment
function duplicateData(idName) {
 	var original = document.getElementById(idName);
	var clone = original.cloneNode(true);
	clone.id = idName + ++i;
	(original.parentNode.appendChild(clone)).insertAfter($("#"+idName));
}

// Remove Added Custom Fields
function removeData(className) {
	if ($('.'+className).length > 1) {
	   $('.'+className+':last').remove();
	}
}


// Auto Field
var i = 0; //Increment
var v = 0; //Increment
function autoaddData() {

    var original = document.getElementById('itemLabel');
    var clone = original.cloneNode(true); // "deep" clone
    clone.id = "duplicetor" + ++i; // there can only be one element with an ID
    original.parentNode.appendChild(clone);

    var original = document.getElementById('itemValue');
    var clone = original.cloneNode(true); // "deep" clone
    clone.id = "duplicetor" + ++v; // there can only be one element with an ID
    original.parentNode.appendChild(clone);

}

function autoremoveData() {

    if ($('.labelItem').length > 1) {
       $('.labelItem:last').remove();
    }

    if ($('.valueItem').length > 1) {
       $('.valueItem:last').remove();
    }

}

$(document).ready(function(){

    var selected = $('#usePost').val();
    if (selected == 'video') {
        $('#dataImage').hide();
        $('#dataVideo').show();
    }else{
        $('#dataVideo').hide();
        $('#dataImage').show();
    }

    // Categories
    var cat_url = $('#categorySELECT').val();
    $('#categories').on("change",function () {
        var categoryId = $(this).find('option:selected').val();
        $.ajax({
            url: cat_url,
            type: "POST",
            data: "categoryNAME="+categoryId,
            success: function (response) {
                console.log(response);
                $("#sub_category").html(response);
            },
        });
    }); 

    $('#usePost').on("change",function () {
        var usePost = $(this).find('option:selected').val();
        if (usePost == 'video') {
            $('#dataImage').hide();
            $('#dataImage').fadeOut("slow");
            $('#dataVideo').show();
        }else{
            $('#dataVideo').hide();
            $('#dataVideo').fadeOut("slow");
            $('#dataImage').show();
        }
    }); 


});

//On Post Publish Time Change


//Hide And Show the Current Link Button
function changeCUR(arg) {

    //check argument passed
    if(arg == 'change'){

        //Show Save and Cancel Button
        $('.curr-hide-btn').removeClass('curr-hide');

        //Show shorten URL without Post ID
        $('#current-link-label').removeClass('curr-hide');

        //Show Edit Input
        $('#edit-current-link').removeClass('curr-hide');

        //End Slash
        $('.end-slash').removeClass('curr-hide');

        //Hide Change Button
        $('#change-btn').hide();

        //Hide Current Link
        $('#current-link').hide();
    }
    else if(arg == 'save'){

        //default Label Link
        var currentURL = $('#current-link-label').text();

        //Current Entered Post ID
        var currentPOSTID = $('#edit-current-link').val();

        //Correct URL
        var correctURL = currentPOSTID.replace(/\s+/g, '-').toLowerCase();

        //Update links
        var newLink = currentURL.trim()+correctURL.trim();

        //Hide Save and Cancel Button
        $('.curr-hide-btn').addClass('curr-hide');

        //Hide shorten URL without Post ID
        $('#current-link-label').addClass('curr-hide');

        //Hide Edit Input
        $('#edit-current-link').addClass('curr-hide');

        //End Slash
        $('.end-slash').addClass('curr-hide');

        //Show Change Button
        $('#change-btn').show();

        //New Link to Database
        $('#set-current-link').val(correctURL);

        //change or update the link
        $('#current-link').text(newLink);

        //Show Current Link
        $('#current-link').show();
    }
    else if(arg == 'cancel'){

        //Cancel Action
        btnlinkCAN();
    }
    else{

        //Cancel Action
        btnlinkCAN();
    }

}

// On Current Link Change CLICK CANCEL
function btnlinkCAN() {

    //Hide Save and Cancel Button
    $('.curr-hide-btn').addClass('curr-hide');

    //Hide shorten URL without Post ID
    $('#current-link-label').addClass('curr-hide');

    //Hide Edit Box
    $('#edit-current-link').addClass('curr-hide');

    //End Slash
    $('.end-slash').addClass('curr-hide');

    //Show Change Button
    $('#change-btn').show();

    //Show Current Link
    $('#current-link').show();

    var oldLink = $('#old-url-link').val();
    $('#current-link').text(oldLink);

    var oldURL = $('#old-url').val();
    $('#set-current-link').val(oldURL);

}

//On Post Publish Time Change
$("#post-schedule").change(function () {

    //Check if Checked
    if($(this).prop("checked") == true){

        //Hide Calender
        $('#post-date').addClass('curr-hide');
        $('#post-date').removeClass('fg-line');

        //Change Text
        $('#post-time').text('Post Now');

    }else{

        //Show Calender
        $('#post-date').removeClass('curr-hide');
        $('#post-date').addClass('fg-line');

        //Change Text
        $('#post-time').text('Post On Date');
    }
});



/*
* Auto Complete Data  
*/
function autocomplete(inp, arr) {

    /*the autocomplete function takes two arguments, the text field element and an array of possible autocompleted values:*/
    var currentFocus;

    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {

        var a, b, i, val = this.value;

        /*close any already open lists of autocompleted values*/
        closeAllLists();

        if (!val) { return false;}
        currentFocus = -1;

        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);

        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {

            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");

                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);

                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {

                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;

                    /*close the list of autocompleted values,(or any other open lists of autocompleted values:*/
                    closeAllLists();
                });

                a.appendChild(b);
            }
        }
    });

    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {

        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {

            /*If the arrow DOWN key is pressed, increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);

        } else if (e.keyCode == 38) { //up

            /*If the arrow UP key is pressed,decrease the currentFocus variable:*/
            currentFocus--;

            /*and and make the current item more visible:*/
            addActive(x);

        } else if (e.keyCode == 13) {

            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {

                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {

        /*a function to classify an item as "active":*/
        if (!x) return false;

        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);

        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {

        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }

    }
        
    function closeAllLists(elmnt) {

        /*close all autocomplete lists in the document,except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {

        closeAllLists(e.target);
    });
}

/*An array containing all the country names in the world:*/
//var autocompleteData = $('#dataToAutoComplete').val().split(',');

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
//autocomplete(document.getElementById("autoCompleteField"), autocompleteData);

