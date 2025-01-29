<?php
/**
* Plugin Name: WPML Language Menu Switch Shortcode
* Version: 1.0.0
* Plugin URI: https://elsaagency.ir/langmenu
* Description: Language switcher shortcode which will present the current page in other langauges. Please add contry flags inside a folder called asset with naming as flag-LANGUAGECODE.png such as flag-ir.png
* Author URI: https://elsaagency.ir/saeedroshan
* Author: Sir Saeed
* Requires Plugins: sitepress-multilingual-cms/sitepress.php
*/

add_shortcode( 'aca_langauge_menu_desktop', 'aca_langauge_menu_desktop' );
function aca_langauge_menu_desktop(){

    // Check if WPML is active
    if (!defined('ICL_SITEPRESS_VERSION')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p><strong>Language Menu Switch Shortcode:</strong> WPML is required but not activated.</p></div>';
        });

        return;
    }

    $current_lang   = wpml_get_current_language();
    $languages      = icl_get_languages('skip_missing=0');

    $currentPage    = get_permalink();

    $htmlOutput = "";
    $htmlOutput = '<div onClick="displayLangContent()" style="display: flex; flex-direction: column; cursor: pointer; position: relative;">

                    <div style="display: flex; flex-direction: row; padding: 0 10px; gap: 10px;">
                        <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                            <img class="no-tooltip" alt="globe" src="' . plugin_dir_url(__FILE__) . 'assets/globe.svg" style="width: 15px; user-select: none;">
                            <p style="margin-bottom: 0; font-size: 12px; font-weight: 600; user-select: none; color: white;">' . $languages[$current_lang]['native_name'] . '</p>
                        </div>

                        <div>
                            <img class="no-tooltip" alt="arrow down" id="langdeskdownmenu" src="' . plugin_dir_url(__FILE__) . 'assets/menudown.svg" onClick="openDeskLang()" style="padding: 20px 20px 20px 5px; user-select: none;">
                            <img class="no-tooltip" alt="arrow up" id="langdeskupmenu" src="' . plugin_dir_url(__FILE__) . 'assets/menuup.svg" onClick="closeDeskLang()" style="display: none; padding: 20px 20px 20px 5px; user-select: none;">
                        </div>
                        
                    </div>';

    $htmlOutput .= '<div id="itbdesklangmenu" style="position: absolute; top: 50px; background: #1E1E26; padding: 8px; width: 160px; display: flex; flex-direction: column; gap: 10px; display: none; z-index: 20; border-radius: 5px;">';

    foreach ($languages as $lang_code => $lang_info) {

        $destUrl = $lang_info['url'];      
        
        $htmlOutput .= '<a href="' . $destUrl . '" style="text-decoration: none; color: white; padding: 12px; border-radius: 5px;">
                            <div style="display: flex; flex-direction: row; align-items: center; gap: 12px; justify-content: space-between;">
                                <div style="display: flex; flex-direction: row ;gap: 12px; align-items: center;">
                                    <img src="' . plugin_dir_url(__FILE__) . 'assets/flag-' . $lang_code . '.png" class="no-tooltip" alt="' . $lang_info['native_name'] . ' flag">
                                    <p style="margin-bottom: 0; font-size: 12px;">' . $lang_info['native_name'] . '</p>
                                </div>';

        if($current_lang === $lang_code){
            $htmlOutput .= '<div>
                                <img src="' . plugin_dir_url(__FILE__) . 'assets/radiobuttonactive.svg" style="object-fit: contain;">
                            </div>';
        }else{
            $htmlOutput .= '<div>
                                <img src="' . plugin_dir_url(__FILE__) . 'assets/radiobutton.svg" style="object-fit: contain; margin-right: 3px;">
                            </div>';
        }

        $htmlOutput .= '</div>
                    </a>';
    }

    $htmlOutput .= '</div>';


    $htmlOutput .= '<script>
                        var state = "close";
                        function displayLangContent(){
                            var menuDropdown = document.getElementById("itbdesklangmenu");
                            if (state === "close"){
                                menuDropdown.style.display = "flex";
                                document.getElementById("langdeskdownmenu").style.display = "none";
                                document.getElementById("langdeskupmenu").style.display = "";
                                state = "open";
                            }else{
                                menuDropdown.style.display = "none";
                                document.getElementById("langdeskdownmenu").style.display = "";
                                document.getElementById("langdeskupmenu").style.display = "none";
                                state = "close";
                            }
                        }
                    </script>';

    $htmlOutput .= '</div>';

    return $htmlOutput;
}