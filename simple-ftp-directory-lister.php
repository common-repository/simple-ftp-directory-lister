<?php
/**
 * Plugin Name:       Simple FTP Directory Lister
 * Description:       Choose folder from FTP - WP UPLOAD DIRECTORY - and display all its files and subfolders. Easy integration.
 * Version:           1.4.7
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jakub Raška
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       Simple-FTP-Directory-Lister
 */


	//add wp-admin settings
include 'assets/sfdl-options.php';
/* settings link in plugins menu, ignore this one */
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

/*add shortcode only outside admin area */
add_shortcode( 'simple-ftp-directory-lister', 'sfdl_main_function');

$options_array = get_option( 'simple_file_directory_lister_option_name');
$user_input_path = $options_array["id_path_to_folder"];
$layout = $options_array["id_style"];
$disable_loading_animation = $options_array['id_disable_loading_animation'];
$hide_file_extension = $options_array['id_hide_file_extension'];
$hide_some_extensions = $options_array['id_hide_some_extensions'];


/* set full path and remove all dot dot slashes from the path */
$upload_dir = wp_upload_dir();

// add / to beginning of user input path if missing
if (substr($user_input_path, 0, 1) !== '/' && substr($user_input_path, 0, 1) !== '\\' && substr($user_input_path, 0, 1) !== '.') {
      $user_input_path =   "/" . $user_input_path;
      }

// change all \ to / within user input path
elseif (substr($user_input_path, 0, 1) === '\\') {
$user_input_path = str_replace("\\", "/", $user_input_path);
}

$full_dir_path = $upload_dir['basedir'] . $user_input_path;
$full_safe_dir_path = realpath($full_dir_path);


/* functions declaration */
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

function dirToArray($dir) {

   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value)
   {
      if (!in_array($value,array(".","..")))
      {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
         {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else
         {
            $result[] = $value;
         }
      }
   }

   return $result;
}


function displayarray($filearray) {
	global $directory, $hide_file_extension, $hide_some_extensions;
if(!empty($hide_some_extensions) and !is_array($hide_some_extensions))
{
  $hide_some_extensions = explode(' ', $hide_some_extensions);
}

	//echo "<pre>";	print_r($filearray);echo "</pre>";

	foreach($filearray as $key => $value ){


	//files
	if (is_array($value) == false)
	{

$filename = $value;
$file_ext = pathinfo($value, PATHINFO_EXTENSION);



if(is_array($hide_some_extensions) AND in_array($file_ext, $hide_some_extensions) AND $hide_file_extension){
  $filename = pathinfo($filename, PATHINFO_FILENAME);
}
elseif ($hide_file_extension AND empty($hide_some_extensions)){
  $filename = pathinfo($filename, PATHINFO_FILENAME);
}

$link = '<a class="soubor-link" target="_blank" file="'.$value.'" href="' . $directory . '/' . $value . '">' . $filename. '</a><br />';
$extension = pathinfo($directory . '/' . $value, PATHINFO_EXTENSION);

/*files html output */
	echo '<div class="soubor"><div class="sfdl-icon download-icon ' . $extension . '"></div>' . $link . "</div>";
	}

	//folders
	elseif (is_array($value) == true)
	{
	$namelink = array_key_first($value);

/*folders html output */
		echo '<div class="slozka"><span class="nazev-slozky"><div class="sfdl-icon folder-icon"></div>' . $key . '</span>' ;
    echo '<div class="child-wrapper schovat-slozku">';
	displayarray($value);
	echo '</div>';
  echo '</div>';
	}

}
	}

