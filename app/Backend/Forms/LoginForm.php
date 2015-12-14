<?php
namespace App\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{

    public function initialize()
    {
        // Username
        $username = new Text('username', [
            'placeholder' => 'Username'
        ]);

        $username->addValidator(
            new PresenceOf([
                'message' => 'the username is required',
            ])
        );

        $this->add($username);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password'
        ]);

        $password->addValidator(
            new PresenceOf([
                'message' => 'the password is required',
            ])
        );

        $this->add($password);

        // Remember
        $remember = new Check('remember', [
            'value' => 'yes'
        ]);

        $remember->setLabel('Remember me');

        $this->add($remember);

        /*// CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('go', array(
            'class' => 'btn btn-success'
        )));*/
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}
