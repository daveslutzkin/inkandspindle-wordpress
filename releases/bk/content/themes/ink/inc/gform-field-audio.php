<?php
// Add a custom field button to the advanced to the field editor
add_filter( 'gform_add_field_buttons', 'ts_add_rec_field' );
function ts_add_rec_field( $field_groups ) {
    foreach( $field_groups as &$group ){
        if( $group["name"] == "advanced_fields" ){ // to add to the Advanced Fields
        //if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
        //if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
            $group["fields"][] = array(
                "class"=>"button",
                "value" => __("Audio Recorder", "gravityforms"),
                "onclick" => "StartAddField('rec');"
            );
            break;
        }
    }
    return $field_groups;
}
 

// Adds title to Audio Recorder custom field
add_filter( 'gform_field_type_title' , 'ts_rec_title' );
function ts_rec_title( $type ) {
    if ( $type == 'rec' )
        return __( 'Audio Recorder' , 'gravityforms' );
}


// Now we execute some javascript technicalitites for the field to load correctly
add_action( "gform_editor_js", "ts_gform_editor_js" );
function ts_gform_editor_js(){
?>
<script type='text/javascript'>
    jQuery(document).ready(function($) {
    	//this will show all the fields of the HTML field minus a couple that I didn't want to appear.
        fieldSettings["rec"] = ".content_setting, .css_class_setting";
    });
 
</script>
<?php
}


// add the necessary HTML to make the audio recorder field function

add_filter("gform_pre_render", "add_recorder_html");
function add_recorder_html($form) {
	$html_content = "<div><a href='javascript:record()' id='record'>Record</a><a href='javascript:play()' id='play'>Play</a><a href='javascript:stop()' id='stop'>Stop</a><a href='javascript:upload()' id='upload'>Upload (faked)</a></div><span id='time'>0:00</span>";
	
		foreach($form["fields"] as &$field)
		{
			//add the above HTML content if the field type is "rec" (custom Audio Recorder)
			if ($field["type"] == "rec")
			{
				//set the field content to the html
				$field["content"] = $html_content;
			}
		}
	//return altered form so changes are displayed
	return $form;		
}

