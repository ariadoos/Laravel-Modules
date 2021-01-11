<?php
/**
 * Created by PhpStorm.
 * User: @ariadoos - Nikesh Bdr. Adhikari
 * Date: 1/10/2021
 * Time: 10:26 PM
 */

namespace Modules\Core\Services;

use Modules\Core\Traits\ResponseTraits;

class BaseService
{
    /**
     * ResponseTraits
     */
    use ResponseTraits;

    /**
     * BaseService constructor.
     */
    public function __construct() {}
}