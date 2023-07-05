<?php

require_once "db_config.php";

$pdo = connectDatabase($dsn, $pdoOptions);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASS'], $pdoOptions);

    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}


/**
 * Function redirects user to given url
 *
 * @param string $url
 */
function redirection($url)
{
    header("Location:$url");
    exit();
}

/**
 * Function checks that login parameters exists in admin table
 *
 * @param PDO $pdo
 * @param string $email
 * @param string $enteredPassword
 * @return array
 */
function checkUserLogin(PDO $pdo, string $username, string $enteredPassword): array
{
    $sqlUser = "SELECT admin_id,username,password FROM admin WHERE username=:username";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':username', $username, PDO::PARAM_STR);

    $data = [];

    $stmtUser->execute();

    if($stmtUser->rowCount() > 0){
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);

    }
    $data['username'] = $result['username'];


    if ($stmtUser->rowCount() > 0) {

        $registeredPassword = $result['password'];

        if ($enteredPassword === $registeredPassword) {
            $data['admin_id'] = $result['admin_id'];
        }
    }

    return $data;
}

function userBan(PDO $pdo,string $user_ban):bool
{
    $sql = "UPDATE user SET is_banned = 1 WHERE user_id = :user_ban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_ban', $user_ban, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function userUnban(PDO $pdo,string $user_unban):bool
{
    $sql = "UPDATE user SET is_banned = 0 WHERE user_id = :user_unban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_unban', $user_unban, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}

function trainerBan(PDO $pdo,string $trainer_ban):bool
{
    $sql = "UPDATE trainer SET is_banned = 1 WHERE trainer_id = :trainer_ban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_ban', $trainer_ban, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function trainerUnban(PDO $pdo,string $trainer_unban):bool
{
    $sql = "UPDATE trainer SET is_banned = 0 WHERE trainer_id = :trainer_unban";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_unban', $trainer_unban, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function trainerApprove(PDO $pdo,string $trainer_approve):bool
{
    $sql = "UPDATE trainer SET admin_approval = 1 WHERE trainer_id = :trainer_approve";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_approve', $trainer_approve, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function trainerDelete(PDO $pdo,string $trainer_delete):bool
{
    $sql = "Delete from trainer WHERE trainer_id = :trainer_delete";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_delete', $trainer_delete, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}

function trainerProgramUnblock(PDO $pdo,string $trainer_unblock):bool
{
    $sql = "UPDATE programs SET is_hidden = 0 WHERE program_id = :trainer_unblock";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_unblock', $trainer_unblock, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function trainerProgramBlock(PDO $pdo,string $trainer_block):bool
{
    $sql = "UPDATE programs SET is_hidden = 1 WHERE program_id = :trainer_block";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_block', $trainer_block, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function userProgramBlock(PDO $pdo,string $user_block):bool
{
    $sql = "UPDATE user_programs SET is_hidden = 1 WHERE user_programs_id = :user_block";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_block', $user_block, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function userProgramUnblock(PDO $pdo,string $user_unblock):bool
{
    $sql = "UPDATE user_programs SET is_hidden = 0 WHERE user_programs_id = :user_unblock";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_unblock', $user_unblock, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}

function newCategory(PDO $pdo,string $id,$name,$description):bool
{
    $sql = "Insert into program_category VALUES(:id,:name,:description)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    try {
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}

function editCategory(PDO $pdo,string $id,$name,$description):bool
{
    $sql = "UPDATE program_category SET name=:name,description=:description WHERE category_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    try {
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}

function deleteCategory(PDO $pdo,string $id,$name,$description):bool
{
    $sql = "DELETE FROM program_category WHERE category_id=:id AND name = :name AND description = :description";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    try {
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }
    catch (\mysql_xdevapi\Exception $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
     catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}

function deleteRating(PDO $pdo,string $id):bool
{
    $sql = "Delete FROM trainer_rating WHERE rating_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    try {
        $stmt->execute();
        if($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }
    catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}