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

namespace Mageplaza\CompanyAccountsGraphQl\Model\Resolver\Company;

use Exception;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mageplaza\CompanyAccountsGraphQl\Model\Resolver\AbstractResolver;

/**
 * Class Register
 * @package Mageplaza\CompanyAccountsGraphQl\Model\Resolver\Company
 */
class Register extends AbstractResolver
{
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        parent::resolve($field, $context, $info, $value, $args);

        $company = $this->companyFactory->create()->setData($args['input']);

        try {
            $result = $this->companyManagement->register($this->customerId, $company);
        } catch (Exception $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }

        return $result;
    }
}
