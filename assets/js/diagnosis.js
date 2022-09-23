//   Đóng div hình ảnh
function closediv() {   
    document.getElementById("img-symptom").style.display = "none";
}

//   Ẩn hiện list sub-trieuchung
$(document).ready(function(){   
    $("#label_sub_class1").click(function(e){ 
        if(document.getElementById("div_sub_subclass1").style.display == "block"){
            document.getElementById("div_sub_subclass1").style.display = "none";
            document.getElementById("label_sub_class1").style.background = "#80ddef";
            document.getElementById("label_sub_class1").style.color = "#336fb7";
        }
        else    {
            document.getElementById("div_sub_subclass1").style.display = "block";
            document.getElementById("label_sub_class1").style.background = "rgb(6 80 170)";
            document.getElementById("label_sub_class1").style.color = "white";
           
        }
    });
});
$(document).ready(function(){   
    $("#label_sub_class2").click(function(e){ 
        if(document.getElementById("div_sub_subclass2").style.display == "block"){
            document.getElementById("div_sub_subclass2").style.display = "none";
            //document.getElementById("label_sub_class2").style.background = "#5acae0";
            document.getElementById("label_sub_class2").style.background = "#80ddef";
            document.getElementById("label_sub_class2").style.color = "#336fb7";
        }
        else    {
            document.getElementById("div_sub_subclass2").style.display = "block";
           // document.getElementById("label_sub_class2").style.background = "#80ddef";
           document.getElementById("label_sub_class2").style.background = "rgb(6 80 170)";
            document.getElementById("label_sub_class2").style.color = "white";
        }
    });
});
$(document).ready(function(){   
    $("#label_sub_class3").click(function(e){ 
        if(document.getElementById("div_sub_subclass3").style.display == "block"){
            document.getElementById("div_sub_subclass3").style.display = "none";
           // document.getElementById("label_sub_class3").style.background = "#5acae0";
            document.getElementById("label_sub_class3").style.background = "#80ddef";
            document.getElementById("label_sub_class3").style.color = "#336fb7";
        }
        else    {
            document.getElementById("div_sub_subclass3").style.display = "block";
            //document.getElementById("label_sub_class3").style.background = "#80ddef";
            document.getElementById("label_sub_class3").style.background = "rgb(6 80 170)";
            document.getElementById("label_sub_class3").style.color = "white";
        }
    });
});

//  Event click img-icon
$(document).ready(function(){ 
    $(".clickimg").click(function(e){
        document.getElementById("img-symptom").style.display = "block";
        var img_src=this.src;
        var id=this.id;
        var source = "<center><img src='".concat(img_src, "'/></center>");
        var symptom_name = "<p>".concat(id, "</p>");
        document.getElementById("img-list").innerHTML = source;
        document.getElementById("symptom-name").innerHTML = symptom_name;
    });
});

//  check All
$(document).ready(function(){   
    $("#checkAll").click(function(e){ 
        var trieuchung=[];
        $(".trieuchung").each(function(){
            $(this).is(":checked");
        });
    });
});


//////////////////////////////////////////////////////////
///////////////          access.php       ///////////////
//////////////////////////////////////////////////////////
//  click View
function click_view($view) {   
    // document.getElementById("a").style.display = "none";
    // document.getElementsByClassName("view").style.display = "none !important";
    var elements = document.getElementsByClassName($view);
    for (var i in elements) {
        if (elements.hasOwnProperty(i)) {
            if(elements[i].style.display == "" || elements[i].style.display == "none"){
                elements[i].style.display = "block";
            }
            else 
            if(elements[i].style.display == "block"){
                elements[i].style.display = "none";
            }
        }
    }
}


//////////////////////////////////////////////////////////
///////////////          search.php       ///////////////
//////////////////////////////////////////////////////////
/*
$("#chose_benh").click(function(e){ 
    $benh = document.getElementById("benh_search");
    $trieuchung = document.getElementById("trieuchung_search");
    $thuoc = document.getElementById("thuoc_search");
        $benh.style.display = "block";
        $trieuchung.style.display = "none";
        $thuoc.style.display = "none";

    $chose1 = document.getElementById("chose_benh");
    $chose2 = document.getElementById("chose_trieuchung");
    $chose3 = document.getElementById("chose_thuoc");
        $chose1.style.background = "#2c6dd5";
        $chose1.style.color = "white";
        $chose2.style.background = "#f0e6e6";
        $chose2.style.color = "black";
        $chose3.style.background = "#f0e6e6";
        $chose3.style.color = "black"; 
});
$("#chose_trieuchung").click(function(e){ 
    $benh = document.getElementById("benh_search");
    $trieuchung = document.getElementById("trieuchung_search");
    $thuoc = document.getElementById("thuoc_search");
        $benh.style.display = "none";
        $trieuchung.style.display = "block";
        $thuoc.style.display = "none";

    $chose1 = document.getElementById("chose_benh");
    $chose2 = document.getElementById("chose_trieuchung");
    $chose3 = document.getElementById("chose_thuoc");
        $chose2.style.background = "#2c6dd5";
        $chose2.style.color = "white";
            $chose3.style.background = "#f0e6e6";
            $chose3.style.color = "black";
            $chose1.style.background = "#f0e6e6";
            $chose1.style.color = "black"; 
});
$("#chose_thuoc").click(function(e){ 
    $benh = document.getElementById("benh_search");
    $trieuchung = document.getElementById("trieuchung_search");
    $thuoc = document.getElementById("thuoc_search");
        $benh.style.display = "none";
        $trieuchung.style.display = "none";
        $thuoc.style.display = "block";

    $chose1 = document.getElementById("chose_benh");
    $chose2 = document.getElementById("chose_trieuchung");
    $chose3 = document.getElementById("chose_thuoc");
        $chose3.style.background = "#2c6dd5";
        $chose3.style.color = "white";
            $chose2.style.background = "#f0e6e6";
            $chose2.style.color = "black";
            $chose1.style.background = "#f0e6e6";
            $chose1.style.color = "black"; 
});
*/





