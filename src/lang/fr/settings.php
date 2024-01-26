<?php

return [
    'basic_settings_header' => 'Paramètres de base',

    'ore_value_modifier_label' => 'Modificateur de valeur du minerai',
    'ore_value_modifier_desc' => 'Il s\'agit d\'un modificateur utilisé sur les coûts de base du minerai/minéraux/goo
                    pour ajuster l\'inflation/déflation pendant la période de facturation. Normalement, c\'est 90-95%',

    'ore_refining_rate_label' => 'Taux de raffinage du minerai',
    'ore_refining_rate_desc' => 'Cela devrait être le montant maximum de raffinage dans votre région. Tarifs maximum avec
                    implant RX-804, compétences de niveau V, et un T2 Tatara Rigged est 89.4%. Ajustez cela comme bon vous semble, mais je
                    recommande d\'utiliser le tarif maximum disponible à vos membres dans votre zone d\'espace.',

    'bounty_tax_rate_label' => 'Taux d\'imposition des primes',
    'bounty_tax_rate_desc' => 'Taux de primes à taxer. Généralement de 5 à 10 %',

    'incentive_settings_header' => 'Paramètres d\'incitation',
    'incentive_settings_desc' => 'Les modificateurs incitatifs s\'appliquent uniquement à chaque corporation.
                    Ce sont des modificateurs appliqués aux corporations où au moins un certain nombre de membres (y compris les alts)
                    sont enregistrés sur SeAT. S\'ils ne sont pas inscrits sur SeAT, l\'alliance ne voit pas leur exploitation minière
                    montants et impôts manquants, donc la corporation obtient des taux d\'imposition plus élevés.',

    'incentive_ore_value_modifier_label' => 'Modificateur de valeur du minerai',
    'incentive_ore_value_modifier_desc' => 'Modificateur de valeur du minerai à utiliser pour les corporations bénéficiant de tarifs incitatifs.',

    'incentive_ore_refining_rate_label' => 'Taux de raffinage du minerai',
    'incentive_ore_refining_rate_desc' => 'Ce modificateur s\'applique à la taxe normale. Avec votre taxe normale à 5 % et la taxe sur les minerais incitative
                    modificateur à 50%, vos membres devront payer une taxe de 2,5%',

    'incentive_bounty_tax_rate_label' => 'Taux d\'imposition des primes',
    'incentive_bounty_tax_rate_desc' => 'Ce modificateur s\'applique à la taxe normale. Avec votre taxe normale à 5 % et la taxe sur les minerais incitative
                    modificateur à 50%, vos membres devront payer une taxe de 2,5%',

    'rate_threshold_label' => 'Seuil de taux',
    'rate_threshold_desc' => 'Lorsque plus de x% des membres d\'une corporation sont inscrits sur SeAT, les paramètres incitatifs s\'appliquent.',

    'valuation_of_ore_header' => 'Valorisation du minerai',
    'valuation_of_ore_desc' => 'La valeur du minerai peut être déterminée avec deux méthodes: Par type de minerai OU Par
                    teneur en minéraux. Si vous êtes un mineur de lune, il est préférable d\'utiliser la teneur en minéraux car elle est plus précise car
                    Lune Goo est rarement vendu sous forme de minerai brut, mais le plus souvent sous forme de produits raffinés. Cela permet à l\'exploitation minière
                    de la lune d\'être honnête.',



    'valuation_mode_label' => 'Mode de valorisation²²²',
    'value_at_ore_price_label' => 'Valeur au prix du minerai',
    'value_at_mineral_price_label' => 'Valeur au prix des minéraux',

    'value_at_sell_price_label' => 'Valeur au prix de vente',
    'value_at_buy_price_label' => 'Valeur au prix d\'achat',
    'value_at_ccp_price_label' => 'Valeur au prix CCP',
    'value_at_ccp_market_price_label' => 'Valeur au prix du marché CCP (ancien défaut)',

    'ore_tax_header' => 'Taxe sur le minerai',
    'ore_tax_desc' => 'Vous pouvez spécifier des taxes distinctes pour chaque catégorie de minerai.',


    'r64_tax_label' => 'Taxe R64',
    'r32_tax_label' => 'Taxe R32',
    'r16_tax_label' => 'Taxe R16',
    'r8_tax_label' => 'Taxe R8',
    'r4_tax_label' => 'Taxe R4',
    'gas_tax_label' => 'Tax sur le gaz',
    'ice_tax_label' => 'Tax la glace',
    'other_ores_tax_label' => 'Taxe sur les autres minerais',

    'enable_tax_invoices_label' => 'Activer les factures fiscales',
    'disable_tax_invoices_label' => 'Désactiver les factures fiscales',

    'corporation_whitelist_label' => 'Liste blanche des corporations',
    'corporation_whitelist_desc' => 'Collez un nom de corporation par ligne. Laisser ce champ vide désactive la liste blanche.',

    'invoice_threshold_label' => 'Seuil de facture',
    'invoice_threshold_desc' => 'Les personnages qui doivent payer moins que cette valeur n\'ont pas à payer d\'impôts.',

    'holding_corps_label' => 'Holding de corporations',
    'holding_corps_desc' => 'Permet le paiement d\'impôts à d\'autres sociétés pour lesquelles la facture fiscale a été émise.
                        Si aucune holding de corporations n\'est spécifiée, seule la corporation qui a émis la facture fiscale peut recevoir les paiements..
                        Plusieurs holding peuvent être spécifiées.
                        Dès qu\'une corporation est spécifiée, seules les corporations spécifiées peuvent recevoir des paiements.
                        Dans le cas où il s\'agit d\'une corporation différente de celle qui a émis la facture, cela signifie que
                        la coporation émettrice NE PEUT PAS recevoir le paiement.
                        Les associations sont spécifiées comme ceci: <code>corp name -> other corp name</code> et ils veulent dire 
                        que les paiements à <code>corp name</code> peut couvrir les factures de <code>other corp name</code>.',

    'tax_code_visibility' => 'Visibilité du code fiscal',
    'tax_code_visibility_desc' => 'Afficher uniquement les codes fiscaux pour les factures pouvant être payées. <small class="text-muted">Cette option est
                                recommandée.</small>',

    'always_show_tax_codes_label' => 'Toujours afficher les codes fiscaux.',
    'always_show_tax_codes_desc' => 'En activant cette option, vous reconnaissez que les prédictions ne peuvent pas être
                                payées jusqu\'à la fin du mois, et vous promettez de ne pas poser de questions à ce sujet sur
                                discord.',

    'update_btn' => 'Mise à jour',

];