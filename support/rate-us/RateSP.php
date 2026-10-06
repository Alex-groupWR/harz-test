<?php
include_once('crest.php');
class RateSP
{
    public static function updateStatusCoupon($desc): void
    {
        $SPlist = CRest::call(
            'crm.item.list',
            [
                'entityTypeId' => 1054,
                'select' => ["id"],
                'filter' => [
                    "ufCrm10_1759942592008" => $desc,
                ],
            ]
        );

        $SP = current($SPlist['result']['items'] ?? []);
            
        if($SP['id'])
        {
            CRest::call(
                'crm.item.update',
                [
                    'entityTypeId' => 1054,
                    'id' => $SP['id'],
                    'fields' => [
                        'ufCrm10_1760041935807' => 'Использован',
                    ]
                ]
            );  
        }  
        
    }
}