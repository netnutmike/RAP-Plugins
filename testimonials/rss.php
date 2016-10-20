<?
//==============================================================================================
//
//  Filename: rss.php
//
//  Author:   Mike Myers
//  Email:    mike@geniusideastudio.com
//  Blog:     mikemyers.me
//  Support:  www.askmikemyers.com
//
//  Copyright:  Copyright, 2010(c), Genius Idea Studio, LLC
//
//  Product Is Available For Download From www.rap-tools.com
//
//  Description:  This script is called by core rap when it is building an RSS feed to that
//                Testimonials can be added to the feed.
//
//  Version:  1.0.0 (June 15th, 2010)
//
//  Change Log:
//        06/15/10 - Initial Version (JMM)
//
//==============================================================================================

  require_once($_SERVER[DOCUMENT_ROOT] . "/rap_admin/settings.php");

  $gBuildVar = "";
  
  if (!function_exists('gOpenTestimonials')) {
	function gOpenTestimonials() {
    	$gBuildVar = "";
    
    	$gBuildVar .= "<testimonials>\n"; 
    	
    	return $gBuildVar;
		}
  }
  if (!function_exists('gCloseTestimonials')) {
	function gCloseTestimonials() {
    	$gBuildVar = "";
    
    	$gBuildVar .= "</testimonials>\n"; 
    	
    	return $gBuildVar;
		}
	}
	
	if (!function_exists('gTestimonialEntry')) {

		function gTestimonialEntry($gVisualName, $gFromLocation, $gShortSubject, $gTestimonial, $gVideoURL) {
  			$gBuildVar = "";
    
  			$gBuildVar .= "<testimonial>\n";
  			$gBuildVar .= "  <name>" . $gVisualName . "</name>\n";
  			$gBuildVar .= "  <location>" . $gFromLocation . "</location>\n";
 			$gBuildVar .= "  <subject>" . $gShortSubject . "</subject>\n";
  			$gBuildVar .= "  <testimonial>" . $gTestimonial . "</testimonial>\n";
  			$gBuildVar .= "  <videourl>" . $gVideoURL . "</videourl>\n";
  			$gBuildVar .= "</testimonial>\n";
  			
  			return $gBuildVar;
		}
	}


//=========================================================================
// M A I N   P R O G R A M   S T A R T S   H E R E 
//=========================================================================

    
      //Loop through all testimonials for the current product
      $sql="SELECT * FROM g_testimonials WHERE productID = '" . $productID . "' AND Status='1' Order By Date, Time DESC";
      $gid=mysql_query($sql);

      if (mysql_num_rows($gid) > 0) {
         $gBuildVar .= gOpenTestimonials();
         
         while ( $grow=mysql_fetch_array($gid) ) {
          $gBuildVar .= gTestimonialEntry($grow['VisualName'], $grow['FromLocation'], $grow['ShortSubject'], $grow['Testimonial'], $grow['VideoURL']);
          }
         $gBuildVar .= gCloseTestimonials();
      }
      
      echo $gBuildVar;
      $RSSItemExtension = $gBuildvar;

?>
