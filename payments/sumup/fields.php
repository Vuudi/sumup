<?php

use Admin\Models\Statuses_model;

return [
    'fields' => [
        'setup' => [
            'type' => 'partial',
            'path' => '$/dineabyte/sumup/payments/sumup/info',
        ],
        'transaction_mode' => [
            'label' => 'lang:dineabyte.sumup::default.sumup.label_transaction_mode',
            'type' => 'radiotoggle',
            'default' => 'test',
            'span' => 'left',
            'options' => [
                'live' => 'lang:dineabyte.sumup::default.sumup.text_live',
                'test' => 'lang:dineabyte.sumup::default.sumup.text_test',
            ],
        ],
        'transaction_type' => [
            'label' => 'lang:dineabyte.sumup::default.sumup.label_transaction_type',
            'type' => 'radiotoggle',
            'default' => 'auth_capture',
            'span' => 'right',
            'options' => [
                'auth_capture' => 'lang:dineabyte.sumup::default.sumup.text_auth_capture',
                'auth_only' => 'lang:dineabyte.sumup::default.sumup.text_auth_only',
            ],
        ],
        'live_secret_key' => [
            'label' => 'lang:dineabyte.sumup::default.sumup.label_live_secret_key',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[live]',
            ],
        ],
        'test_public_key' => [
            'label' => 'lang:dineabyte.sumup::default.sumup.label_test_public_key',
            'type' => 'text',
            'span' => 'right',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'test_secret_key' => [
            'label' => 'lang:dineabyte.sumup::default.sumup.label_test_secret_key',
            'type' => 'text',
            'span' => 'left',
            'trigger' => [
                'action' => 'show',
                'field' => 'transaction_mode',
                'condition' => 'value[test]',
            ],
        ],
        'order_fee_type' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee_type',
            'type' => 'radiotoggle',
            'span' => 'right',
            'cssClass' => 'flex-width',
            'default' => 1,
            'options' => [
                1 => 'lang:admin::lang.menus.text_fixed_amount',
                2 => 'lang:admin::lang.menus.text_percentage',
            ],
        ],
        'order_fee' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee',
            'type' => 'currency',
            'span' => 'right',
            'cssClass' => 'flex-width',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'span' => 'left',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => [Statuses_model::class, 'getDropdownOptionsForOrder'],
            'span' => 'right',
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['transaction_mode', 'lang:dineabyte.sumup::default.sumup.label_transaction_mode', 'string'],
        ['live_secret_key', 'lang:dineabyte.sumup::default.sumup.label_live_secret_key', 'string'],
        ['live_public_key', 'lang:dineabyte.sumup::default.sumup.label_live_public_key', 'string'],
        ['test_secret_key', 'lang:dineabyte.sumup::default.sumup.label_test_secret_key', 'string'],
        ['test_public_key', 'lang:dineabyte.sumup::default.sumup.label_test_public_key', 'string'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'integer'],
    ],
];
