<?php
/*
 * this program depends on wav2png, wav2json and sox
 *
 * creates waveform png, json for an mp3 fill
 *
 *usage: php wavformgen.php 'song.mp3' 'foreground color', 'background color'
 */
//phpinfo();

$target     = $_SERVER["argv"][1]  ? $_SERVER["argv"][1] : "";
$output     = $_SERVER["argv"][2]  ? $_SERVER["argv"][2] : 'png';
$forecolor  = $_SERVER["argv"][3]  ? $_SERVER["argv"][3] : '2e4562ff';
$backcolor  = $_SERVER["argv"][4]  ? $_SERVER["argv"][4] : '00000000';
$overwrite  = $_SERVER["argv"][5]; 


var_dump($_SERVER["argv"]);

if( file_exists("$target") && $output ) {

	if(is_dir("$target")){

		if ($handle = opendir("$target")) {
		    
		    $count    = 1;
            $loc      = "";
            		    
		    while (false !== ($file = readdir($handle)))
		    {
		        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'mp3')
		        {
		            $loc = "$target/$file";
		            error_log($loc);
		            
		            render_waveform( $loc);
		            
		            exec("clear");
		            echo ("(# $count) - Finished: ". $loc."\n");
		            $count++;
		            
		        }
		        
		    }
		    closedir($handle);
		}
    
	}
	else
	{
	    render_waveform($target);
	    exec("clear");
	    echo ("Done processing $target\n");
	}

}
else
{
    if(!$output){ $output = "Missing output target type"; }
    if(!$target){ $target = "Missing target"; }
    
    echo <<<EOF


             
Dependencies:  sox, wav2png, wav2json

Usage: php wavformgen.php 'song.mp3' 'png|json' 'foreground color'  'background color' 'false'

Outputs to same directory as input.
        
$target
    
$output

EOF;
     
}

exec("clear");

exit("\nEnd\n");


function render_waveform($target){
    
    $sleep = 1;

    global $forecolor;
    global $backcolor;
    global $output;
    global $overwrite;
    
    $dir    = dirname("$target\n");
    $base   = basename("$target",".mp3");
    
    $png    = $dir."/".$base.".wavform.png";
    $json   = $dir."/".$base.".wavform.json";
    $cmd    = "";
    

    
    if( preg_match('/^png/', $output ) ){

    	if( file_exists("$png") && $overwrite == "true")
        {
        	renderpng($cmd,$png,$target);
        }
        elseif ( ! file_exists("$png") )
        {
        
        	renderpng($cmd,$png,$target);
        }
        else
        {
            echo "skip overwriting: $target to png\n";
        }
    }
    

    if( preg_match('/^json/', $output ) ){
        
    	if( file_exists("$json") && $overwrite == "true")
        {
        	renderjson($cmd,$json,$target);
        }
        elseif(! file_exists("$json"))
        {
        	renderjson($cmd,$json,$target);
        }
        else
        {
            echo "skip overwriting: $target to json\n";
        }
    }

    var_dump($_SERVER["argv"][5]);
    var_dump($overwrite);
    var_dump($forecolor);
    var_dump($backcolor);
    
    //sleep($sleep);
}

function renderpng($cmd,$png,$target){

	global $forecolor;
	global $backcolor;

	
	$cmd = "sox -v 0.99 \"$target\" -c 2 -t wav - | wav2png --foreground-color=$forecolor --background-color=$backcolor -o \"$png\" /dev/stdin";
	//error_log($cmd);
	exec("clear");
	exec($cmd);
	
}

function renderjson($cmd,$json,$target){
	
	$cmd = "sox -v 0.99 \"$target\" -c 2 -t wav - | wav2json -o \"$json\" /dev/stdin";
	//error_log($cmd);
	exec("clear");
	exec($cmd);
	
}

?>
