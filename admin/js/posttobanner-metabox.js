(function ($) {

    $(document).ready(function () {
        console.log('Hello.');
        // Creating canvas for Feed
        // var canvasFeed = document.getElementById("ptb-canvas-feed");
        // var contextFeed = canvasFeed.getContext("2d");
        // canvasFeed.style.maxWidth = '100%';
        // canvasFeed.style.maxHeight = '100%';

        // // Creating canvas for Story
        // var canvasStory = document.getElementById("ptb-canvas-story");
        // var contextStory = canvasStory.getContext("2d");
        // canvasStory.style.maxWidth = '100%';
        // canvasStory.style.maxHeight = '100%';

        // // Setting the background image
        // var background = new Image();
        // background.crossOrigin = "anonymous";
        // background.src = '<?php echo $post_thumbnail_url; ?>';

        // // Setting the logo
        // var logo = new Image();
        // logo.crossOrigin = "anonymous";
        // logo.src = '<?php echo wp_get_original_image_url( get_option( 'ptb_image_id' ) ); ?>';

        // // Setting post data
        // var title = '<?php echo html_entity_decode( $post_title ); ?>';
        // var excerpt = '<?php echo html_entity_decode( $post_excerpt ); ?>';

        // var category = '<?php echo get_option( 'ptb_category' ); ?>';
        // if (category == '') category = '<?php echo $post_category[0]->name; ?>';

        // var referenceTitle = '<?php echo get_option( 'ptb_footer_title' ); ?>';
        // if (referenceTitle == '') referenceTitle = 'Read now';

        // var reference = '<?php echo get_option( 'ptb_blog_url' ); ?>';
        // if (reference == '') reference = '<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>';

        // // Drawing the canva
        // function renderImageFeed(canvas, ctx) {

        //     //Background
        //     setBackground(background, ctx);
        //     let width = canvas.width;
        //     let height = canvas.height;
        //     let leftMargin = width * 0.125;
        //     let topMargin = height * 0.125;

        //     //Darkening Background
        //     ctx.fillStyle = "rgba(0, 0, 0, 0.80)";
        //     ctx.fillRect(0, 0, width, height);

        //     //Adding the Logo
        //     logo = scaleLogo(logo, 270);
        //     ctx.drawImage(logo, leftMargin, topMargin, logo.width, logo.height);

        //     //Write the Category
        //     ctx.fillStyle = "#fff";
        //     ctx.font = "600 28px Montserrat";
        //     ctx.letterSpacing = '10px';
        //     ctx.fillText(category.toUpperCase(), leftMargin, 450);

        //     //Write the Title
        //     ctx.font = "normal 60px Montserrat";
        //     ctx.letterSpacing = '0px';
        //     fillTextLines(ctx, title, 90, 800, leftMargin, 600);

        //     //Write the URL Title
        //     ctx.textAlign = "center";
        //     ctx.textBaseline = "bottom";
        //     ctx.font = "normal 20px Montserrat";
        //     ctx.fillText(referenceTitle.toUpperCase(), width / 2, 990);

        //     //Write the URL
        //     ctx.font = "normal 35px Montserrat";
        //     ctx.fillText(reference, width / 2, 1050);
        // }

        // function renderImageStory(canvas, ctx) {

        //     // Setting Background
        //     setBackground(background, ctx);

        //     // Setting properties
        //     let width = canvas.width;
        //     let height = canvas.height;
        //     ctx.textAlign = "center";

        //     //Darkening Background
        //     ctx.fillStyle = "rgba(0, 0, 0, 0.80)";
        //     ctx.fillRect(0, 0, width, height);

        //     //Adding the Logo
        //     logo = scaleLogo(logo, 270);
        //     let imageCenter = (width / 2) - (logo.width / 2);
        //     ctx.drawImage(logo, imageCenter, 220, logo.width, logo.height);

        //     //Write the Post Category
        //     ctx.fillStyle = "#fff";
        //     ctx.font = "600 32px Montserrat";
        //     ctx.letterSpacing = '10px';
        //     ctx.fillText(category.toUpperCase(), width / 2, 720);

        //     //Write the Post Title
        //     ctx.font = "normal 60px Montserrat";
        //     ctx.letterSpacing = '0px';
        //     var lastY = fillTextLines(ctx, title, 90, 800, width / 2, 860);

        //     // Write the Excerpt
        //     // ctx.font = "normal 36px Montserrat";
        //     // fillTextLines(ctx, excerpt, 60, 800, width/2, lastY + 150);

        //     //Write the URL Title
        //     ctx.textBaseline = "bottom";
        //     ctx.font = "normal 24px Montserrat";
        //     ctx.fillText(referenceTitle.toUpperCase(), width / 2, height - 380);

        //     //Write the URL
        //     ctx.font = "normal 40px Montserrat";
        //     ctx.fillText(reference, width / 2, height - 300);
        // }

        // function scaleLogo(img, maxSize) {

        //     let maxWidth = maxSize;
        //     let maxHeight = maxSize;

        //     let logoWidth = logo.width;
        //     let logoHeight = logo.height;

        //     // Change the resizing logic
        //     if (logoWidth > logoHeight) {
        //         if (logoWidth > maxWidth) {
        //             logoHeight = logoHeight * (maxWidth / logoWidth);
        //             logoWidth = maxWidth;
        //         }
        //     } else {
        //         if (logoHeight > maxHeight) {
        //             logoWidth = logoWidth * (maxHeight / logoHeight);
        //             logoHeight = maxHeight;
        //         }
        //     }

        //     img.width = logoWidth;
        //     img.height = logoHeight;

        //     return img;
        // }

        // function setBackground(img, ctx) {
        //     let canvas = ctx.canvas;
        //     let hRatio = canvas.width / img.width;
        //     let vRatio = canvas.height / img.height;
        //     let ratio = Math.max(hRatio, vRatio);
        //     let centerShift_x = (canvas.width - img.width * ratio) / 2;
        //     var centerShift_y = (canvas.height - img.height * ratio) / 2;
        //     ctx.clearRect(0, 0, canvas.width, canvas.height);
        //     ctx.drawImage(img, 0, 0, img.width, img.height, centerShift_x, centerShift_y, img.width * ratio, img.height * ratio);
        // }

        // function fillTextLines(ctx, text, lineHeight, maxWidth, x, y) {

        //     var words = text.split(' '),
        //         lines = [],
        //         line = "";

        //     if (ctx.measureText(text).width < maxWidth) {
        //         ctx.fillText(text, x, y);
        //         return;
        //     }

        //     while (words.length > 0) {
        //         var split = false;
        //         while (ctx.measureText(words[0]).width >= maxWidth) {
        //             var tmp = words[0];
        //             words[0] = tmp.slice(0, -1);
        //             if (!split) {
        //                 split = true;
        //                 words.splice(1, 0, tmp.slice(-1));
        //             } else {
        //                 words[1] = tmp.slice(-1) + words[1];
        //             }
        //         }
        //         if (ctx.measureText(line + words[0]).width < maxWidth) {
        //             line += words.shift() + " ";
        //         } else {
        //             lines.push(line);
        //             line = "";
        //         }
        //         if (words.length === 0) {
        //             lines.push(line);
        //         }
        //     }

        //     let shiftY = y;
        //     for (let i = 0; i < lines.length; i++) {
        //         ctx.fillText(lines[i], x, shiftY);
        //         shiftY = shiftY + lineHeight;
        //     }

        //     return shiftY;
        // }

        // function download(canvas, type) {
        //     let ptbCanvas = document.getElementById(canvas);
        //     let renderedImage = ptbCanvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        //     let link = document.createElement('a');
        //     link.download = "<?php echo ( 'post-' . $post->ID ); ?>" + "-" + type + ".png";
        //     link.href = renderedImage;
        //     link.click();
        // }

        // function renderImages() {
        //     renderImageFeed(canvasFeed, contextFeed);
        //     renderImageStory(canvasStory, contextStory);
        // }

        // window.addEventListener('load', renderImages);
    });

})(jQuery);