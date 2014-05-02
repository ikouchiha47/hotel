<?php
function date_picker($name, $startyear=NULL, $endyear=NULL,$noofdays=null)
{
	$selected_day=0;
	$selected_month=0;
	$selected_year=0;
	
    if($startyear==NULL) $startyear = date("Y")-10;
    
    if($endyear==NULL) $endyear=date("Y")+10; 
    
    if($noofdays>0) {
		$today=date('F j,Y');
		$today=strtotime($today);
		$futrdate=strtotime("+".$noofdays."days",$today);
		$changddate=date('Y-m-d',$futrdate);
		$elements=preg_split('/[\-]/',$changddate);
		$selected_year=$elements[0];
		$selected_month=$elements[1];
		$selected_day=$elements[2];
	}
	$html="";
    $months=array('','January','February','March','April','May',
    'June','July','August', 'September','October','November','December');

    // Month dropdown
    $html="<select name=\"".$name."month\">";

    for($i=1;$i<=12;$i++)
    {
		if($months[$i]===date('F') && $noofdays==null)
		$html.="<option selected value='$i'>$months[$i]</option>";
		elseif($i==$selected_month && $selected_month>0)
		{
			$html.="<option selected value='$i'>$months[$i]</option>";
			}
		else	
        $html.="<option value='$i'>$months[$i]</option>";
    }
    $html.="</select> ";
   
    // Day dropdown
    $html.="<select name=\"".$name."day\">";
    for($i=1;$i<=31;$i++)
    {
       if($i==date('d') && $noofdays==null){
       $html.="<option selected value='$i'>$i</option>";
       }
       elseif($selected_day==$i){
		   $html.="<option selected value='$i'>$i</option>";
       }
       
       else
       $html.="<option value='$i'>$i</option>";
    }
    $html.="</select> ";

    // Year dropdown
    $html.="<select name=\"".$name."year\">";

    for($i=$startyear;$i<=$endyear;$i++)
    {      
      if($selected_year!=$i)
      $html.="<option value='$i'>$i</option>";
      elseif($i==$selected_year && $selected_year>0)
      $html.="<option selected value='$i'>$i</option>";
      
    }
    $html.="</select> ";

    print_r($html);
}
?>
