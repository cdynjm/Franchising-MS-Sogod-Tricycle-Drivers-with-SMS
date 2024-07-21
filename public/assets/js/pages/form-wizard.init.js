var currentTab = 0; // Current tab is set to be the first tab (0)

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

document.addEventListener('livewire:navigated', () => { 
    showTab(currentTab); // Display the current tab
});

function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("wizard-tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        var nextBtn = document.getElementById("nextBtn");

        nextBtn.innerHTML = "Submit";
       
     
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that displays the correct step indicator:
    fixStepIndicator(n);
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("wizard-tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
     // Otherwise, display the correct tab:
     console.log(currentTab)
     
    if (currentTab == 3) {
        
        var nextBtn = document.getElementById("nextBtn");
        nextBtn.setAttribute("type", "submit");
    }
   
    showTab(currentTab);
}

function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("wizard-tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }
    }

    // Check if checkbox is checked in the first tab
    if (currentTab == 0) {
        var checkbox = document.getElementById("agreeCheckbox");
        if (!checkbox.checked) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Error</h4><small>Please check the terms and conditions to proceed</small>`,
                confirmButtonColor: "#3a57e8"
            });
            return false
        }
    }

    if (currentTab == 1) {
        var select = document.getElementById("category");
        if (select.value == "") {
            select.className += " invalid";
            valid = false;
        }
    }

    if (!valid) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Empty Field(s)</h4><small>Do not leave an empty field</small>`,
            confirmButtonColor: "#3a57e8"
        });
    } else {
        document.getElementsByClassName("list-item")[currentTab].className += " finish";
    }

    return valid;
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("list-item");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
}
