<?php include("searchResult.php");?>

<html>
<head> 
<title>Know your city area</title>
 <link rel="stylesheet" href="style.css">

<script src = "https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type = "text/javascript">

  $(document).ready(function(){
    $('.rightpane').hide();
  });  

  $(document).ready(function(){
    $('.search-box input[name = "search"]').on("keyup input", function(){

        var inputVal  =  $(this).val();  
        var resultDropdown  =  $(this).siblings(".result");
        if(inputVal.length){
            $.get("searchResult.php", {term: inputVal}).done(function(data){
              resultDropdown.html(data);
              if (typeof(Storage) !== "undefined") {
                sessionStorage.setItem('dataStored', data);
              }
            });
        } else{
            resultDropdown.empty();
        }
    });
  });

  var filterTerms = {
    height: null,
    area: null,
    populationMin: null,
    populationMax: null
  };

  function showMax() {
     $(document).ready(function(){
      var populationMin = document.getElementsByName('populationMin');
      for (var i = 0; i < populationMin.length; i++)
      if (populationMin[i].checked) {
        filterTerms.populationMin = populationMin[i].value;
        if (populationMin[i].value == 200) {
          $('.rightpane').show();
        }
        else if (populationMin[i].value == 401) {
          $('.rightpane').show();
          document.getElementById('four').style.visibility = 'hidden';
          document.getElementById('six').style.visibility = 'visible';
          document.getElementById('eight').style.visibility = 'visible';
          document.getElementById('ten').style.visibility = 'visible';
        }
        else if (populationMin[i].value == 601) {
          $('.rightpane').show();
          document.getElementById('four').style.visibility = 'hidden';
          document.getElementById('six').style.visibility = 'hidden';
          document.getElementById('eight').style.visibility = 'visible';
          document.getElementById('ten').style.visibility = 'visible';
        }
        else {
          $('.rightpane').show();
          document.getElementById('four').style.visibility = 'hidden';
          document.getElementById('six').style.visibility = 'hidden';
          document.getElementById('eight').style.visibility = 'hidden';
          document.getElementById('ten').style.visibility = 'visible';
        }
      }
  });
  }

 function filters() {

    //Height Filter
    var height = document.getElementsByName('height');
    for (var i = 0; i < height.length; i++) {
      if (height[i].checked) {
        filterTerms.height = height[i].value;
      }
    }
     
    //Area Filter
    var area = document.getElementsByName('area');
    for (var i = 0; i < area.length; i++) {
      if (area[i].checked) {
        filterTerms.area = area[i].value;
      }
    }

    //Population Filter
    var populationMax = document.getElementsByName('populationMax');
    for (var i = 0; i < populationMax.length; i++) {
      if (populationMax[i].checked) {
        filterTerms.populationMax = populationMax[i].value;
      }
    }
      getFilteredData(filterTerms);

  }

  function getFilteredData(filterTerms) {
    var data = sessionStorage.getItem("dataStored");
    console.log(data);
    var cities = [];
    var heightFilter = filterTerms.height;
    var araeFilter = filterTerms.area;
    var populationMinFilter = filterTerms.populationMin;
    var populationMaxFilter = filterTerms.populationMax;
    var dataResult = jQuery.parseJSON(data);

    for (var i = 0; i < dataResult.length; i++) {
      if (heightFilter != null && araeFilter != null && populationMinFilter != null && populationMaxFilter != null) {
        if (dataResult[i].height > heightFilter  && dataResult[i].area < araeFilter && dataResult[i].population > populationMinFilter && dataResult[i].population < populationMaxFilter) {
          cities = cities.concat(JSON.stringify(dataResult[i]));  
        }
        else {
          $(".result").html("No city found");
        }
      }
      else if (heightFilter != null && araeFilter != null) {
        if (dataResult[i].height > heightFilter  && dataResult[i].area < araeFilter) {
          cities = cities.concat(JSON.stringify(dataResult[i]));  
        }
        else {
          $(".result").html("No city found");
        }
      }
      else if (heightFilter != null && dataResult[i].height > heightFilter) {
        cities = cities.concat(JSON.stringify(dataResult[i]));
      }
      else if (araeFilter != null && dataResult[i].area < araeFilter) {
        cities = cities.concat(JSON.stringify(dataResult[i]));
      }
      else if (populationMinFilter != null && populationMaxFilter != null) { console.log("Tale");
        if (dataResult[i].population > populationMinFilter && dataResult[i].population < populationMaxFilter) { 
            cities = cities.concat(JSON.stringify(dataResult[i]));
          }
          else {
            $(".result").html("No city found");
          }
      }
    }
    if (cities.length) {
      $( ".result" ).html( cities );
    }
    else {
      $( ".result" ).html( "No city found" );
    }
      
  }

  

    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type = "text"]').val($(this).text());
        $(this).parent(".result").empty();
    });

</script>

</head>
<body bgcolor = "#34495E" class="container"> 
  <div class = "toppane">
<h1><center><font color = "#D1F2EB">CITIES OF INDIA</font></center></h1>
<hr></div>
 <div class="leftpane">
  <div class = "search-box"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <label><b>City: </b></label><input id = "searchBar" type = "text" name = "search" autocomplete = "off" placeholder = "Search City...." />
  <br><br>

  <div class = "result"></div> 

</div>
</div>

<div class="middlepane">
    <label>Height: </label>
    <ol><input type="radio" name="height" value = "50" onchange = "filters()"/>Height above 50</ol>
    <ol><input type="radio" name="height" value = "100" onchange = "filters()"/>Height above 100</ol>
    <ol><input type="radio" name="height" value = "150" onchange = "filters()"/>Height above 150</ol>
    <ol><input type="radio" name="height" value = "200" onchange = "filters()"/>Height above 200</ol>

    <label>Area: </label>
    <ol><input type="radio" name="area" value = "500" onchange = "filters()"/>Area below 500</ol>
    <ol><input type="radio" name="area" value = "1000" onchange = "filters()"/>Area below 1000</ol>
    <ol><input type="radio" name="area" value = "1500" onchange = "filters()"/>Area below 1500</ol>
    <ol><input type="radio" name="area" value = "2000" onchange = "filters()"/>Area below 2000</ol>

</div>
<div class="rightpane">
    <label>Population Min: </label>
    <ol><input id="four" type="radio" name="populationMax" value = "400" onchange = "filters()"/>Max 400</ol>
    <ol><input id="six" type="radio" name="populationMax" value = "600" onchange = "filters()"/>Max 600</ol>
    <ol><input id="eight" type="radio" name="populationMax" value = "800" onchange = "filters()"/>Max 800</ol>
    <ol><input id="ten" type="radio" name="populationMax" value = "1000" onchange = "filters()"/>greater that 1000</ol>
</div>
<div class = "max">
    <label>Population Max: </label>
    <ol><input type="radio" name="populationMin" value = "200" onchange = "showMax()"/>Min 200</ol>
    <ol><input type="radio" name="populationMin" value = "401" onchange = "showMax()"/>Min 401</ol>
    <ol><input type="radio" name="populationMin" value = "601" onchange = "showMax()"/>Min 601</ol>
    <ol><input type="radio" name="populationMin" value = "801" onchange = "showMax()"/>Min 801</ol> 
  </div>


</div>
</body>
</html>
