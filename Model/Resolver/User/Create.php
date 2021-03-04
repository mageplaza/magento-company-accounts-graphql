<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CompanyAccountsGraphQl
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

declare(strict_types=1);

namespace Mageplaza\CompanyAccountsGraphQl\Model\Resolver\User;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\CompanyAccounts\Model\Api\Data\Users;
use Mageplaza\CompanyAccountsGraphQl\Model\Resolver\AbstractResolver;

/**
 * Class Create
 * @package Mageplaza\CompanyAccountsGraphQl\Model\Resolver\User
 */
class Create extends AbstractResolver
{
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        parent::resolve($field, $context, $info, $value, $args);

        $user = new Users($args['input']);

        return $this->usersManagement->createUsers($this->customerId, $user, $args['password']);
    }
}