<?php
/*
 * this program depends on wav2png, wav2json and sox
 *
 * creates waveform png, json for an mp3 fill
 *
 *usage: php wavformgen.php 'song.mp3' 'foreground color', 'background color'
 */
//phpinfo();

$arg = isset( $_SERVER["argv"][1] ) ? $_SERVER["argv"][1] : "";


if( file_exists("$arg") ) {

	if(is_dir("$arg")){

		if ($handle = opendir("$arg")) {
		    
		    $count = 1;
		    
		    while (false !== ($file = readdir($handle)))
		    {
		        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'mp3')
		        {
		            
		            render_waveform( $arg.$file );
		            
		            exec("clear");
		            echo ("(# $count) - Finished: ". $arg.$file."\n");
		            $count++;
		            
		        }
		    }
		    closedir($handle);
		}
    
	}
	else
	{
	    render_waveform($arg);
	    exec("clear");
	    echo ("Done processing $arg\n");
	     
	}

}
else
{
     echo <<<EOF
     
Dependencies:  sox, wav2png, wav2json

Usage: php wavformgen.php 'song.mp3' 'foreground color', 'background color'

Outputs to same directory as input.

EOF;
     
}


exit("\nEnd\n");


function render_waveform($arg){
    
    $sleep = 2;
    $forecolor  = isset( $_SERVER["argv"][2] ) ? $_SERVER["argv"][2] : 'ffb400aa';
    $backcolor  = isset( $_SERVER["argv"][3] ) ? $_SERVER["argv"][3] : '00000000';
    
    $dir    = dirname("$arg\n");
    $base   = basename("$arg",".mp3");
    
    $png    = $dir."/".$base.".wavform.png";
    $json   = $dir."/".$base.".wavform.json";
    $cmd    = "";
    
    if( ! file_exists("$png") )
    {
        $cmd = "sox -v 0.99 '$arg' -c 2 -t wav - | wav2png --foreground-color=$forecolor --background-color=$backcolor -o '$png' /dev/stdin";
        //error_log($cmd);
        exec("clear");
        exec($cmd);
        sleep($sleep);
    }
    else
    {
        echo "skipping: $png\n";
    }
    
    if( ! file_exists("$json") )
    {

        $cmd = "sox -v 0.99 '$arg' -c 2 -t wav - | wav2json -o '$json' /dev/stdin";
        //error_log($cmd);
        exec("clear");
        exec($cmd);
        sleep($sleep);
    }
    else
    {
        echo "skipping: $json\n";
    }
    
}

?>
