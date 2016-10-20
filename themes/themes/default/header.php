<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php /* Arclite/digitalnature */
  if(get_option('arclite_meta')<>'') {
   if (is_home()) {
  	$metakeywords = get_option('arclite_meta');
   }
   else if(is_category()) {
    foreach((get_the_category()) as $category) { $metakeywords = $metakeywords.$category->cat_name . ','; }
   }
   else{
  	$metakeywords = "";
  	$tags = wp_get_post_tags($post->ID);
  	foreach ($tags as $tag ) { $metakeywords = $metakeywords . $tag->name . ", "; }
   }
  }
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php //language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if(($metakeywords<>'') && (!is_404())) { ?>
<meta name="keywords" content="<?php print $metakeywords; ?>" />
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php } ?>

<title><?php wp_title('&laquo;', true, 'right'); if (get_query_var('cpage') ) print ' Page '.get_query_var('cpage').' &laquo; ';?> <?php bloginfo('name'); ?></title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

<?php
  if(!defined("PHP_EOL")) define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n"); 

  print '<style type="text/css" media="all">'.PHP_EOL;

  if(get_option('arclite_imageless')=='yes') print '@import "'.get_bloginfo('template_url').'/style-imageless.css";'.PHP_EOL;
  else {
   print '@import "'.get_bloginfo('stylesheet_url').'";'.PHP_EOL;

   if(get_option('arclite_widgetbg')<>'')
    print '@import "'.get_bloginfo('template_url').'/options/side-'.get_option('arclite_widgetbg').'.css";'.PHP_EOL;

   if(get_option('arclite_contentbg')<>'')
    print '@import "'.get_bloginfo('template_url').'/options/content-'.get_option('arclite_contentbg').'.css";'.PHP_EOL;
   else
    print '@import "'.get_bloginfo('template_url').'/options/content-default.css";'.PHP_EOL;

  if(get_option('arclite_sidebarpos')=='left')
    print '@import "'.get_bloginfo('template_url').'/options/leftsidebar.css";'.PHP_EOL;

   if((get_option('arclite_header')=='default') || (get_option('arclite_header')==''))
    print '@import "'.get_bloginfo('template_url').'/options/header-default.css";'.PHP_EOL;

   else if(get_option('arclite_header')=='user') {
    if(get_option('arclite_headerimage')<>'')
       print '#header{ background: transparent url("'.get_option('arclite_headerimage').'") no-repeat center top; }'.PHP_EOL;
    else if(get_option('arclite_headerimage2')<>'')
        print '#header-wrap{ background: transparent url("'.get_option('arclite_headerimage2').'") repeat center top; }'.PHP_EOL;
    }
   else if(get_option('arclite_header')=='user2')
    print '#header, #header-wrap{ background: #'.get_option('arclite_headercolor').'; }'.PHP_EOL;
   else
    print '@import "'.get_bloginfo('template_url').'/options/header-'.get_option('arclite_header').'.css";'.PHP_EOL;
  }

  $usercss = get_option('arclite_css');
  if($usercss<>'') print $usercss;

  print '</style>'.PHP_EOL;
?>

<!--[if lte IE 6]>
<style type="text/css" media="screen">
@import "<?php bloginfo('template_url'); ?>/ie6.css";
</style>
<![endif]-->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php if(get_option('arclite_jquery')<>'no') { ?>
 <?php wp_enqueue_script('jquery'); ?>
 <?php wp_enqueue_script('arclite',get_bloginfo('template_url').'/js/arclite.js'); ?>
<?php } ?>

<?php wp_head(); ?>

</head>
<body <?php if (is_home()) { ?>class="home"<?php } else { ?>class="inner"<?php } ?>>
<?php do_action('wp_insert_h1h2tags'); ?>
 <!-- page wrap -->
 <div id="page"<?php if(!is_page_template('page-nosidebar.php')) { print ' class="with-sidebar'; if((get_option('arclite_3col')=='yes') || (is_page_template('page-3col.php'))) print ' and-secondary'; print '"';  } ?>>

  <!-- header -->
  <div id="header-wrap">
   <div id="header" class="block-content">
     <div id="pagetitle">

      <?php
      // logo image?
      if(get_option('arclite_logo')=='yes' && get_option('arclite_logoimage')) { ?>
      <h1 class="logo"><a href="<?php bloginfo('url'); ?>/"><img src="<?php print get_option('arclite_logoimage'); ?>" title="<?php bloginfo('name');  ?>" alt="<?php bloginfo('name');  ?>" /></a></h1>
      <?php } else { ?>
      <h1 class="logo"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
      <?php }  ?>

      <?php if(get_bloginfo('description')<>'') { ?><h4><?php bloginfo('description'); ?></h4><?php } ?>
      <div class="clear"></div>

      <?php if(get_option('arclite_search')<>'no') { ?>
      <?php // get_search_form(); ?>
      <!-- search form -->
      <div class="search-block">
        <div class="searchform-wrap">
          <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
            <fieldset>
            <input type="text" name="s" id="searchbox" class="searchfield" value="<?php _e("Search","arclite"); ?>" onfocus="if(this.value == '<?php _e("Search","arclite"); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e("Search","arclite"); ?>';}" />
             <input type="submit" value="Go" class="go" />
            </fieldset>
          </form>
        </div>
      </div>
      <!-- /search form -->
      <?php } ?>

     </div>

     <!-- main navigation -->
     <div id="nav-wrap1">
      <div id="nav-wrap2">
        <ul id="nav">
         <?php
          if((get_option('show_on_front')<>'page') && (get_option('arclite_topnav')<>'categories')) {
           if(is_home() && !is_paged()){ ?>
            <li id="nav-homelink" class="current_page_item"><a class="fadeThis" href="<?php echo get_settings('home'); ?>" title="<?php _e('You are Home','arclite'); ?>"><span><?php _e('Home','arclite'); ?></span></a></li>
           <?php } else { ?>
            <li id="nav-homelink"><a class="fadeThis" href="<?php echo get_option('home'); ?>" title="<?php _e('Click for Home','arclite'); ?>"><span><?php _e('Home','arclite'); ?></span></a></li>
          <?php
           }
          } ?>
         <?php
           if(get_option('arclite_topnav')=='categories') {
            echo preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a>@i', '<li$1><a class="fadeThis"$2><span>$3</span></a>', wp_list_categories('show_count=0&echo=0&title_li='));
            }
           else {
             echo preg_replace('@\<li([^>]*)>\<a([^>]*)>(.*?)\<\/a>@i', '<li$1><a class="fadeThis"$2><span>$3</span></a>', wp_list_pages('echo=0&orderby=name&title_li=&'));
           }
          ?>
        </ul>
      </div>
     </div>
     <!-- /main navigation -->

   </div>
  </div>
  <!-- /header -->