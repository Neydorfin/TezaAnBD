<script src="../js/jquery-3.6.1.min.js"></script>

<script type="text/javascript">
    function editAccount(){
        $(document).ready(function(){
            var data = {
                first_name : $('#first_name').val(),
                last_name : $('#last_name').val(),
                email : $('#email').val(),
                password : $('#password').val(),
                date : $('#date').val(),
                action : $('#action').val(),
            };

            $.ajax({
                url: 'function.php',
                type: 'post',
                data: data,
                success:function(response){
                    console.log(response);
                if(response.replace(/\s/g, '') == "EditingEditing"){
                    window.location = "account.php";
                    $("#error").addClass("hidden");
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
