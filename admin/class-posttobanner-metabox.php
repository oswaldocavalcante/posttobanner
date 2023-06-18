<?php

class ptbMetaBox {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post',      array( $this, 'save'         ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		// Limit meta box to certain post types.
		$post_types = array( 'post' );

		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'ptb-meta-box',
				__( 'Post to Banner', 'textdomain' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'side',
				'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['myplugin_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) ) {
			return $post_id;
		}

		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['myplugin_new_field'] );

		// Update the meta field.
		update_post_meta( $post_id, '_my_meta_value_key', $mydata );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_my_meta_value_key', true );

        if (has_post_thumbnail( $post->ID ) ) {
            $post_thumbnail_url = get_the_post_thumbnail_url( $post , 'full' );
            $post_category = get_the_category( $post->ID );
            $post_title = get_the_title( );
        }

        ?>

        <div id="ptb-canvas-container">
            <canvas id="ptb-canvas" width="1000px" height="1000px">
                Your browser does not support the HTML canvas tag.
            </canvas>
        </div>

        <script>
            //Creating the Canva
            var canvas = document.getElementById("ptb-canvas");
            var ctx = canvas.getContext("2d");

            //Getting the logo
            var img = new Image();
            img.crossOrigin = "anonymous";
            img.src = '<?php echo $post_thumbnail_url; ?>';
            
            //Getting the background image;
            var logo = new Image();
            logo.crossOrigin = "anonymous";
            logo.src = 'https://classebiblica.org/wp-content/uploads/2023/06/classebiblica_logotipo_horizontal_branco.png';
            
            //Getting post data
            var category = '<?php echo $post_category[0]->name; ?>';
            var title = '<?php echo $post_title; ?>';
            var referenceTitle = 'já disponível em';
            var reference = 'classebiblica.org/blog';

            function myCanvas() {
                //Background
                drawImageScaled(img, ctx);

                //Darkening Background
                ctx.fillStyle = "rgba(0, 0, 0, 0.7)";
                ctx.fillRect(0, 0, 1000, 1000);

                //Adding the Logo
                ctx.drawImage(logo, 100, 100, 200, 73.48)

                //Write the Category
                ctx.fillStyle = "#fff";
                ctx.font = "600 28px Montserrat";
                ctx.fillText(category.toUpperCase(), 100, 400);
                
                //Write the Title
                ctx.font = "normal 60px Montserrat";
                let titleLines = fragmentText(title, 800);
                let y = 500;
                for (let i = 0; i < titleLines.length; i++) {            
                    ctx.fillText(titleLines[i], 100, y);
                    y = y+70;
                }

                //Write the Reference Title
                ctx.textAlign = "center";
                ctx.textBaseline = "bottom";
                ctx.font = "normal 15px Montserrat";
                ctx.fillText(referenceTitle.toUpperCase(), 500, 800);
                ctx.font = "normal 25px Montserrat";
                ctx.fillText(reference, 500, 850);
            }

            canvas.style.maxWidth = '100%';
            canvas.style.maxHeight = '100%';

            function fragmentText(text, maxWidth) {
                var words = text.split(' '),
                    lines = [],
                    line = "";
                if (ctx.measureText(text).width < maxWidth) {
                    return [text];
                }
                while (words.length > 0) {
                    var split = false;
                    while (ctx.measureText(words[0]).width >= maxWidth) {
                        var tmp = words[0];
                        words[0] = tmp.slice(0, -1);
                        if (!split) {
                            split = true;
                            words.splice(1, 0, tmp.slice(-1));
                        } else {
                            words[1] = tmp.slice(-1) + words[1];
                        }
                    }
                    if (ctx.measureText(line + words[0]).width < maxWidth) {
                        line += words.shift() + " ";
                    } else {
                        lines.push(line);
                        line = "";
                    }
                    if (words.length === 0) {
                        lines.push(line);
                    }
                }
                return lines;
            }

            function drawImageScaled(img, ctx) {
                let canvas = ctx.canvas ;
                let hRatio = canvas.width  / img.width    ;
                let vRatio =  canvas.height / img.height  ;
                let ratio  = Math.max ( hRatio, vRatio );
                let centerShift_x = ( canvas.width - img.width*ratio ) / 2;
                var centerShift_y = ( canvas.height - img.height*ratio ) / 2;  
                ctx.clearRect(0,0,canvas.width, canvas.height);
                ctx.drawImage(img, 0,0, img.width, img.height, centerShift_x,centerShift_y,img.width*ratio, img.height*ratio);  
            }

            function ptbDownload(){
                var ptbCanvas = document.getElementById("ptb-canvas");
                var banner = ptbCanvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                var link = document.createElement('a');
                link.download = "my-image.png";
                link.href = banner;
                link.click();
            }

            window.addEventListener('load', myCanvas);

        </script>

        <p><button onClick="ptbDownload()">Download</button></p>

        <?php
	}
    
}