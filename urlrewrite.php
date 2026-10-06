<?php
$arUrlRewrite=array (
  1 => 
  array (
    'CONDITION' => '#^/support/printer/([a-zA-Z0-9"%\\-\\_]+)/\\??#',
    'RULE' => 'SECTION_CODE=$1&',
    'ID' => '',
    'PATH' => '/support/printer/index.php',
    'SORT' => 1,
  ),
  5 => 
  array (
    'CONDITION' => '#^/media/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/media/index.php',
    'SORT' => 10,
  ),
  534 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 90,
  ),
  3 => 
  array (
    'CONDITION' => '#^/support/([a-zA-Z0-9\\-\\_]+)/([a-zA-Z0-9\\-\\_]+)/\\??#',
    'RULE' => 'SECTION_CODE=$1&ELEMENT_CODE=$2&',
    'ID' => '',
    'PATH' => '/support/detail.php',
    'SORT' => 100,
  ),
  302 => 
  array (
    'CONDITION' => '#^/academy/([a-zA-Z0-9\\-\\_]+)/([a-zA-Z0-9\\-\\_]+)/\\??#',
    'RULE' => 'SECTION_CODE=$1&ELEMENT_CODE=$2&',
    'ID' => '',
    'PATH' => '/academy/detail.php',
    'SORT' => 100,
  ),
  525 => 
  array (
    'CONDITION' => '#^/pub/calendar-sharing/([0-9a-zA-Z]+)/?([^/]*)#',
    'RULE' => 'hash=$1',
    'ID' => 'bitrix:calendar.pub.sharing',
    'PATH' => '/pub/calendar_sharing.php',
    'SORT' => 100,
  ),
  511 => 
  array (
    'CONDITION' => '#^/pub/pay/([\\w\\W]+)/([0-9a-zA-Z]+)/([^/]*)#',
    'RULE' => 'account_number=$1&hash=$2',
    'ID' => NULL,
    'PATH' => '/pub/payment.php',
    'SORT' => 100,
  ),
  502 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  529 => 
  array (
    'CONDITION' => '#^/extranet/task/comments/([0-9]+)#',
    'RULE' => 'taskId=$1',
    'ID' => NULL,
    'PATH' => '/extranet/tasks/comments.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#/products/([a-zA-Z0-9\\-\\_]+)/\\??#',
    'RULE' => 'ELEMENT_CODE=$1&',
    'ID' => '',
    'PATH' => '/products/detail.php',
    'SORT' => 100,
  ),
  526 => 
  array (
    'CONDITION' => '#^/pub/payment-slip/([\\w\\W]+)/#',
    'RULE' => 'signed_payment_id=$1',
    'ID' => 'bitrix:salescenter.pub.payment.slip',
    'PATH' => '/pub/payment_slip.php',
    'SORT' => 100,
  ),
  500 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/support/all-printers/#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/support/all_printers.php',
    'SORT' => 100,
  ),
  504 => 
  array (
    'CONDITION' => '#^/stssync/contacts_crm/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/contacts_crm/index.php',
    'SORT' => 100,
  ),
  503 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  506 => 
  array (
    'CONDITION' => '#^/shop/buyer_group/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.order.buyer_group',
    'PATH' => '/shop/buyer_group/index.php',
    'SORT' => 100,
  ),
  510 => 
  array (
    'CONDITION' => '#^/marketing/toloka/#',
    'RULE' => '',
    'ID' => 'bitrix:sender.yandex.toloka',
    'PATH' => '/marketing/toloka.php',
    'SORT' => 100,
  ),
  505 => 
  array (
    'CONDITION' => '#^/pub/site/(.*?)#',
    'RULE' => 'path=$1',
    'ID' => 'bitrix:landing.pub',
    'PATH' => '/pub/site/index.php',
    'SORT' => 100,
  ),
  512 => 
  array (
    'CONDITION' => '#^/crm/invoicing/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/crm/invoicing/index.php',
    'SORT' => 100,
  ),
  527 => 
  array (
    'CONDITION' => '#^/personal-test/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal-test/index.php',
    'SORT' => 100,
  ),
  508 => 
  array (
    'CONDITION' => '#^/shop/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.productcard.controller',
    'PATH' => '/shop/catalog/index.php',
    'SORT' => 100,
  ),
  509 => 
  array (
    'CONDITION' => '#^/crm/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.catalog.controller',
    'PATH' => '/crm/catalog/index.php',
    'SORT' => 100,
  ),
  507 => 
  array (
    'CONDITION' => '#^/shop/buyer/#',
    'RULE' => '',
    'ID' => 'bitrix:crm.order.buyer',
    'PATH' => '/shop/buyer/index.php',
    'SORT' => 100,
  ),
  528 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  532 => 
  array (
    'CONDITION' => '#^/products/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/products/index.php',
    'SORT' => 100,
  ),
  501 => 
  array (
    'CONDITION' => '#^/academy/#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/academy/index.php',
    'SORT' => 100,
  ),
  535 => 
  array (
    'CONDITION' => '#^\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/support/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
