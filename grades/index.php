<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="select.css">
<link rel="stylesheet" href="../header.css">

<script type="text/javascript" src="script.js"></script>
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

  div.charts {
    margin-top: 13em;
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
                <img width="100%" src="../img/upload.png"/>
            </a>
        
            <form id='frm' method="POST" onsubmit="return false">
                <span class='ad'>התחדשנו בעמוד ציונים מעוצב מחדש ונוח לקריאה! לתקלות / ביקורות אנא צרו קשר :)</span>
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
    <h3 id='statics'>באתר הוזנו עד כה courses קורסים ו moeds מועדים</h3>

<?php

if (!isset($_POST['data'])) $data = "def";
else $data = $_POST['data'];
$data = htmlspecialchars($data, ENT_QUOTES);

$mod = isset($_POST['mod']) ? $_POST['mod'] : "0";

$field = 'name';
$opposite_field = 'lecture';

$courses = json_decode(file_get_contents("../data/courses.json"), true)["Data"];
$lectures = json_decode(file_get_contents("../data/lecturers.json"), true)["Data"];

require_once 'u299615442_db_site.php';

$courses_num = count($TgradesSemesters);
$moeds_num = count($Tgrades);

?>

<div class="dropdown-container"><form action="index.php" method="post">
    <select id="sel1" name="data" onchange="this.form.submit()">
        <option value="def">בחירת מרצה</option>
        <?php
            foreach ($lectures as $lecture) { echo "<option value='".$lecture."'";
            if ($data == $lecture) echo " selected"; 
            echo ">" .$lecture."</option>"; }
        ?>
    </select>
    <div class="select-icon">
        <svg focusable="false" viewBox="0 0 104 128" width="17" height="35" class="icon">
        <path d="m2e1 95a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm0-3e1a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm0-3e1a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm14 55h68v1e1h-68zm0-3e1h68v1e1h-68zm0-3e1h68v1e1h-68z"></path>
        </svg>
    </div>
    </form>
</div>

<div class="dropdown-container"><form action="index.php" method="post">
    <select id="sel2" name="data" onchange="this.form.submit()">
        <option value="def">בחירת קורס</option>
        <?php
            foreach ($courses as $course) { echo "<option value='".$course."'";
            if ($data == $course) { echo " selected"; $field="lecture"; $opposite_field="name"; } 
            echo ">" .$course."</option>"; }
        ?>
    </select>
    <div class="select-icon">
        <svg focusable="false" viewBox="0 0 104 128" width="17" height="35" class="icon">
          <path d="m2e1 95a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm0-3e1a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm0-3e1a9 9 0 0 1 -9 9 9 9 0 0 1 -9 -9 9 9 0 0 1 9 -9 9 9 0 0 1 9 9zm14 55h68v1e1h-68zm0-3e1h68v1e1h-68zm0-3e1h68v1e1h-68z"></path>
        </svg>
    </div>
    </form>
</div>

<?php
$rep_name = array("name" => "Course", "lecture" => "Lecturer")[$field];
?>
</center>
<center style="top: 180px; position: relative;">

<form class='filter-0' action="index.php" method="post"><input type='hidden' name='mod' value='1'/><input type='hidden' name='data' value=<?php echo "'$data'"; ?>/><a onclick="sub(this)" href='#'>Sort by <?php echo $rep_name; ?></a></form>
<form class='filter-1' action="index.php" method="post"><input type='hidden' name='mod' value='0'/><input type='hidden' name='data' value=<?php echo "'$data'"; ?>/><a onclick="sub(this)" href='#'>Sort by Year</a></form>

</center>
    
<div class="charts">
<?php

$arrRanks = ["'a'" => "א", "'b'" => "ב", "'c'" => "ג", "'A'" => "א", "'B'" => "ב", "'C'" => "ג"];



$year = "";
$id = "";
$dta = "";