/*main function of the lister */
function sfdl_main_function($array_info_main){



	global $full_safe_dir_path;
  global $full_dir_path;
  global $upload_dir;
  global $directory;
  global $id_path_to_folder;
  global $user_input_path;
  global $layout;
  global $options_array;
  global $disable_loading_animation;

// set directory
  if (isset($array_info_main['path'])){
      $directory = $array_info_main['path'];
      $user_input_path = $array_info_main['path'];
  }

if (isset($array_info_main['layout'])){
    $layout = $array_info_main['layout'];
}
elseif ($layout === "1" OR $layout === "horizontal") {
    $layout = "horizontal";
}
else {
$layout = "vertical";
}

if (empty($options_array["mobile_version_breakpoint"])){$options_array["mobile_version_breakpoint"] = 767;}

if (isset($array_info_main['loading_animation']) && ($array_info_main['loading_animation'] == "disable" || $array_info_main['loading_animation'] == "enable")){
    $disable_loading_animation = $array_info_main['loading_animation'];
}
  // add / to beginning of user input path if missing
  if (substr($user_input_path, 0, 1) !== '/' && substr($user_input_path, 0, 1) !== '\\' && substr($user_input_path, 0, 1) !== '.') {
        $user_input_path =   "/" . $user_input_path;
        }

  // change all \ to / within user input path
  elseif (substr($user_input_path, 0, 1) === '\\') {
  $user_input_path = str_replace("\\", "/", $user_input_path);
  }

  $full_dir_path = $upload_dir['basedir'] . $user_input_path;
  $full_safe_dir_path = realpath($full_dir_path);

/*dont run in admin area */
	if ( !is_admin() OR wp_doing_ajax() ) {

/*check if set path is existing directory */
if (file_exists($full_safe_dir_path) && is_dir($full_safe_dir_path)) {
$filearray = dirToArray($full_safe_dir_path);


/* load jquery and scripts */
wp_enqueue_script( 'JQUERY-3.4.1', plugins_url( 'assets/js/jquery-3.4.1.min.js', __FILE__ ), array ( 'jquery' ), "3.4.1", true);
wp_enqueue_script( 'assets/js/simple-ftp-directory-lister-script', plugins_url( 'assets/js/simple-ftp-directory-lister.js', __FILE__ ), array ( 'jquery' ), 1.3, true);
		ob_start();
?>
<style>
<?php
$pathToStyles = "assets/css";
$pathToStylesThemeOverride = get_stylesheet_directory() . "/simple-ftp-directory-lister";
if (is_dir( $pathToStylesThemeOverride )){
$pathToStyles = $pathToStylesThemeOverride."/css";
}


/*load styles */
if ($layout === "horizontal")
{

  echo "@media (min-width: ".($options_array["mobile_version_breakpoint"]+1)."px) {";
  include $pathToStyles."/simple-ftp-directory-lister-horizontal.css";
  echo '}';

  echo "@media (max-width: ".$options_array["mobile_version_breakpoint"]."px) {";
  include $pathToStyles."/simple-ftp-directory-lister-horizontal-mobile.css";
  echo '}';
        }
else  {
  include $pathToStyles."/simple-ftp-directory-lister-vertical.css";
}

include $pathToStyles."/simple-ftp-directory-lister.css";

echo "#mobile-indicator {
  display: none;
}

@media (max-width: ".$options_array["mobile_version_breakpoint"]."px) {
  #mobile-indicator {
    display: block;
  }
}";
include $pathToStyles."/simple-ftp-directory-lister-icons.css";
?>
</style>

<?php

if ($disable_loading_animation !== "disable" && $disable_loading_animation != "0" ){
 echo '<div class="sfdl-loading-gif-wrapper"><img src="' . esc_url( plugins_url( 'assets/img/sfdl-loading-gif.gif', __FILE__ ) ) . '" class="sfdl-loading-gif" ></div>'; }
 ?>
<div class="directory-lister-wrapper <?php echo $options_array["custom_classes_sfdl_wrapper"];?>" id="directory-lister" layout="<?php echo $layout; ?>" mainpath="<?php echo $upload_dir['baseurl'] . $user_input_path; ?>" mobile_version_breakpoint="<?php echo $options_array["mobile_version_breakpoint"]?>">
<?php
if (empty($filearray)) {
echo '<div class="sdfl-no-files-available-wrapper"><div class="sdfl-no-files-available-icon"></div></div>';
}
else {
    displayarray($filearray);
}
?>
</div>

<div id="mobile-indicator"></div>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}
}
}
?>
