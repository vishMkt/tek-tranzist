
      
$(document).ready(function() {
    var $menuToggle = $('#menu-toggle');
    var $closeSidebar = $('#close-sidebar');
    var $sidebar = $('#sidebar');
    var $wrapper = $('#wrapper');
    var $toggleIcon = $menuToggle.find('i'); // Select the icon inside the button

    // Default state: Sidebar is active (visible) on larger screens
    function checkScreenSize() {
        if ($(window).width() >= 992) {
            $sidebar.addClass("active"); // Active (visible) on large screens
            $wrapper.addClass("padding-left").removeClass("no-padding");
            $toggleIcon.removeClass('fa-times').addClass('fa-bars'); // Ensure correct icon on load
        } else {
            $sidebar.removeClass("active"); // Not active (hidden) on small screens
            $wrapper.addClass("no-padding").removeClass("padding-left");
            // $toggleIcon.removeClass('fa-bars').addClass('fa-times'); // Ensure correct icon on load
        }
    }

    // Run on initial load
    checkScreenSize();

    // Toggle sidebar visibility and icon on button click
    $menuToggle.on('click', function() {
        $sidebar.toggleClass("active");
        $wrapper.toggleClass("padding-left", $sidebar.hasClass("active"));
        $wrapper.toggleClass("no-padding", !$sidebar.hasClass("active"));

        // Change the icon based on sidebar state
        if ($sidebar.hasClass('active')) {
            $toggleIcon.removeClass('fa-bars').addClass('fa-times'); // Change to 'close' icon
        } else {
            $toggleIcon.removeClass('fa-times').addClass('fa-bars'); // Change to 'menu' icon
        }
    });

    // Close sidebar on close button click and reset the toggle icon
    $closeSidebar.on('click', function() {
        $sidebar.removeClass("active");
        $wrapper.addClass("no-padding").removeClass("padding-left");
        $toggleIcon.removeClass('fa-times').addClass('fa-bars'); // Change to 'menu' icon
    });

    // Run the check on window resize
    $(window).on('resize', checkScreenSize);
});


$(document).ready(function() {
    $('.sidemenu-toggle > a').on('click', function(event) {
        // alert('tttt'); 
        event.preventDefault(); 
        var $parentLi = $(this).parent(); 
        
        // Toggle the active class on the parent li
        $parentLi.toggleClass('active');
        
        // Slide toggle the submenu
        // $parentLi.find('.pcoded-submenu').slideToggle();
    });

    // $('.main_menu li').on('click', function(event){
    //     // alert('tttt'); 
    //     $(this).addClass('active'); 
    // });

    // $('.pcoded-submenu > li').on('click', function(event){
        
    //     $('.pcoded-submenu > li').removeClass('active'); 
    //     $(this).addClass('active'); 
    // });


        $('.dropdownButton').click(function(){
          $(this).next('.dropdown-menu').toggle();
        });
      
});


const countries = [
    { name: "United Kingdom", code: "+44", flag: "https://www.countryflags.com/wp-content/uploads/united-kingdom-flag-png-large.png" },
    { name: "United States", code: "+1", flag: "https://www.countryflags.com/wp-content/uploads/united-states-of-america-flag-png-large.png" },
    { name: "Canada", code: "+1", flag: "https://www.countryflags.com/wp-content/uploads/canada-flag-png-large.png" },
    { name: "Australia", code: "+61", flag: "https://www.countryflags.com/wp-content/uploads/australia-flag-png-large.png" },
    { name: "India", code: "+91", flag: "https://www.countryflags.com/wp-content/uploads/india-flag-png-large.png" },
    // Add more countries as needed
];

$(document).ready(function() {
    const $countrySelect = $('#country-code');

    countries.forEach(country => {
        const option = `<option value="${country.code}" data-flag="${country.flag}" data-code="${country.code}">
                            <img src="${country.flag}" alt="${country.name} Flag" style="width: 20px; margin-right: 5px;">
                            ${country.name} (${country.code})
                        </option>`;
        $countrySelect.append(option);
    });

    // Set the initial flag and code
    updatePhoneCode($countrySelect.find('option:selected').data('flag'), $countrySelect.val());

    $countrySelect.change(function() {
        const selectedOption = $(this).find('option:selected');
        const flag = selectedOption.data('flag');
        const code = selectedOption.val();

        updatePhoneCode(flag, code);
    });

    function updatePhoneCode(flagUrl, code) {
        const flagImg = `<img src="${flagUrl}" alt="Flag" style="width: 20px; margin-right: 5px;">`;
        $('#selected-country').html(`${flagImg}${code}`);
    }
});

// $(document).ready(function() {
//     $(".select-selected").click(function() {
//       $(this).next(".select-items").toggle();
//     });
  
//     $(".select-items div").click(function() {
//       var selectedText = $(this).text();
//       $(".select-selected").text(selectedText);
//       $(".select-items").hide();
//     });
  
//     // Close the dropdown if the user clicks outside of it
//     $(document).click(function(e) {
//       if (!$(e.target).closest('.custom-select').length) {
//         $(".select-items").hide();
//       }
//     });
//   });

  $(document).ready(function() {
    $(".select-selected").click(function() {
      $(this).next(".select-items").toggle();
    });
  
    $(".select-items div").click(function() {
      var selectedDiv = $(this).clone(); // Clone the clicked div
      $(".select-selected").html(selectedDiv); // Replace the content of .select-selected with the cloned div
      $(".select-items").hide();
    });
  
    // Close the dropdown if the user clicks outside of it
    $(document).click(function(e) {
      if (!$(e.target).closest('.custom-select').length) {
        $(".select-items").hide();
      }
    });
  });

  // Example of changing the button text when a status is selected
document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', function() {
        document.getElementById('statusDropdown').textContent = this.textContent.trim();
    });
});


$(document).ready(function() {
    $('.stars').each(function() {
        var rating = parseFloat($(this).attr('data-rating'));
        $(this).find('.star').each(function() {
            var value = parseFloat($(this).attr('data-value'));
            if (value <= rating) {
                $(this).addClass('filled');
            }
        });
    });
});

function  statusRow(e,url) {
    // alert(url);
    var type=0;
    if($(e).prop("checked") == true){
        type=1;
    }
    if(confirm("Are you sure want to change status?")){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('status', type);
        $.ajax({
            url: url,
            method: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                
                if (response.success == 1) {
                    toastr.success(response.message, 'Success');
                    table.draw(false);
                }
            },
            error: function(data) {
                if (typeof data.responseJSON.status !== 'undefined') {
                    toastr.error(data.responseJSON.error, 'Error');
                } else {
                    $.each(data.responseJSON.errors, function(key, value) {
                        toastr.error(value, 'Error');
                    });
                }
            }
        });
    }else{
        if($(e).prop("checked") == true){
            $(e).prop('checked', false);
        }else{
            $(e).prop('checked', true);
        }
    }
}

