<?php

// Initialising variables. Don't change.
//

$_CONFIG = array();
$_ERROR = "";
$_LANG = array();

$_CONFIG['lang'] = "en";


// The starting directory.
// Use only relative subdirectories!
// Default: .
//
$_CONFIG['starting_dir'] = ".";   //substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")) . "/prod1";


// Will the files be opened in a new window? 0=no, 1=yes. Default: 0
//
$_CONFIG['open_in_new_window'] = 0;


// The maximum allowed space in server (to calculate remaining space).
// 1MB = 1024KB. Default: 25600
//
$_CONFIG['max_space'] = 25600;

// How deep in subfilders will the script search for files? Default: 3
//
$_CONFIG['dir_levels'] = 3;


// Will the page header be displayed? 0=no, 1=yes. Default: 1
//
$_CONFIG['show_top'] = 0;

$_CONFIG['charset'] = "UTF-8";

// The array of folders that will be hidden from the list.
//
$_CONFIG['hidden_dirs'] = array();


// Filenames that will be hidden from the list.
//
$_CONFIG['hidden_files'] = array(".ftpquota", ".htpasswd");

// Password for uploading files. You need to set the password to activate uploading.
// To upload into a directory it has to have proper rights.
//
$_CONFIG['upload_password'] = "";

$_CONFIG['basedir'] = "";


/***************************************************************************/
/*   TRANSLATIONS.                                                         */
/***************************************************************************/

$_TRANSLATIONS = array();

// English
$_TRANSLATIONS["en"] = array(
	"file_name" => "File name",
	"size" => "Size",
	"last_changed" => "Last changed",
	"total_used_space" => "Total used space",
	"free_space" => "Free space",
	"password" => "Password",
	"upload" => "Upload",
	"failed_upload" => "Failed to upload the file!",
	"failed_move" => "Failed to move the file into the right directory!",
	"wrong_password" => "Wrong password",
	"make_directory" => "New dir",
	"new_dir_failed" => "Failed to create directory",
	"chmod_dir_failed" => "Failed to change directory rights",
	"unable_to_read_dir" => "Unable to read directory",
	"location" => "Location",
	"root" => "Root",
	"delete" => "Delete",
	"rename" => "Rename"
);


/***************************************************************************/
/*   CSS FOR TWEAKING THE DESIGN                                           */
/***************************************************************************/


function css()
{
?>

<style type="text/css">

BODY {
	background-color:#FFFFFF;
	font-family:Verdana;
}

A {
	color: #000000;
	text-decoration: none;
}

A:hover {
	text-decoration: underline;
}



</style>

<?php
}

/***************************************************************************/
/*   IMAGE CODES IN BASE64                                                 */
/*   You can generate your own with a converter                            */
/*   Like here: http://www.motobit.com/util/base64-decoder-encoder.asp     */
/*   Or here: http://www.greywyvern.com/code/php/binary2base64             */
/*   Or just use PHP base64_encode() function                              */
/***************************************************************************/


