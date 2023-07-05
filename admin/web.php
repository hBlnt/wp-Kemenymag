<?php
session_start();
require_once "db_config.php";
require_once "functions.php";


$referer = $_SERVER['HTTP_REFERER'];

$action = $_POST["action"];

if ($action != "" and in_array($action, $actions) and strpos($referer, SITE) !== false ) {

    switch ($action) {
        case "login":
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            if (!empty($username) and !empty($password)) {
                $data = checkUserLogin($pdo, $username, $password);

                if ($data and is_int($data['admin_id'])) {

                    $_SESSION['username'] = $username;
                    $_SESSION['admin_id'] = $data['admin_id'];
                    redirection('index.php');
                }
                else {
                    redirection('login.php?l=1');
                }
            } else {
                redirection('login.php?l=1');
            }
            break;

        case "ban":
            $user_ban = $_POST["userBan"];
            $user_unban = $_POST["userUnban"];

            $trainer_ban = $_POST["trainerBan"];
            $trainer_unban = $_POST["trainerUnban"];

            $trainer_approve = $_POST['trainerApprove'];

            $trainer_delete = $_POST['trainerDelete'];
           if(!empty($user_ban))
           {
                $result = userBan($pdo,$user_ban);
                if ($result == true)
                    redirection('user_permissions.php?ub=30');
                else
                    redirection('user_permissions.php?ub=32');
           }
           elseif(!empty($user_unban))
           {
               $result = userUnban($pdo,$user_unban);
               if ($result == true)
                   redirection('user_permissions.php?ub=30');
               else
                   redirection('user_permissions.php?ub=32');
           }
           elseif(!empty($trainer_ban))
           {
               $result = trainerBan($pdo,$trainer_ban);
               if ($result == true)
                   redirection('user_permissions.php?tb=30');
               else
                   redirection('user_permissions.php?tb=32');
           }
           elseif(!empty($trainer_unban))
           {
               $result = trainerUnban($pdo,$trainer_unban);
               if ($result == true)
                   redirection('user_permissions.php?tb=30');
               else
                   redirection('user_permissions.php?tb=32');
           }
            elseif(!empty($trainer_approve))
            {
                $result = trainerApprove($pdo,$trainer_approve);
                if ($result == true)
                    redirection('user_permissions.php?tb=30');
                else
                    redirection('user_permissions.php?tb=32');
            }
            elseif(!empty($trainer_delete))
            {
                $result = trainerDelete($pdo,$trainer_delete);
                if($result == true)
                    redirection('user_permissions.php?tb=30');
                else
                    redirection('user_permissions.php?tb=32');
            }
            else
               redirection('user_permissions.php?ub=31');

            break;

        case "block":
            $trainer_program_Block = $_POST["trainer_program_Block"];
            $trainer_program_Unblock = $_POST["trainer_program_Unblock"];

            if(!empty($trainer_program_Block))
            {
                $result = trainerProgramBlock($pdo,$trainer_program_Block);
                if($result == true)
                    redirection('check_programs.php?pt=30');
                else
                    redirection('check_programs.php?pt=32');
            }
            elseif(!empty($trainer_program_Unblock))
            {
                $result = trainerProgramUnblock($pdo,$trainer_program_Unblock);
                if($result == true)
                    redirection('check_programs.php?pt=30');
                else
                    redirection('check_programs.php?pt=32');
            }
            else
                redirection('check_programs.php?pt=31');

            break;

        case "block2":

            $user_program_Block = $_POST["user_program_Block"];
            $user_program_Unblock = $_POST["user_program_Unblock"];

                if(!empty($user_program_Block))
                {
                $result = userProgramBlock($pdo,$user_program_Block);
                    if($result == true)
                        redirection('check_programs.php?pu=30');
                    else
                        redirection('check_programs.php?pu=32');
                  }
                elseif(!empty($user_program_Unblock))
                    {
                    $result = userProgramUnblock($pdo,$user_program_Unblock);
                    if($result == true)
                        redirection('check_programs.php?pu=30');
                    else
                        redirection('check_programs.php?pu=32');
                }
                else
                    redirection('check_programs.php?pu=31');

                    break;


        case "newCategory":

            if(isset($_POST['category_id']))
            {
                $id = trim($_POST["category_id"]);
            }
            if (isset($_POST['name'])) {
                $name = trim($_POST["name"]);
            }
            if (isset($_POST['description'])) {
                $description = trim($_POST["description"]);
            }

            if (empty($id)) {
                redirection('category.php?c=33');
            }
            if (empty($name)) {
                redirection('category.php?c=34');
            }
            if (empty($description)) {
                redirection('category.php?c=35');
            }

                $result = newCategory($pdo,$id,$name,$description);
                if($result == true)
                    redirection('category.php?c=36');
                else
                    redirection('category.php?c=32');

            break;

        case "editCategory":

            if(isset($_POST['category_id']))
            {
                $id = trim($_POST["category_id"]);
            }
            if (isset($_POST['name'])) {
                $name = trim($_POST["name"]);
            }
            if (isset($_POST['description'])) {
                $description = trim($_POST["description"]);
            }

            if (empty($id)) {
                redirection('category.php?c=33');
            }
            if (empty($name)) {
                redirection('category.php?c=34');
            }
            if (empty($description)) {
                redirection('category.php?c=35');
            }

            $result = editCategory($pdo,$id,$name,$description);
            if($result == true)
                redirection('category.php?c=37');
            else
                redirection('category.php?c=32');

            break;

        case "deleteCategory":

            if(isset($_POST['category_id']))
            {
                $id = trim($_POST["category_id"]);
            }
            if (isset($_POST['name'])) {
                $name = trim($_POST["name"]);
            }
            if (isset($_POST['description'])) {
                $description = trim($_POST["description"]);
            }

            if (empty($id)) {
                redirection('category.php?c=33');
            }
            if (empty($name)) {
                redirection('category.php?c=34');
            }
            if (empty($description)) {
                redirection('category.php?c=35');
            }

            $result = deleteCategory($pdo,$id,$name,$description);
            if($result == true)
                redirection('category.php?c=38');
            else
                redirection('category.php?c=32');

            break;

        case "deleteRating":

            $delete_rating = $_POST['deleteButton'];

            if(!empty($delete_rating))
            {
                $result = deleteRating($pdo,$delete_rating);
                if($result == true)
                    redirection('trainer_ratings.php?t=30');
                else
                    redirection('trainer_ratings.php?t=32');
            }
            else
                redirection('trainer_ratings.php?t=31');

            break;

        default:
            redirection('login.php?l=1');
            break;
    }
}
else {
    redirection('login.php?l=1');
}