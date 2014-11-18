<?php

$plans = array(
        array(
            array(1,1,0),
            array(2,1,0),
            array(3,1,0),
            array(4,1,1),
            array(4,4,1),
            array(3,2,1),
            array(3,4,0),
            array(4,1,1),
            array(4,4,1),
            ),
        array(
            array(1,2,0),
            array(2,1,0),
            array(3,1,1),
            array(3,4,1),
            array(2,2,1),
            array(2,4,0),
            array(3,1,1),
            array(3,4,1),
            ),
        array(
            array(1,3,1)
            )
    )
  
?>
<pre>
<?php  
    print_r($plans);
?>
</pre>

<?php 

    $bbb = array(
        array(),
        array(),
        array()
    )

?>
<?php             
            
    for ($index = 0; $index < count($plans); $index++) {
        $t = array();
        $max = $plans[$index][0][0];
        $t_no = $plans[$index][0][1];
        for ($index1 = 0; $index1 < count($plans[$index]); $index1++){
            $m = $plans[$index][$index1][1]." - ".$plans[$index][$index1][2];
            if($plans[$index][$index1][0] >= $max){
                $max = $plans[$index][$index1][0];
                if($plans[$index][$index1][2] == 1){
                    array_push($t, $m);
                    array_push($bbb[$index], $t);
                    array_pop($t);
                } else{
                    array_push($t, $m);
                }
            } else{
                array_pop($t);
                $max = $plans[$index][$index1][0];
                if($plans[$index][$index1][2] == 1){
                    array_push($t, $m);
                    array_push($bbb[$index], $t);
                    array_pop($t);
                } else{
                    array_push($t, $m);
                }
            }
        } 
}
?>
<pre>
<?php  
    print_r($bbb);
?>
</pre>
