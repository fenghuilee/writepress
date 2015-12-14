<?php
namespace Dsc\Admin\Models;

/**
 * EmailConfirmations
 * Stores the reset password codes and their evolution
 */
class EmailConfirmations extends \Phalcon\Mvc\Collection
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $usersId;

    public $code;

    /**
     *
     * @var integer
     */
    public $createdAt;

    /**
     *
     * @var integer
     */
    public $modifiedAt;

    public $confirmed;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();

        // Generate a random confirmation code
        $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

        // Set status to non-confirmed
        $this->confirmed = 'N';
    }

    /**
     * Sets the timestamp before update the confirmation
     */
    public function beforeValidationOnUpdate()
    {
        // Timestamp the confirmaton
        $this->modifiedAt = time();
    }

    /**
     * Send a confirmation e-mail to the user after create the account
     */
    public function afterCreate()
    {
        /*
        $this->getDI()
            ->getMail()
            ->send(array(
            $this->email => $this->first_name . " " . $this->last_name 
        ), "Please confirm your email", 'confirmation', array(
            'confirmUrl' => '/confirm/' . $this->code . '/' . $this->email
        ));
        */
    }

    public function initialize()
    {
        /*
        $this->belongsTo('usersId', 'Dsc\Admin\Models\Users', 'id', array(
            'alias' => 'user'
        ));
        */
    }
}