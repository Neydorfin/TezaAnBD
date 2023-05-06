<script src="../js/jquery-3.6.1.min.js"></script>

<script type="text/javascript">
    function submitData(){
        $(document).ready(function(){
            var data = {
                first_name : $('#first_name').val(),
                last_name : $('#last_name').val(),
                email : $('#email').val(),
                password : $('#password').val(),
                conf_pass : $('#conf_pass').val(),
                action : $('#action').val(),
            };

            $.ajax({
                url: 'function.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "LoginSuccessful" || response.replace(/\s/g, '') == "RegisterSuccesful"){
                    window.location.reload();
                    $("#error").addClass("hidden");
                }
                else if(response.replace(/\s/g, '') == "admin")
                {
                    window.location.replace("../admin/admin.php");
                }
                else{
                    $("#error").removeClass("hidden");
                    $("#error").addClass("error");
                    $("#error").text(response);
                }
                }
            });
        });
    }
</script>



