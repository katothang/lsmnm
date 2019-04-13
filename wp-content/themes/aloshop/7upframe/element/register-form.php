<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_register_form'))
    {
        function sv_vc_register_form($attr)
        {
            $html = '';
            extract(shortcode_atts(array(
                'order_count'       => '15',
                'register'          => '',
                'title'             => '',
            ),$attr));
            $wrap_class = '6';
            if(is_user_logged_in() || $register != 'yes' || class_exists( 'WC_Dependencies_Product_Vendor' )){
                $wrap_class = '12';
            }
            $html .=    '<div class="row">';
            $my_account_html = do_shortcode('[woocommerce_my_account order_count="'.$order_count.'"]');
            $html .=    '<div class="col-md-'.$wrap_class.' col-sm-'.$wrap_class.' col-ms-12">
                            <div class="account-login form-my-account">
                                '.$my_account_html.'
                            </div>
                        </div>';
            if(!is_user_logged_in() && $register == 'yes'){
                global $user_ID, $user_identity; wp_get_current_user();
                $register = '';
                if(isset($_GET['register'])) $register = $_GET['register'];
                $html .=    '<div class="col-md-6 col-sm-6 col-ms-12">
                                <div class="account-register">
                                    <form method="post" action="'.site_url('wp-login.php?action=register', 'login_post').'" class="form-my-account">
                                        <h2 class="title">'.$title.'</h2>
                                        <p><input name="user_login" type="text" value="" placeholder="'.esc_html__("Username *","aloshop").'"></p>
                                        <p><input name="user_email" type="text" value="" placeholder="'.esc_html__("E-mail *","aloshop").'"></p>
                                        <p><input name="password" type="password" value="" placeholder="'.esc_html__("Password *","aloshop").'"></p>
                                        <p><input name="repeat_password" type="password" value="" placeholder="'.esc_html__("Repeat password *","aloshop").'"></p>';
                if($register == true) $html .= '<p>'.esc_html__("Check your email for the password!","aloshop").'</p>';
                    $html .=            '<p><input type="submit" value="'.esc_html__("Register","aloshop").'"></p>
                                    </form>
                                </div>
                            </div>';
            }
            $html .=    '</div>';
            return $html;
        }
    }

    stp_reg_shortcode('sv_register_form','sv_vc_register_form');

    vc_map( array(
        "name"      => esc_html__("SV Login/Register Form", 'aloshop'),
        "base"      => "sv_register_form",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        "params"    => array(    
            array(
                "type" => "textfield",
                "heading" => esc_html__("Order count",'aloshop'),
                "param_name" => "order_count",            
            ),     
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show Register Form",'aloshop'),
                "param_name" => "register",
                "value"     => array(
                    esc_html__("No",'aloshop')  => '',
                    esc_html__("Yes",'aloshop')  => 'yes',
                    )
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Title",'aloshop'),
                "param_name" => "title",
                "dependency"    => array(
                    "element"   => 'register',
                    "value"   => 'yes',
                    )
            ),
        )
    ));
}