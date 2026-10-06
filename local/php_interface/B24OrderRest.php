<?php
use Bitrix\Main\Loader;

class B24OrderRest
{
    private const WEBHOOK_URL = 'https://bx.harzlabs.ru/rest/';
    private const USER_ID = '1051';
    private const WEBHOOK_CODE = 'qlqau3lyj9c2eqs3';

    private static $instance = null;
    private $arCachedDeals = [];
    private $arCachedPayments = [];
    private static $productDataCache = [];
    private $paySystemCache = [];
    private $orderRelationsCache = [];
    private $shipmentCache = [];

    private function __construct() {
        $this->getPaySystemsList();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getMethodUrl(string $method): string
    {
        return rtrim(self::WEBHOOK_URL, '/').'/'
            .self::USER_ID.'/'
            .self::WEBHOOK_CODE.'/'
            .ltrim($method, '/');
    }

    public function callMethod(string $method, array $params = []): array
    {
        $queryUrl = $this->getMethodUrl($method);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POST => true,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $queryUrl,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) {
            throw new RuntimeException("Bitrix24 API error. HTTP code: {$httpCode}");
        }

        $decodedResult = json_decode($result, true);

        if (isset($decodedResult['error'])) {
            throw new RuntimeException(
                "Bitrix24 API error: {$decodedResult['error_description']}"
            );
        }

        return $decodedResult;
    }

    public function matchFilter(array $arDeal, string $sFilterType): bool
    {
        switch ($sFilterType) {
            case 'completed':
                return in_array($arDeal['STAGE_ID'], ['C8:WON', 'C8:SUCCESS']);
            case 'canceled':
                return $arDeal['CLOSED'] === 'Y';
            case 'all':
                return true;
            default:
                return true;
        }
    }

    public function normalizeDealToOrder(array $arDeal, array $arParams = []): array
    {
        if ($arDeal['CATEGORY_ID'] == 3) {
            $sOrderNumber = $arDeal['UF_CRM_1668255176610'] ?? $arDeal['ID'];
        } else {
            $sOrderNumber = 'HL-' . $arDeal['UF_CRM_1668255176610'] ?? $arDeal['ID'];
        }

        try {
            $date = new DateTime($arDeal['DATE_CREATE']);
            $sFormattedDate = $date->format('d.m.Y');
        } catch (Exception $e) {
            $sFormattedDate = '';
        }

        $sCurrencySymbol = match($arDeal['CURRENCY_ID'] ?? 'RUB') {
            'EUR' => '€',
            'USD' => '$',
            default => '₽'
        };

        $price = (float)($arDeal['OPPORTUNITY'] ?? 0);
        $sFormattedPrice = number_format($price, $price == floor($price) ? 0 : 2, '.', ' ') . ' ' . $sCurrencySymbol;

        $arOrderRelation = $this->getOrderRelation($arDeal['ID']);

        $sDealID = isset($arOrderRelation['orderId']) ? $arOrderRelation['orderId'] : $arDeal['ID'];
        $arDeal['ORDER_ID'] = $sDealID;

        $arOrder = [
            'ID' => $arDeal['ID'],
            'ACCOUNT_NUMBER' => $sOrderNumber,
            'ORDER_ID' => $sDealID,
            'DATE_INSERT_FORMATED' => $sFormattedDate,
            'FORMATED_PRICE' => $sFormattedPrice,
            'CURRENCY_ID' => $arDeal['CURRENCY_ID'],
            'CURRENCY_SYMBOL' => $sCurrencySymbol,
            'STATUS_ID' => $arDeal['STAGE_ID'],
            'URL_TO_DETAIL' => $this->getDetailUrl($sOrderNumber),
            'DATE_INSERT' => $arDeal['DATE_CREATE'],
            'DATE_PAYED' => $this->getPaymentDate($arDeal),
            'PAYED' => $this->isPaid($arDeal) ? 'Y' : 'N',
            'CANCELED' => $arDeal['CLOSED'] === 'Y' ? 'Y' : 'N',
            'DATE_CANCELED' => $arDeal['DATE_CLOSED'] ?? null,
        ];

        $arBasketItems = $this->getDealProducts($arDeal['ID']);
        $arBasket = $this->formatProducts($arBasketItems['result'], $sCurrencySymbol);

        return [
            'ORDER' => $arOrder,
            'BASKET_ITEMS' => $arBasket,
            'PAYMENT' => $this->getDealPayments($arDeal['ID'], $sDealID),
           // 'SHIPMENT' => $this->getDealShipments($sDealID),
            'SHIPMENT' => array()
        ];
    }

