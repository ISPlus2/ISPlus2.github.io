<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="../select.css">
<link rel="stylesheet" href="../../header.css">

<script type="text/javascript" src="../script.js"></script>

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
  h5 {
    float: right;
    margin-top: -0rem;
  }

  div.select {
    position: relative;
  }

  h2.title {
    right: 5%;
    position: relative;
    margin-top: 5em;
    top: 1em;
  }

  body{
    margin: 0;
    padding: 0;
    display: grid;
    justify-content: center;
  }

  .dropdown-container:last-child {
    right: 50%;
  }

  div.charts-0 {
    margin-top: 7em;
    text-align: center;
  }
  
  div.charts-1 {
    margin-top: 7em;
    text-align: center;
  }

  table {
    border-collapse: collapse;
    direction: rtl;
    width: 100%;
  }

  th,
  td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
  }

  body.dark th {
    border: 1px solid white;
  }

  body.dark td {
    border: 1px solid white;
  }

  th {
    background-color: #f2f2f2;
  }

  body.dark th {
    background-color: #020246;
  }

  td.grade {
    background-color: rgb(212, 218, 225);
  }
  
  form.filter-0, form.filter-1{
      display: none;
      background: none;
      position: relative;
  }
  
  body.dark form.filter-0, body.dark form.filter-1{
      background: none;
  }
  
  body.dark a{
      color: white;
  }
  
  a{
      color: black;
  }
  
  @media screen and (max-width: 600px) {
        body{
            display: block;
            width: 190%;
        }
        table {
            width: 80%;
            margin-left: 8%;
        }
    }
  
</style>

</head>
<body>
<header id="header">
    <div style="width: 100%; height: 100%">
        <div style="width: 100%; height: 62%; top: 0%; position: absolute;">
            <a class="hover" href="uploads/" title="Directory Lister" style="position: absolute; top: 20%; left: 6%; width: 50px; height:30px;">
                <img width="100%" src="../../img/upload.png"/>
            </a>
        
            <form id='frm' method="POST" onsubmit="return false">
                <span class='ad'></span>
            </form>
            
            <div id="mode">
               <div class="transform" style="transition-property: all;transition-duration: .3s;transition-timing-function: cubic-bezier(.4,0,.2,1);background-color: white;border-radius: 9999px;width: 1.25rem; height: 1.25rem;margin-left: -0.08rem;">
                    <i id="lamp" class="fa fa-lightbulb-o" style="margin-left: 7px; font-size: .75em;"></i>
                </div>
            </div>
        </div>
        <div style="position: absolute;left: 4.8%;height: 60%;color: white;top: 45%;">
            <h4 class="dl hover" title="Info" style="font-size: 1.1rem; line-height: 1.25rem;">
                העלאת ציונים
            </h4>
        </div>
        <div style="position: absolute;right: 4.8%;height: 60%;color: white;top: 45%;">
            <h4 class="dl hover" title="Info" style="font-size: 1.1rem; line-height: 1.25rem;">
                מערכות מידע
            </h4>
        </div>
    </div>
</header>

<center style="top: 100px;position: relative">
    
<?php

$dir = basename(getcwd());
$paths = explode('-', $dir);
$lect = $paths[0];
unset($paths[0]);
$course = implode('-', $paths);

echo "<h3 id='statics'>מרצה: $lect, קורס: $course</h3>";

$field = 'name';
$opposite_field = 'lecture';

$rep_name = array("name" => "Course", "lecture" => "Lecturer")[$field];
?>
</center>

<center style="top: 100px; position: relative;">

<a id="show-0" onclick="reg_sort()" href='#'>Sort by <?php echo $rep_name; ?></a></form>
<a id="show-1" onclick="year_sort()" href='#'>Sort by Year</a></form>

</center>

<?php

$arrRanks = ["'a'" => "א", "'b'" => "ב", "'c'" => "ג", "'A'" => "א", "'B'" => "ב", "'C'" => "ג"];


?>

<div class="charts-0">

<?php 

$files = scandir('.');
unset($files[0]);
unset($files[1]);
unset($files[2]);
$files = array_values($files);

$rows = [];
$c = 0;
while ($c < count($files))
{
    $headers = explode('-', str_replace(".json", "", $files[$c]));
    $data = json_decode(file_get_contents($files[$c]), true);

    $rows[] = array("id" => $c, "lecture" => $headers[0], "name" => $headers[1], "moed" => $headers[2], "semester" => $headers[3], "year" => $headers[4], "file" => $files[$c+1], "avg" => 0, "num" => 0);
    $c += 2;
}

$year = "";
$id = "";
$dta = "";

$c1 = array_column($rows, 'year');
$c2 = array_column($rows, $field);
$c3 = array_column($rows, 'semester');
$c4 = array_column($rows, 'moed');
    
array_multisort($c1, SORT_DESC, $c2, SORT_ASC, $c3, SORT_DESC, $c4, SORT_ASC, $rows);

$table_start = "<table><tr><th>Year</th><th>Semester</th><th>$rep_name</th><th>Moed</th><th hidden>Average</th><th hidden>Amount</th><th colspan='5'>Histogram</th></tr>";
$table_end = "</table>";
    
$counts_for_course = [];
$counts_for_year = [];
$counts_for_semester = [];
    
foreach ($rows as $row)
{
    $key = $row["id"];
    if (!array_key_exists($key, $counts_for_semester)) {
        $counts_for_semester[$key] = 0;
    }
    $counts_for_semester[$key] += 1;
        
    $key = $row["year"];
    if (!array_key_exists($key, $counts_for_year)) {
        $counts_for_year[$key] = 0;
    }
    $counts_for_year[$key] += 1;
}
    
