<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        //check if email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //if email is valid
            //check if email already exist in database or not
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){ //if email already exist
                echo "$email - This email already exist!";
            }else{
                //check if user upload img or not
                if(isset($_FILES['image'])){ //if file is uploaded
                    $img_name = $_FILES['image']['name']; //get user uploaded img name
                    $img_type = $_FILES['image']['type']; // get user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name']; // this tmp name is used to save file in img folder
                    
                    //explode img and get the extension
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode); //get the extension of uploaded img
    
                    $extensions = ["jpeg", "png", "jpg"]; //valid img extensions which are stored in array
                    if(in_array($img_ext, $extensions) === true){ //if uploaded img extension is the same as any array extensions
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time(); //this will return current time
                                            //use this time, when img is uploading in img folder, we rename img file with current time
                                            //with that all the imgs will have unique name - id
                            //here move uploaded img in img folder
                            $new_img_name = $time.$img_name;

                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){ //if uploaded img was moved successfuly
                                $ran_id = rand(time(), 100000000); //create random id for users
                                $status = "Active now"; //when user signed up his status will change to active
                                $encrypt_pass = md5($password);

                                //insert all user data inside table
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");

                                if($insert_query){ //if these data is inserted 
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id']; //using this session we used user uniqueID in other php files
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>