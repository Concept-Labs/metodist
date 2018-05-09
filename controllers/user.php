<?php
Class Controller_User Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }

    public function index() 
    {
        $template = $this->_initTemplate('Користувач');
        
        $template->set("data", "Вход", false);
        $template->setFile('templates/user.phtml');
        
        $this->_renderLayout($template);
    }

    public function login() 
    {
        $template = $this->_initTemplate('Вхід');

        $template->setFile('templates/user/login.phtml');

        $db = $this->_registry->get('db');
        
        
        $errorsl = array();
        //для дебага розкоментувати слід срочку
        //print_r($data); die;
        //тут реєструємо
        //проверяем данні
        if (isset($_POST['login'])) {    !        
            $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
            $password = htmlspecialchars(stripslashes(md5($_POST['password'])));

            $result = mysqli_query($db, "SELECT * FROM users WHERE email='$email'");
            $row = mysqli_fetch_array($result);

            if (empty(trim($_POST['email']))) {
                $errorsl = 'Введіть email!';
            }
            elseif (empty($row['id'])) {
                $errorsl = 'Невірний email!';
            } 
            elseif (empty($_POST['password'])) {
                $errorsl = 'Введіть пароль!';
            } 
            elseif (empty($row['password'] == $password)) {
                $errorsl = 'Невірний пароль!';
            }

            if (empty($errorsl)) {
                $_SESSION['email']=$row['email']; 
                $_SESSION['id']=$row['id'];
            }

        }
             

        $template->set('errorsl', $errorsl);
        mysqli_close($db);
        
        $this->_renderLayout($template);
    }

    public function registration() 
    {
        $template = $this->_initTemplate('Реєстрація');
        

        $template->setFile('templates/user/registration.phtml');

        $db = $this->_registry->get('db');

        $data = $_POST;
        $template->set('data', $data);
        $errors = array();
        //для дебага розкоментувати слід срочку
        //print_r($data); die;
        //тут реєструємо
        //проверяем данні
        if (isset($data['enter'])) {
            $name = htmlspecialchars(stripslashes(trim($data['name'])));
            $surname = htmlspecialchars(stripslashes(trim($data['surname'])));
            $patronymic = htmlspecialchars(stripslashes(trim($data['patronymic'])));
            $email = htmlspecialchars(stripslashes(trim($data['email'])));
            $password = htmlspecialchars(stripslashes(md5($data['password'])));

            $_SESSION['name']=$name; 
            $_SESSION['patronymic']=$patronymic;

            $result = mysqli_query($db, "SELECT id FROM users WHERE email='$email'");
            $myrow = mysqli_fetch_array($result);
            
            if (empty(trim($data['name']))) {
                $errors = "Введіть і'мя!";
            } 
            elseif (empty(trim($data['surname']))) {
                $errors = 'Введіть прізвище!';
            } 
            elseif (empty(trim($data['patronymic']))) {
                $errors = 'Введіть по батькові!';
            } 
            elseif (empty($data['pol'])) {
                $errors = 'Вкажіть свою стать!';
            } 
            elseif (empty(trim($data['email']))) {
                $errors = 'Введіть email!';
            }
            elseif (!empty($myrow['id'])) {
                $errors = 'Вибачте, введений вами email вже зареєстрований. Введіть, будь ласка, другий email!';
            } 
            elseif (empty($data['password'])) {
                $errors = 'Введіть пароль!';
            } 
            elseif ($data['password'] != $data['password-confirm']) {
                $errors = 'Пароль і підтвердження пароля не співпадають!';
            }

            if (empty($errors)) { //нема помилки
              //дата народження в форматі MySql - 1983-03-21
                $birthDate = date('Y-m-d', strtotime($_POST['year'].'/'. $_POST['month'] .'/'. $_POST['day']));
                
                //тут записиваем в базу данних
                /* @var $db PDO */
                $sql = mysqli_query($db, "INSERT INTO `users` (`id`, `name`, `surname`, `patronymic`, `pol`, `date`, `email`, `password`, `date_registration`) "
                    ." VALUES (null, '{$name}', '{$surname}', '{$patronymic}', '{$data['pol']}', '{$birthDate}',"
                    ." '{$email}', '{$password}', NOW());");
                header("Location: /user/registrationSuccess"); /* Redirect browser */
                exit();
            }
            
        }
        $template->set('errors', $errors);
        mysqli_close($db);       
        $this->_renderLayout($template, true);
    }
    
    
    public function registrationSuccess()
    {
        $template = $this->_initTemplate('Реєстрація');
        $template->setFile('templates/user/registration-success.phtml');

        $this->_renderLayout($template, true);
    }
    public function logout() 
    {
        $template = $this->_initTemplate('Вихід');

        $template->setFile('templates/user/logout.phtml');

        $this->_renderLayout($template, true);
    }
}