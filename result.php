<html>
<head>
    <title>Disease Diagnosis System</title>
    <link rel="icon" href="img/shrimp-icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom Theme files -->
    <link href="assets/css/style.css" rel='stylesheet' type='text/css' />
    <!-- Link font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Google -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Customer Javascript -->
    <script src="assets/js/diagnosis.js"></script>
</head>
<body>
    <?php   
        require_once( "sparqllib.php" );
        require_once( "../connect_sparql.php" );
        $trieuchung_arr_1 = $_POST["trieuchung"]; //Triệu chứng đã chọn ở access.php
        $trieuchung_arr_2 = $_POST["trieuchung2"];  //Triệu chứng liên quan ở access.php
        $loaibenh = get_loaibenh_result();            //Loại bệnh tìm được từ 2 trieuchung_arr ở trên
        $trieuchung_dachon =   get_label_trieuchung_result();     //  = tổng 2 trieuchung_arr ở trên
        $trieuchung_lienquan =  get_trieuchung_lienquan_result();    //Từ trieuchung của loaibenh trừ đi 2 trieuchung_arr ở trên
    ?><!-- connect DB -->

    <div class="header">
        <div class="header-top">
            <div class="container">
                <div class="logo">
                    <img src="img/shrimp-icon.png">
                    <h1>Shrimp: Disease Diagnosis System</h1>
                </div>  <!-- logo -->
            </div>  <!-- container -->
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
                    </div>  <!-- nav-collapse -->
                </div> <!-- container -->
            </nav>
        </div>  <!--head-bottom-->
    </div> <!-- header -->

    <div class="technology-1">
        <div class="container#">
            <div>
                <form action="result.php" method="post">
                    <div class="list-desease">
                        <label>Loại bệnh </label>
                        <div>
                            <?php   
                                if (isset($loaibenh)) {
                                    foreach( $loaibenh as $row2 ){?>
                                        <input type='hidden' name="loaibenh[]" value="<?php print $row2['loaibenh']; ?>" />
                                        <div class="div_benh">
                                            <div class="ptram"><span> <?php print $row2['ptram']; ?> </span></div>
                                            <div class="name"><span> <?php print $row2['label']; ?> </span></div>
                                            <div class="img"> <a href="desease-detail.php?id=<?php print urlencode($row2['loaibenh']); ?>"><img src="img/detail-icon.png" alt=""></a></div>
                                        </div>
                                    <?php  }
                                } ?>
                        </div>
                    </div>
                    <div class="list-symptom">
                        <label>Triệu chứng liên quan </label>
                        <div>
                            <?php   
                                if (isset($trieuchung_lienquan)) {
                                    foreach( $trieuchung_lienquan as $row2 ){?>
                                        <div class="div_trieuchung">
                                            <div class="check">
                                                <input type='checkbox' name='trieuchung2[]' class='trieuchung2' value='<?php print $row2['trieuchung']; ?>' />
                                            </div>
                                            <div class="name">   
                                                <span><?php print $row2['label']; ?></span>   
                                            </div>
                                            <div class="photo">
                                                <img id='<?php print $row2['label']; ?>' class='clickimg'  src='<?php print $row2['img']; ?>' alt=''>
                                            </div>
                                        </div>
                                    <?php } 
                                } ?>
                        </div>
                        <?php if(count($trieuchung_lienquan) !=0){    ?>
                                    <button id="click-button" disabled class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Submit</button>
                            <?php } ?>
                    </div>    
                    <div class="checked-symptom">
                        <label>Triệu chứng đã chọn </label> 
                        <div>
                            <?php 
                                if (isset($trieuchung_dachon)) {
                                    foreach($trieuchung_dachon as $row2) {?>
                                        <div class="div_trieuchung">
                                            <div class="check">
                                                <input type='hidden' checked name="trieuchung[]" value='<?php print $row2['trieuchung']; ?>' />
                                            </div>
                                            <div class="name">       
                                                <span><?php print $row2['label']; ?></span>
                                            </div>
                                            <div class="photo">
                                                <img id='<?php print $row2['label']; ?>' class='clickimg'  src='<?php print $row2['img']; ?>' alt=''>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                        </div>
                    </div>
                </form><!-- Form -->
            </div>
        </div> <!-- container# -->
    </div> <!-- technology-1 -->                                 

    <div class="img-symptom" id="img-symptom">
        <div class="close" id="close" onclick="closediv()">Close</div>
        <h1>Diagnosis Image</h1>
        <div id="symptom-name">
            <p> Tên triệu chứng</p>
        </div>
        <div class="img-list" id="img-list">
            <center><img src="#" alt=""></center>
        </div>
    </div> <!-- img-symptom -->

    <div class="back back_access">
        <img onclick="back()" src="img/back.png" alt="" >
    </div>  <!-- back button-->

<script>
    $(document).ready(function(){   
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
    $(function() {      /*  disabled  button    */
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
    function back(){
        history.back();
    }
</script>

</body>
</html>