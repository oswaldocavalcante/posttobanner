<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Posttobanner
 * @subpackage Posttobanner/admin/partials
 */
?>

<?php

$args = array (
  'post_status' => 'publish',
  'posts_per_page' => '-1',
);

$posts = get_posts( $args );

if ( $posts ) {
    global $post;

	foreach ( $posts as $post ) :
		setup_postdata( $post ); ?>

        <div id="<?php echo $post->ID ?>">
            <h2 id="<?php echo 'my_title'; ?>"><?php the_title(); ?></h2>

            <?php if (has_post_thumbnail( $post->ID ) ) {
                $post_thumbnail_url = get_the_post_thumbnail_url( $post , 'full' );
                $post_category = get_the_category( $post->ID );
            }
            break;
            ?>

        </div>

	    <?php wp_reset_postdata();
	endforeach; 
}

?>

<canvas id="myCanvas" width="1000px" height="1000px"
style="border:1px solid #d3d3d3;">
Your browser does not support the HTML canvas tag.</canvas>

<p><button onClick="myCanvas()">Try it</button></p>

<script>
    var canvas = document.getElementById("myCanvas");
    var ctx = canvas.getContext("2d");
    var img = new Image();
    var logo = new Image();
    var title = document.getElementById("my_title");
    var category = '<?php echo $post_category[0]->name; ?>';
    var referenceTitle = 'Leia o artigo em';
    var reference = 'classebiblica.org/blog';

    function myCanvas() {
        ctx.drawImage(img,0,0);
        ctx.fillStyle = "rgba(0, 0, 0, 0.75)";
        ctx.fillRect(0, 0, 1000, 1000);
        ctx.drawImage(logo, 100, 100, 200, 73.48)

        //Write the Category
        ctx.fillStyle = "#fff";
        ctx.font = "600 30px Montserrat";
        ctx.fillText(category.toUpperCase(), 100, 400);
        
        //Write the Title
        ctx.font = "normal 60px Montserrat";
        var titleLines = fragmentText(title.innerHTML, 800);
        let y = 500;
        for (var i = 0; i < titleLines.length; i++) {            
            ctx.fillText(titleLines[i], 100, y);
            y = y+70;
        }

        //Write the Reference
        ctx.textAlign = "center";
        ctx.textBaseline = "bottom";
        ctx.font = "normal 20px Montserrat";
        ctx.fillText(referenceTitle.toUpperCase(), 500, 850);
    }

    img.src = '<?php echo $post_thumbnail_url; ?>';
    logo.src = 'https://classebiblica.org/wp-content/uploads/2023/06/classebiblica_logotipo_horizontal_branco.png';

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

    document.onLoad(myCanvas());

</script>

