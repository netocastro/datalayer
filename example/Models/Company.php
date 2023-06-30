<?php

namespace Example\Models;

use NTTech\DataLayer\DataLayer;

class Company extends DataLayer
{
    public function __construct()
    {
        parent::__construct("companies", ["user_id", "name"]);
    }
}