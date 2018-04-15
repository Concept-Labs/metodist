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
        $template = $this->_initTemplate('Вход');
        
        
        $template->setFile('templates/user/login.phtml');
        
        $this->_renderLayout($template);
    }

    public function registration() 
    {
        $template = $this->_initTemplate('Регистрация');
        
       
        $template->setFile('templates/user/registration.phtml');
        
        $this->_renderLayout($template, true);
    }
    
    public function registrationPost()
    {
        $data = $_POST;
        //для дебага розкоментувати слід срочку
        //print_r($data); die;
        
        //проверяем данні
        if($data['password'] != $data['password-confirm']){
            $_SESSION['error'] = 'Помилка: пароль і підтвердження пароля не співпадають';
        }
        if(empty($data['name'])){
            $_SESSION['error'] = 'Помилка: поле імя не може бути пустим';
        } elseif(empty($data['surname'])) {
            $_SESSION['error'] = 'Помилка: поле прізвище не може бути пустим';
        }elseif(empty($data['patronymic'])) {
            $_SESSION['error'] = 'Помилка: поле побатькові не може бути пустим';
        }elseif(empty($data['pol'])) {
            $_SESSION['error'] = 'Помилка: вкажіть свою стать';
        }elseif(empty($data['email'])) {
            $_SESSION['error'] = 'Помилка: вкажіть свій email';
        }elseif(empty($data['password'])) {
            $_SESSION['error'] = 'Помилка: вкажіть свій пароль';
        }//elseif(...  дальше добавте інші провірки
        else { //нема помилки
            try {
                //дата народження в форматі MySql - 1983-03-21
                $birthDate = date('Y-m-d', strtotime($_POST['year'].'/'. $_POST['month'] .'/'. $_POST['day']));
                
                //тут записиваем в базу данних
                $db = $this->_registry->get('db');
                /* @var $db PDO */
                $sql = "INSERT INTO `user` (`id`, `name`, `surname`, `patronymic`, `pol`, `date`, `email`, `password`, `country`) "
                    ." VALUES (null, '{$data['name']}', '{$data['surname']}', '{$data['patronymic']}', '{$data['pol']}', '{$birthDate}',"
                    ." '{$data['email']}', '{$data['password']}', '{$data['country']}');";
                $db->query($sql);
                if($db->errorCode() != '00000'){
                    $error = $db->errorInfo();
                    $_SESSION['error'] = $error[2];
                }
                //розкоментувати слід строчку для емуляції помилки
                // throw new Exception('Помилка: нету записи в базу');
            } catch (Exception $ex) {
                //тут обрабативаем ошибку
                $_SESSION['error'] = $ex->getMessage();
            }
        }
        
        if(isset($_SESSION['error'])){
            header("Location: /user/registration");
            exit();
        }
        //если все ок - идем на сакес пейдж
        header("Location: /user/registrationSuccess"); /* Redirect browser */
        exit();
    }
    
    public function registrationSuccess()
    {
        $template = $this->_initTemplate('Регистрация');
        $template->setFile('templates/user/registration-success.phtml');
        $this->_renderLayout($template, true);
    }
}