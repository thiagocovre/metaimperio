<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;


class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'lof_marketplace_product'
         */
        // $table = $installer->getConnection()->newTable(
        //     $installer->getTable('lof_marketplace_product')
        // )->addColumn(
        //     'seller_id',
        //     Table::TYPE_INTEGER,
        //     null,
        //     ['nullable' => false, 'primary' => true],
        //     'Seller ID'
        // )->addColumn(
        //     'product_id',
        //     Table::TYPE_SMALLINT,
        //     null,
        //     ['unsigned' => true, 'nullable' => false, 'primary' => true],
        //     'Product ID'
        // )->addColumn(
        //     'product_name',
        //     \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        //     255,
        //     ['nullable' => false],
        //     'product name'
        // )->addColumn(
        //     'position',
        //     Table::TYPE_INTEGER,
        //     11,
        //     ['nullable' => true],
        //     'Position'
        // )->setComment(
        //     'Lof Seller To Product Linkage Table'
        // );
        // $installer->getConnection()->createTable($table);
         /**
         *  setup for Seller Settings
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_marketplace_seller_settings')
        )->addColumn(
            'setting_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Setting Id'
        )->addColumn(
            'seller_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller Id'
        )->addColumn(
            'group',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '32',
            ['nullable' => false],
            'Group'
        )->addColumn(
            'key',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64',
            ['nullable' => false],
            'Key'
        )->addColumn(
            'value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '500',
            ['nullable' => false],
            'value'
        )->addColumn(
            'serialized',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'serialized'
        )->setComment(
            'MarketPlace Seller Settings'
        );
        $installer->getConnection()->createTable($table);

         /**
         *  lof_marketplace_message_admin
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_marketplace_message_admin')
        )->addColumn(
            'message_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            32,
            [],
            'Identifier'
        )->addColumn(
            'admin_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [ 'unsigned' => true, 'nullable' => false,],
            'Owner Id'
        )->addColumn(
            'admin_email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Admin Email'
        )->addColumn(
            'admin_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Admin Name'
        )->addColumn(
            'seller_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Sender Id'
        )->addColumn(
            'seller_email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Sender Email'
        )->addColumn(
            'seller_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Sender Name'
        )->addColumn(
            'seller_send',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller Send'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            \Magento\Framework\DB\Ddl\Table::DEFAULT_TEXT_SIZE,
            [],
            'Description'
        )->addColumn(
            'receiver_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Receiver Id'
        )->addColumn(
            'subject',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Subject'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            ['unsigned' => true, 'nullable' => false,],
            'Status (0 => Draft, 1 => Unread, 2 => Read, 3 => Sent)'
        )->addColumn(
            'is_read',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            1,
            ['unsigned' => true, 'nullable' => false,],
            'Is read Message (0 => No, 1 => Yes)'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created At'
        );
        $installer->getConnection()->createTable($table);


        /* table lof_marketplace_message_detail */
        $table = $installer->getTable('lof_marketplace_message_detail');

        $installer->getConnection()->addColumn(
            $table,
            'message_admin',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'message admin'
            ]
        );

        /* table lof_marketplace_seller */
        $table = $installer->getTable('lof_marketplace_seller');

        $installer->getConnection()->addColumn(
            $table,
            'page_id',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'page id facebook'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'country_id',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'country_id'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'verify_status',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 15,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'verify_status'
            ]
        );
        /* table lof_marketplace_group */
        $table = $installer->getTable('lof_marketplace_group');

        $installer->getConnection()->addColumn(
            $table,
            'limit_product',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => true,
                'comment'  => 'Limit Product'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_add_product',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'Can add product'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_cancel_order',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'Can cancel order'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_create_invoice',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_create_invoice'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_create_shipment',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_create_shipment'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_create_creditmemo',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_create_creditmemo'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'hide_payment_info',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'hide_payment_info'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'hide_customer_email',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 0,
                'comment'  => 'hide_customer_email'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_use_shipping',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_shipping'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_submit_order_comments',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_submit_order_comments'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_use_message',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_message'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_use_review',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_review'
            ]
        );
          $installer->getConnection()->addColumn(
            $table,
            'can_use_rating',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_rating'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_use_import_export',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_import_export'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_use_vacation',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_vacation'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'can_use_report',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_report'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'can_use_withdrawal',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'length'   => 10,
                'nullable' => false,
                'default'  => 1,
                'comment'  => 'can_use_withdrawal'
            ]
        );
         /* table lof_marketplace_payment */
        $table = $installer->getTable('lof_marketplace_payment');
        $installer->getConnection()->addColumn(
            $table,
            'fee_by',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 255,
                'nullable' => true,
                'comment'  => 'Fee By'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'fee_percent',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => true,
                'comment'  => 'Fixed Percent'
            ]
        );

        $table = $installer->getTable('lof_marketplace_seller');

        $installer->getConnection()->addColumn(
            $table,
            'company',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 255,
                'nullable' => true,
                'comment'  => 'Company'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'city',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 255,
                'nullable' => true,
                'comment'  => 'City'
            ]
        );
          $installer->getConnection()->addColumn(
            $table,
            'region',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 255,
                'nullable' => true,
                'comment'  => 'Region'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'street',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 255,
                'nullable' => true,
                'comment'  => 'street'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'product_count',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => true,
                'comment'  => 'Product count'
            ]
        );
         $installer->getConnection()->addColumn(
            $table,
            'duration_of_vendor',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => true,
                'comment'  => 'duration_of_vendor'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'region_id',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => true,
                'comment'  => 'region id'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'postcode',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 15,
                'nullable' => true,
                'comment'  => 'postcode'
            ]
        );
        $installer->getConnection()->addColumn(
            $table,
            'telephone',
            [
               'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length'   => 50,
                'nullable' => true,
                'comment'  => 'Tele Phone'
            ]
        );
          $installer->getConnection()->addColumn(
            $table,
            'total_sold',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                'length'   => '10,4',
                'nullable' => true,
                'comment'  => 'total amount sold'
            ]
        );
        $table = $installer->getTable('lof_marketplace_seller');

        $installer->getConnection()->modifyColumn(
            $table,
            'country_id',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => 15,
                'nullable' => false,
                'comment'  => 'country_id'
            ]
        );
         $installer->endSetup();
    }
}
