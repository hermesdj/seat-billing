<?php

return [
    'basic_settings_header' => 'Basic Settings',

    'ore_value_modifier_label' => 'Ore value modifier',
    'ore_value_modifier_desc' => 'This is a modifier used on the base costs of the ore/minerals/goo
                    to adjust for inflation/deflation during the billing period. Normally this is 90-95%',

    'ore_refining_rate_label' => 'Ore Refining Rate',
    'ore_refining_rate_desc' => 'This should be the max refine amount in your area. Max rates with
                    RX-804 implant, level V skills, and a T2 Rigged Tatara is 89.4%. Adjust this as you see fit, but I
                    recommend using the maximum rate available to your members in your area of space.',

    'bounty_tax_rate_label' => 'Bounty Tax Rate',
    'bounty_tax_rate_desc' => 'Rate of ratting bounties to tax. Usually 5-10%',

    'incentive_settings_header' => 'Incentive Settings',
    'incentive_settings_desc' => 'Incentivised modifiers are on a per-corporation basis only.
                    These are modifiers applied to corps where at least a certain number of members (including alts)
                    have registered on SeAT. If they\'re not signed up on SeAT, the alliance is not seeing their mining
                    amounts and missing on tax, therefore the corporation gets higher tax rates.',

    'incentive_ore_value_modifier_label' => 'Ore value modifier',
    'incentive_ore_value_modifier_desc' => 'Ore Value Modifier to use for corps with incentivised rates.',

    'incentive_ore_refining_rate_label' => 'Ore Refining Rate',
    'incentive_ore_refining_rate_desc' => 'This modifier is applied to the normal tax. With your normal tax at 5 % and the incentivised ore tax
                    modifier at 50%, your members will have to pay 2.5% tax',

    'incentive_bounty_tax_rate_label' => 'Bounty Tax Rate',
    'incentive_bounty_tax_rate_desc' => 'This modifier is applied to the normal tax. With your normal tax at 5 % and the incentivised ore tax
                    modifier at 50%, your members will have to pay 2.5% tax',

    'rate_threshold_label' => 'Rates Threshold',
    'rate_threshold_desc' => 'When more than x% of the members of a corp are registered on SeAT, the incentivised settings apply.',

    'valuation_of_ore_header' => 'Valuation of Ore',
    'valuation_of_ore_desc' => 'Value of ore can be determined with two methods: By ore type OR By
                    mineral content. If you are moon mining, it\'s better to use mineral content as it\'s more accurate as
                    Moon Goo is rarely sold by the raw ore, but more often as refined products. This keeps the moon
                    mining honest.',



    'valuation_mode_label' => 'Valuation Mode',
    'value_at_ore_price_label' => 'Value at Ore Price',
    'value_at_mineral_price_label' => 'Value at Mineral Price',

    'value_at_sell_price_label' => 'Value at Sell Price',
    'value_at_buy_price_label' => 'Value at Buy Price',
    'value_at_ccp_price_label' => 'Value at CCP Price',
    'value_at_ccp_market_price_label' => 'Value at CCP Market Price (old default)',

    'ore_tax_header' => 'Ore Tax',
    'ore_tax_desc' => 'You can specify separate taxes for each category of ore.',


    'r64_tax_label' => 'R64 Tax',
    'r32_tax_label' => 'R32 Tax',
    'r16_tax_label' => 'R16 Tax',
    'r8_tax_label' => 'R8 Tax',
    'r4_tax_label' => 'R4 Tax',
    'gas_tax_label' => 'Gas Tax',
    'ice_tax_label' => 'Ice Tax',
    'other_ores_tax_label' => 'Other Ores Tax',

    'enable_tax_invoices_label' => 'Enable Tax Invoices',
    'disable_tax_invoices_label' => 'Disable Tax Invoices',

    'corporation_whitelist_label' => 'Corporation Whitelist',
    'corporation_whitelist_desc' => 'Paste one corporation name per line. Leaving this empty disables the whitelist.',

    'invoice_threshold_label' => 'Invoice Threshold',
    'invoice_threshold_desc' => 'Character that have to pay less than this value don\'t have to pay any tax.',

    'holding_corps_label' => 'Holding Corps',
    'holding_corps_desc' => 'Allows tax payments to other corporations than the tax invoice was issued to.
                        If no holding corp is specified, only the corp that issued the tax invoice can receive payments.
                        Multiple holding corporations can be specified.
                        As soon as one corporation is specified, only the specified corporations can receive payments.
                        In case that\'s a different corporation than the corp that issued the invoice, this means the
                        issuing corp CAN\'T receive the payment.
                        Associations are specified like this: <code>corp name -> other corp name</code> and mean they
                        that payments to <code>corp name</code> can cover invoices from <code>other corp name</code>.',

    'tax_code_visibility' => 'Tax Code Visibility',
    'tax_code_visibility_desc' => 'Only show tax codes for invoices that can be paid. <small class="text-muted">This option is
                                recommended.</small>',

    'always_show_tax_codes_label' => 'Always show tax codes.',
    'always_show_tax_codes_desc' => 'By enabling this option, you acknowledge that predictions can\'t be
                                paid until the end of the month, and you promise not to ask about this on
                                discord.',

    'update_btn' => 'Update',

];