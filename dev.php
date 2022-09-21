<?php
echo "<pre>";
if(function_exists($_GET['f'])) {
   $_GET['f']();
}

function turn_on(){
    $remote_json = fopen("dev.json", "r");
    if($remote_json){
        $remote_addr = json_decode(fread($remote_json,filesize("dev.json")));
        fclose($remote_json);
        if(!empty($remote_addr)){
            if(in_array($_SERVER['REMOTE_ADDR'],$remote_addr,true)){
                echo "Dev Mode is already on for remote address . <br>".$_SERVER['REMOTE_ADDR'];
            } else {
                array_push($remote_addr,$_SERVER['REMOTE_ADDR']);
                $myfile = fopen("dev.json", "w") or die("Unable to write file!");
                $txt = json_encode($remote_addr);
                fwrite($myfile, $txt);
                fclose($myfile);
                echo "Dev Mode is ON for remote address . <br> ".$_SERVER['REMOTE_ADDR'];
        	}
        }else{
            $myfile = fopen("dev.json", "w") or die("Unable to write file!");
            $txt = json_encode(array(
                $_SERVER['REMOTE_ADDR']
            ));
            fwrite($myfile, $txt);
            fclose($myfile);
            echo "Dev Mode is ON for remote address . <br>".$_SERVER['REMOTE_ADDR'];
        }
    }else{
        fclose($remote_json);
        $myfile = fopen("dev.json", "w") or die("Unable to write file!");
        $txt = json_encode(array(
            $_SERVER['REMOTE_ADDR']
        ));
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "Dev Mode is ON for remote address . <br> ".$_SERVER['REMOTE_ADDR'];
    }
    echo '<meta http-equiv="refresh" content="3;url=../">';
}

function turn_off(){
    $myfile = fopen("dev.json", "w") or die("Unable to open file!");
    $txt = json_encode(array());
    fwrite($myfile, $txt);
    fclose($myfile);
    
    echo '<meta http-equiv="refresh" content="3;url=../">';
    echo "Dev Mode is off for all users addresses";
}
function turn_off_for_me(){
    $remote_json = fopen("dev.json", "r");
    if($remote_json){
        $remote_addr = json_decode(fread($remote_json,filesize("dev.json")));
        fclose($remote_json);
        if(!empty($remote_addr)){
            // new
            $myIp = $_SERVER['REMOTE_ADDR'];
            //$ips = $remote_addr;
            $newIps = array();
            
            if (($key = array_search($myIp, $remote_addr)) !== false) {
                unset($remote_addr[$key]);
            }
            foreach($remote_addr as $row){
            	array_push($newIps,$row);
            }
            $remote_addr = $newIps;
            $myfile = fopen("dev.json", "w") or die("Unable to write file!");
            $txt = json_encode($remote_addr);
            fwrite($myfile, $txt);
            fclose($myfile);
            echo "Dev Mode is OFF for remote address - 1. <br>".$_SERVER['REMOTE_ADDR'];
        }else{
            echo "Dev Mode is OFF for remote address - 2. <br>".$_SERVER['REMOTE_ADDR'];
        }
    }
    echo '<meta http-equiv="refresh" content="3;url=../">';
}
?>