if ($mod == "0")
{
    $rows = [];
    foreach ($TgradesSemesters as $row)
    {
        foreach ($Tgrades as $row2)
            if ($row[$opposite_field] == $data &&
                $row['id'] == $row2['idsemester'])
            {
                $rows[] = array_merge($row, $row2);
            }
    }
    
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
            
        if (isset($row["proj"]))
            $table_start .= "<td>{$row["proj"]}</td>";
        else
        {
            $m = $arrRanks["'".$row["moed"]."'"];
            $table_start .= "<td>מועד $m</td>";
        }
        
        $table_start .= "<td hidden>{$row['avg']}</td><td hidden>{$row['num']}</td>";
        
                
        $id11 = $row["lecture"]."!!".$row["name"]."!!".$row["moed"]."!!".$row["semester"]."!!".$row["year"];
                    
    
        $arrGrades = str_replace(',', '+', $row["grades"]);
        $table_start .= "<td class='grade'><canvas width='300px' height='84px' style='float: right; padding-right: 40px; position: relative; right:0%; top:0px' id='$id11#$arrGrades'></canvas></td>";
        $table_start .= "</tr>";
    }
}

if ($mod == "1")
{
    $rows = [];
    foreach ($TgradesSemesters as $row)
    {
        foreach ($Tgrades as $row2)
            if ($row[$opposite_field] == $data &&
                $row['id'] == $row2['idsemester'])
            {
                $rows[] = array_merge($row, $row2);
            }
    }
    
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
            
        if (isset($row["proj"]))
            $table_start .= "<td>{$row["proj"]}</td>";
        else
        {
            $m = $arrRanks["'".$row["moed"]."'"];
            $table_start .= "<td>מועד $m</td>";
        }
        
        $table_start .= "<td hidden>{$row['avg']}</td><td hidden>{$row['num']}</td>";
        
                
        $id11 = $row["lecture"]."-".$row["name"]."-".$row["moed"]."-".$row["semester"]."-".$row["year"];
                    
    
        $arrGrades = str_replace(',', '+', $row["grades"]);
        $table_start .= "<td class='grade'><canvas width='300px' height='84px' style='float: right; padding-right: 40px; position: relative; right:0%; top:0px' id='$id11#$arrGrades'></canvas></td>";
        $table_start .= "</tr>";
    }
}

if (count($rows) > 0)
{
    $table_start .= $table_end;
    echo $table_start;
}

?>
</div>
<script>

window.onload = function(){
        
        if ($("table").length > 0)
        {
            $("form.filter-" + <?php echo $mod; ?>).show();
            
        }
        $("header").width($("body").width());
        $("#statics").text($("#statics").text().replace('courses', <?php echo "'$courses_num'"; ?>).replace('moeds', <?php echo "'$moeds_num'"; ?>));
        if ($("select#sel1").val() != 'def') 
            $("select#sel1 option[value='def']").remove();
        if ($("select#sel2").val() != 'def') 
            $("select#sel2 option[value='def']").remove();
            
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
    		    switchMode();
    		    
        $("div#mode").click(switchMode);
        
        
        
        var arr = document.getElementsByTagName('canvas');
        for (elem of arr) { creatAndDrawGrade(elem.id); }
        for (elem of arr) { removeId(elem); }
    }
    
    function sub(e)
    {
        e.parentNode.submit();
    }
    
    function removeId(elem)
    {
        elem.id = "";
    }


    function creatAndDrawGrade(data)
    {
        var canvasId = data;
        var arrGrades = data.split("#")[1].split("+");
        
        var canvas = document.getElementById(canvasId);
        var el = canvas.parentNode.previousSibling;
        var context = canvas.getContext("2d");
        var imageObj = new Image();
        imageObj.onload = function(){
            context.drawImage(imageObj, 0, 0);
            context.font = "10pt David";
            
            for (var i = 0; i < arrGrades.length; i++)
                context.fillText(arrGrades[i], 20 + 29.8 * i - arrGrades[i].length, 78);
            context.fillText(el.previousSibling.lastChild.data, 248, 42);
            context.fillText(el.lastChild.data, 256, 24);
        };
        imageObj.src = "table-new.png"; 
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


