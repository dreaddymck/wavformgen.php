<?php
/*
 * this program depends on wav2png, wav2json and sox
 *
 * creates waveform png, json for an mp3 fill
 *
 *usage: php wavformgen.php 'song.mp3' 'foreground color', 'background color'
 */
//phpinfo();

$target     = isset( $_SERVER["argv"][1] ) ? $_SERVER["argv"][1] : "";
$output     = isset( $_SERVER["argv"][2] ) ? $_SERVER["argv"][2] : '';
$forecolor  = isset( $_SERVER["argv"][3] ) ? $_SERVER["argv"][3] : 'ffb400aa';
$backcolor  = isset( $_SERVER["argv"][4] ) ? $_SERVER["argv"][4] : '00000000';



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

Usage: php wavformgen.php 'song.mp3' 'png|json' 'foreground color', 'background color'

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
    
    $dir    = dirname("$target\n");
    $base   = basename("$target",".mp3");
    
    $png    = $dir."/".$base.".wavform.png";
    $json   = $dir."/".$base.".wavform.json";
    $cmd    = "";
    
    
    if( preg_match('/^png/', $output ) ){

        if( ! file_exists("$png") )
        {
            $cmd = "sox -v 0.99 \"$target\" -c 2 -t wav - | wav2png --foreground-color=$forecolor --background-color=$backcolor -o \"$png\" /dev/stdin";
            //error_log($cmd);
            exec("clear");
            exec($cmd);
        }
        else
        {
            echo "skip converting: $target to png\n";
        }
    }
    

    if( preg_match('/^json/', $output ) ){
        
        if( ! file_exists("$json") )
        {
            $cmd = "sox -v 0.99 \"$target\" -c 2 -t wav - | wav2json -o \"$json\" /dev/stdin";
            //error_log($cmd);
            exec("clear");
            exec($cmd);
        }
        else
        {
            echo "skip converting: $target to json\n";
        }
    }

    
    sleep($sleep);
}

?>