    public function getOrderRelation($iDealId): ?array
    {
        if (isset($this->orderRelationsCache[$iDealId])) {
            return $this->orderRelationsCache[$iDealId];
        }

        try {
            $arResult = $this->callMethod(
                'crm.orderentity.list',
                [
                    'select' => ['orderId', 'ownerId'],
                    'filter' => [
                        '=ownerTypeId' => 2,
                        '@ownerId' => [$iDealId],
                    ],
                    'limit' => 1
                ]
            );

            if (isset($arResult['result']['orderEntity']) && !empty($arResult['result']['orderEntity'][0])) {
                $this->orderRelationsCache[$iDealId] = $arResult['result']['orderEntity'][0];
                return $arResult['result']['orderEntity'][0];
            }
        } catch (Exception $e) {
            AddMessage2Log("Error getting order relation: ".$e->getMessage(), 'b24_rest');
        }

        return null;
    }

    public function formatProducts(array $arProducts, $sCurrencyID):array {
        $arResult = array();

        $sCurrencySymbol = match($sCurrencyID ?? 'RUB') {
            'EUR' => '€',
            'USD' => '$',
            default => '₽'
        };

        if (!empty($arProducts)) {
            foreach ($arProducts as $arProduct) {

                $arResult[] = [
                    'ID' => $arProduct['PRODUCT_ID'],
                    'PRODUCT_ID' => $arProduct['PRODUCT_ID'],
                    'QUANTITY' =>  $arProduct['QUANTITY'],
                    'PRICE' =>  $arProduct['PRICE'],
                    'BASE_PRICE' => $arProduct['PRICE'],
                    'CURRENCY' =>  $sCurrencyID,
                    'PRICE_FORMATED' => ($arProduct['PRICE'] == floor( $arProduct['PRICE']))
                        ? number_format($arProduct['PRICE'], 0, '', ' ') . ' ' . $sCurrencySymbol
                        : number_format($arProduct['PRICE'], 2, '.', ' ') . ' ' . $sCurrencySymbol,
                    'BASE_PRICE_FORMATED' => ($arProduct['PRICE'] == floor($arProduct['PRICE']))
                        ? number_format($arProduct['PRICE'], 0, '', ' ') . ' ' .  $sCurrencySymbol
                        : number_format($arProduct['PRICE'], 2, '.', ' ') . ' ' . $sCurrencySymbol,

                    'SUM_FORMATED' => ($arProduct['PRICE'] * $arProduct['QUANTITY'] == floor($arProduct['PRICE'] * $arProduct['QUANTITY']))
                        ? number_format($arProduct['PRICE'] * $arProduct['QUANTITY'], 0, '', ' ') . ' ' . $sCurrencySymbol
                        : number_format($arProduct['PRICE'] * $arProduct['QUANTITY'], 2, '.', ' ') . ' ' . $sCurrencySymbol,
                    'MEASURE_NAME' => LANGUAGE_ID == 'ru' ? 'шт.' : 'pcs',
                    'WEIGHT' => 0,
                    'DISCOUNT_PRICE' => 0,
                    'DISCOUNT_PRICE_PERCENT' => 0,
                    'DETAIL_PAGE_URL' => $this->getProductDetailUrl($arProduct['PRODUCT_ID']),
                    'PICTURE' => $this->getProductImageUrl($arProduct['PRODUCT_ID']),
                    'NAME' => $this->getProductName($arProduct['PRODUCT_ID'], $arProduct['PRODUCT_NAME']),
                ];
            }
        }

        return $arResult;
    }

    private function getDetailUrl($orderId): string
    {
        return '/personal/order/detail/' . $orderId . '/';
    }

