# wavformgen.php
A simple php script that combines sox, wav2png, wav2json to generate wavform png and/or wavform json documents from mp3 files.

Dependencies:  sox, wav2png, wav2json
-------------------------------------
Usage: 
	
	php wavformgen.php 'song.mp3' 'png|json' 'foreground color', 'background color'
	
	php wavformgen.php 'path/to/directory/' 'png|json' 'foreground color', 'background color'	

	
required:
------------
Parameter 1 - "path/to/song.mp3" or "path/to/directory/" 
Parameter 2 - "png|json"	
	
optional parameters:

Parameter 3 - foreground color. Defaults to 'ffb400aa' (weird orange yellow)
Parameter 4 - background color. Defaults to '00000000' (transparent)	

Outputs to the same directory as input.

Output examples can be seen here: http://dreaddymck.com

Known issues:
-------------
Crappy code. Yep. I know.
