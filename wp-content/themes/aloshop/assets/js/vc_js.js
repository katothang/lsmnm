(function($)
{
	"use strict";   

	$('body').on('click', '.st-del-social', function(e)
    {
    	e.preventDefault();
    	$(this).parent().remove();
    })
	$('.vc_ui-button-action[data-vc-ui-element=button-save]').on('click', function()
    {
    	var value;
    	if($('.st_add_social').length >0) {
    		value = $('.st_add_social').find('.st-social').serialize();
	    	$('.st-social-value').val( encodeURIComponent(value) );
	    }
        if($('.st_add_location').length >0) {
            var value = $('.st_add_location').find('.st-location-save').serialize();
            $('.st-location-value').val( encodeURIComponent(value) );

        }        
        if($('.st_add_brand').length >0) {
            value = $('.st_add_brand').find('.st-brand').serialize();
            $('.st-brand-value').val( encodeURIComponent(value) );
        }
        if($('.st_add_advantage').length >0) {
            value = $('.st_add_advantage').find('.st-advantage').serialize();
            $('.st-advantage-value').val( encodeURIComponent(value) );
        }
        if($('.st_add_testimonial').length >0) {
            value = $('.st_add_testimonial').find('.st-testimonial').serialize();
            $('.st-testimonial-value').val( encodeURIComponent(value) );
        }
    });
    $('.st-button-add').on('click', function()
    {
    	var key = $('.st_add_social').find('.social-item').last().data('item');
    	if(key == '' || key == undefined)
    	{
    		key = 1;
    	}else
    	{
    		key = parseInt(key) + 1;
    	}
    	var item = '<div class="social-item" data-item="'+key+'">';
            item += '<label>Social '+key+':</label></br><label>Icon </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class=" sv_iconpicker st-social" name="'+key+'[social]" value="" type="text"></br>';
            // item += '<div class="edit_form_line"><input type="hidden" class="st-social wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'+key+'[social]" value=""><div class="gallery_widget_attached_images"><ul class="gallery_widget_attached_images_list ui-sortable"></ul></div><div class="gallery_widget_site_images"></div><a class="gallery_widget_add_images" href="#" title="Add images">Add images</a><span class="vc_description vc_clearfix">Select images from media library.</span></div>';
    		item += '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social" name="'+key+'[url]" value="" type="text">';
    		item += '<a style="color:red" href="#" class="st-del-item">Delete</a>';
    		item += '</div>';
    	$('.st_add_social').append(item);
    }); 
    // maps location
    var set_first = 1;
    $('.st-location-add-map').on('click', function()
    {
        var key = $('.st_add_location').find('.location-item').last().attr('data-item');
        // console.log('sss');
        if(key == '' || key == undefined)
        {
            key = set_first;
            set_first++;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="location-item" data-item="'+key+'">';
            item += '<div class="wpb_element_label">Location '+key+'</div>';
            item += '<label>Latitude</label><input class="st-input st-location-save st-title" name="'+key+'[lat]" value="" type="text">';
            item += '<label>Longitude</label><input class="st-input st-location-save st-des" name="'+key+'[lon]" value="" type="text">';
            item += '<label>Marker Title</label><input class="st-input st-location-save st-label" name="'+key+'[title]" value="" type="text">';
            item += '<label>Info Box</label><textarea class="st-input st-location-save info-content" name="'+key+'[boxinfo]"></textarea>';
            item += '</span>';
            item += '<a href="#" class="st-del-item">delete</a>';
            item += '</div>';
        $('.st_add_location').append(item);
        $('.st_add_location').find('.location-item').last().attr('data-item',key);
    });
    // add Brand
    $('.st-button-add-brand').on('click', function()
    {
        var key = $('.st_add_brand').find('.brand-item').last().data('item');
        if(key == '' || key == undefined)
        {
            key = 1;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="brand-item" data-item="'+key+'">';            
            item += '<div class="wpb_el_type_attach_image edit_form_line"><input type="hidden" class="st-brand wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'+key+'[image]" value=""><div class="gallery_widget_attached_images"><ul class="gallery_widget_attached_images_list ui-sortable"></ul></div><div class="gallery_widget_site_images"></div><a class="gallery_widget_add_images" href="#" use-single="true" title="Add images">Add images</a><span class="vc_description vc_clearfix">Select images from media library.</span></div>';
            item += '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-brand" name="'+key+'[link]" value="" type="text">';
            item += '<a style="color:red" href="#" class="st-del-item">Delete</a>';
            item += '</div>';
        $('.st_add_brand').append(item);
    });
    // add Adv
    $('.st-button-add-advantage').on('click', function()
    {
        var key = $('.st_add_advantage').find('.advantage-item').last().data('item');
        if(key == '' || key == undefined)
        {
            key = 1;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="advantage-item" data-item="'+key+'">';            
            item += '<div class="wpb_el_type_attach_image edit_form_line"><input type="hidden" class="st-advantage wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'+key+'[image]" value=""><div class="gallery_widget_attached_images"><ul class="gallery_widget_attached_images_list ui-sortable"></ul></div><div class="gallery_widget_site_images"></div><a class="gallery_widget_add_images" href="#" use-single="true" title="Add images">Add images</a><span class="vc_description vc_clearfix">Select images from media library.</span></div>';
            item += '<label>Description </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-advantage" name="'+key+'[des]" value="" type="text"></br>';
            item += '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-advantage" name="'+key+'[link]" value="" type="text">';
            item += '<a style="color:red" href="#" class="st-del-item">Delete</a>';
            item += '</div>';
        $('.st_add_advantage').append(item);
    });
    // add Testimonial
    $('.st-button-add-testimonial').on('click', function()
    {
        var key = $('.st_add_testimonial').find('.testimonial-item').last().data('item');
        if(key == '' || key == undefined)
        {
            key = 1;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="testimonial-item" data-item="'+key+'">';            
            item += '<div class="wpb_el_type_attach_image edit_form_line"><input type="hidden" class="st-testimonial wpb_vc_param_value gallery_widget_attached_images_ids images attach_images" name="'+key+'[image]" value=""><div class="gallery_widget_attached_images"><ul class="gallery_widget_attached_images_list ui-sortable"></ul></div><div class="gallery_widget_site_images"></div><a class="gallery_widget_add_images" href="#" use-single="true" title="Add images">Add images</a><span class="vc_description vc_clearfix">Select images from media library.</span></div>';
            item += '<label>Name </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'+key+'[name]" value="" type="text"></br>';
            item += '<label>Position </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'+key+'[pos]" value="" type="text"></br>';
            item += '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'+key+'[link]" value="" type="text"></br>';
            item += '<label>Description </label><textarea style="width:100%;margin-right:10px;margin-bottom:15px" class="st-testimonial" name="'+key+'[des]"></textarea>';
            item += '<a style="color:red" href="#" class="st-del-item">Delete</a>';
            item += '</div>';
        $('.st_add_testimonial').append(item);
    });
    // Delete
    $('body').on('click', '.st-del-item', function(e)
    {
        e.preventDefault();
        $(this).parent().remove();
    })

})(jQuery)