$c = 0;
foreach ($rows as $row)
{
        
    $table_start .= "<tr>";
        
    if ($row['year'] != $year && $row['id'] != $id)     //we start completely new year
    {
        $year = "";
        $id = "";
    }
        
    if ($row['year'] != $year)     //start year
    {
        $year = $row['year'];
        $dta = "";
            
        $key = $row["year"];
        $table_start .= "<td rowspan='{$counts_for_year[$key]}'>{$row['year']}</td>";
    }
        
    if ($row['id'] != $id)     //start semester
    {
        $id = $row['id'];
        $dta = "";
            
        $key = $row["id"];
        $m = $arrRanks["'".$row["semester"]."'"];
        $table_start .= "<td rowspan='{$counts_for_semester[$key]}'>סמסטר $m</td>";
    }
        
    if ($row[$field] != $dta)     //finish year and start new one
    {
        $dta = $row[$field];
        
        $key = $row["id"];
        $table_start .= "<td rowspan='{$counts_for_semester[$key]}'>{$row[$field]}</td>";
    }
        
    
    $m = $arrRanks["'".$row["moed"]."'"];
    $table_start .= "<td>מועד $m</td>";
        
    $table_start .= "<td hidden>{$row['avg']}</td><td hidden>{$row['num']}</td>";
        
                
    $table_start .= "<td class='grade'><img width='300px' height='84px' style='float: right; padding-right: 40px; position: relative; right:0%; top:0px' src='{$row['file']}' /></td>";
    $table_start .= "</tr>";
}

if (count($rows) > 0)
{
    $table_start .= $table_end;
    echo $table_start;
}


?>
</div>

<div style="display: none" class="charts-1">

<?php

$year = "";
$id = "";
$dta = "";

$c1 = array_column($rows, $field);
$c2 = array_column($rows, 'year');
$c3 = array_column($rows, 'semester');
$c4 = array_column($rows, 'moed');

array_multisort($c1, SORT_ASC, $c2, SORT_DESC, $c3, SORT_DESC, $c4, SORT_ASC, $rows);

$table_start = "<table><tr><th colspan='2'>$rep_name</th><th>Year</th><th>Semester</th><th>Moed</th><th hidden>Average</th><th hidden>Amount</th><th colspan='5'>Histogram</th></tr>";
$table_end = "</table>";

$counts_for_course = [];
$counts_for_year = [];
$counts_for_semester = [];
    
foreach ($rows as $row)
{
    $key = $row["id"];
    if (!array_key_exists($key, $counts_for_semester)) {
        $counts_for_semester[$key] = 0;
    }
    $counts_for_semester[$key] += 1;
    
    $key = $row["name"].'-'.$row["lecture"].'-'.$row["year"];
    if (!array_key_exists($key, $counts_for_year)) {
        $counts_for_year[$key] = 0;
    }
    $counts_for_year[$key] += 1;
    
    $key = $row["name"].'-'.$row["lecture"];
    if (!array_key_exists($key, $counts_for_course)) {
        $counts_for_course[$key] = 0;
    }
    $counts_for_course[$key] += 1;
}
    
$c = 0;
foreach ($rows as $row)
{
    
    $table_start .= "<tr>";
    
    if ($row[$field] != $dta)     //finish year and start new one
    {
        $dta = $row[$field];
        $year = "";
        
        $key = $row["name"].'-'.$row["lecture"];
        $table_start .= "<td colspan='2' rowspan='{$counts_for_course[$key]}'>{$row[$field]}</td>";
    }
    
    if ($row['year'] != $year)     //finish year and start new one
    {
        $year = $row['year'];
        
        $key = $row["name"].'-'.$row["lecture"].'-'.$row["year"];
        $table_start .= "<td rowspan='{$counts_for_year[$key]}'>{$row['year']}</td>";
    }

    
    if ($row['id'] != $id)     //start semester
    {
        $id = $row['id'];
        
        $key = $row["id"];
        $m = $arrRanks["'".$row["semester"]."'"];
        $table_start .= "<td rowspan='{$counts_for_semester[$key]}'>סמסטר $m</td>";
    }
        
    $m = $arrRanks["'".$row["moed"]."'"];
    $table_start .= "<td>מועד $m</td>";
    
    $table_start .= "<td hidden>{$row['avg']}</td><td hidden>{$row['num']}</td>";
    
            
    $table_start .= "<td class='grade'><img width='300px' height='84px' style='float: right; padding-right: 40px; position: relative; right:0%; top:0px' src='{$row['file']}' /></td>";
    $table_start .= "</tr>";
}


if (count($rows) > 0)
{
    $table_start .= $table_end;
    echo $table_start;
}

?>
</div>
<br/>

<script>
var mod = 0;
window.onload = function(){
        
        $("a#show-0").hide();
        $("a#show-1").hide();
        
        if ($("table").length > 0)
        {
            $("a#show-" + mod).show();
        }
        $("header").width($("body").width());
        
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
    		    switchMode();
    		    
        $("div#mode").click(switchMode);

        
    }


    function reg_sort()
    {
        $("a#show-0").hide();
        $("a#show-1").show();
        
        $("div.charts-0").hide();
        $("div.charts-1").show();
    }
    
    function year_sort()
    {
        $("a#show-1").hide();
        $("a#show-0").show();
        
        $("div.charts-1").hide();
        $("div.charts-0").show();
    }

    function switchMode()
	{
	    if ($("body").hasClass("dark")){
	        $("body").attr('class', 'light');
	    }
	    
	    else{
	        $("body").attr('class', 'dark');
	    }
	}
    	
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => { 
    	
        if (event.matches)
    	   switchMode();
    });
    
</script>


</body>
</html>


