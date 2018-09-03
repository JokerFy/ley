<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/6/26
 * Time: 15:49
 */

namespace app\admin\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}