$_IMAGES = array();
$_IMAGES["asp"] = "R0lGODlhEAAQAKIAAAAA/wAAhACEhMDAwP///8bGxoSEhAAAACH5BAEAAAMALAAAAAAQABAAQANK
OLrcewUeAokI9JG4oTlgA35RUQDFJ6bg4SgSxxGGCpdxERjRO4wf16vl05SCQoak06n1brFJgUBN
LpeGy/NHyp22jwPJZCuGGAkAOw==";
$_IMAGES["avi"] = "R0lGODlhEAAQALP/AMDAwAAAgAD//wCAgP8AAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARYEEhwqrUzn8J7MUcmbR5nFKFWckiLqKuJDBMZG/MgDHw/
cBXcoCUoIorDwQGBe7mOyCMOJ9EVr8MZ8wUYEIwCRABRaFEBz9aYLIPduKNYu2ao2+9wdHofAQA7";
$_IMAGES["bmp"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AAAAv78AvwC/v8DAwICAgP8AAAD/AP//AAAA//8A/wD/
/////yH5BAEAAAoALAAAAAAQABAAAARaUEmJAKhgzkwt3gpSUQ9gHNx1PWMSmA6hDGWGHAzgwsRw
jBKCgbEzIAaLAWciLCKVmpBoSgVSDo/sYfuzXrtTSzSE1XaXk5t5671mH+w2ef1Du80iu8TC52si
ADs=";
$_IMAGES["chm"] = "R0lGODlhEAAQAKIAAAAAhP//AISEAMDAwP///8bGxoSEhAAAACH5BAEAAAMALAAAAAAQABAAQANQ
OLoq7ssQYqoUIZQTrTlZURUZJ1EWAZZMi2WwOJxTDayaOXkT19I1guBAFLRcMI3x+Ao4YLrJpviB
zoKUQ3OjANYEngh2MiyKxzjfjMhuHxMAOw==";
$_IMAGES["css"] = "R0lGODlhDQAQAMQAAAAAAP///4SGhMbHxroPAKENAIgMAM0cDdEwItREONpYTOOFfOyspvfY1eeX
kfLDwPvq6v///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
ABEALAAAAAANABAAAAVVoCCOZGQKQaqmg3Cu6xC4KJwCOFDbrG5DDEhg4IMRHAUIcddINBABAmMZ
YCQOi1SjMNQlpCvFoytgHA4MVZqcelwDD0NvF2i05zzVcsDv+4k5gYIAIQA7";
$_IMAGES["directory"] = "R0lGODlhDwANAMIGAP//mczMZgAAAP/MmZmZAP//zP///////yH5BAEAAAcALAAAAAAPAA0AAAM9
eEfMohCSUwoA5MUVug9Ns1RkWQGBQFhX6w7p6rYDUMfsbNv4XP8oVY62gwmJwIFxlSwqY5/o5yGo
Wq/XBAA7";
$_IMAGES["doc"] = "R0lGODlhEAAQAMIBAAAAAP///wAA/8zMzJmZmWZmZv///////yH5BAEAAAcALAAAAAAQABAAAANU
eErF3kXJU4K9loB5CMbVJlWfBZynAKjsug7B4AoBW7uw7Ab7DmuH1Y2mquQ2reRg4JEFk7uL09Yi
LI9PAI/lkSKFraU1AFyUME5F4cpmizqouDwBADs=";
$_IMAGES["exe"] = "R0lGODlhEAAOAMIAAP///5mZmWZmZgAAAMzMzAAAzAAAmf///yH5BAEAAAcALAAAAAAQAA4AAAM8
GKK83oLISWcYgZTN+xbDUhjjCAzneWWC87whAcx0Pa+yrYORrq8Bnw2UEdYuPeOMl1OuXo3oYEqt
WqcJADs=";
$_IMAGES["gif"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AMDAwICAgP8AAAD/AAD//////wAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAgALAAAAAAQABAAAARcsMhJkb0l6a1JuVbGbUTyIUYgjgngAkYqDgQ9DEBCxAEi
Ei8ALsELaXCHJK5o1AGSh0EBEABgjgABwQMEXp0JgcDl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd
FxEAOw==";
$_IMAGES["gz"] = "R0lGODlhEAAQAMQAAJzO/2OczgBjnGPO/wCczgAxMTHOzsDAwM7OMf//nP//zv//986cAP/OMf/O
Y//OnP8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAcALAAAAAAQABAAQAVr4CGOUmkWI6Qkj9O8DSMdEjBDUbSs7TvXsxHJVEKJICxHgWgSAFCQ3crh
8tFsBwhz6zQKRRKBhBAOHyEQmoBAMBgGASN6TkdfbzrFFPbDRqdVDQh9N0kwMTJ3X2psbnBeiyQE
kUJiYmRiByEAOw==";
$_IMAGES["htm"] = "R0lGODlhEAAQALMAAAAA/wAAhDFj/zFjnDGc/zHO/wCEhDH//8DAwDGcAP////f398bGxoSEhAAA
AAAAACH5BAEAAAgALAAAAAAQABAAQARXsMlJJbqoqb1U+FvoZGFnGEK4jdoyvDDcsWqpLIzSXBpn
HIVEQEVzxWIzUmd5ayZ7tRBjx1MxZ44sKWRQHAhD0XYjICQA4dX26rzR2uzFO+4cZe/4/CgCADs=";
$_IMAGES["html"] = $_IMAGES["htm"];
$_IMAGES["jpeg"] = "R0lGODlhEAAQALMAAAAAAL8AAAC/AL+/AAAAv78AvwC/v8DAwICAgP8AAAD/AP//AAAA//8A/wD/
/////yH5BAEAAAoALAAAAAAQABAAAARaEMlJlb3o6a0PulbGbcfzKQwhjg/gAkwqDgdNA88RE4p4
vIABbhfSCBNIIbGYAyATAwSAAMAYAYGD5/ezNhOBgKvpPV7JzJpaiO5pgK/2iiXX2u/aqgXOd10i
ADs=";
$_IMAGES["jpg"] = $_IMAGES["jpeg"];
$_IMAGES["js"] = "R0lGODlhEAAQAOMAAP///wAAAMzMzJmZmWZmZv//AJmZAGZmAP//////////////////////////
/////yH5BAEAAAgALAAAAAAQABAAAARbcJAh6aw1DMB5nZ0QEB0wFAAqcuLGkYdhtAHQepyqrSJp
AoZYYFizaV4oXanXOQVnRaMLmTKyjh5KIGZlAki0FO+4KYySK6NvIBAMAu3ojUMkLkftvH5f7/uH
EQA7";
$_IMAGES["jsp"] = "R0lGODlhEAAQAOMAAP///wAAAMzMzJmZmWZmZv//AJmZAGZmAP//////////////////////////
/////yH5BAEAAAgALAAAAAAQABAAAARbcJAh6aw1DMB5nZ0QEB0wFAAqcuLGkYdhtAHQepyqrSJp
AoZYYFizaV4oXanXOQVnRaMLmTKyjh5KIGZlAki0FO+4KYySK6NvIBAMAu3ojUMkLkftvH5f7/uH
EQA7";
$_IMAGES["mov"] = "R0lGODlhEAAQAKL/AMDAwAD/AACAAP8AAP///8DAwICAgAAAACH5BAEAAAAALAAAAAAQABAAAANS
CArW7isaQispJqppaSGZ1FFHeYijdwgLlxarEAh0LVANLJRBf/Q7geEAO5l+wB8MppD1nrsV8QQQ
DHwBKaHEBBy/le4mpUK9qJuCes1Ge7/wBAA7";
$_IMAGES["mp3"] = "R0lGODlhEAAQAJEAAMDAwP///8bGxgAAACH5BAEAAAAALAAAAAAQABAAQAI5xI45wDwB4XtQLBNz
EPFSnVkOWE3NJx2RiJGrtwnyTMPu0bSghYxu6esEPixKYqgq/oA6V1EBxRUAADs=";
$_IMAGES["mpeg"] = $_IMAGES["avi"];
$_IMAGES["mpeg"] = $_IMAGES["avi"];
$_IMAGES["arrow_down"] = "R0lGODlhBwAGAIABAHh5f////yH+FUNyZWF0ZWQgd2l0aCBUaGUgR0lNUAAh+QQBCgABACwAAAAA
BwAGAAACCowfoMucbhZKpwAAOw==";
$_IMAGES["arrow_up"] = "R0lGODlhBwAGAIABAHh5f////yH+FUNyZWF0ZWQgd2l0aCBUaGUgR0lNUAAh+QQBCgABACwAAAAA
BwAGAAACCoxhCavLDiNLqQAAOw==";
$_IMAGES["pdf"] = "R0lGODlhEAAQALMAAP///+/v7wAAAN4AAMbGxgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AP+A/yH5BAEAAA8ALAAAAAAQABAAQARF8D1Bq5V4hh3G4JswWSQoSkLnfZsXiGQpECfKfSxXp227
vhiBC2QKEnU7AECgZC5fFePtuJvmQlIfsdr7dXa4IxYViz0iADs=";
$_IMAGES["php"] = "R0lGODlhDgAQAOMAAP///wAAAMzMzJmZmWZmZpnMmWaZZjOZM8zMmQBmAMz//5nMzDOZZmbMmWaZ
M////yH5BAEAAA8ALAAAAAAOABAAAARUcJAh6RwvvwG67wKWEd8nAETGlV3gBhtrwiRbgPD6HUsC
CLmPQWAAHArAB6lgOHp8yYGBcfM0TlEEw7HwIHAxgKIp9v1osu85LFsTBPC4PPmq22ERADs=";
$_IMAGES["png"] = "R0lGODlhEAAQALP/AMDAwAD/AACAAICAAP8AAIAAAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARcEMlJgb3I6K0PulbGbYfxAUQhjkbiJkQqDgc9DIlxxAUg
Hq8EzsALaXCBJK5o1CWSgQEiUUhgjgnBwQMEXp0GgcDl/A6x5WZtPfQ2g6+0j8Vx+7b4/NZqgftd
FxEAOw==";
$_IMAGES["ppt"] = "R0lGODlhEAAQAIQAAP////8AAAAAAMzMzGZmAJmZAGZmZpmZmWaZAMzMmZmZzMyZzJnMmZmZZplm
AGZmmf///////////////////////////////////////////////////////////////yH5BAEA
ABAALAAAAAAQABAAAAVzICQeBmmWhqhCBuC+bikGBR0gNuIeQErAsIBLQBQIA4SAAwlwDJ6AgeBX
AxytMOkVgNMRBoxFVFAA/F5bl9ZaZpufAwBD4EXasa810FVQJOILdDk2SVkCKg9qUXAKAAmHIg17
hogDCQqWfk+XkBANRaChIQA7";
$_IMAGES["rar"] = "R0lGODlhEAAQAIQBAAAAAP///wAAmQAAZszMzJkAAGYAZpkAmf8A/wCZZmYAADMzMwD/ADOZzDMA
mZmZmQAzmTP/AACZ/wAzzP//AJmZM2ZmADOZmQBm////M2ZmZgCZzACZMwBmZgBmAP///yH5BAEA
AB8ALAAAAAAQABAAAAV8YKGI5GiSH6ESxmO8MFwQQX1QSK7rylMHBsJhSCQWfgFAZcHUMJ8FwUAg
AFivWECK8CAMLlKBYxoe0GqdTEPS2LDXDcc5cCFAJhPMHaIXIAEWZVSDA1mGWFsqAxVTjWVyPxwU
DJQRDJaWAz41HgQJn6CgDn8WY4KNh6kfIQA7";
$_IMAGES["sql"] = "R0lGODlhDQAQAMQAAAAAAP///4WS2djc8wAboQAWiAcjsh85uzJJwEdcxVptzZml36225cXN7uvu
+YSGhMbHxv///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
ABEALAAAAAANABAAAAVV4COOZGQ+Qaqm0HOuKxS4KJwCOFDbrG47DEcA4oMZFgQHcTdIDBABA2MZ
YCQOgtSAMNQlpCtFo/tgHA4MVZqcalwDjUJvFxi05zzVEsLv+4k5gYIAIQA7";
$_IMAGES["unknown"] = "R0lGODlhEAAQALMAAAAAAAAA/wCEAISEhMbGxv8AAP//AP//////////////////////////////
//+A/yH5BAEAAA8ALAAAAAAQABAAAAQ58L1Bq5V4ns03GZnWccQBYsPIASyAqh3hSinszaItv/ax
0z0frqYbBn85GJKoNPaWhKh0imxZr64IADs=";
$_IMAGES["txt"] = "R0lGODlhEAAQAMIAAP///wAAAMzMzJmZmWZmZv///////////yH5BAEAAAcALAAAAAAQABAAAANC
eBrA3ioeNkC9MNbH8yFAKI5CoI0oUJ5N4DCqqYCpuCpV67rhfeS1WIS22/Vkv+CRVeQJZ8pnUukb
CK7YrG/SbEYSADs=";
$_IMAGES["wav"] = "R0lGODlhEAAQALP/AMDAwAAAgAD//wCAgP8AAP///8DAwICAgAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAACH5BAEAAAAALAAAAAAQABAAAARYEEhwqrUzn8J7MUcmbR5nFKFWckiLqKuJDBMZG/MgDHw/
cBXcoCUoIorDwQGBe7mOyCMOJ9EVr8MZ8wUYEIwCRABRaFEBz9aYLIPduKNYu2ao2+9wdHofAQA7";
$_IMAGES["wmv"] = $_IMAGES["avi"];
$_IMAGES["xls"] = "R0lGODlhEAAQAOMAAP///8zMzAAAAJmZmQBmAACZAGZmZmaZZplmmZnMmcyZzP//////////////
/////yH5BAEAAA8ALAAAAAAQABAAAARv8MlhqK1G6meA/94gSAVSDN9AoEA3HgTcwbAn3AIBrOW6
BkBAYFQAFAzHUiIkHD10JWVAERw+VUakyRNoFmhQkyGQUAASAoQP6wMNv7FYMS5salg7FaprlXSA
ZEIDXSJ3IId2fkCDgI1ODyI4kpIRADs=";
$_IMAGES["xml"] = "R0lGODlhEAAQAMQAAAAA/wAAnAAAhDFj/zFjnKXO9zGc/zHO/wCEhDH//zGcAMDAwP////f398bG
xoSEhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAsALAAAAAAQABAAQAVl4COOpLicy8M0RcMI8NoyUCq7CDLctN0QwGDQVVMxjkhXw8F4nB6FwAqR
OCgErkChuBJ6ib6VWCnmIs9Hh/N5JJMhcG6UgWAkDAKGtiGXDgwKAHl7Zm5jK4WHbomGSjVxkJFx
CyEAOw==";
$_IMAGES["xsl"] = "R0lGODlhEAAQAMQAAAAA/wAAnAAAhDFj/zFjnKXO9zGc/zHO/wCEhDH//8DAwDGcAP//AISEAP//
//f398bGxoSEhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAoALAAAAAAQABAAQAV5oBKNZDkqqOg0zeMIsPMUrqTOLoIMMu1ILIYkwmhICEhk7SZruh4QRwQV
KQRkiMRhIXAFCrYGY2xEJJU/BXAoeTyd6ch77oBMqfS3ZG+TWx0IDgkGAg5fD30zVwMGCwCFh2Fi
e3kyQGMREkVtcIgKYmRteTZ8paZ8IQA7";
$_IMAGES["zip"] = "R0lGODlhEAAQAMQAAJzO/2OczgBjnGPO/wCczgAxMTHOzsDAwM7OMf//nP//zv//986cAP/OMf/O
Y//OnP8AAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEA
AAcALAAAAAAQABAAQAVr4CGOUmkWI6Qkj9O8DSMdEjBDUbSs7TvXsxHJVEKJICxHgWgSAFCQ3crh
8tFsBwhz6zQKRRKBhBAOHyEQmoBAMBgGASN6TkdfbzrFFPbDRqdVDQh9N0kwMTJ3X2psbnBeiyQE
kUJiYmRiByEAOw==";


/***************************************************************************/

/***************************************************************************/

//
// Comparison functions for sorting.
// Since PHP4 doesn't support static functions, these are not in any class
//
function cmp_name_desc($a, $b)
{
	return strcasecmp($a->name, $b->name);
}

function cmp_name_asc($b, $a)
{
	return strcasecmp($a->name, $b->name);
}

function cmp_size_desc($a, $b)
{
	return ($b->size - $a->size);
}

function cmp_size_asc($a, $b)
{
	return ($a->size - $b->size);
}

function cmp_mod_desc($a, $b)
{
	return ($a->modTime - $b->modTime);
}

function cmp_mod_asc($b, $a)
{
	return ($a->modTime - $b->modTime);
}

//
// The class that displays images (icons)
//
class ImageServer
{
	function showImage()
	{
		global $_IMAGES;
		if(isset($_GET['img']))
		{
			if(strlen($_GET['img']) > 0)
			{
				header('Content-type: image/gif');
				if(isset($_IMAGES[$_GET['img']]))
					print base64_decode($_IMAGES[$_GET['img']]);
				else
					print base64_decode($_IMAGES["unknown"]);
			}
			return true;
		}
		return false;
	}
}

// 
// The class for any kind of file managing (new folder, upload, etc).
//
class FileManager
{
	function checkPassword($inputPassword)
	{
		global $_CONFIG;
		global $_ERROR;
		global $_LANG;

		if(strlen($_CONFIG['upload_password']) > 0 && $inputPassword == $_CONFIG['upload_password'])
		{
			return true;
		}
		else
		{
			$_ERROR = $_LANG["wrong_password"];
			return false;
		}
	}

	function newFolder($location, $dirname)
	{
		global $_ERROR;
		global $_LANG;

		if(strlen($dirname) > 0)
		{
			$forbidden = array(".", "/", "\\");
			for($i = 0; $i < count($forbidden); $i++)
				$dirname = str_replace($forbidden[$i], "", $dirname);
			if(!mkdir($location->getDir(true, false, 0).$dirname, 0777))
				$_ERROR = $_LANG["new_dir_failed"];
			else if(!chmod($location->getDir(true, false, 0).$dirname, 0777))
				$error = $_LANG["chmod_dir_failed"];
		}
	}

	function uploadFile($location, $userfile)
	{
		global $_CONFIG;
		global $_ERROR;
		global $_LANG;

		$name = basename($userfile['name']);
		if(get_magic_quotes_gpc())
			$name = stripslashes($name);

		$upload_dir = $location->getFullPath();
		$upload_file = $upload_dir . $name;

		if(!is_uploaded_file($userfile['tmp_name']))
		{
			$_ERROR = $_LANG["failed_upload"];
		}
		else if(!@move_uploaded_file($userfile['tmp_name'], $upload_file))
		{
			$_ERROR = $_LANG["failed_move"];
		}
		else
			chmod($upload_file, 0755);
	}

	//
	// The main function, checks if the user wants to perform any supported operations
	// 
	function run($location)
	{
		if(isset($_POST['password']) && $this->checkPassword($_POST['password']))
		{
			if(isset($_POST['userdir']) && strlen($_POST['userdir']) > 0)
				$this->newFolder($location, $_POST['userdir']);
			if(isset($_FILES['userfile']['name']) && strlen($_FILES['userfile']['name']) > 0)
				$this->uploadFile($location, $_FILES['userfile']);
		}
	}
}

//
// Dir class holds the information about one directory in the list
//
class Dir
{
	var $name;
	var $location;

	//
	// Constructor
	// 
	function Dir($name, $location)
	{
		
		$this->name = htmlspecialchars($name);
		$this->location = $location;
	}

	function getName()
	{
		return $this->name;
	}

	function getNameEncoded()
	{
		return urlencode($this->name);
	}

	//
	// Debugging output
	// 
	function output()
	{
		print("Dir name: ".$this->name."\n");
		print("Dir location: ".$this->location->getDir(true, false, 0)."\n");
	}
}

//
// File class holds the information about one file in the list
//
class File
{
	var $name;
	var $location;
	var $size;
	var $extension;
	var $modTime;

	//
	// Constructor
	// 
	function File($name, $location)
	{
		$this->name = htmlspecialchars($name);
		$this->location = $location;
		
		$this->extension = $this->findExtension($this->location->getDir(true, false, 0).$this->getName());
		$this->size = $this->findSize($this->location->getDir(false, false, 0).$this->getName());
		$this->modTime = filemtime($this->location->getDir(false, false, 0).$this->getName());
	}

	function getName()
	{
		return $this->name;
	}

	function getNameEncoded()
	{
		return urlencode($this->name);
	}

	function getSize()
	{
		return $this->size;
	}

	function getExtension()
	{
		return $this->extension;
	}

	function getModTime()
	{
		return $this->modTime;
	}

	//
	// Determine the size of a file
	// 
	function findSize($file)
	{
		//echo "file: " . $file . "<br>";
		$sizeInBytes = filesize($file);

		// If filesize() fails (with larger files), try to get the size from unix command line.
		if (!$sizeInBytes) {
			$sizeInBytes=exec("ls -l '$file' | awk '{print $5}'");
		}
		return $sizeInBytes;
	}

	//
	// Return file extension (the string after the last dot).
	//
	function findExtension($file)
	{
		$chunks = explode(".", $file);
		return $chunks[count($chunks)-1];
	}

	//
	// Debugging output
	// 
	function output()
	{
		print("File name: ".$this->getName()."\n");
		print("File location: ".$this->location->getDir(true, false, 0)."\n");
		print("File size: ".$this->size."\n");
		print("File extension: ".$this->extension."\n");
		print("File modTime: ".$this->modTime."\n");
	}
}

class Location
{
	var $path;

	//
	// Split a file path into array elements
	// 
	function splitPath($dir)
	{
		$path1 = preg_split("/[\\\\\/]+/", $dir);
		$path2 = array();
		for($i = 0; $i < count($path1); $i++)
		{
			if($path1[$i] == ".." || $path1[$i] == "." || $path1[$i] == "")
				continue;
			$path2[] = $path1[$i];
		}
		return $path2;
	}

	function GetPath() {
		return $this->path;
	}
	
	//
	// Get the current directory.
	// Options: Include the prefix ("./"); URL-encode the string; return directory n-levels up
	// 
	function getDir($prefix, $encoded, $up)
	{
		$dir = "";
		if($prefix == true)
			$dir .= "./";
		else
			$dir .= "/";
			
		for($i = 0; $i < ((count($this->path) >= $up && $up > 0)?count($this->path)-$up:count($this->path)); $i++)
		{
			$dir .= ($encoded?rawurlencode($this->path[$i]):$this->path[$i])."/";
		}
		return $dir;
	}

	function getFullPath()
	{
		//return ($_CONFIG['basedir']?$_CONFIG['basedir']:dirname($_SERVER['SCRIPT_FILENAME']))."/".$this->getDir(true, false, 0);
		return (substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")) . "/");
	}

	//
	// Debugging output
	// 
	function output()
	{
		print_r($this->path);
		print("Dir with prefix: ".$this->getDir(true, false, 0)."\n");
		print("Dir without prefix: ".$this->getDir(false, false, 0)."\n");
		print("Upper dir with prefix: ".$this->getDir(true, false, 1)."\n");
		print("Upper dir without prefix: ".$this->getDir(false, false, 1)."\n");
	}


	//
	// Set the current directory
	// 
	function init()
	{
		global $_CONFIG;
		if(!isset($_POST['dir']) || strlen($_POST['dir']) == 0)
		{
			$this->path = $this->splitPath(substr(getcwd(),0,strrpos(getcwd(), "/rap_admin")));  //$this->splitPath($_CONFIG['starting_dir']);
		}
		else
		{
			$this->path = $this->splitPath($_POST['dir']);
		}
	}
}

class Encode_Explorer
{
	var $location;
	var $dirs;
	var $files;
	var $sort_by;
	var $sort_as;

	//
	// Determine sorting, calculate space.
	// 
	function init()
	{
		$this->sort_by = "";
		$this->sort_as = "";
		if(isset($_GET["sort_by"]) && isset($_GET["sort_as"]))
		{
			if($_GET["sort_by"] == "name" || $_GET["sort_by"] == "size" || $_GET["sort_by"] == "mod")
				if($_GET["sort_as"] == "asc" || $_GET["sort_as"] == "desc")
				{
					$this->sort_by = $_GET["sort_by"];
					$this->sort_as = $_GET["sort_as"];
				}
		}
		if(strlen($this->sort_by) <= 0 || strlen($this->sort_as) <= 0)
		{
			$this->sort_by = "name";
			$this->sort_as = "desc";
		}

		$this->calculateSpace();
	}

	//
	// Read the file list from the directory
	// 
	function readDir()
	{
		global $_CONFIG;
		global $_ERROR;
		global $_LANG;
		//
		// Reading the data of files and directories
		//
		//echo "opendir: " . $this->location->getDir(false, false, 0).$object . "<br>";
		if($open_dir = @opendir($this->location->getDir(false, false, 0).$object))
		{
			$this->dirs = array();
			$this->files = array();
			$this->flpath = $this->location->getFullPath();
			while ($object = readdir($open_dir))
			{
				//echo "object: " . $object ."<br>";
				if($object != "." && $object != "..") 
				{
					//echo "is_dir: " . $this->location->getDir(false, false, 0).$object . "<BR>";
					//echo "getDir: " . $this->location->getDir(true, false, 0) . "<BR>";
					if(is_dir($this->location->getDir(false, false, 0).$object))
					{
						//echo "in directory";
						if(!in_array($object, $_CONFIG['hidden_dirs']))
							$this->dirs[] = new Dir($object, $this->location);
					}
					else if(!in_array($object, $_CONFIG['hidden_files']))
						$this->files[] = new File($object, $this->location);
				}
			}
			closedir($open_dir);
		}
		else
		{
			$_ERROR = $_LANG['unable_to_read_dir'];
		}
	}

	//
	// A recursive function for calculating the total used space
	// 
	function sum_dir($start_dir, $ignore_files, $levels = 1) 
	{
		if ($dir = opendir($start_dir)) 
		{
			$filesize = 0;
			while ((($file = readdir($dir)) !== false)) 
			{
				if (!in_array($file, $ignore_files)) 
				{
					if ((is_dir($start_dir . '/' . $file)) && ($levels - 1 >= 0)) 
					{
						$filesize += $this->sum_dir($start_dir . '/' . $file, $ignore_files, $levels-1);
					}
					elseif (is_file($start_dir . '/' . $file)) 
					{					
						$filesize += filesize($start_dir . '/' . $file) / 1024;
					}
				}
			}
			
			closedir($dir);
			return $filesize;
		}
	}

	function calculateSpace()
	{
		global $_CONFIG;
		$ignore_files = array('..', '.');
		$start_dir = getcwd();
		$spaceUsed = $this->sum_dir($start_dir, $ignore_files, $_CONFIG['dir_levels']);
		$spaceLeft = $_CONFIG['max_space'] - $spaceUsed;
		$this->spaceUsed = round($spaceUsed/1024, 3);
		$this->spaceLeft = round($spaceLeft/1024, 3);
	}

	function sort()
	{
		@usort($this->files, "cmp_".$this->sort_by."_".$this->sort_as);
		if($this->sort_by == "name" && $this->sort_as == "asc")
			@usort($this->dirs, "cmp_name_asc");
		else
			@usort($this->dirs, "cmp_name_desc");
	}

	function makeArrow($sort_by)
	{
		global $_LANG;
		
		if($this->sort_by == $sort_by && $this->sort_as == "asc")
		{
			$sort_as = "desc";
			$img = "arrow_up";
		}
		else
		{
			$sort_as = "asc";
			$img = "arrow_down";
		}

		if($sort_by == "name")
			$text = $_LANG["file_name"];
		else if($sort_by == "size")
			$text = $_LANG["size"];
		else if($sort_by == "mod")
			$text = $_LANG["last_changed"];

		return "<a href=\"?dir=".$this->location->getDir(false, true, 0)."&amp;sort_by=".$sort_by."&amp;sort_as=".$sort_as."\">
			$text <img style=\"border:0;\" alt=\"".$sort_as."\" src=\"/rap_admin/addons/GIS/raptools/explorer.php?img=".$img."\" /></a>";
	}

	function makeIcon($l)
	{
		$l = strtolower($l);
		return "/rap_admin/addons/GIS/raptools/explorer.php?img=".$l;
	}

	function formatModTime($time)
	{
		return date("d.m.y H:i:s", $time);
	}

	function formatSize($size) 
	{
		$sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
		$y = $sizes[0];
		for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) 
		{
			$size = $size / 1024;
			$y  = $sizes[$i];
		}
		return round($size, 2)." ".$y;
	}

	//
	// Debugging output
	// 
	function output()
	{
		print("!!!!!!!!!");
		print("Explorer location: ".$this->location->getDir(true, false, 0)."\n");
		for($i = 0; $i < count($this->dirs); $i++)
			$this->dirs[$i]->output();
		for($i = 0; $i < count($this->files); $i++)
			$this->files[$i]->output();
	}

	//
	// Main function, activating tasks
	// 
	function run($location)
	{
		$this->init();
		$this->location = $location;
		$this->readDir();
		$this->sort();
		$this->outputHtml();
	}

	//
	// Printing the actual page
	// 
	function outputHtml()
	{
		global $_ERROR;
		global $_CONFIG;
		global $_LANG;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $_CONFIG['lang']; ?>" lang="<?php print $_CONFIG['lang']; ?>">
<head>
<?php css(); ?>
<meta content="text/html; charset=<?php print $_CONFIG['charset']; ?>" http-equiv="content-type" />
<title>File Explorer</title>
<script language="JavaScript">

function aExplorer(url, dir) {

	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { dir: dir },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aSelectFile(FileName) {

	jQuery('#FileActions').show();
	jQuery('#Productname').html(FileName);
	jQuery('#Rnm').html('Rename &nbsp;' + FileName + '&nbsp; To:<br>');
	jQuery('#Dlt').html('Delete &nbsp;' + FileName + '<br>');
	
}

function aRenameFile() {

	var FileName =		jQuery("#Productname").html();
	var NewName =		jQuery("#newname").val();
	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { action: 'Rename', Filename: FileName, Newname: NewName, dir: '<? echo $_REQUEST['dir']; ?>' },
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);	
}

function aDeleteFile() {

	var FileName =		jQuery("#Productname").html();
	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { action: 'Delete', Filename: FileName, dir: '<? echo $_REQUEST['dir']; ?>' },
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);
}

function aCreateDirectory() {

	var DirectoryName =		jQuery("#newdirectory").val();
	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { action: 'CreateDirectory', Directoryname: DirectoryName, dir: '<? echo $_REQUEST['dir']; ?>' },
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);
}

function aUploadFile() {

	var DirectoryName =		jQuery("#Productname").html();
	jQuery.post("/rap_admin/addons/GIS/raptools/explorer.php", { action: 'UploadFile', Directoryname: DirectoryName, dir: '<? echo $_REQUEST['dir']; ?>' },
			function(data){
				jQuery('#main-dis').html(data);
		  	}
		);
}


function aDeleteDelete() {

	var FileName =		jQuery("#Productname").html();
	jQuery.post("addons/GIS/raptools/explorer.php", { action: 'DoDelete', Filename: '<?= $_REQUEST['Filename']; ?>', dir:'<? echo $_REQUEST['dir']; ?>' },
					function(data){
						jQuery('#main-dis').html(data);
				  	}
				);
}

function aContinue() {

	var cont = jQuery('#main-dis');
	cont.html(loadingimage);
	jQuery.post("addons/GIS/raptools/explorer.php", { dir: '<?= $_REQUEST['dir']; ?>' },
		function(data){
			cont.html(data);
		  	}
		);
}

</script>
</head>
<body>
<?php 
//
// Print the error (if there is something to print)
//
if($_ERROR)
{
?>
	<div id="error"><?php print $_ERROR; ?></div>
<?php
}

?>


<div id="frame">


<!-- START: List table -->
<table class="table" border="0" cellpadding="3" cellspacing="0">
<tr class="breadcrumbs">
	<td colspan="4">: <a href="#" onClick="javascript:aExplorer('','')"><?php print $_LANG['root']; ?></a>
<?php
	for($i = 0; $i < count($this->location->path); $i++)
	{
?>
		/ <a href="#" onClick="javascript:aExplorer('/rap_admin/addons/GIS/raptools/explorer.php','<?php print $this->location->getDir(false, true, count($this->location->path) - $i - 1); ?>')">
			<?php print $this->location->path[$i]; ?>
		</a>
<?php
	}
?>
	</td>
</tr>
<tr class="row one">
	<td class="icon">&nbsp;</td>
	<td class="name"><?php print $this->makeArrow("name");?></td>
	<td class="size"><?php print $this->makeArrow("size"); ?></td>
	<td class="changed"><?php print $this->makeArrow("mod"); ?></td>
</tr>
<tr class="row two">
	<td class="icon"><img alt="dir" src="/rap_admin/addons/GIS/raptools/explorer.php?img=directory" /></td>
	<td colspan="3" class="long"><a href="#" onClick="javascript:aExplorer('/rap_admin/addons/GIS/raptools/explorer.php','<?php print $this->location->getDir(false, true, 1); ?>')">..</a></td>
</tr>
<?php
//
// Ready to display folders and files.
//
$row = 1;

//
// Folders first
//
if($this->dirs)
{
	foreach ($this->dirs as $dir)
	{
		$row_style = ($row ? "one" : "two");
?>
<tr class="row <?php print $row_style; ?>">
	<td class="icon"><img alt="dir" src="/rap_admin/addons/GIS/raptools/explorer.php?img=directory" /></td>
	<td colspan="3" class="long"><?php print "<a href=\"#\" onClick=\"javascript:aExplorer('/rap_admin/addons/GIS/raptools/explorer.php','".$this->location->getDir(false, true, 0).$dir->getNameEncoded()."')\">".$dir->getName()."</a>"; ?></td>
</tr>
<?php
		$row =! $row;
	}
}

//
// Now the files
//
if($this->files)
{
	foreach ($this->files as $file)
	{
		$row_style = ($row ? "one" : "two");
?>
<tr class="row <?php echo $row_style; ?>">
	<td class="icon"><img alt="<?php print $file->getExtension(); ?>" src="<?php print $this->makeIcon($file->getExtension()); ?>" /></td>
	<td class="name">
<?php
		print "\t\t<a href=\"#\" onClick=\"javascript:aSelectFile('".$file->getName()."')\"";
		if($_CONFIG['open_in_new_window'])
			print "target=\"_blank\"";
		print ">".$file->getName()."</a>";
?>
	</td>
	<td class="size"><?php print $this->formatSize($file->getSize()); ?></td>
	<td class="changed"><?php print $this->formatModTime($file->getModTime());?></td>
</tr>
<?php
	$row =! $row;
	}
}


//
// The files and folders have been displayed
//
?>

</table>
<!-- END: List table -->

</div>


<!-- START: Upload area -->
<div id="xupload"><br>
<table><tr align="left"><td width="45px;"></td><td>
<div id="FileActions" style="display:none">

		<table cellspacing="0" cellpadding="0" border="0" >
			<tr>
				<td>
				<div id="Productname"></div>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>
					<div class="upload" id="Rnm" style="font-family:Georgia;">
						Rename x to:<br></div>
						<input name="newname" id="newname" type="text" class="text" size="50"/>
						<input type="button" id="submit" value="<?php print $_LANG["rename"]; ?>" onClick="javascript:aRenameFile();"/><br><br>
					</div>
				</td>
			</tr>
			
			<tr>
				<td>
					<div id ="Dlt" class="upload" style="font-family:Georgia;">
						Delete File:<br></div><br></br>
						
						<input type="button" name="submit" id="submit" value="<?php print $_LANG["delete"]; ?>" onClick="javascript:aDeleteFile();"/><br><br>
					</div>
				</td>
			</tr>
		</table>

</div></td></tr>
<tr align="left"><td></td><td>
	
		<table cellspacing="0" cellpadding="0" border="0" >
			<tr>
				<td>
					<div class="upload" style="font-family:Georgia;">
						Create New Directory:<br>
						<input name="newdirectory" id="newdirectory" type="text" class="text" size="50"/>
						<input type="button" name="submit" id="submit" value="<?php print $_LANG["make_directory"]; ?>" onClick="javascript:aCreateDirectory();"/><br><br>
					</div>
				</td>
			</tr>
			
			<tr>
				<td>
				<?
				if (trim($_REQUEST['dir']) == "") 
					$tdir = $this->location->getFullPath();
				else
					$tdir = $_REQUEST['dir'];
				?>
				<iframe src="addons/GIS/raptools/upload_file.php?dir=<?= $tdir; ?>" frameborder="0" scrolling="no" width="350" height="200"></iframe>
				</td></tr>
			
		</table>

	</td></tr>
</div>
<!-- END: Upload area -->


</body>
</html>

<?
	
	}
}

