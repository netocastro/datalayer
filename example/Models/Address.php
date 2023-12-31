<?php

namespace Example\Models;

use NTTech\DataLayer\DataLayer;

/**
 * Class Address
 * @package Example\Models
 */
class Address extends DataLayer
{
    /**
     * Address constructor.
     */
    public function __construct()
    {
        parent::__construct("adresses", ["user_id"]);
    }

    /**
     * @return $this
     */
    public function getUser(): Address
    {
        $this->user = (new User())->findById($this->user_id)->data();
        return $this;
    }
}