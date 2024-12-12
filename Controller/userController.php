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
                'admin' => $result->getAdmin() // Ajoutez cette ligne
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

    private function isAdmin()
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
}