    private function getProductData($elementId): array
    {
        if (isset(self::$productDataCache[$elementId])) {
            return self::$productDataCache[$elementId];
        }

        $defaultData = [
            'url' => '/products/'.$elementId.'/',
            'image' => '/bitrix/templates/.default/components/bitrix/sale.personal.order.detail/intec.cabinet.order.detail.1/images/picture.missing.png'
        ];

        if (!Loader::includeModule('iblock')) {
            return $defaultData;
        }

        $originalElementId = $elementId;
        if (Loader::includeModule('catalog')) {
            $productData = \CCatalogSKU::getProductList([$elementId]);
            if (!empty($productData[$elementId])) {
                $elementId = $productData[$elementId]['ID'];
            }
        }

        $element = \CIBlockElement::GetList(
            [],
            ['ID' => $elementId],
            false,
            false,
            ['ID', 'CODE', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE']
        )->Fetch();

        if (!$element) {
            return $defaultData;
        }

        $result = ['image' => $defaultData['image']];

        $result['name'] = $element['NAME'];

        $sectionCode = '';
        if ($element['IBLOCK_SECTION_ID']) {
            $section = \CIBlockSection::GetList(
                [],
                ['ID' => $element['IBLOCK_SECTION_ID']],
                false,
                ['CODE']
            )->Fetch();

            if ($section) {
                $sectionCode = $section['CODE'] ?: $sectionCode;
            }
        }

        $productCode = $element['CODE'] ?: $element['ID'];
        $result['url'] = empty($sectionCode)
            ? '/products/'.$productCode.'.html'
            : '/products/'.$sectionCode.'/'.$productCode.'.html';

        $imageId = $element['DETAIL_PICTURE'] ?: $element['PREVIEW_PICTURE'];
        if ($imageId) {
            $imageFile = \CFile::GetFileArray($imageId);
            if ($imageFile) {
                $result['image'] = $imageFile['SRC'];
            }
        }

        self::$productDataCache[$originalElementId] = $result;
        return $result;
    }

    private function getProductDetailUrl($iElementId): string
    {
        $arData = $this->getProductData($iElementId);
        return $arData['url'];
    }

    private function getProductName($iElementId, $sName): string
    {
        $arData = $this->getProductData($iElementId);
        return isset($arData['name']) ? $arData['name'] : $sName;
    }

    private function getProductImageUrl($iElementId): string
    {
        $arData = $this->getProductData($iElementId);
        return $arData['image'];
    }

    private function isPaid(array $arDeal): bool
    {
        $arPayments = $this->getDealPayments($arDeal['ID'], $arDeal['ORDER_ID']);

        foreach ($arPayments as $arPayment) {
            if ($arPayment['IS_PAID']) {
                return true;
            }
        }

        return false;
    }

    private function getPaymentDate(array $arDeal): ?string
    {
        $arPayments = $this->getDealPayments($arDeal['ID'], $arDeal['ORDER_ID']);

        foreach ($arPayments as $arPayment) {
            if ($arPayment['IS_PAID'] && $arPayment['DATE_PAID']) {
                try {
                    $date = new DateTime($arPayment['DATE_PAID']);
                    return $date->format('d.m.Y H:i:s');
                } catch (Exception $e) {
                    return null;
                }
            }
        }

        return null;
    }

    private function getPaymentUrl($paymentId): ?string
    {
        if (empty($paymentId)) {
            return null;
        }

        try {
            $response = $this->callMethod('salescenter.payment.getPublicUrl', [
                'id' => $paymentId
            ]);

            return $response['result']['payment']['url'] ?? null;
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Not found') === false) {
                AddMessage2Log("Payment URL error: ".$e->getMessage(), 'b24_rest');
            }
            return null;
        }
    }

    public function getAllContactsByEmail($sEmail)
    {
        if (!$sEmail) {
            return [];
        }

        $allContacts = [];
        $start = 0;
        $batchSize = 50;

        do {
            $arContact = $this->callMethod('crm.contact.list', [
                'filter' => ['EMAIL' => $sEmail],
                'select' => ['ID', 'EMAIL', 'NAME', 'LAST_NAME'],
                'start' => $start
            ]);

            if (!isset($arContact['result']) || empty($arContact['result'])) {
                break;
            }

            $allContacts = array_merge($allContacts, $arContact['result']);
            $start += $batchSize;

        } while (count($arContact['result']) === $batchSize);

        return $allContacts;
    }

