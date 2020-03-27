
// change password
$("#change_password").on('click', function(){
    var password            = $('#current_password').val();
    var new_password        = $('#new_password').val();
    var confirm_password    = $('#confirm_password').val();
    
    if(!new_password || !confirm_password || new_password !== confirm_password)
    {
        showNotification('error', 'New password and confirm password does not match or password fields can not be empty')
    }
    else
    {
        $.ajax({
            type      : 'POST',
            url       : BASE_URL + 'API/User/change_password',
            dataType  : 'text',
            data      : {'password': password, 'new_password': new_password},
            success: function(response)
            {
                if(response)
                    showNotification('success', 'Password changed successfully');               
                else
                    showNotification('error', 'Password could not be changed.')
 
            }
        });
    }
});


// Add user
$("#add_user").on('click', function(e){
    e.preventDefault();
    var name    = $('#name').val();
    var email   = $('#email').val();
    var mobile  = $('#mobile').val();
    var type    = $('#type').val();
    var password   = $('#password').val();
    
    // alert(name + " - "+ email + " - "+ mobile + " - "+ type);
    if(!name || !email || !mobile || !type)
    {
        $('#au_result').html('<div class="alert alert-danger event-notification"> All fields are required. Please fill all fields.</div>');
    }
    else
    {
        $.ajax({
            type      : 'POST',
            url       : BASE_URL + 'API/User/add_user',
            dataType  : 'text',
            data      : {'name': name, 'email': email, 'mobile': mobile, 'type': type, 'password' : password},

            beforeSend: function()
            {
                $('#au_result').html('<img src="'+BASE_URL+'assets/img/loader.gif" class="pull-right" style="width: 30px;">');
            },

            success: function(response)
            {
                if(JSON.parse(response)['data']['result']){
                    showNotification('success', 'User created successfully');
                    window.location.href="/user/dashboard";
                }
                else
                    showNotification('error', 'User coukd not be created, please try again.')
                
            }
        });
    }
});

// 



$(".assign_to_modal").on('click', function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    $("#myModal").modal();
    $(".modal-footer").hide();
    $.ajax({
        url     : href,
        beforeSend: function()
        {
            $(".modal-title").html('Please wait..');
            $('.modal-body').html('<center><br><img src="'+BASE_URL+'assets/img/loader.gif" style="width: 30px;"></center><br>');
        },

        success: function(response)
        {
            $(".modal-title").html('Assign Ticket..');
            $('.modal-body').html(response);
        }
    })
    // $(".modal-body").html(href);

});








