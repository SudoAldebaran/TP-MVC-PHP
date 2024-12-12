<?php
class userController
{
    private $userManager;
    private $user;
    public function __construct($db1)
    {
        require('./Model/User.class.php');
        require_once('./Model/userManager.class.php');
        $this->userManager = new UserManager($db1);
        $this->db = $db1;
    }

    public function home()
    {
        $page = 'home';
        require('./View/main.php');
    }

    public function login()
    {
        $page = 'login';
        require('./View/main.php');
    }

    public function doLogin()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = $this->userManager->findByEmailAndPassword($email, $password);

        if ($result) {
            $_SESSION['user'] = [
                'firstName' => $result->getFirstName(),
                'lastName' => $result->getLastName(),
                'admin' => $result->getAdmin(),
                'email' => $result->getEmail()
            ];
            header('Location: index.php?ctrl=user&action=home');
            exit();
        } else {
            $info = "Identifiants incorrects.";
        }

        require('./View/main.php');
    }

    public function doCreate()
    {
        var_dump($_POST);
        if (
            isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['lastName']) &&
            isset($_POST['firstName']) &&
            isset($_POST['address']) &&
            isset($_POST['postalCode']) &&
            isset($_POST['city'])
        ) {
            $alreadyExist = $this->userManager->findByEmail($_POST['email']);

            if (!$alreadyExist) {
                $newUser = new User($_POST);
                $this->userManager->create($newUser);

                $page = 'login';
                header('Location: index.php?ctrl=user&action=login');
                exit();
            } else {
                $error = "ERROR : This email (" . $_POST['email'] . ") is used by another user";
                $page = 'Error';
            }
        } else {
            $page = 'createAccount';
        }
        require('./View/main.php');
    }

    public function logout()
    {
        session_start();

        session_unset();

        session_destroy();

        header('Location: index.php?ctrl=user&action=home&logout=true');
        exit();
    }

    public function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['admin'] == 1;
    }

    public function userList()
    {
        if ($this->isAdmin()) {
            $users = $this->userManager->getAllUsers();
            $page = 'userList';
            require('./View/main.php');
        } else {
            $page = 'unauthorized';
            require('./View/main.php');
        }
    }

    public function deleteUser()
    {
        
        if (!$this->isAdmin()) {
            
            header('Location: index.php?ctrl=user&action=unauthorized');
            exit();
        }

        
        $userEmail = $_POST['userEmail'] ?? null;

        if ($userEmail && $userEmail !== $_SESSION['user']['email']) {
            
            $result = $this->userManager->deleteUserByEmail($userEmail);

            if ($result) {
                
                header('Location: index.php?ctrl=user&action=userList&success=1');
            } else {
                
                header('Location: index.php?ctrl=user&action=userList&error=1');
            }
            exit();
        }
    }

    public function editUser()
    {
        
        if (!$this->isAdmin()) {
            header('Location: index.php?ctrl=user&action=unauthorized');
            exit();
        }

        $originalEmail = $_POST['originalEmail'] ?? null;
        $newEmail = $_POST['email'] ?? null;
        $firstName = $_POST['firstName'] ?? null;
        $lastName = $_POST['lastName'] ?? null;
        $admin = $_POST['admin'] ?? null;

        
        if ($originalEmail && $newEmail && $firstName && $lastName && $admin !== null) {
            
            $result = $this->userManager->updateUser($originalEmail, [
                'email' => $newEmail,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'admin' => $admin
            ]);

            if ($result) {
                
                header('Location: index.php?ctrl=user&action=userList&success=1');
            } else {
                
                header('Location: index.php?ctrl=user&action=userList&error=1');
            }
            exit();
        }
    }
}