    public function getCompaniesByEmail($sEmail)
    {
        if (!$sEmail) {
            return [];
        }

        $allCompanies = [];
        $start = 0;
        $batchSize = 50;

        do {
            $arCompanies = $this->callMethod('crm.company.list', [
                'filter' => ['EMAIL' => $sEmail],
                'select' => ['ID', 'TITLE', 'EMAIL', 'PHONE', 'ADDRESS'],
                'start' => $start
            ]);

            if (!isset($arCompanies['result']) || empty($arCompanies['result'])) {
                break;
            }

            $allCompanies = array_merge($allCompanies, $arCompanies['result']);
            $start += $batchSize;

        } while (count($arCompanies['result']) === $batchSize);

        return $allCompanies;
    }

    public function getOrdersByEmail($sEmail, $arFilter = [], $iPage = 1, $iPageSize = 50, $arSort = ['DATE_CREATE' => 'DESC'])
    {
        if (!$sEmail) {
            return [
                'result' => [],
                'total' => 0
            ];
        }

        $arContacts = $this->getAllContactsByEmail($sEmail);
        $arContactsIds = array_column($arContacts, 'ID');

        $arCompanies = $this->getCompaniesByEmail($sEmail);
        $arCompaniesIds = array_column($arCompanies, 'ID');

        $contactDeals = !empty($arContactsIds)
            ? $this->getDealsByEntityIds($arContactsIds, 'CONTACT_ID', $arFilter, $arSort)
            : [];

        $companyDeals = !empty($arCompaniesIds)
            ? $this->getDealsByEntityIds($arCompaniesIds, 'COMPANY_ID', $arFilter, $arSort)
            : [];

        $allDeals = $this->mergeSortAndFilterDeals($contactDeals, $companyDeals, $arFilter, $arSort);

        $iTotalDeals = count($allDeals);
        $startPosition = ($iPage - 1) * $iPageSize;
        $arPaginatedDeals = array_slice($allDeals, $startPosition, $iPageSize);

        return [
            'result' => $arPaginatedDeals,
            'total' => $iTotalDeals
        ];
    }

 private function getDealsByEntityIds(array $entityIds, string $entityField, array $arFilter, array $arSort): array
{
    $apiFilter = ['@'.$entityField => $entityIds];

    if (isset($arFilter['filter_history'])) {
        if ($arFilter['filter_history'] === 'Y' && !isset($arFilter['show_all']) && $arFilter['show_all'] !== 'Y') {
            $apiFilter['@STAGE_ID'] = isset($arFilter['show_canceled']) && $arFilter['show_canceled'] === 'Y'
                ? ['LOSE', 'C3:LOSE']
                : ['WON', 'C3:WON'];
        }
    }

    if (isset($arFilter['filter_account_number']) && $arFilter['filter_account_number']) {
        $apiFilter['=UF_CRM_1668255176610'] = str_replace('HL-', '', $arFilter['filter_account_number']);
    }

    if (isset($arFilter['filter_date_from']) && $arFilter['filter_date_from']) {
        $apiFilter['>=DATE_CREATE'] = $arFilter['filter_date_from'];
    }

    if (isset($arFilter['filter_date_to']) && $arFilter['filter_date_to']) {
        $apiFilter['<=DATE_CREATE'] = $arFilter['filter_date_to'];
    }

    $allDeals = [];
    $nextPointer = 0; // Используем стандартный указатель Б24

    do {
        $arResponse = $this->callMethod('crm.deal.list', [
            'filter' => $apiFilter,
            // Спецификатор '*' уже включает базовые поля, 'UF_*' — пользовательские. 
            // Лишние дубликаты (STAGE_ID, ID) можно убрать для экономии памяти.
            'select' => ['*', 'UF_*'], 
            'order' => $arSort,
            'start' => $nextPointer, // Передаем ID следующей страницы из ответа API
        ]);

        if (empty($arResponse['result'])) {
            break;
        }

        $allDeals = array_merge($allDeals, $arResponse['result']);
        
        // Защита от утечки памяти: если суммарно загружено слишком много (например, > 5000 сделок)
        if (count($allDeals) > 5000) {
            break; 
        }

        // Если Битрикс24 говорит, что есть следующая страница, берем её указатель
        $nextPointer = isset($arResponse['next']) ? (int)$arResponse['next'] : 0;

    } while ($nextPointer > 0); // Цикл работает, пока Б24 возвращает маркер следующей страницы

    return $allDeals;
}

