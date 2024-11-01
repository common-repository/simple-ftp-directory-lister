<?php
/*

THIS FILE IS JUST FOR WORDPRESS SETTINGS FROM ADMIN ENVIRONMENT.
YOU PROBABLY DON'T WANT TO CHANGE ANYTHING HERE.

*/

class simple_ftp_directory_lister_settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'SFDL Admin',
            'Simple FTP Directory Lister Settings',
            'manage_options',
            'sfdl-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'simple_file_directory_lister_option_name' );
        ?>
        <div class="wrap">
            <h1>Simple FTP Directory Lister - settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'simple_file_directory_lister_option_group' );
                do_settings_sections( 'sfdl-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'simple_file_directory_lister_option_group', // Option group
            'simple_file_directory_lister_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            '', // Title
            array( $this, 'print_section_info' ), // Callback
            'sfdl-setting-admin' // Page
        );

        add_settings_field(
            'id_path_to_folder', // ID
            'Path to folder<br><span style="color:red;font-size:12px; max-width:130px; display:block;">Path to folder you want to list.</span>', // Title
            array( $this, 'id_path_to_folder_callback' ), // Callback
            'sfdl-setting-admin', // Page
            'setting_section_id' // Section
        );

		   add_settings_field(
            'id_shortcode', // ID
            'Shortcode<br><span style="color:red;font-size:12px; max-width:130px; display:block;">Dont change, copy and paste to your page.</span>', // Title
            array( $this, 'id_shortcode_callback' ), // Callback
            'sfdl-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
             'id_shortcode_extended', // ID
             'Extended shortcode (optional)<br><span style="color:red;font-size:12px; max-width:130px; display:block;">You can define shortcode parameters.</span>', // Title
             array( $this, 'id_shortcode_extended_callback' ), // Callback
             'sfdl-setting-admin', // Page
             'setting_section_id' // Section
         );

        add_settings_field(
             'id_style', // ID
             'Style of listing', // Title
             array( $this, 'id_style_callback' ), // Callback
             'sfdl-setting-admin', // Page
             'setting_section_id' // Section
         );


         add_settings_section(
                 'advanced_setting', // ID
                 'Advanced settings - dont change if not necessary', // Title
                 array( $this, 'id_advanced_setting_callback' ), // Callback
                 'sfdl-setting-admin' // Page
             );

             add_settings_field(
                  'custom_classes_sfdl_wrapper', // ID
                  'Add custom classes to main wrapper<br><span style="color:red;font-size:12px; display:block;">.directory-lister-wrapper</span>', // Title
                  array( $this, 'id_custom_classes_sfdl_wrapper_callback' ), // Callback
                  'sfdl-setting-admin', // Page
                  'advanced_setting' // Section
              );

              add_settings_field(
                   'mobile_version_breakpoint', // ID
                   'When should layout change to mobile version<br><span style="color:red;font-size:12px; display:block;">Width of .directory-lister-wrapper in pixels.</span>', // Title
                   array( $this, 'id_mobile_version_breakpoint_callback' ), // Callback
                   'sfdl-setting-admin', // Page
                   'advanced_setting' // Section
               );

               add_settings_field(
                    'id_disable_loading_animation', // ID
                    'Control of loading animation', // Title
                    array( $this, 'id_disable_loading_animation_callback' ), // Callback
                    'sfdl-setting-admin', // Page
                    'advanced_setting' // Section
                );

               add_settings_field(
                    'id_hide_file_extension', // ID
                    'Hide file extensions?', // Title
                    array( $this, 'id_hide_file_extension_callback' ), // Callback
                    'sfdl-setting-admin', // Page
                    'advanced_setting' // Section
                );

                add_settings_field(
                     'id_hide_some_extensions', // ID
                     'Hide only these extensions<br><span style="color:red;font-size:12px; display:block;">separated by space</span>', // Title
                     array( $this, 'id_hide_some_extensions_callback' ), // Callback
                     'sfdl-setting-admin', // Page
                     'advanced_setting' // Section
                 );

		add_settings_section(
            'setting_section_id2', // ID
            'Additional information', // Title
            array( $this, 'print_section_info2' ), // Callback
            'sfdl-setting-admin' // Page
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        $new_input = array();

        if( isset( $input['id_path_to_folder'] ) ) {
        $new_input['id_path_to_folder'] = sanitize_text_field ($input['id_path_to_folder']);}

        if( isset( $input['id_style'] ) ) {
        $new_input['id_style'] = sanitize_text_field ($input['id_style']);}

        if( isset( $input['custom_classes_sfdl_wrapper'] ) ) {
        $new_input['custom_classes_sfdl_wrapper'] = sanitize_text_field ($input['custom_classes_sfdl_wrapper']);}

        if( isset( $input['mobile_version_breakpoint'] ) ) {
        $new_input['mobile_version_breakpoint'] = sanitize_text_field ($input['mobile_version_breakpoint']);}

        if( isset( $input['id_disable_loading_animation'] ) ) {
        $new_input['id_disable_loading_animation'] = sanitize_text_field ($input['id_disable_loading_animation']);}

        if( isset( $input['id_hide_file_extension'] ) ) {
        $new_input['id_hide_file_extension'] = sanitize_text_field ($input['id_hide_file_extension']);}

        if( isset( $input['id_hide_some_extensions'] ) ) {
        $new_input['id_hide_some_extensions'] = sanitize_text_field ($input['id_hide_some_extensions']);}

        return $new_input;


    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print '';
    }

    public function id_advanced_setting_callback()
   {
     printf(
         ''
     );
   }
   public function id_custom_classes_sfdl_wrapper_callback()
   {
     printf(
         '<input type="text" id="id_custom_classes_sfdl_wrapper" style="min-width:500px;" name="simple_file_directory_lister_option_name[custom_classes_sfdl_wrapper]" value="%s" />
         <br><span style="margin-top:10px; font-size:12px; color: red;">Useful option only if your theme is looking for a class (for example to set full width).</span></b><br>
         ',isset( $this->options['custom_classes_sfdl_wrapper'] ) ? esc_attr( $this->options['custom_classes_sfdl_wrapper']) : ''
     );
   }

   public function id_mobile_version_breakpoint_callback()
   {

     if (empty($this->options['mobile_version_breakpoint'])) {
       $this->options['mobile_version_breakpoint'] = 767;
     }

     printf(
         '<input type="text" id="id_mobile_version_breakpoint" style="max-width: 80px;" name="simple_file_directory_lister_option_name[mobile_version_breakpoint]" value="%s" />
         <br><span style="margin-top:10px; font-size:12px; color: red;">767px by default, adjust if needed. Mobile version = vertical layout.</span></b><br>
         ',isset( $this->options['mobile_version_breakpoint'] ) ? esc_attr( $this->options['mobile_version_breakpoint']) : ''
     );
   }


	   public function print_section_info2()
    {
        print '<div>Plugin register path to folder within wordpress upload folder, therefore add only relative path to the folder you want to list. <br> When the path to folder is properly set, just copy the shortcode and past it anywhere to the page where you want to show the listing. </div><div style="color: red; margin-top:10px;">
        Please keep in mind that by default this plugin is not suitable for listing thousands of items since it loads all the information at once.</div>';
        print '<br><b>Ajax calls supported. If you are a developer, you can use this plugin to create dynamical listings.</b>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_path_to_folder_callback()
    {
		global $full_safe_dir_path;
		$pathcheck = "<br>Set directory for listing: " . $full_safe_dir_path . "<br><br>";

		if (! file_exists($full_safe_dir_path)) {
				$pathcheck .= '<div style="color:red;font-size:20px;font-weight:600;"> ERROR --> Set path does not exist.</div>';
			}
		else if (! is_dir($full_safe_dir_path)) {
				$pathcheck .= '<div style="color:red;font-size:20px;font-weight:600;"> ERROR --> Set path is not a directory.</div>';
			}


        printf(
            '<input type="text" id="id_path_to_folder" style="min-width:500px;" name="simple_file_directory_lister_option_name[id_path_to_folder]" value="%s" />
            <br><span style="margin-top:10px; font-size:12px; color: red;">E.g. /wp-content/uploads/your-folder</span></b><br>' . $pathcheck,
            isset( $this->options['id_path_to_folder'] ) ? esc_attr( $this->options['id_path_to_folder']) : ''
        );
    }

	    public function id_shortcode_callback()
    {
        printf(
            '<input type="text" id="id_shortcode" style="min-width:190px;" name="[simple-ftp-directory-lister]" value="[simple-ftp-directory-lister]" />
            <br><span style="margin-top:10px;  font-size:12px; color: red;">Copy and paste this to the page where you want to show directory listing.</span></b>'
			);
    }

    public function id_shortcode_extended_callback()
  {
      printf(
          '<input type="text" id="id_shortcode_extended" style="min-width:490px;" name="[simple-ftp-directory-lister layout=\'horizontal\' path=\'/path_to_your_folder\']" value="[simple-ftp-directory-lister layout=\'horizontal\' path=\'/path_to_your_folder\']" />
          <br><span style="margin-top:10px;  font-size:12px; color: red;">You can define path and layout directly in shortcode. This allows you to create multiple listings across the website. <br>Variables defined in shortcodes are prioritized over general settings.</span></b>'
    );
  }

    public function id_style_callback()
    {
		if (!isset($this->options['id_style'])) {
			$this->options['id_style'] = 0;
		}
        printf(
            '<input type="radio" name="simple_file_directory_lister_option_name[id_style]" value="0"'. checked( '0', $this->options['id_style'], false). ' />
            <label for="0">Vertical layout</label><br>
            <input type="radio" name="simple_file_directory_lister_option_name[id_style]" value="1"'. checked( '1', $this->options['id_style'], false) . ' />
            <label for="1">Horizontal layout (vertical on mobile)</label>
            ',   isset( $this->options['id_style'] ) ? esc_attr( $this->options['id_style']) : ''
        );
    }

    public function id_disable_loading_animation_callback()
    {
    if (!isset($this->options['id_disable_loading_animation'])) {
      $this->options['id_disable_loading_animation'] = 1;
    }
        printf(
            '<input type="radio" name="simple_file_directory_lister_option_name[id_disable_loading_animation]" value="0"'. checked( '0', $this->options['id_disable_loading_animation'], false). ' />
            <label for="0">Disable loading animation</label><br>
            <input type="radio" name="simple_file_directory_lister_option_name[id_disable_loading_animation]" value="1"'. checked( '1', $this->options['id_disable_loading_animation'], false) . ' />
            <label for="1">Enable loading animation</label>
            <br><span style="margin-top:10px;  font-size:12px; color: red;">This can be also set individually in shortcode by loading_animation=\'disable\' </span></b>
            ',  isset( $this->options['id_disable_loading_animation'] ) ? esc_attr( $this->options['id_disable_loading_animation']) : ''
        );
    }
    public function id_hide_file_extension_callback()
    {
    if (!isset($this->options['id_hide_file_extension'])) {
      $this->options['id_hide_file_extension'] = 0;
    }
        printf(
            '<input type="radio" name="simple_file_directory_lister_option_name[id_hide_file_extension]" value="0"'. checked( '0', $this->options['id_hide_file_extension'], false). ' />
            <label for="0">Show file extensions</label><br>
            <input type="radio" name="simple_file_directory_lister_option_name[id_hide_file_extension]" value="1"'. checked( '1', $this->options['id_hide_file_extension'], false) . ' />
            <label for="1">Hide file extensions</label>
            <br>
            ',  isset( $this->options['id_hide_file_extension'] ) ? esc_attr( $this->options['id_hide_file_extension']) : ''
        );
    }

    public function id_hide_some_extensions_callback()
    {
      printf(
          '<input type="text" id="id_hide_some_extensions" style="min-width:500px;" name="simple_file_directory_lister_option_name[id_hide_some_extensions]" value="%s" />
          <br><span style="margin-top:10px; font-size:12px; color: red;">Space between extensions, example: pdf jpg png</span></b><br>
          ',isset( $this->options['id_hide_some_extensions'] ) ? esc_attr( $this->options['id_hide_some_extensions']) : ''
      );
    }


}



if( is_admin() )
    $my_settings_page = new simple_ftp_directory_lister_settings();

function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=sfdl-admin">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
