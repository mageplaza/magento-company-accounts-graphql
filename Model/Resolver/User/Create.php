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

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\CompanyAccounts\Api\Data\UserRolesInterface;
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

        $userRule = $args['input']['mpca_role'][UserRolesInterface::USER_RULES];

        foreach ($userRule as $key => $rule) {
            $modelRule      = $this->ruleFactory->create()->setData($rule);
            $userRule[$key] = $modelRule;
        }

        $this->role                                    = $this->roleFactory->create()->setData($args['input']['mpca_role']);

        //create user
        unset($args['input']['mpca_role']);
        $user = new Users($args['input']);

        try {
            $result = $this->usersManagement->createUsers($this->customerId, $user, $args['password']);
        } catch (Exception $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        //create user role
        if (!isset($args['input']['mpca_role_id'])) {
            try {
                $resultUserRole = $this->userRolesManagement->createUserRoles($context->getUserId(), $this->role, $args['password']);
            } catch (Exception $e) {
                throw new GraphQlInputException(__($e->getMessage()));
            }
        }

        $userCompany = \Magento\Framework\App\ObjectManager::getInstance()->create(
            'Magento\Customer\Api\CustomerRepositoryInterface'
        );
        $customer = $userCompany->getById($result->getEntityId());
        $customer->setCustomAttribute('mpca_role_id',$resultUserRole->getRoleId());
        $userCompany->save($customer);

        return $result;
    }
}