    private function mergeSortAndFilterDeals(array $contactDeals, array $companyDeals, array $arFilter, array $arSort): array
    {
        $allDeals = array_merge($contactDeals, $companyDeals);

        $uniqueDeals = [];
        foreach ($allDeals as $deal) {
            $uniqueDeals[$deal['ID']] = $deal;
        }
        $allDeals = array_values($uniqueDeals);

        $allDeals = $this->sortDeals($allDeals, $arSort);

        if (isset($arFilter['filter_payed']) && $arFilter['filter_payed'] === 'Y') {
            $allDeals = array_filter($allDeals, function($deal) {
                return $this->isPaid($deal);
            });
        }

        return $allDeals;
    }

    private function sortDeals(array $deals, array $sortRules): array
    {
        if (empty($sortRules)) {
            return $deals;
        }

        usort($deals, function($a, $b) use ($sortRules) {
            foreach ($sortRules as $field => $direction) {
                $valueA = $a[$field] ?? null;
                $valueB = $b[$field] ?? null;

                if ($valueA === $valueB) {
                    continue;
                }

                $result = $valueA <=> $valueB;
                return strtoupper($direction) === 'DESC' ? -$result : $result;
            }
            return 0;
        });

        return $deals;
    }

//    public function getOrdersByEmail($sEmail, $arFilter = [], $iPage = 1, $iPageSize = 50, $arSort = ['DATE_CREATE' => 'DESC'])
//    {
//        if (!$sEmail) {
//            return [
//                'result' => [],
//                'total' => 0
//            ];
//        }
//
//        $arContacts = $this->getAllContactsByEmail($sEmail);
//        $arContactsIds = array_column($arContacts, 'ID');
//
//        $arCompanies = $this->getCompaniesByEmail($sEmail);
//        $arCompaniesIds = array_column($arCompanies, 'ID');
//
//        var_dump($arCompaniesIds, 'comp');
//
//        if (empty($arContactsIds) && empty($arCompaniesIds)) {
//            return [
//                'result' => [],
//                'total' => 0
//            ];
//        }
//
//        if (!empty($arContactsIds) && !empty($arCompaniesIds)) {
//            $apiFilter = [
//                '@CONTACT_ID' => $arContactsIds,
//                '@COMPANY_ID' => $arCompaniesIds,
//            ];
//        } else if (!empty($arContactsIds)) {
//            $apiFilter = ['@CONTACT_ID' => $arContactsIds];
//        } else if (!empty($arCompaniesIds)) {
//            $apiFilter = ['@COMPANY_ID' => $arCompaniesIds];
//        }
//
//        if (isset($arFilter['filter_history'])) {
//            if ($arFilter['filter_history'] === 'Y' && !isset($arFilter['show_all']) && $arFilter['show_all'] !== 'Y') {
//                if (isset($arFilter['show_canceled']) && $arFilter['show_canceled'] === 'Y') {
//                    $apiFilter['@STAGE_ID'] = ['LOSE', 'C3:LOSE'];
//                } else   {
//                    $apiFilter['@STAGE_ID'] = ['WON', 'C3:WON'];
//                }
//            }
//        }
//
//        if (isset($arFilter['filter_account_number']) && $arFilter['filter_account_number']) {
//            $apiFilter['=UF_CRM_1668255176610'] = str_replace('HL-', '', $arFilter['filter_account_number']);
//        }
//
//        if (isset($arFilter['filter_date_from']) && $arFilter['filter_date_from']) {
//            $apiFilter['>=DATE_CREATE'] = $arFilter['filter_date_from'];
//        }
//
//        if (isset($arFilter['filter_date_to']) && $arFilter['filter_date_to']) {
//            $apiFilter['<=DATE_CREATE'] = $arFilter['filter_date_to'];
//        }
//
//        $sCacheKey = md5($sEmail . serialize($arFilter) . serialize($arSort));
//
//        if (!isset($this->arCachedDeals[$sCacheKey])) {
//            $allDeals = [];
//            $iStart = 0;
//            $batchSize = 50;
//
//            do {
//                $arResponse = $this->callMethod('crm.deal.list', [
//                    'filter' => $apiFilter,
//                    'select' => ['ID', 'TITLE', '*', 'STAGE_ID', 'OPPORTUNITY', 'CURRENCY_ID', 'DATE_CREATE', 'CLOSED', 'DATE_CLOSED'],
//                    'order' => $arSort,
//                    'start' => $iStart,
//                    'limit' => $batchSize,
//                ]);
//
//                if (empty($arResponse['result'])) break;
//
//                $allDeals = array_merge($allDeals, $arResponse['result']);
//                echo '<pre>';
//                var_dump($apiFilter,$arResponse);
//                echo '</pre>';
//                $iStart += $batchSize;
//            } while (count($arResponse['result']) === $batchSize && false);
//
//            if (isset($arFilter['filter_payed']) && $arFilter['filter_payed'] === 'Y') {
//                $filteredDeals = [];
//                foreach ($allDeals as $deal) {
//                    if ($this->isPaid($deal)) {
//                        $filteredDeals[] = $deal;
//                    }
//                }
//                $allDeals = $filteredDeals;
//            }
//
//            $this->arCachedDeals[$sCacheKey] = $allDeals;
//        }
//
//        $allDeals = $this->arCachedDeals[$sCacheKey];
//        $iTotalDeals = count($allDeals);
//
//        $startPosition = ($iPage - 1) * $iPageSize;
//        $arPaginatedDeals = array_slice($allDeals, $startPosition, $iPageSize);
//
//        return [
//            'result' => $arPaginatedDeals,
//            'total' => $iTotalDeals
//        ];
//    }

