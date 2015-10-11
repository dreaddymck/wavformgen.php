# wavformgen.php
A simple php script that calls sox, wav2png, wav2json to generate waveform png and json documents from mp3 files.

Dependencies:  sox, wav2png, wav2json
-------------------------------------
Usage: 
	
	php wavformgen.php 'song.mp3' 'foreground color', 'background color'
	
	php wavformgen.php 'path/to/directory/' 'foreground color', 'background color'	

	
required:
------------
Parameter 1 - "path/to/song.mp3" or "path/to/directory/" 	
	
optional parameters:

Parameter 2 - foreground color. Defaults to 'ffb400aa' (weird yellow)
Parameter 3 - background color. Defaults to '00000000' (transparent)	

Outputs to the same directory as input.

Output examples can be seen here: http://dreaddymck.com

Known issues:
-------------
Crappy code. Yep. I know.

Fails to process mp3 files with (') in the file name.