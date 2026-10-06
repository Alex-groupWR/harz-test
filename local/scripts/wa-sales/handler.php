<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once('functions.php');

$widgetUri = 'WA Sales';//detail page chat "https://example.com/index.php"
$widgetName = 'WA Sales API';//name connector in widget

$connector_id = getConnectorID();

if (!empty($_REQUEST['PLACEMENT_OPTIONS']) && $_REQUEST['PLACEMENT'] == 'SETTING_CONNECTOR') {
	//activate connector
	$options = json_decode($_REQUEST['PLACEMENT_OPTIONS'], true);
	$result = CRest::call(
		'imconnector.activate',
		[
			'CONNECTOR' => $connector_id,
			'LINE' => intVal($options['LINE']),
			'ACTIVE' => intVal($options['ACTIVE_STATUS']),
		]
	);
	if (!empty($result['result'])) {
		//add data widget
		if (!empty($widgetUri) && !empty($widgetName)) {
			$resultWidgetData = CRest::call(
				'imconnector.connector.data.set',
				[
					'CONNECTOR' => $connector_id,
					'LINE' => intVal($options['LINE']),
					'DATA' => [
						'id' => $connector_id . 'line' . intVal($options['LINE']),//
						'url_im' => $widgetUri,
						'name' => $widgetName
					],
				]
			);
			if (!empty($resultWidgetData['result'])) {
				setLine($options['LINE']);
				echo 'successfully 1';
			}
		} else {
			setLine($options['LINE']);
			echo 'successfully 2';
		}
	}
}