    public function getDealById($dealId)
    {
        $method = 'crm.deal.get';
        $params = [
            'id' => $dealId,
            'select' => ['*', 'UF_*']
        ];

        return $this->callMethod($method, $params);
    }

    public function getDealByAccountNumber($sAccNumber)
    {
        $method = 'crm.deal.list';
        $params = [
            'filter' => [
                '=UF_CRM_1668255176610' => $sAccNumber
            ],
            'select' => ['*', 'UF_*']
        ];

        return $this->callMethod($method, $params);
    }

    public function getDealProducts($iDealId)
    {
        $sMethod = 'crm.deal.productrows.get';
        $arParams = ['id' => $iDealId];

        return $this->callMethod($sMethod, $arParams);
    }

    public function getDealPayments($sDealId, $sOrderId): array
    {
        if (isset($this->arCachedPayments[$sDealId])) {
            return $this->arCachedPayments[$sDealId];
        }

        try {
            $arPayments = $this->callMethod('crm.item.payment.list', [
                'entityTypeId' => 2,
                'entityId' => $sDealId,
                'select' => ['id', 'entityId', '*', 'paymentSystemId', 'name', 'sum', 'status', 'datePaid']
            ]);

            $arResult = [];

            if (!empty($arPayments['result'])) {
                foreach ($arPayments['result'] as $arPayment) {
                    $isPaid = ($arPayment['paid'] === 'Y');

                    $sDateFormat = '';
                    if ($isPaid && $arPayment['datePaid']) {
                        $date = new DateTime($arPayment['datePaid']);
                        $sDateFormat = $date->format('d.m.Y');
                    }

                    $arPaymentData = [
                        'ID' => $arPayment['id'],
                        'PAY_SYSTEM_ID' => $arPayment['paySystemId'],
                        'SUM' => $arPayment['sum'],
                        'ACCOUNT_NUMBER' => $sOrderId,
                       // 'STATUS' =>$arPayment['status'],
                        'ORDER_ID' => $sOrderId,
                        'DATE_PAID' => $arPayment['datePaid'] ?? null,
                        'DATE_PAID_FORMAT' => $sDateFormat,
                        'PAY_SYSTEM_NAME' => $this->getPaySystemName($arPayment['paySystemId']),
                        'IS_PAID' => $isPaid,
                        'PAYMENT_LINK' => null,
                    ];

                    if (!$isPaid) {
                        //$arPaymentData['PAYMENT_LINK'] = $this->getPaymentUrl($arPayment['id']);
                    }

                    $arResult[] = $arPaymentData;
                }
            }

            $this->arCachedPayments[$sDealId] = $arResult;

            return $arResult;
        } catch (Exception $e) {
            AddMessage2Log($e->getMessage(), 'b24_rest');
            return [];
        }
    }

