<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package 7up-framework
 */

?>
    <?php
    $page_id = sv_get_value_by_id('sv_footer_page');
    if(!empty($page_id)) {
        sv_get_footer_visual($page_id);
    }
    else{
        sv_get_footer_default();
    }
    sv_scroll_top();
    ?>
</div>
<div id="boxes"></div>
<?php wp_footer(); ?>
</body>
</html>
