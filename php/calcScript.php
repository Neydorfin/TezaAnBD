<script src="../js/jquery-3.6.1.min.js"></script>

<script type="text/javascript">
    function calcCollect(){
        $(document).ready(function(){
            var data = {
                colect : $('#colect').val(),
                suma : $('#suma').val(),
                percent : $('#percent').val(),
                action : $('#action').val(),
            };

            $.ajax({
                url: 'function.php',
                type: 'post',
                data: data,
                success:function(response){
                    console.log(response);
                if(response.replace(/\s/g, '') == "Calculate"){
                    window.location = "index.php";
                }
                }
            });
        });
    }

    function getIndex(month, i){
                $(document).ready(function(){
                    var data = {
                        index : i,
                        monthYear : month,
                        action: 'index',
                    };
                    $.ajax({
                        url: 'function.php',
                        type: 'post',
                        data: data,
                        success:function(data){
                            window.location.reload();
                        }
                    });
                });
            }
    function deleteCalc(id)
    {
        var data = {
            id_colect :id,
            action: "deleteCalc",
        };
        console.log(data);
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success:function(response){
            if(response.replace(/\s/g, '') == "Delete"){
                window.location.reload();
            }
            }
        });
    }

    function deleteChelt(id)
    {
        var data = {
            id_chelt :id,
            action: "deleteChelt",
        };
        console.log(data);
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success:function(response){
            if(response.replace(/\s/g, '') == "Delete"){
                window.location.reload();
            }
            }
        });
    }

    function deleteVenit(id)
    {
        var data = {
            id_venit :id,
            action: "deleteVenit",
        };
        console.log(data);
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success:function(response){
            if(response.replace(/\s/g, '') == "Delete"){
                window.location.reload();
            }
            }
        });
    }

    function editChelt(id)
    {
        obj_chelt = '#obj_chelt'.concat(id);
        suma = '#suma'.concat(id);
        date = '#date'.concat(id);
        var data = {
            id_chelt :id,
            obj_chelt: $(obj_chelt).val(),
            date: $(date).val(),
            suma: $(suma).val(),
            action: "editChelt",
        };
        console.log(data);
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success:function(response){
            if(response.replace(/\s/g, '') == "Edit"){
                window.location.reload();
            }

            }
        });
    }

    function editVenit(id)
    {
        obj_venit = '#obj_venit'.concat(id);
        suma = '#sumaV'.concat(id);
        date = '#dateV'.concat(id);
        var data = {
            id_venit :id,
            obj_venit: $(obj_venit).val(),
            date: $(date).val(),
            suma: $(suma).val(),
            action: "editVenit",
        };
        console.log(data);
        $.ajax({
            url: 'function.php',
            type: 'post',
            data: data,
            success:function(response){
            if(response.replace(/\s/g, '') == "Edit"){
                window.location.reload();
            }

            }
        });
    }
    
</script>
