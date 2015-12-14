<?php

namespace App\Backend\Controllers;

use App\Common\Controllers\BaseController;
use App\Backend\Forms\LoginForm;

class PassportController extends BaseController
{
    public function indexAction()
    {
        print_r(new \App\Common\Models\User);
    }

    public function loginAction()
    {
        $this->smarty->assign('error',$this->flashSession->getMessages());
        $this->html;
    }

    public function doLoginAction()
    {
        $form = new LoginForm();
        try {
            $credentials = $this->request->getPost();
            if ($form->isValid($credentials) === false) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->message($message->getField(), $message->getMessage());
                }
                return $this->redirect('dashboard/passport/login');
            } else {
                // wrap this in a try/catch for now
                try {
                    $this->auth->login($credentials);
                    return $this->redirect('dashboard');
                } finally {
                    return $this->redirect('dashboard/passport/login');
                }
            }
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
        }
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->logout();

        return $this->response->redirect('/');
    }

}
?>
