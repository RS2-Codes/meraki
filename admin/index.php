<?php
include_once('assets/check.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion of all type form</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box
        }

        .margin-20 {
            margin: 20px;
        }
    </style>
</head>

<body>

    <div class="margin-20">
        <form action="assets/check.php" method="post" enctype="multipart/form-data">
            <input type="text" name="main_course" placeholder="Main Course Category" required>
            <input type="submit" name="main_course_insert" value="Insert">
        </form>
    </div>

    <div class="margin-20">
        <?php
        $menu_data = new menuData;
        $main_course_details = $menu_data->mainCourseFetch();
        echo "<pre>";
        print_r($main_course_details[0]);
        echo "</pre>";
        if ($main_course_details[1] == 0) {
            echo "No Main Course Category";
        } else { ?>
            <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <select name="main_course_category" required>
                    <option selected disabled hidden value="">Select Main Course Category</option>
                    <?php
                    foreach ($main_course_details[0] as $key) {
                        echo '<option value="' . $key['main_course_id'] . '">' . $key['main_menu_name'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="main_course" placeholder="Main Category" required>
                <input type="submit" name="main_insert" value="Insert">
            </form>
        <?php } ?>
    </div>

    <div class="margin-20">
        <?php
        $main_menu_details = $menu_data->mainMenuFetch();
        echo "<pre>";
        print_r($main_menu_details[0]);
        echo "</pre>";
        if ($main_menu_details[1] == 0) {
            echo "No Main Course Category";
        } else { ?>
            <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <select name="menu_category" required>
                    <option selected disabled hidden value="">Select Main Course Category</option>
                    <?php
                    foreach ($main_menu_details[0] as $key) {
                        echo '<option value="' . $key['menu_id'] . '">' . $key['menu_name'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="sub_menu_name" placeholder="Sub Menu Category" required>
                <input type="number" name="sub_menu_price" min="0" placeholder="Price" required>
                <input type="submit" name="sub_menu_insert" value="Insert">
            </form>
        <?php } ?>
    </div>
</body>

</html>