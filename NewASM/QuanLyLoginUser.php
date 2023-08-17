<?
session_start();
if (!isset($_SESSION['errors'])) {
    $_SESSION['errors'] = [];
}
include("./provider.php");
$admins = array(
    array(
        "username" => 'admin',
        'password' => '123456'
    ),
    array(
        "username" => 'admin1',
        'password' => '123456'
    ),
    array(
        "username" => 'admin2',
        'password' => '123456'
    ),
    array(
        "username" => 'admin3',
        'password' => '123456'
    ),
);
if (isset($_POST['SignUp'])) {
    if (
        isset($_POST['UsernameRegister']) &&
        isset($_POST['EmailRegister']) &&
        isset($_POST['PasswordRegister']) &&
        isset($_POST['CPasswordRegister'])
    ) {
        $UsernameR = trim(htmlspecialchars($_POST['UsernameRegister']));
        $EmailR = trim($_POST['EmailRegister']);
        $PasswordR = trim($_POST['PasswordRegister']);
        $CPasswordR = trim($_POST['CPasswordRegister']);
        if (strlen($UsernameR) < 1) {
            $_SESSION['errors'][] = "Username can not empty";
        }
        if (strlen($PasswordR) < 1) {
            $_SESSION['errors'][] = "Password can not empty";
        }
        if (strlen($CPasswordR) < 1) {
            $_SESSION['errors'][] = "Confirm password can not empty";
        }
        if ($PasswordR != $CPasswordR) {
            $_SESSION['errors'][] = "Password not match";
        }
        $errors = $_SESSION['errors'];
        if (isset($connection) && count($errors) < 1) {
            try {
                $sql1 = "SELECT * FROM users where username = :username";
                $statement1 = $connection->prepare($sql1);
                $statement1->execute([
                    ':username' => $UsernameR
                ]);
                $result = $statement1->setFetchMode(PDO::FETCH_ASSOC);
                $count_user = count($statement1->fetchAll());
                if ($count_user > 0) {
                    $_SESSION['errors'][] = "Username already exists!";
                } else {
                    $sql = "INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
                    $statement = $connection->prepare($sql);
                    if ($statement->execute([
                        ':username' => $UsernameR,
                        ':password' => password_hash($PasswordR, PASSWORD_DEFAULT),
                        ':email' => $EmailR
                    ])) {
                        $_SESSION['MessageSuccess'] = 'Create Success';
                        header("Location: login.php");
                        exit;
                    } else {
                        $_SESSION['MessageSuccess'] =  "Create not success";
                    }
                }
            } catch (Exception $err) {
                echo $err->getMessage();
            }
        } else {
            header("Location: login.php");
            exit;
        }
    }
}
?>
<?
if (isset($_POST['Login'])) {
    require("./User.php");
    if (
        isset($_POST['UsernameLogin']) &&
        isset($_POST['PasswordLogin'])
    ) {
        $UsernameL = trim($_POST['UsernameLogin']);
        $PasswordL = trim($_POST['PasswordLogin']);
        if (strlen($UsernameL) < 1) {
            $_SESSION['errors'][] = "Username can not empty";
        }
        if (strlen($PasswordL) < 1) {
            $_SESSION['errors'][] = "Password can not empty";
        }
        if (isset($connection) && count($_SESSION['errors']) < 1) {
            if (isset($_POST['checkbox'])) {
                $Check = true;
                $_SESSION['Check'] = $Check;
            } else {
                $Check = false;
                $_SESSION['Check'] = $Check;
            }
            if ($_SESSION['Check']) {
                $Acct = array(
                    'username' => $UsernameL,
                    'password' => $PasswordL,
                );
                $_SESSION['RememberAcct'] = $Acct;
            } else {
                unset($_SESSION['RememberAcct']);
            }
            try {
                $sql = "SELECT * FROM users where username = :username";
                $statement1 = $connection->prepare($sql);
                $statement1->execute([
                    ':username' => $UsernameL,
                ]);
                $result = $statement1->setFetchMode(PDO::FETCH_ASSOC);
                $result1 = $statement1->fetchAll();
                $user = $statement1->rowCount();
                if ($user > 0) {
                    $currentPass = $result1[0]['password'];
                    if (password_verify($PasswordL, $currentPass)) {
                        $user =  new User(
                            $result1[0]['userId'],
                            $result1[0]['username'],
                            $result1[0]['role'],
                            $result1[0]['email']
                        );
                        $_SESSION['currentUser'] = $user->serialize();
                        $CheckAdmin = false;
                        $UsernameAdmin = "";
                        foreach ($admins as $admin => $Value) {
                            if ($user->username == $Value['username']) {
                                $CheckAdmin = true;
                                $UsernameAdmin = $Value['username'];
                            }
                        }
                        if ($CheckAdmin) {
                            $statement1 = $connection->prepare("UPDATE users SET role = 1 where username = :username");
                            if ($statement1->execute([
                                'username' => $UsernameAdmin
                            ])) {
                                $user->role = 1;
                            }
                        }
                        if ($result1[0]['ban_status'] == 1) {
                            header('Location: index.php');
                            exit;
                        } else {
                            unset($_SESSION['currentUser']);
                            header("Location: 404.php");
                            exit;
                        }
                    } else {
                        $_SESSION['errors'][] = "Username or password invalid";
                        header('Location: login.php');
                    }
                } else {
                    $_SESSION['errors'][] = "Username or password invalid";
                    header('Location: login.php');
                }
            } catch (Exception $err) {
                echo $err->getMessage();
            }
        } else {
            header('Location: login.php');
            exit;
        }
    }
}
?>
