<?php
include '../db.php'; // Make sure to include your database connection file
$query = "SELECT * FROM course";
$result = mysqli_query($conn, $query);
$course = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
} 

// Print the courses array
 print_r($course)
?>


<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>

    <body>
        
    <div class="row">


<?php

if(!empty($courses)){

    foreach ($courses as $course) {
    

    ?>



        <div class="col-12 col-lg-3 col-md-4">
            <div class="card" style="width: 18rem;">
                <img src="<?php echo $course['thumbnail'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $course['title'] ?> </h5>
                    <p class="card-text">Description: <?php echo $course['description'] ?></p>
                    <br>
                    <p class="card-text">Duration : <?php echo $course['duration'] ?></p>
                    <form method="post">
                        <input type="hidden" name="course_id" id="course_id" value="<?php echo $course['course_id'] ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>

                    <!-- for more data to transfer on get method -->

                    <form action="editcourse.php" method="get">

                        <input type="hidden" name="course_id" id="course_id" value="<?php echo $course['course_id'] ?>">

                        <button type="submit" class="btn btn-Primary">Edit</button>


                    </form>

                    <!-- // for single or two data transfer on get method -->

                    <a href="editcourse.php?course_id=<?php echo $course['course_id'] ?>" class="btn btn-primary">Edit</a>
                
                </div>
            </div>
        </div>


    


    <?php

    }

} else {
    ?>

<h1> Sorry No courses Found. Please create new Course </h1>

<?php
}


?>

</div>







</body>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>

   






55