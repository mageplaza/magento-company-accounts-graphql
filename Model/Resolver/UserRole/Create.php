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

namespace Mageplaza\CompanyAccountsGraphQl\Model\Resolver\UserRole;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\CompanyAccounts\Api\Data\UserRolesInterface;
use Mageplaza\CompanyAccountsGraphQl\Model\Resolver\AbstractResolver;

/**
 * Class Create
 * @package Mageplaza\CompanyAccountsGraphQl\Model\Resolver\UserRole
 */
class Create extends AbstractResolver
{
    /**
     * @var UserRolesInterface
     */
    protected $role;

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        parent::resolve($field, $context, $info, $value, $args);

        $userRule = $args['input'][UserRolesInterface::USER_RULES];

        foreach ($userRule as $key => $rule) {
            $modelRule      = $this->ruleFactory->create()->setData($rule);
            $userRule[$key] = $modelRule;
        }

        $args['input'][UserRolesInterface::USER_RULES] = $userRule;
        $this->role                                    = $this->roleFactory->create()->setData($args['input']);

        return $this->userRolesManagement->createUserRoles($this->customerId, $this->role, $args['password']);
    }
}
