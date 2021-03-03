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

namespace Mageplaza\CompanyAccountsGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\CompanyAccounts\Model\Api\CompanyManagement;
use Mageplaza\CompanyAccounts\Model\Api\UsersManagement;
use Mageplaza\CompanyAccounts\Model\Api\UserRolesManagement;
use Magento\CustomerGraphQl\Model\Customer\GetCustomer;
use Mageplaza\CompanyAccounts\Helper\Data as HelperData;

/**
 * Class AbstractResolver
 * @package Mageplaza\CompanyAccountsGraphQl\Model\Resolver
 */
class AbstractResolver implements ResolverInterface
{
    /**
     * @var CompanyManagement
     */
    protected $companyManagement;

    /**
     * @var GetCustomer
     */
    protected $getCustomer;

    /**
     * @var int
     */
    protected $customerId;

    /**
     * @var UsersManagement
     */
    protected $usersManagement;

    /**
     * @var UserRolesManagement
     */
    protected $userRolesManagement;

    /**
     * @var HelperData
     */
    protected $helperData;

    /**
     * AbstractResolver constructor.
     *
     * @param CompanyManagement $companyManagement
     * @param GetCustomer $getCustomer
     * @param UsersManagement $usersManagement
     * @param UserRolesManagement $userRolesManagement
     * @param HelperData $helperData
     */
    public function __construct(
        CompanyManagement $companyManagement,
        GetCustomer $getCustomer,
        UsersManagement $usersManagement,
        UserRolesManagement $userRolesManagement,
        HelperData $helperData
    ) {
        $this->companyManagement   = $companyManagement;
        $this->getCustomer         = $getCustomer;
        $this->usersManagement     = $usersManagement;
        $this->userRolesManagement = $userRolesManagement;
        $this->helperData          = $helperData;
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if ($this->helperData->versionCompare('2.3.3')) {
            if ($context->getExtensionAttributes()->getIsCustomer() === false) {
                throw new GraphQlAuthorizationException(__('The current customer isn\'t authorized.'));
            }
        }

        $customer         = $this->getCustomer->execute($context);
        $this->customerId = $customer->getId();
    }
}
