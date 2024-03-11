<?php 

require_once '../user/session.php';

$sortby=$_POST['sortby'];
 echo '<select class="form-control select2-icon" name="selectdata" id="selectdata" multiple="multiple" style="width:300px">';   
echo "<option value=''>All</option>";

    if($sortby=="Machine"){
        
        $mc_sel="SELECT MC_ID,MC_NAME FROM STD_MACHINES";
        
        $mc_res=mysqli_query($fit,$mc_sel);
        
        if(mysqli_num_rows($mc_res)){
            
            while($mc_row=mysqli_fetch_array($mc_res)){
                
                $mid=$mc_row['MC_ID'];
                
                $mname=$mc_row['MC_NAME'];
                
                echo "<option value='$mid'>$mname</option>";
                
            }
            
            
            
        }
        
    }
    
    if($sortby=="Style"){
        
        $sty_sel="SELECT STYLE_ID,STYLE FROM STDSTYLE";
        
        $sty_res=mysqli_query($fit,$sty_sel);
        
        if(mysqli_num_rows($sty_res)){
            
            while($sty_row=mysqli_fetch_array($sty_res)){
                
                $sid=$sty_row['STYLE_ID'];
                
                $sname=$sty_row['STYLE'];
                
                echo "<option value='$sid'>$sname</option>";
                
            }
            
            
            
        }
        
    }
    
    
    if($sortby=="Inspector"){
        
        $sty_sel="SELECT INSP_ID,INSP_NAME FROM INSPECTORS";
        
        $sty_res=mysqli_query($fit,$sty_sel);
        
        if(mysqli_num_rows($sty_res)){
            
            while($sty_row=mysqli_fetch_array($sty_res)){
                
                $inspid=$sty_row['INSP_ID'];
                
                $inspname=$sty_row['INSP_NAME'];
                
                echo "<option value='$inspid'>$inspname</option>";
                
            }
            
            
            
        }
        
    }
    if($sortby=="Roll"){
        
        $sty_sel="SELECT ROLL_ID,ROLL_NUMBER FROM ROLL";
        
        $sty_res=mysqli_query($fit,$sty_sel);
        
        if(mysqli_num_rows($sty_res)){
            
            while($sty_row=mysqli_fetch_array($sty_res)){
                
                $rollid=$sty_row['ROLL_ID'];
                
                $rollnumber=$sty_row['ROLL_NUMBER'];
                
                echo "<option value='$rollid'>$rollnumber</option>";
                
            }
            
            
            
        }
        
    }
echo '</select>';
?>