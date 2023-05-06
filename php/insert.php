<script src="../js/jquery-3.6.1.min.js"></script>

<script type="text/javascript">
    function submitData(){
        $(document).ready(function(){
            var data = {
                costs : $('#costs').val(),
                sum : $('#sum').val(),
                date : $('#date').val(),
                action : $('#action').val()
            };

            $.ajax({
                url: 'function.php',
                type: 'post',
                data: data,
                success:function(response){
                if(response.replace(/\s/g, '') == "InsertionSuccesful"){
                    window.location = "index.php";
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



