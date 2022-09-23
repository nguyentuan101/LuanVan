<?php
////////////////////////////////////
///			 Diagnoses.php		///
// Get ?trieuchung ?label ?img from  Triệu_Chứng subClassOf
function get_trieuchung($sub_class){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
	PREFIX subclass: <".$sub_class.">
	SELECT * WHERE {
		?trieuchung a subclass: .
		?trieuchung rdfs:label ?label .
	   ?trieuchung benhtom:hinh_anh ?img .";
	if(isset($_POST['search-symptom'])){
		$inp = $_POST['search-symptom'];
		$sparql= $sparql."FILTER(regex(?label, '".$inp."' , 'i'))";
	}
	$sparql = $sparql." } ";
	//print $sparql;
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
// Get subClass of class Triệu_Chứng
function get_subClassOf_trieuchung(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
	SELECT *
	WHERE {
	?trieuchung rdfs:subClassOf benhtom:trieuchung . 
	?trieuchung rdfs:label ?label .
	} ";
	//print $sparql;
	$data = sparql_get($endpoint, $sparql);
	return $data;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
///
/// 		Access.php		///
// Get list Loại_Bệnh from trieuchung đã chọn
function get_loaibenh(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$checked_arr = $_POST['checkbox'];
	$count = count($checked_arr); //so luong checkbox checked
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?loaibenh ?label ?tacnhan ?cachphongchong (sum(?comment) as ?ptram) WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:tac_nhan ?tacnhan . 
		?loaibenh benhtom:cach_phong_chong ?cachphongchong . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?trieuchung in (";
	if (isset($_POST['checkbox'])) {
		foreach($_POST['checkbox'] as $value) {
			$trieuchung="tt".$i;
		if($i < $count)
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
		else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":";
			$i +=1;
		}
		$sparql=$sparql.")) .} ";
	}
	$sparql = $sparql."group by ?loaibenh ?label ?tacnhan ?cachphongchong ORDER BY DESC(?ptram)";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_label_trieuchung(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$checked_arr = $_POST['checkbox'];
	$count = count($checked_arr); //so luong checkbox checked
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?trieuchung ?label ?img WHERE { 
		?trieuchung rdfs:label ?label .
		?trieuchung benhtom:hinh_anh ?img .
		filter(?trieuchung in (";
	if (isset($_POST['checkbox'])) {
		foreach($_POST['checkbox'] as $value) {
			$trieuchung="tt".$i;
		if($i < $count)
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
		else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":";
			$i +=1;
		}
		$sparql=$sparql.")) .} ";
	}
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
// Get trieuchung thuộc 1 số loại bệnh ở access.php
function get_trieuchung2(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$checked_arr = $_POST['checkbox'];
	$count = count($checked_arr); //so luong checkbox checked
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT distinct ?trieuchung ?label ?img WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?trieuchung rdfs:label ?label . 
		?trieuchung benhtom:hinh_anh ?img
		filter(("; 
	if (isset($_POST['checkbox'])) { 
		foreach($_POST['checkbox'] as $value) { 
			$trieuchung="tt".$i; 
		if($i < $count) 
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql."?trieuchung !=".$trieuchung.": && ";
		else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql."?trieuchung !=".$trieuchung.":";
			$i +=1;
		}
		$sparql=$sparql.") && (?loaibenh in (";
	}
	$benh = get_loaibenh();
	$count2 = count($benh);
	$j=1;
	if (isset($benh)) {
		foreach( $benh as $row )
		{
			$lb="lb".$j;
			if($j < $count2)
				$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql.$lb.":, ";
			else	$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql.$lb.":";
				$j +=1;
		}
	}
	$sparql=$sparql."))) .} ";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///
/// 		Result.php		///
// Get list Loại_Bệnh from list benh+Id_tt_plus
function get_loaibenh3(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$checked_arr = $_POST['loaibenh'];
	$count = count($checked_arr); //so luong input loaibenh
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT distinct ?loaibenh WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		filter(?loaibenh in (";
	if (isset($_POST['loaibenh'])) {
		foreach($_POST['loaibenh'] as $value) {
			$lb="lb".$i;
			if($i < $count)
				$sparql="PREFIX ".$lb.": <".$value."> ".$sparql.$lb.":, ";
			else	
				$sparql="PREFIX ".$lb.": <".$value."> ".$sparql.$lb.":)";
			$i +=1;
		}
	}
	if(isset($_POST["trieuchung2"])){
		$radio = $_POST["trieuchung2"];
		$sparql="PREFIX tt: <".$radio."> ".$sparql." && ?trieuchung = tt:) .} ";
	}
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_trieuchung3(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$checked_arr = $_POST['loaibenh'];
	$count = count($checked_arr); //so luong input loaibenh
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT distinct ?trieuchung ?label WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?trieuchung rdfs:label ?label .
		filter(?loaibenh in (";
	$benh = get_loaibenh3();
	$sl_benh = count($benh);
	if (isset($benh)) {
		$i=1;
		foreach( $benh as $row2 )
		{
			$lb="lb".$i;
			if($i < $sl_benh)
				$sparql = "PREFIX ".$lb.": <".$row2['loaibenh']."> ".$sparql.$lb.":, ";
			else	
				$sparql = "PREFIX ".$lb.": <".$row2['loaibenh']."> ".$sparql.$lb.":)";
			$i +=1;
		}
	}
	if (isset($_POST['trieuchung'])) {
		$i=1;
		foreach($_POST['trieuchung'] as $value) {
			$tt="tt".$i;
			$sparql="PREFIX ".$tt.": <".$value."> ".$sparql."&& ?trieuchung !=".$tt.": ";
			$i +=1;
		}
	}
	if(isset($_POST["trieuchung2"])){
	$radio = $_POST["trieuchung2"];
	$sparql="PREFIX tt: <".$radio."> ".$sparql." && ?trieuchung != tt:) .} ";
	}
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_loaibenh_view(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$i=1;
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?loaibenh ?label ?tacnhan ?cachphongchong (sum(?comment) as ?ptram) WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:tac_nhan ?tacnhan . 
		?loaibenh benhtom:cach_phong_chong ?cachphongchong . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?loaibenh in (";
	$benh = get_loaibenh3();
	$sl_benh = count($benh);
	if (isset($benh)) {
		$i=1;
		foreach( $benh as $row2 )
		{
			$lb="lb".$i;
			if($i < $sl_benh)
				$sparql = "PREFIX ".$lb.": <".$row2['loaibenh']."> ".$sparql.$lb.":, ";
			else	
				$sparql = "PREFIX ".$lb.": <".$row2['loaibenh']."> ".$sparql.$lb.":) ";
			$i +=1;
		}
	}
	if (isset($_POST['trieuchung'])) {
		$i=1;
		foreach($_POST['trieuchung'] as $value) {
			$tt="tt".$i;
			if($i==1){
				$sparql="PREFIX ".$tt.": <".$value."> ".$sparql."&& (?trieuchung =".$tt.": ";
			}
			else	
				$sparql="PREFIX ".$tt.": <".$value."> ".$sparql." || ?trieuchung =".$tt.": ";
			$i +=1;
		}
	}
	if(isset($_POST["trieuchung2"])){
		$radio = $_POST["trieuchung2"];
		$sparql="PREFIX tt: <".$radio."> ".$sparql." || ?trieuchung = tt:)) .} ";
		}
	$sparql = $sparql."group by ?loaibenh ?label ?tacnhan ?cachphongchong ORDER BY DESC(?ptram)";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}




function get_loaibenh_tam(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?loaibenh ?label ?tacnhan ?cachphongchong (sum(?comment) as ?ptram) WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:tac_nhan ?tacnhan . 
		?loaibenh benhtom:cach_phong_chong ?cachphongchong . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?trieuchung in (";
	if (isset($_POST['trieuchung2'])) {
		$i=1;
		$checked_arr = $_POST['trieuchung2'];
		$count = count($checked_arr); 
		foreach($_POST['trieuchung2'] as $value) {
			$trieuchung="tt".$i;
			if($i < $count)
				$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
			else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":) && (";
				$i +=1;
		}
	}
	if (isset($_POST['loaibenh'])) {
		$i=1;
		$count = count($_POST['loaibenh']);
		foreach($_POST['loaibenh'] as $value) {
			$lb="lb".$i;
			if($i < $count)
				$sparql="PREFIX ".$lb.": <".$value."> ".$sparql."?loaibenh=".$lb.": ||";
			else	$sparql="PREFIX ".$lb.": <".$value."> ".$sparql."?loaibenh=".$lb.":";
				$i +=1;
		}
	}
	$sparql=$sparql.")) .} ";
	$sparql = $sparql."group by ?loaibenh ?label ?tacnhan ?cachphongchong ORDER BY DESC(?ptram)";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_loaibenh_result(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?loaibenh ?label ?tacnhan ?cachphongchong (sum(?comment) as ?ptram) WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:tac_nhan ?tacnhan . 
		?loaibenh benhtom:cach_phong_chong ?cachphongchong . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?trieuchung in (";
	if (isset($_POST['trieuchung'])) {
		$i=1;
		foreach($_POST['trieuchung'] as $value) {
			$trieuchung="ttt".$i;
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
			$i +=1;
		}
	}
	if (isset($_POST['trieuchung2'])) {
		$i=1;
		$checked_arr = $_POST['trieuchung2'];
		$count = count($checked_arr); 
		foreach($_POST['trieuchung2'] as $value) {
			$trieuchung="tt".$i;
			if($i < $count)
				$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
			else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":) && (";
				$i +=1;
		}
	}
	$loaibenh = get_loaibenh_tam();
	if ($loaibenh) {
		$i=1;
		$count = count($loaibenh);
		foreach($loaibenh as $row) {
			$lb="lb".$i;
			if($i < $count)
				$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql."?loaibenh=".$lb.": ||";
			else	$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql."?loaibenh=".$lb.":";
				$i +=1;
		}
	}
	$sparql=$sparql.")) .} ";
	$sparql = $sparql."group by ?loaibenh ?label ?tacnhan ?cachphongchong ORDER BY DESC(?ptram)";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_label_trieuchung_result(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$checked_arr = $_POST['trieuchung'];
	$checked_arr2 = $_POST['trieuchung2'];
	$count = count($checked_arr); //so luong checkbox checked
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?trieuchung ?label ?img WHERE { 
		?trieuchung rdfs:label ?label .
		?trieuchung benhtom:hinh_anh ?img .
		filter(?trieuchung in (";
	if (isset($_POST['trieuchung2'])) {
		$i=1;
		foreach($_POST['trieuchung2'] as $value) {
			$trieuchung="ttt".$i;
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
			$i +=1;
		}
	}
	if (isset($_POST['trieuchung'])) {
		$i=1;
		foreach($_POST['trieuchung'] as $value) {
			$trieuchung="tt".$i;
		if($i < $count)
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":, ";
		else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql.$trieuchung.":";
			$i +=1;
		}
		$sparql=$sparql.")) .} ";
	}
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_trieuchung_lienquan_result(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$checked_arr = $_POST['trieuchung'];
	$count = count($checked_arr); //so luong checkbox checked
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT distinct ?trieuchung ?label ?img WHERE { 
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		?trieuchung rdfs:label ?label . 
		?trieuchung benhtom:hinh_anh ?img
		filter(("; 
	if (isset($_POST['trieuchung2'])) { 
		$i=1;
		foreach($_POST['trieuchung2'] as $value) { 
			$trieuchung="ttt".$i; 
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql."?trieuchung !=".$trieuchung.": && ";
			$i++;
		}
	}
	if (isset($_POST['trieuchung'])) { 
		$i=1;
		foreach($_POST['trieuchung'] as $value) { 
			$trieuchung="tt".$i; 
		if($i < $count) 
			$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql."?trieuchung !=".$trieuchung.": && ";
		else	$sparql="PREFIX ".$trieuchung.": <".$value."> ".$sparql."?trieuchung !=".$trieuchung.":";
			$i +=1;
		}
		$sparql=$sparql.") && (?loaibenh in (";
	}
	$benh = get_loaibenh_result();
	$count2 = count($benh);
	if (isset($benh)) {
		$j=1;
		foreach( $benh as $row )
		{
			$lb="lb".$j;
			if($j < $count2)
				$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql.$lb.":, ";
			else	$sparql="PREFIX ".$lb.": <".$row['loaibenh']."> ".$sparql.$lb.":";
				$j +=1;
		}
	}
	$sparql=$sparql."))) .} ";
	//	print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}


//////////////////////////////////////////////////////////////////////////////////////
///										
///			Desease-detail.php		///
function get_detail_benh(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?loaibenh ?label ?tacnhan ?cachphongchong WHERE { 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:tac_nhan ?tacnhan . 
		?loaibenh benhtom:cach_phong_chong ?cachphongchong . 
		filter(?loaibenh =";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
				$sparql="PREFIX lb: <".$loaibenh."> ".$sparql."lb: )} ";
		}
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_detail_benh_trieuchung(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?trieuchung ?label ?img ?comment WHERE { 
		?trieuchung rdfs:label ?label .
		?trieuchung benhtom:hinh_anh ?img .
		?loaibenh benhtom:hasTrieuChung ?trieuchung . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?loaibenh =";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
				$sparql="PREFIX lb: <".$loaibenh."> ".$sparql."lb: )} ";
		}
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_detail_benh_thuoc(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT * WHERE { 
		?thuoc rdfs:label ?label .
		?thuoc benhtom:hinh_anh ?img .
		?loaibenh benhtom:hasThuoc ?thuoc . 
		filter(?loaibenh =";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
				$sparql="PREFIX lb: <".$loaibenh."> ".$sparql."lb: )} ";
		}
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}


/////////////////////////////////////////////////////////////////////////////////////
///					
///			Symptom-detail.php		///										
function get_detail_trieuchung(){
	$endpoint="http://localhost:3030/shrimpdisease";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
		$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?trieuchung ?label ?img WHERE { 
		?trieuchung rdfs:label ?label .
		?trieuchung benhtom:hinh_anh ?img
		filter(?trieuchung =";
		$sparql="PREFIX lb: <".$loaibenh."> ".$sparql."lb: )} ";
	}
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_detail_trieuchung_benh(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT * WHERE { 
		?loaibenh rdfs:label ?label .
		?trieuchung benhtom:TrieuChungof ?loaibenh . 
		[  a                      owl:Axiom ;
		rdfs:comment           ?comment;
		owl:annotatedProperty  benhtom:hasTrieuChung ;
		owl:annotatedSource    ?loaibenh ;
		owl:annotatedTarget    ?trieuchung
		] . 
		filter(?trieuchung =";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
		$sparql="PREFIX lb: <".$loaibenh."> ".$sparql."lb: )} ORDER BY DESC(?comment)";
	}
	
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}

/////////////////////////////////////////////////////////////////////////////////////
///					
///			Medicine-detail.php		///										
function get_detail_thuoc(){
	$endpoint="http://localhost:3030/shrimpdisease";
	if (isset($_GET["id"])) {
		$loaibenh = $_GET["id"];
		$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT * WHERE { 
		?thuoc a benhtom:thuoc .
		?thuoc rdfs:label ?label .
	   	?thuoc benhtom:hinh_anh ?img .
  		?thuoc benhtom:cach_su_dung ?csd .
		filter(?thuoc =";
		$sparql="PREFIX t: <".$loaibenh."> ".$sparql."t: )} ";
		$data = sparql_get($endpoint, $sparql);
	}
	//print ($sparql);
	return $data;
}
function get_detail_thuoc_benh(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT * WHERE { 
		?loaibenh rdfs:label ?label .
		?loaibenh benhtom:hasThuoc ?thuoc .
		filter(?thuoc =";
	if (isset($_GET["id"])) {
		$thuoc = $_GET["id"];
		$sparql="PREFIX t: <".$thuoc."> ".$sparql."t: )} ";
	}
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}


////////////////////////////////////////////////////////////////////////////////////
///
///			Search.php			///
function get_all_benh($name_subclass){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql=" PREFIX subclassname: <".$name_subclass."> 
	PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
	SELECT ?loaibenh ?label
	WHERE {
	?loaibenh rdfs:label ?label .
	?loaibenh a subclassname: . ";
	if(isset($_POST['search-desease'])){
		$inp = $_POST['search-desease'];
		$sparql= $sparql."FILTER(regex(?label, '".$inp."' , 'i'))";
	}
	$sparql = $sparql." } ";
	//print($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_all_trieuchung(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
		PREFIX owl: <http://www.w3.org/2002/07/owl#> 
		PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
		SELECT ?trieuchung ?label ?img WHERE { 
			?trieuchung rdfs:label ?label .
			?trieuchung benhtom:hinh_anh ?img .
			?trieuchung a benhtom:trieuchung .
		}";
	//print ($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_subClassOf_benh(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="
	PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
	SELECT ?loaibenh ?label
	WHERE {
	?loaibenh rdfs:label ?label .
	?loaibenh rdfs:subClassOf benhtom:loaibenh . 
	} ";
	//print($sparql);
	$data = sparql_get($endpoint, $sparql);
	return $data;
}
function get_all_thuoc(){
	$endpoint="http://localhost:3030/shrimpdisease";
	$sparql="PREFIX benhtom: <http://www.semanticweb.org/tuan/ontologies/2020/10/Ontology-BenhTom#> 
	PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
	SELECT * WHERE {
		?thuoc a benhtom:thuoc .
		?thuoc rdfs:label ?label .
	   ?thuoc benhtom:hinh_anh ?img .
  		?thuoc benhtom:cach_su_dung ?csd .";
	if(isset($_POST['search-medicine'])){
		$inp = $_POST['search-medicine'];
		$sparql= $sparql."FILTER(regex(?label, '".$inp."' , 'i'))";
	}
	$sparql = $sparql."} ";
	//print $sparql;
	$data = sparql_get($endpoint, $sparql);
	return $data;
}

////////////////////////////////////////////////////////////////////////////////////




?> 