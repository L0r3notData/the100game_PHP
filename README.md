// #############################################
// ###                                       ###
// ###  GAME MEMBERS VIA SCRAPING THE100.IO  ###
// ###  v1.4                                 ###
// ###  @L0r3notData                         ###
// ###                                       ###
// #############################################


# WHAT IS THIS THING? #
Set PHP files that scrapes the members of a the100.io specified game
Note: You specify the game number in apiKeys.php


# WHAT EVERYTHING DOES #

# apiKeys.php #
Contains game ID

# scrapeThe100game.php (primary file) #
Curls down game page from the100.io
Builds array of lines that contain users
Loops though array removing unwanted HTML
Loops though array removing admins
Saves results to cache file
Calls "cache100game.php" to read cache file and output to web page

# cache100members.php #
Gets the contents of the cache file (memberList.htm)
Removes the first line (unix time)
Converts the first line to standard date/time
Prints standard date/time and user list to page

# cache/memberList.htm #
This path and file are auto created
Contains:
	1st Line: Unix time cache was created
	2nd Line: 
	3rd Line:
	4th and all following files: List of members of a the100.io game


------ CHANGE LOG ------

# CHANGES 0.0 --> 1.0 #
Initial working version based off my "the100users" project

# CHANGES 1.0 --> 1.4 #
Skipped some version numbers to align versioning with my other projects