// We check if the user wants an image and show it. If not, we show the explorer.

$imageServer = new ImageServer();
if(!$imageServer->showImage())
{
	if ($_REQUEST['action'] == "") {
		$_LANG = $_TRANSLATIONS[$_CONFIG['lang']];
		$location = new Location();
		$location->init();
		$fileManager = new FileManager();
		$fileManager->run($location);
		$encodeExplorer = new Encode_Explorer();
	//	echo "start loc: " . $location->GetPath() . "<BR>";
		$encodeExplorer->run($location);
	} else {
		$location = new Location();
		$location->init();
		$dir = $_REQUEST['dir'];
		//echo "dir: " . $dir . "<BR>";
		if (trim($dir) == "") {
			$dir = $location->getFullPath();
		}
		
		switch ($_REQUEST['action']) {
			case 'CreateDirectory':
				if (trim($_REQUEST['Directoryname']) == "" || $_REQUEST['Directoryname'] == "undefined") { ?>
					<table><tr><td>
					<div class="rounded-box-red width-500" id="message-box">
    		    	<div class="box-contents width-500">
       					 You must enter a new name for the directory.  Click continue and try again.
    				</div> 
					</div></td></tr><tr><td>
					<div style='clear:both;'></div><br><br>&nbsp;
					<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
					</td></tr></table>
			<? } else { 
					mkdir($dir . "/" . $_REQUEST['Directoryname']); 
					if (!file_exists($dir . "/" . $_REQUEST['Directoryname'])) { ?>
						<table><tr><td>
						<div class="rounded-box-red width-500" id="message-box">
    		    		<div class="box-contents width-500">
       					 	Directory <?= $_REQUEST['Directoryname'] ?> could not be Created.  There could possibly be permission problems.  Click continue to return to the file explorer.
    					</div> 
						</div></td></tr><tr><td>
						<div style='clear:both;'></div><br><br>&nbsp;
						<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
						</td></tr></table>
<?					} else { ?>
						<table><tr><td>
						<div class="rounded-box-green width-500" id="message-box">
    		    		<div class="box-contents width-500">
       					 	Directory <?= $_REQUEST['Directoryname'] ?> has been Created.  Click continue to return to the file explorer.
    					</div> 
						</div></td></tr><tr><td>
						<div style='clear:both;'></div><br><br>&nbsp;
						<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
						</td></tr></table>
<?					}
				}
				break;
			case 'UploadFile':
				break;
				
			case "DoUpload":
				
				$target_path = $dir . "/" . basename( $_FILES['uploadedfile']['name']); 
				//echo "move " . $_FILES['uploadedfile']['tmp_name'] . " to: " . $target_path . "<br>";

				if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    				echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    				" has been uploaded...<br><br>";
				}
    			break;
    			
			case 'Delete': ?>
				<script language="JavaScript">
				function aDeleteDelete() {

					var FileName =		jQuery("#Productname").html();
					jQuery.post("addons/GIS/raptools/explorer.php", { action: 'DoDelete', Filename: '<?= $_REQUEST['Filename']; ?>', dir:'<? echo $_REQUEST['dir']; ?>' },
									function(data){
										jQuery('#main-dis').html(data);
								  	}
								);
				}
				</script>
				<table width="640">
					<tr><td>You are about to Delete <strong>"<? echo $dir . "/" . $_REQUEST[Filename]; ?>"</strong>. <br>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>Please verify you want to delete this file by the delete button below:</td></tr>
				
				
					<tr><td>&nbsp;</td></tr>
					<tr><td><div class="rounded-box-red" id="error-box">
    					<div class="box-contents">
   							WARNING!  You are about to delete this file.  <strong>THIS CANNOT BE UNDONE</strong> so be sure it is what you want to do before you click the delete button below!
						</div> 
					</div></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align="right">
						<input type="button" name="submit" id="submit" value="DELETE" onClick="javascript:aDeleteDelete();"/>
					</td><td align="right">
						<input type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:aContinue();" />
					</td></tr>
				</table>
<?				break;
				
			case 'DoDelete':
				unlink($dir . "/" . $_REQUEST['Filename']);

				if (!file_exists($dir . "/" . $_REQUEST['Filename'])) {?>
					<table><tr><td>
					<div class="rounded-box-green width-500" id="message-box">
    		    	<div class="box-contents width-500">
    					 File <?= $_REQUEST['Filename'] ?> has been Deleted.  Click continue to return to the file explorer.
    				</div> 
					</div></td></tr><tr><td>
					<div style='clear:both;'></div><br><br>&nbsp;
					<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
					</td></tr></table>
			<?	} else {?>
					<table><tr><td>
					<div class="rounded-box-red width-500" id="message-box">
    		    	<div class="box-contents width-500">
    					 File <?= $_REQUEST['Filename'] ?> was not Deleted.  It could be a permissions problem.  Click continue to return to the file explorer.
    				</div> 
					</div></td></tr><tr><td>
					<div style='clear:both;'></div><br><br>&nbsp;
					<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
					</td></tr></table>
<?				}
				break;
				
			case 'Rename':
				
				if (trim($_REQUEST['Newname']) == "" || $_REQUEST['Newname'] == "undefined") { ?>
				<table><tr><td>
					<div class="rounded-box-red width-500" id="message-box">
    		    	<div class="box-contents width-500">
       					 You must enter a new name in the field to perform the rename function.  Click continue and try again.
    				</div> 
					</div></td></tr><tr><td>
					<div style='clear:both;'></div><br><br>&nbsp;
					<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
					</td></tr></table>
			<? } else { 
					rename($dir . "/" . $_REQUEST['Filename'], $dir . "/" . $_REQUEST['Newname']); ?>
					<table><tr><td>
					<div class="rounded-box-green width-500" id="message-box">
    		    	<div class="box-contents width-500">
       					 File <?= $_REQUEST['Filename'] ?> has been renamed to <?= $_REQUEST['Newname'] ?>  Click continue to return to the file explorer.
    				</div> 
					</div></td></tr><tr><td>
					<div style='clear:both;'></div><br><br>&nbsp;
					<input type="button" name="submit" id="submit" value="Continue..." onClick="javascript:aContinue();"/>
					</td></tr></table>
<?				 } 
				break;
		}
	}
}
			

?>