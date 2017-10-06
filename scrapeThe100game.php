<?php


// #################################################
// ###                                           ###
// ###  LIST MEMBER OF THE100 GAME VIA SCRAPING  ###
// ###  v1.4                                     ###
// ###  @L0r3notData                             ###
// ###                                           ###
// #################################################


// ##### READ API KEY AND GROUP NUMBER FROM FILE ####
require 'apiKeys.php';


// ##### CAPTURE VIRTUAL SERVERS DOCUMENT ROOT #####
$siteRoot = $_SERVER['DOCUMENT_ROOT'];


// ##### CURL A MEMBER PAGE FROM BUNGIE IN JSON FORMAT (IN A BUFFER) #####	
ob_start();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.the100.io/game/$hundGame");
$allUsers = curl_exec($curl);
curl_close($curl);
$userList = ob_get_contents();
ob_end_clean();


// ###### SEARCH/REPLACE span WITH href="/users #####
$userList = str_replace('span', '</a>', $userList);


// ##### FIND ALL LINES WITH href="/users AND PUT EACH INTO ARRAY #####
$searchfor = 'href="/users';
$pattern = preg_quote($searchfor, '/');
$pattern = "/^.*$pattern.*\$/m";
if(preg_match_all($pattern, $userList, $matches))


// ##### EXPLODE ARRAY INTO STRING, THEN CREATE NEW ARRAY USING</a> DELIMETER #####
$matches = implode("", $matches[0]);
$matches = explode("</a>", $matches);


// #### COUNT NUMBER OF ENTRIES IN ARRAY
$cntMatches = count($matches);	


// ##### LOOP THOUGH ARRAY FOR TEXT PROCESSING (SCRAPING IS AN UGLY THING) #####
$x = 0;
while($x < $cntMatches) {
	$currentLine = "$matches[$x]";
	
	// REMOVE UNNEEDED TEXT WITHIN EACH ARRAY ENTRY
	$currentLine = preg_replace('/<a[\s\S]+?>/', '', $currentLine);
	$currentLine = str_replace(' class="badge xbox-one">Xbox Live: ', '', $currentLine);
	$currentLine = str_replace('  		  ', '', $currentLine);
	$currentLine = str_replace('</', '', $currentLine);
	$currentLine = str_replace('>', '', $currentLine);
	
	// ADD <br> TO END OF EACH ARRAY ENTRY
	$currentLine = $currentLine ."<br>";
	
	// REMOVE SPACE AT BEGINNING OF EACH ARRAY ENTRY
	$currentLine = ltrim($currentLine);

	// DELETE ARRAY ENTRIES THAT SHOULD NOT BE DISPLAYED
	$matches[$x] = "$currentLine";
	if ($currentLine == '<br>') { unset($matches[$x]); }
	if ($currentLine == '<<br>') { unset($matches[$x]); }
	if ($currentLine == 'BooBooTheBull<br>') { unset($matches[$x]); }
	if ($currentLine == 'OrphanGalaxy545<br>') { unset($matches[$x]); }
	if ($currentLine == 'some dude in VA<br>') { unset($matches[$x]); }
	if ($currentLine == 'HotDergFingers<br>') { unset($matches[$x]); }
	if ($currentLine == 'Hotdergfingers<br>') { unset($matches[$x]); }
	if ($currentLine == 'Kupe81<br>') { unset($matches[$x]); }
	if ($currentLine == 'acbtheman<br>') { unset($matches[$x]); }
	if ($currentLine == 'GrayHoodie<br>') { unset($matches[$x]); }
	if ($currentLine == 'blackbandit1704<br>') { unset($matches[$x]); }
	if ($currentLine == 'Seamus720<br>') { unset($matches[$x]); }
	
	// INCREMENT UP FOR LOOP
	$x++;
}


// ##### RE-KEY ARRAY #####
$matches = array_values($matches);

// #### COUNT NUMBER OF ENTRIES IN ARRAY
$cntMatches = count($matches);

// ##### EXPLODE ARRAY INTO STRING #####
$finalMembList = implode("", $matches);


// ##### BUILD INFO STRINGS #####
$titleURL = '<a href="https://www.the100.io/game/998378">Recruit Game</a><br>';
$titleCount = "Pending Members: $cntMatches<br>";


// ##### WRITE MEMBER LIST TO FILE #####
$theNow = time();
$theNowTwo = "$theNow<br>";
$myFile = "$siteRoot/members/the100game/cache/recruit.htm";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $theNowTwo);
fwrite($fh, $titleURL);
fwrite($fh, $titleCount);
fwrite($fh, '<br>');
fwrite($fh, $finalMembList);
fclose($fh);


// ##### PRINT TO WEB PAGE BY READING CACHE FILE #####
require "$siteRoot/members/the100game/cache100game.php";


?>
