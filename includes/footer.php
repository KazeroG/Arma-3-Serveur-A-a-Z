    <script>
        $("#submit-search").click(function(){
            if($("#input-search").val() != '') {
                $("#search-form").submit();
            }
        });
        $(".notif").click(function(e){
            e.preventDefault();
            var link = $(this).attr("href");
            $.getJSON("ajaxqueries.php",{
                query: "setStatus",
                id: $(this).data('id')
            }).done(function(data){
                window.location.replace(link);
            });
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="bower_components/raphael/raphael-min.js"></script>
    <script src="js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
