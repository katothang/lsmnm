<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(class_exists('Vc_Manager')){
    function sv_add_custom_shortcode_param( $name, $form_field_callback, $script_url = null ) {
        return WpbakeryShortcodeParams::addField( $name, $form_field_callback, $script_url );
    }
    // Add testimonial
    sv_add_custom_shortcode_param('add_testimonial', 'sv_add_testimonial', get_template_directory_uri(). '/assets/js/vc_js.js');
    function sv_add_testimonial($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_testimonial">';
        
        parse_str(urldecode($value), $testimonial);
        if(is_array($testimonial)) 
        {
            $i = 1;
            foreach ($testimonial as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="testimonial-item" data-item="'.$i.'">';
                 $html .= '<strong>'.esc_html__("Image","aloshop").' '.$i.':</strong></br>';
                    $html .=    '<div class="wpb_el_type_attach_image edit_form_line">
                                    <input type="hidden" class="st-testimonial wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'.$i.'[image]" value="'.$value['image'].'">
                                    <div class="gallery_widget_attached_images">
                                        <ul class="gallery_widget_attached_images_list ui-sortable">';
                    if(!empty($value['image'])){
                        $img = wp_get_attachment_image_src( $value['image'] );
                        $html .=            '<li class="added ui-sortable-handle">
                                                <img rel="'.$value['image'].'" src="'.esc_url($img[0]).'">
                                                <a href="#" class="icon-remove"></a>
                                            </li>';
                    }
                    $html .=            '</ul>
                                    </div>
                                    <div class="gallery_widget_site_images"></div>
                                    <a class="gallery_widget_add_images" href="#" use-single="true" title="'.esc_html__("Add images","aloshop").'">'.esc_html__("Add images","aloshop").'</a>
                                    <span class="vc_description vc_clearfix">'.esc_html__("Select images from media library.","aloshop").'</span>
                                </div>';
                    $html .= '<label>'.esc_html__("Name","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'.$i.'[name]" value="'.$value['name'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Position","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'.$i.'[pos]" value="'.$value['pos'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Link","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'.$i.'[link]" value="'.$value['link'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Description","aloshop").' </label><textarea style="width:100%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'.$i.'[des]" >'.$value['des'].'</textarea>';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","aloshop").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add-testimonial" type="button">'.esc_html__('Add Item', 'aloshop').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-testimonial-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }
    //Add adv
    sv_add_custom_shortcode_param('add_advantage', 'sv_add_advantage', get_template_directory_uri(). '/assets/js/vc_js.js');
    function sv_add_advantage($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_advantage">';
        
        parse_str(urldecode($value), $advantage);
        if(is_array($advantage)) 
        {
            $i = 1;
            foreach ($advantage as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="advantage-item" data-item="'.$i.'">';
                 $html .= '<strong>'.esc_html__("Image","aloshop").' '.$i.':</strong></br>';
                    $html .=    '<div class="wpb_el_type_attach_image edit_form_line">
                                    <input type="hidden" class="st-advantage wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'.$i.'[image]" value="'.$value['image'].'">
                                    <div class="gallery_widget_attached_images">
                                        <ul class="gallery_widget_attached_images_list ui-sortable">';
                    if(!empty($value['image'])){
                        $img = wp_get_attachment_image_src( $value['image'] );
                        $html .=            '<li class="added ui-sortable-handle">
                                                <img rel="'.$value['image'].'" src="'.esc_url($img[0]).'">
                                                <a href="#" class="icon-remove"></a>
                                            </li>';
                    }
                    $html .=            '</ul>
                                    </div>
                                    <div class="gallery_widget_site_images"></div>
                                    <a class="gallery_widget_add_images" href="#" use-single="true" title="'.esc_html__("Add images","aloshop").'">'.esc_html__("Add images","aloshop").'</a>
                                    <span class="vc_description vc_clearfix">'.esc_html__("Select images from media library.","aloshop").'</span>
                                </div>';
                    $html .= '<label>'.esc_html__("Description","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-advantage" name="'.$i.'[des]" value="'.$value['des'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Link","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-advantage" name="'.$i.'[link]" value="'.$value['link'].'" type="text" >';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","aloshop").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add-advantage" type="button">'.esc_html__('Add Item', 'aloshop').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-advantage-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }
    //Add image link
    sv_add_custom_shortcode_param('add_brand', 'sv_add_brand', get_template_directory_uri(). '/assets/js/vc_js.js');
    function sv_add_brand($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_brand">';
        
        parse_str(urldecode($value), $brand);
        if(is_array($brand)) 
        {
            $i = 1;
            foreach ($brand as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="brand-item" data-item="'.$i.'">';
                 $html .= '<strong>'.esc_html__("Image","aloshop").' '.$i.':</strong></br>';
                    $html .=    '<div class="wpb_el_type_attach_image edit_form_line">
                                    <input type="hidden" class="st-brand wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'.$i.'[image]" value="'.$value['image'].'">
                                    <div class="gallery_widget_attached_images">
                                        <ul class="gallery_widget_attached_images_list ui-sortable">';
                    if(!empty($value['image'])){
                        $img = wp_get_attachment_image_src( $value['image'] );
                        $html .=            '<li class="added ui-sortable-handle">
                                                <img rel="'.$value['image'].'" src="'.esc_url($img[0]).'">
                                                <a href="#" class="icon-remove"></a>
                                            </li>';
                    }
                    $html .=            '</ul>
                                    </div>
                                    <div class="gallery_widget_site_images"></div>
                                    <a class="gallery_widget_add_images" href="#" use-single="true" title="'.esc_html__("Add images","aloshop").'">'.esc_html__("Add images","aloshop").'</a>
                                    <span class="vc_description vc_clearfix">'.esc_html__("Select images from media library.","aloshop").'</span>
                                </div>';
                    $html .= '<label>'.esc_html__("Link","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-brand" name="'.$i.'[link]" value="'.$value['link'].'" type="text" >';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","aloshop").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add-brand" type="button">'.esc_html__('Add Item', 'aloshop').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-brand-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    sv_add_custom_shortcode_param('add_social', 'sv_add_social', get_template_directory_uri(). '/assets/js/vc_js.js');
    // function social
    function sv_add_social($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_social">';
        
        parse_str(urldecode($value), $social);
        if(is_array($social)) 
        {
            $i = 1;
            foreach ($social as $key => $value) {
                if(!isset($value['url'])) $value['url'] = '';
                $html .= '<div class="social-item" data-item="'.$i.'">';
                    $html .= '<label>'.esc_html__("Social","aloshop").' '.$i.':</label></br><label>'.esc_html__("Icon","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social sv_iconpicker" name="'.$i.'[social]" value="'.$value['social'].'" type="text" ></br>';
                    $html .= '<label>'.esc_html__("Link","aloshop").' </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social" name="'.$i.'[url]" value="'.$value['url'].'" type="text" >';
                    $html .= '<a style="color:red" href="#" class="st-del-item">'.esc_html__("Delete","aloshop").'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="st-add"><button class="vc_btn vc_btn-primary vc_btn-sm st-button-add" type="button">'.esc_html__('Add social', 'aloshop').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-social-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    // Mutil location param

    sv_add_custom_shortcode_param('add_location_map', 'sv_add_location_map', get_template_directory_uri(). '/assets/js/vc_js.js');

    function sv_add_location_map($settings, $value)
    {
        $val = $value;
        $html = '<div class="st_add_location">';
        
        parse_str(urldecode($value), $locations);
        if(is_array($locations)) 
        {
            $i = 1;
            foreach ($locations as $key => $value) {
                $html .= '<div class="location-item" data-item="'.$i.'">';
                    $html .= '<div class="wpb_element_label">'.esc_html__("Location",'aloshop').' '.$i.'</div>';
                    $html .= '<label>'.esc_html__("Latitude",'aloshop').'</label><input class="st-input st-location-save st-title" name="'.$i.'[lat]" value="'.$value['lat'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Longitude",'aloshop').'</label><input class="st-input st-location-save st-des" name="'.$i.'[lon]" value="'.$value['lon'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Marker Title",'aloshop').'</label><input class="st-input st-location-save st-label" name="'.$i.'[title]" value="'.$value['title'].'" type="text" >';
                    $html .= '<label>'.esc_html__("Info Box",'aloshop').'</label>';
                    $html .= '<label>'.esc_html__("Info Box",'aloshop').'</label><textarea id="content'.$i.'" class="st-input st-location-save info-content" name="'.$i.'[boxinfo]">'.$value['boxinfo'].'</textarea>';
                    $html .= '<a href="#" class="st-del-item">'.esc_html__("delete",'aloshop').'</a>';
                $html .= '</div>';
                $i++;
            }
        }
        $html .= '</div>';
        $html .= '<div class="add-location"><button style="margin-top: 10px;padding: 5px 12px" class="vc_btn vc_btn-primary vc_btn-sm st-location-add-map" type="button">'.esc_html__('Add more', 'aloshop').' </button></div>';
        $html .= '<input name="'.$settings['param_name'].'" class="st-location-value wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'.$val.'">';
        return $html;
    }

    // Mutil location param

    if(!class_exists('SV_VisualComposerController'))
    {
        class  SV_VisualComposerController
        {

            static function _init()
            {
                add_filter('vc_shortcodes_css_class',array(__CLASS__,'_change_class'), 10, 2);
            }

            static function _custom_vc_param()
            {
               
            }

            static function _change_class($class_string, $tag)
            {
                if($tag=='vc_row' || $tag=='vc_row_inner') {
                    $class_string = str_replace('vc_row-fluid', '', $class_string);
                }

                if(defined ('WPB_VC_VERSION'))
                {
                    if(version_compare(WPB_VC_VERSION,'4.2.3','>'))
                    {
                        if($tag=='vc_column' || $tag=='vc_column_inner') {
                            $class_string=str_replace('vc_col', 'col', $class_string);
                        }
                    }else
                    {
                        if($tag=='vc_column' || $tag=='vc_column_inner') {
                            $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-lg-$1', $class_string);
                        }
                    }
                }

                return $class_string;
            }

        }    

        SV_VisualComposerController::_init();
        SV_VisualComposerController:: _custom_vc_param(); 
    }
    
}