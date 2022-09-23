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
            <a href="search.php"><div class="chose_sub chose1" id="chose_benh" ><span>Loại Bệnh</span></div></a>
            <a href="search-symptom.php"><div class="chose_sub chose2 daclick" id="chose_trieuchung"><span>Triệu Chứng</span></div></a>
            <a href="search-medicine.php"><div class="chose_sub chose3" id="chose_thuoc"><span>Thuốc</span></div></a>
        </div><!-- chose -->
        <div class="search-container search-medicine">
            <form action="search-symptom.php" method="post">
                <input type="text" placeholder="Search.." name="search-symptom">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div><!-- search -->
        <div class="trieuchung_search" id="trieuchung_search">
            <div class="basic-search">
                <label id="search">Triệu Chứng</label>
            </div>
            <div class="text">
                <?php 
                    $subclass_tc = get_subClassOf_trieuchung();
                    if( isset($subclass_tc) )  {
                        foreach( $subclass_tc as $row1 ) { ?>
                            <p><?php print $row1['label']; ?></p>
                            <div class="part_trieuchung">
                                <?php 
                                    $list_trieuchung = get_trieuchung($row1['trieuchung']);
                                    if(isset($list_trieuchung))  {
                                        foreach( $list_trieuchung as $row ) {?>
                                            <div class="element">
                                                <div class="name">       
                                                    <a href="symptom-detail.php?id=<?php print urlencode($row['trieuchung']); ?>">
                                                        <span><?php print $row['label']; ?></span>
                                                    </a>
                                                </div>
                                                <div class="photo">
                                                    <img id="Mắt phồng rộp" class="clickimg" src="<?php print $row['img']; ?>" alt="">
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                            </div>
                        <?php }
                    } 
                ?>
            </div> <!-- text -->
        </div> <!-- trieuchung_search -->
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