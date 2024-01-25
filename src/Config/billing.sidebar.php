<?php

return [
    'billing' => [
        'name' => 'SeAT Billing',
        'label' => 'billing::billing.billing_menu_label',
        'icon' => 'fas fa-credit-card',
        'route_segment' => 'billing',
        'entries' => [
            'billing' => [
                'name' => 'Billing Data',
                'label' => 'billing::billing.billing_data_menu_label',
                'icon' => 'fas fa-money-bill',
                'route' => 'billing.view',
                'permission' => 'billing.view',
            ],
            'settings' => [
                'name' => 'Settings',
                'label' => 'billing::billing.billing_data_menu_label',
                'icon' => 'fas fa-cog',
                'route' => 'billing.settings',
                'permission' => 'billing.settings',
            ],
            'personal' => [
                'name' => 'User',
                'label' => 'billing::billing.billing_personal_menu_label',
                'icon' => 'fas fa-user',
                'route' => 'billing.userBill',
            ],
            'tax' => [
                'name' => 'Tax Invoices',
                'label' => 'billing::billing.billing_tax_invoices_menu_label',
                'icon' => 'fas fa-user',
                'route' => 'tax.userTaxInvoices',
            ],
            'corporation_tax' => [
                'name' => 'Tax Management',
                'label' => 'billing::billing.billing_corp_tax_menu_label',
                'icon' => 'fas fa-briefcase',
                'route' => 'tax.corporationSelectionPage',
                'permission'=>'billing.tax_manager',
            ],
        ],
    ],
];
