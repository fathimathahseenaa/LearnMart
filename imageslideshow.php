<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slideshow</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .slideshow-container {
            width: calc(100% - 60px); /* Adjust the width to account for padding */
            height: 500px; /* Set a specific height for the container */
            position: relative;
            margin: auto;
            padding: 0 30px; /* Add padding to the left and right */
        }
        .mySlides {
            display: none;
            height: 100%;
        }
        img {
            vertical-align: middle;
            width: calc(100% - 20px); /* Adjust the width to account for margin */
            height: 100%; /* Set the height to 100% of the container */
            object-fit: cover; /* Ensures the images cover the area without distortion */
            margin: 0 10px; /* Add margin to the left and right */
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            z-index: 2; /* Ensure the arrows are above the images */
            color: rgba(0,0,0,0.8); /* Display arrows by default */
        }
        .next {
            right: 10px; /* Position inside the image */
            border-radius: 3px 0 0 3px;
        }
        .prev {
            left: 10px; /* Position inside the image */
            border-radius: 3px 0 0 3px;
        }
        .transparent-text {
            color: rgba(255, 255, 255, 0.96); /* White color with 50% transparency */
        }
        .imageslideshow {
            margin-bottom: 20px; /* Adjust the value as needed */
                margin-top: 20px; /* Adjust the value as needed to move down from navbar */
        }
    </style>
</head>
<body>

<div class="imageslideshow">
    <div class="slideshow-container">
        
        <?php
        $images = glob("images/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        foreach ($images as $index => $image) {
            echo '<div class="mySlides">';
            echo '<img src="'.$image.'" alt="Image '.$index.'">';
            echo '</div>';
        }
        ?>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    
    </div>
</div>
<script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex-1].style.display = "block";
        setTimeout(showSlides, 10000); // Change image every 10 seconds
    }

    function plusSlides(n) {
        slideIndex += n - 1;
        showSlides();
    }
</script>

</body>
</html>
