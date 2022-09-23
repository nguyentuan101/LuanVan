<!DOCTYPE html>
<html>
<head>
    <title>Disease Diagnosis System</title>
    <link rel="icon" href="img/shrimp-icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel='stylesheet' type='text/css' />
    <!-- Link font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Google -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>

<body>
    <?php 
        require_once( "sparqllib.php" );
        require_once( "../connect_sparql.php" );
    ?>
    <!-- php library sparql code -->
    
    <div class="header">
        <div class="header-top">
            <div class="container">
                <div class="logo">
                    <img src="img/shrimp-icon.png">
                    <h1>Shrimp: Disease Diagnosis System</h1>
                </div>
                <!-- logo -->
            </div>
            <!-- container -->
        </div>  <!-- header-top -->
        <div class="head-bottom">
            <nav>
                <div class="container">
                    <div id="navbar22" class="navbar-collapse22 collapse22">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php"><span class="fa fa-home"></span> Home</a></li>
                            <li><a href="diagnosis.php"><span class="fa fa-bar-chart"></span> Chẩn đoán</a></li>
                            <li><a href="search.php"><span class="fa fa-pencil"></span> Tra cứu </a></li>
                        </ul>
                    </div>  <!-- nav-collapse22 -->
                </div> <!-- container -->
            </nav>
        </div>  <!--head-bottom-->
    </div> <!-- header -->

    <div class="technology-1">
        <div class="container">
            <div class="col-md-12">
                <div class="blog-text">
                    <h1>Chẩn đoán bệnh</h1>
                        <form action="access.php" method="post">
                            <input type="hidden" name="m" value="hasil" />
                            <div class="panel panel-default">
                                <div class="panel-heading text-center">
                                    <h7 class="panel-title">Chọn Triệu Chứng</h7>
                                </div>
                                <?php 
                                    $data = get_subClassOf_trieuchung();
                                    if( !isset($data) )  {
                                        print "<p>Error: ".sparql_errno().": ".sparql_error()."</p>";
                                        return;
                                    }
                                    $i=1;
                                    foreach( $data as $row ) {?>
                                        <div class="div_sub_class">
                                            <label id="label_sub_class<?php print $i;?>"> <?php print $row['label']; ?></label><br>
                                            <div id="div_sub_subclass<?php print $i;?>">
                                                <?php
                                                    $sub_TrieuChung = $row['trieuchung'];
                                                    $list_trieuchung = get_trieuchung($sub_TrieuChung);
                                                ?>
                                                <div class="row"> 
                                                    <?php
                                                    foreach( $list_trieuchung as $row2 ) { ?>
                                                        <div class="col-md-3">
                                                            <div class="div_trieuchung">
                                                                <div class="check">
                                                                    <input type='checkbox' name='checkbox[]' class='trieuchung' value='<?php print $row2['trieuchung']; ?>' />
                                                                </div>
                                                                <div class="name">       
                                                                    <span><?php print $row2['label']; ?></span>
                                                                </div>
                                                                <div class="photo">
                                                                    <img id='<?php print $row2['label']; ?>' class='clickimg'
                                                                        src='<?php print $row2['img']; ?>' alt=''>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>  <!-- div_sub_subclass -->
                                        </div>   <!-- div_subclass -->
                                    <?php 
                                        $i++;} ?>
                                <div class="panel-footer">
                                    <button id="click-button"class="btn btn-primary" disabled><span
                                            class="glyphicon glyphicon-ok"></span> Submit Diagnosa</button>
                                    <img src="" alt="">
                                    <span> All   </span><input type="checkbox" id="checkAll">
                                </div>
                            </div>   <!-- panel panel-default -->
                        </form>  <!-- Form -->
                </div>   <!-- blog-text -->
            </div>     <!-- col-md-12 -->
        </div>    <!-- container -->
    </div>    <!-- technology-1 -->

    <div class="footer">
        <div class="text-center"> &copy; CanTho University</div>
    </div>  <!-- footer -->

    <div class="img-symptom" id="img-symptom">
        <div class="close" id="close" onclick="closediv()">Close</div>
        <h1>Diagnosis Image</h1>
        <div id="symptom-name">
            <p> Tên triệu chứng</p>
        </div>
        <div class="img-list" id="img-list">
            <center><img src="#" alt=""></center>
        </div>
    </div>   <!-- img-symptom -->


</body>
<script src="./assets/bootstrap/js/jquery.min.js"></script>
<script src="./assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/diagnosis.js"></script>
<script>
    $(document).ready(function() {
        $('#tabel_konsultasi').DataTable({
            "ordering": false,
            "pageLength": 50,
            "dom": '<"top"f>rt<"bottom"p><"clear">'
        });
    });
    $(function() {      /* check All */
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
    $(function() {      /*  disabled  button*/
        $('input:checkbox').click(function() {
            var count=0;
            $('input:checkbox').each(function() {
                if ($(this).is(":checked")) {
                    count++;
                    //alert(count);
                    document.getElementById("click-button").disabled=false;
                }
                if(count == 0){
                    document.getElementById("click-button").disabled=true;
                }
            });
        });
    });
    $(document).ready(function(){       /*  disabled  button 2  */
        var count=0;
        $('input:checkbox').each(function() {
            if ($(this).is(":checked")) {
                count++;
                //alert(count);
                document.getElementById("click-button").disabled=false;
            }
            if(count == 0){
                document.getElementById("click-button").disabled=true;
            }
        });
    });
</script>   <!-- js design -->

</html>