<!DOCTYPE html>
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
    <!-- Font Google -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- Link font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Javascript -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php 
        require_once( "sparqllib.php" );
        require_once( "../connect_sparql.php" );
    ?>  <!-- php code -->
    
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
                    </div>  <!-- nav-collapse -->
                </div> <!-- container -->
            </nav>
        </div>  <!--head-bottom-->
    </div> <!-- header -->

    <div class="noidung">
        <div class="chose">
            <a href="search.php"><div class="chose_sub chose1 daclick" id="chose_benh" ><span>Loại Bệnh</span></div></a>
            <a href="search-symptom.php"><div class="chose_sub chose2" id="chose_trieuchung"><span>Triệu Chứng</span></div></a>
            <a href="search-medicine.php"><div class="chose_sub chose3" id="chose_thuoc"><span>Thuốc</span></div></a>
        </div><!-- search -->
        <div class="search-container search-medicine">
            <form action="search.php" method="post">
                <input type="text" placeholder="Search.." name="search-desease">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div><!-- search -->
        <div class="benh_search" id="benh_search">
            <div class="basic-search">
                <label id="search">Loại Bệnh</label>
            </div>
            <div class="list_all_benh">            
                <div class="all_benh">
                    <?php
                        $subClass_benh = get_subClassOf_benh();
                        if (isset($subClass_benh)) {
                            foreach( $subClass_benh as $row ){  ?>
                                <p><?php print $row['label']; ?></p>
                                <div class="part_benh">
                                    <?php   // Danh sach loai benh
                                        $loaibenh2 = get_all_benh($row['loaibenh']);
                                        if (isset($loaibenh2)) {
                                            foreach( $loaibenh2 as $row2 ){?>
                                                <div class="element_benh">
                                                    <a href="desease-detail.php?id=<?php print urlencode($row2['loaibenh']); ?>">
                                                        <div class="ptram"><span>  </span></div>
                                                        <span> <?php print $row2['label']; ?> </span>
                                                    </a>
                                                </div>
                                            <?php  }
                                        } ?>
                                </div>
                            <?php }
                        } ?>  
                </div>    
            </div>
        </div>  <!-- benh_search -->
    </div> <!-- noidung -->


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

<script src="assets/js/diagnosis.js"></script>
<script src="assets/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>
<script src="assets/select2/js/select2.min.js"></script>
<script src="assets/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function() {
            $("#checkAll").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });
    </script>
</body>
<script src="./assets/bootstrap/js/jquery.min.js"></script>
<script src="./assets/bootstrap/js/bootstrap.min.js"></script>
</html>