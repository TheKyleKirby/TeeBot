$(document).ready(function() {
    $("#signupForm").on("submit", function(e) {
        e.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();
        var handicap = $("#handicap").val();
        var profile_picture = $("#profile_picture").prop('files')[0];

        var formData = new FormData();
        formData.append("username", username);
        formData.append("password", password);
        formData.append("handicap", handicap);
        formData.append("profile_picture", profile_picture);

        $.ajax({
            url: "signup.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert("An error occurred. Please try again.");
            }
        });
    });
});
