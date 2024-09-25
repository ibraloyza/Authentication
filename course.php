<?php 
include './config/dbconn.php';
include ('./authentication.php'); 
include('./includes/header.php');
include('./includes/navbar.php');

if(isset($_POST['submit'])){
    $course_Name = $_POST['course_name'];
    $file_Name = $_FILES['image']['name']; // Change this to 'image'
    $tempName = $_FILES['image']['tmp_name']; // Corrected 'tempName' to 'tmp_name'
    $folder = 'images/' . $file_Name;
    $desc_course = $_POST['description'];

    // Insert course into the database
    $query = "INSERT INTO courses(course_name, course_image, description) 
              VALUES ('$course_Name', '$file_Name', '$desc_course')";
    $result_query = mysqli_query($conn, $query);

    // Move uploaded file
    if(move_uploaded_file($tempName, $folder)){
        echo "<h2>File uploaded successfully</h2>";
    } else {
        echo "<h2>File upload failed</h2>"; 
    }
}

?>

<div class="">
    <div class="card-header">
        <h5>Upload the Course</h5>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="course_image">Course Image:</label>
                <input type="file" name="image" class="form-control" required> <!-- Changed to 'image' -->
            </div>
            <div class="form-group mb-3">
                <label for="course_name">Course Name:</label>
                <input type="text" name="course_name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="teacher_id">Assign Teacher:</label>
                <select name="teacher_id" class="form-control" required>
                    <option value="" disabled selected>Select a teacher</option>
                    <?php
                    // Fetch all teachers from the teachers table
                    $teachers = mysqli_query($conn, "SELECT * FROM teachers");
                    while ($teacher = mysqli_fetch_assoc($teachers)) {
                        echo "<option value='{$teacher['teacher_id']}'>{$teacher['teacher_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>           
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Add Course">
            </div>
        </form>
    </div>
    <div>
        <?php 
        // Display uploaded image
        if(isset($file_Name)){
            echo "<img src='images/$file_Name' class='rounded mx-auto d-block' alt='Course Image'>";
        }
        ?>
    </div>

</div>

<?php include ('./includes/footer.php'); ?>