    public function getPaySystemName($iPaySystemId)
    {
        if (empty($iPaySystemId)) {
            return false;
        }

        if (isset($this->paySystemCache[$iPaySystemId])) {
            return $this->paySystemCache[$iPaySystemId];
        }

        return false;
    }

    public function getPaySystemsList()
    {
        if (!empty($this->paySystemCache)) {
            return $this->paySystemCache;
        }

        try {
            $arResponse = $this->callMethod('sale.paysystem.list', [
                'SELECT' => ['ID', 'NAME'],
                'ORDER' => ['NAME' => 'ASC']
            ]);

            if (!empty($arResponse['result'])) {
                foreach ($arResponse['result'] as $arItem) {
                    $this->paySystemCache[$arItem['ID']] = htmlspecialcharsbx($arItem['NAME']);
                }
                return $this->paySystemCache;
            }
        } catch (Exception $e) {
            AddMessage2Log('Ошибка получения списка платежных систем: '.$e->getMessage(), 'b24_rest');
        }
        return [];
    }

    public function getDealShipments($iOrderId)
    {
        if (empty($iOrderId)) {
            return [];
        }

        if (isset($this->shipmentCache[$iOrderId])) {
            return $this->shipmentCache[$iOrderId];
        }

        try {
            $arShipments = $this->getShipmentsByOrderId($iOrderId);

            $arResult = [];
            foreach ($arShipments as $arShipment) {
                $arNormalizedShipment = $this->normalizeShipment($arShipment);
                if (!empty($arNormalizedShipment)) {
                    $arResult[] = $arNormalizedShipment;
                }
            }


            $this->shipmentCache[$iOrderId] = $arResult;

            return $arResult;
        } catch (Exception $e) {
            AddMessage2Log("Ошибка получения отгрузок для заказа {$iOrderId}: " . $e->getMessage(), 'b24_rest');
            return [];
        }
    }

    private function getShipmentsByOrderId($iOrderId): array
    {
        try {
            $arResponse = $this->callMethod('sale.shipment.list', [
                'filter' => ['=orderId' => $iOrderId],
                'select' => [
                    "id",
                    "accountNumber",
                    "allowDelivery",
                    "basePriceDelivery",
                    "canceled",
                    "comments",
                    "companyId",
                    "currency",
                    "customPriceDelivery",
                    "dateAllowDelivery",
                    "dateCanceled",
                    "dateDeducted",
                    "dateInsert",
                    "dateMarked",
                    "dateResponsibleId",
                    "deducted",
                    "deliveryDocDate",
                    "deliveryDocNum",
                    "deliveryId",
                    "deliveryName",
                    "deliveryXmlId",
                    "discountPrice",
                    "empAllowDeliveryId",
                    "empCanceledId",
                    "empDeductedId",
                    "empMarkedId",
                    "empResponsibleId",
                    "externalDelivery",
                    "id1c",
                    "marked",
                    "orderId",
                    "priceDelivery",
                    "reasonMarked",
                    "reasonUndoDeducted",
                    "responsibleId",
                    "statusId",
                    "statusXmlId",
                    "system",
                    "trackingDescription",
                    "trackingLastCheck",
                    "trackingNumber",
                    "trackingStatus",
                    "updated1c",
                    "version1c",
                    "xmlId",
                ]
            ]);

            return isset($arResponse['result']) && isset($arResponse['result']['shipments']) ? $arResponse['result']['shipments'] : [];

        } catch (Exception $e) {
            return [];
        }
    }

