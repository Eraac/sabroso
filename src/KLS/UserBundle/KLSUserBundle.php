<?php

namespace KLS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KLSUserBundle extends Bundle
{
    public function getParent()
    {
        return "FOSUserBundle";
    }
}
