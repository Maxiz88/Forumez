<?php

class UserIdentity extends CUserIdentity {

    // Будем хранить id.
    protected $_id;

    // Данный метод вызывается один раз при аутентификации пользователя.
    public function authenticate() {
        // Производим стандартную аутентификацию, описанную в руководстве.
        $user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        if ($user->ban == 0)
            die('You have banned! Wait for activation from admin.');
        //если в БД в поле ban значение 0, то у юзера бан (пустая страница с сообщением)
        if (($user === null) || (md5('sdfdsf[]\/>' . $this->password) !== $user->password)) {
            //если юзера нет или введенный пароль с формы не равен паролю из базы-- выводим ошибку 
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            // В качестве идентификатора используем id, а не username

            $this->_id = $user->id;

            $this->username = $user->username;

            //приравниваем имена
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