    private function normalizeShipment(array $arShipment): array
    {
        $arNormalized = [
            'ID' => $arShipment['id'] ?? null,
            'ORDER_ID' => $arShipment['orderId'] ?? null,
            'STATUS_ID' => $arShipment['statusId'] ?? null,
            'DELIVERY_ID' => $arShipment['deliveryId'] ?? null,
            'DELIVERY_NAME' => $arShipment['deliveryName'] ?? null,
            'TRACKING_NUMBER' => $arShipment['trackingNumber'] ?? null,
            'DATE_INSERT' => $arShipmentt['dateInsert'] ?? null,
            'PRICE_DELIVERY' => $arShipment['priceDelivery'] ?? 0,
            'CURRENCY' => $arShipment['currency'] ?? 'RUB',
            'BASE_PRICE_DELIVERY' => $arShipment['basePriceDelivery'] ?? 0,
            'ITEMS' => $this->getShipmentItems($arShipment['id'] ?? 0)
        ];
        return $arNormalized;
    }

    private function getShipmentItems($iShipmentId): array
    {
        if (empty($iShipmentId)) {
            return [];
        }

        try {
            $arResponse = $this->callMethod('sale.shipment.item.list', [
                'filter' => ['SHIPMENT_ID' => $iShipmentId],
                'select' => ['ID', 'ORDER_DELIVERY_ID', 'BASKET_ID', 'PRODUCT_ID',
                    'QUANTITY', 'NAME', 'MEASURE_NAME', 'PRICE', 'CURRENCY']
            ]);

            $arItems = [];
            foreach ($arResponse['result'] ?? [] as $arItem) {
                $arItems[] = [
                    'ID' => $arItem['ID'] ?? null,
                    'ORDER_DELIVERY_ID' => $arItem['ORDER_DELIVERY_ID'] ?? null,
                    'BASKET_ID' => $arItem['BASKET_ID'] ?? null,
                    'PRODUCT_ID' => $arItem['PRODUCT_ID'] ?? null,
                    'QUANTITY' => $arItem['QUANTITY'] ?? 0,
                    'NAME' => $arItem['NAME'] ?? null,
                    'MEASURE_NAME' => $arItem['MEASURE_NAME'] ?? (LANGUAGE_ID == 'ru' ? 'шт.' : 'pcs'),
                    'PRICE' => $arItem['PRICE'] ?? 0,
                    'CURRENCY' => $arItem['CURRENCY'] ?? 'RUB',
                    'SUM' => ($arItem['PRICE'] ?? 0) * ($arItem['QUANTITY'] ?? 0)
                ];
            }

            return $arItems;
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCurrentUserEmail(): ?string
    {
        global $USER;

        if (is_object($USER) && $USER->IsAuthorized()) {
            return $USER->GetEmail() ?: null;
        }

        return null;
    }

    public function isDealLinkedToEmail(array $arDeal, string $sEmail): bool
    {
        if (!empty($arDeal['CONTACT_ID'])) {
            $arContactData = $this->callMethod('crm.contact.get', [
                'ID' => $arDeal['CONTACT_ID']
            ]);

            if (!empty($arContactData['result']['EMAIL'])) {
                foreach ($arContactData['result']['EMAIL'] as $arContactEmail) {
                    if (strtolower($arContactEmail['VALUE']) === strtolower($sEmail)) {
                        return true;
                    }
                }
            }
        }

        if (!empty($arDeal['COMPANY_ID'])) {
            $arCompanyData = $this->callMethod('crm.company.get', [
                'ID' => $arDeal['COMPANY_ID'],
            ]);

            if (!empty($arCompanyData['result']['EMAIL'])) {
                foreach ($arCompanyData['result']['EMAIL'] as $arCompanyEmail) {
                    if (strtolower($arCompanyEmail['VALUE']) === strtolower($sEmail)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

public function getDealByOrderId(int $iOrderId): ?array
{
    try {
        $arResult = $this->callMethod('crm.orderentity.list', [
            'select' => ['orderId', 'ownerId', 'ownerTypeId'],
            'filter' => [
                '=ownerTypeId' => 2, // сделка
                '=orderId'     => $iOrderId,
            ],
            'limit' => 1
        ]);

        $entities = $arResult['result']['orderEntity'] ?? [];
        if (!empty($entities[0]['ownerId'])) {
            return $entities[0]; // ['orderId' => 11959, 'ownerId' => 30356]
        }
    } catch (Exception $e) {
        AddMessage2Log('getDealByOrderId error: ' . $e->getMessage(), 'b24_rest');
    }

    return null;
}
}