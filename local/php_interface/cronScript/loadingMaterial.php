<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if (!$USER->IsAdmin() && $USER->GetID() != 41) {
	LocalRedirect("/personal/");
}



define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);

@set_time_limit(0);
@ignore_user_abort(true);

$iblockId1 = 71;
$parentSectionId1 = 5211;
$iblockId2 = 72;
$parentSectionId2 = 5213;

$uploadResult = null;

// Запускаем сессию для PRG-паттерна
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// ─── BACKUP ──────────────────────────────────────────────────────────────────

function createBackup($iblockId, $parentSectionId, $iblockLabel) {
	CModule::IncludeModule('iblock');

	$backupDir = $_SERVER["DOCUMENT_ROOT"] . "/upload/material_backups/";
	if (!is_dir($backupDir)) {
		mkdir($backupDir, 0777, true);
	}

	$fileName = "backup_ib{$iblockId}_" . date('Y-m-d_H-i-s') . ".csv";
	$filePath = $backupDir . $fileName;

	$handle = fopen($filePath, 'w');
	if (!$handle) {
		throw new Exception("Не удалось создать файл бэкапа: {$filePath}");
	}

	// Заголовки CSV (те же колонки, что принимает парсер)
	$headers = [
		'Code', 'Материал',
		'Количество базовых слоев, шт',
		'Время засветки 50мкм, с', 'Время засветки низа 50мкм, с',
		'Время засветки 100мкм, с', 'Время засветки низа 100мкм, с',
		'Время засветки 200мкм, с', 'Время засветки низа 200мкм, с',
		'Пауза в нижнем положении, с',
		'Выоста подъема столика, мм',
		'Скорость подъема столика, мм/мин',
		'Скорость опускания столика, мм/мин',
	];
	fputcsv($handle, $headers, ',', '"');

	$propMap = [
		'Количество базовых слоев, шт'         => 'BASE_LAYORTS',
		'Время засветки 50мкм, с'               => 'T_50_ILLUMINATION',
		'Время засветки низа 50мкм, с'          => 'T_50_ILLUMINATION_FOOTER',
		'Время засветки 100мкм, с'              => 'T_100_ILLUMINATION',
		'Время засветки низа 100мкм, с'         => 'T_100_ILLUMINATION_FOOTER',
		'Время засветки 200мкм, с'              => 'T_200_ILLUMINATION',
		'Время засветки низа 200мкм, с'         => 'T_200_ILLUMINATION_FOOTER',
		'Пауза в нижнем положении, с'           => 'PAUSE_FOOTER',
		'Выоста подъема столика, мм'            => 'TABLE_HEIGHT',
		'Скорость подъема столика, мм/мин'      => 'TABLE_UP',
		'Скорость опускания столика, мм/мин'    => 'TABLE_DOWN',
	];

	// Получаем все секции внутри parentSection
	$sectionRes = CIBlockSection::GetList(
		['SORT' => 'ASC'],
		['IBLOCK_ID' => $iblockId, 'SECTION_ID' => $parentSectionId, 'CHECK_PERMISSIONS' => 'N'],
		false,
		['ID', 'CODE', 'NAME']
	);

	$rows = 0;

	while ($section = $sectionRes->Fetch()) {
		$sectionCode = urldecode($section['CODE']);

		$elRes = CIBlockElement::GetList(
			['NAME' => 'ASC'],
			[
				'IBLOCK_ID'          => $iblockId,
				'IBLOCK_SECTION_ID'  => $section['ID'],
				'INCLUDE_SUBSECTIONS'=> 'N',
				'CHECK_PERMISSIONS'  => 'N',
			],
			false,
			false,
			['ID', 'NAME']
		);

		while ($element = $elRes->Fetch()) {
			$row = ['Code' => $sectionCode, 'Материал' => $element['NAME']];

			// Загружаем свойства
			$propRes = CIBlockElement::GetProperty(
				$iblockId,
				$element['ID'],
				[],
				['EMPTY' => 'N']
			);
			$props = [];
			while ($prop = $propRes->Fetch()) {
				$props[$prop['CODE']] = $prop['VALUE'];
			}

			foreach (array_values($propMap) as $code) {
				$row[] = isset($props[$code]) ? $props[$code] : '0';
			}

			fputcsv($handle, $row, ',', '"');
			$rows++;
		}
	}

	fclose($handle);

	return [
		'file'  => $fileName,
		'path'  => $filePath,
		'url'   => "/upload/material_backups/{$fileName}",
		'rows'  => $rows,
	];
}

// ─── PARSE ───────────────────────────────────────────────────────────────────

function parseSettingsTable($filePath) {
	$settings = [];
	if (($handle = fopen($filePath, "r")) !== FALSE) {
		$firstLine = fgets($handle);
		rewind($handle);
		$delimiter = strpos($firstLine, "\t") !== false ? "\t" : ",";
		$headers = fgetcsv($handle, 4000, $delimiter, '"');
		if ($headers) {
			$headers = array_map('trim', $headers);
		}
		while (($data = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
			if (count($data) !== count($headers)) continue;
			$row = array_combine($headers, $data);
			$settings[] = [
				'PRINTER_NAME'      => trim($row['Принтер'] ?? ''),
				'SECTION_CODE'      => trim($row['Code']                                ?? $row['Код']               ?? ''),
				'MATERIAL_NAME'     => trim($row['Матреиал']                            ?? $row['Материал']          ?? ''),
				'BASE_LAYERS'       => trim($row['Количество базовых слоев, шт']        ?? $row['Базовые слои']      ?? '0'),
				'EXPOSURE_50'       => trim($row['Время засветки 50мкм, с']             ?? $row['Засветка 50']       ?? '0'),
				'BOTTOM_EXPOSURE_50'=> trim($row['Время засветки низа 50мкм, с']        ?? $row['Засветка низа 50']  ?? '0'),
				'EXPOSURE_100'      => trim($row['Время засветки 100мкм, с']            ?? $row['Засветка 100']      ?? '0'),
				'BOTTOM_EXPOSURE_100'=>trim($row['Время засветки низа 100мкм, с']       ?? $row['Засветка низа 100'] ?? '0'),
				'EXPOSURE_200'      => trim($row['Время засветки 200мкм, с']            ?? $row['Засветка 200']      ?? '0'),
				'BOTTOM_EXPOSURE_200'=>trim($row['Время засветки низа 200мкм, с']       ?? $row['Засветка низа 200'] ?? '0'),
				'PAUSE'             => trim($row['Пауза в нижнем положении, с']         ?? $row['Пауза']             ?? '0'),
				'LIFT_HEIGHT'       => trim($row['Выоста подъема столика, мм']          ?? $row['Высота подъема']    ?? '0'),
				'LIFT_SPEED'        => trim($row['Скорость подъема столика, мм/мин']    ?? $row['Скорость подъема']  ?? '0'),
				'RETRACT_SPEED'     => trim($row['Скорость опускания столика, мм/мин']  ?? $row['Скорость опускания']?? '0'),
			];
		}
		fclose($handle);
	}
	return $settings;
}

// ─── SECTION / ELEMENT HELPERS ───────────────────────────────────────────────

function getOrCreateSection($iblockId, $sectionCode, $sectionName, $parentSectionId) {
	CModule::IncludeModule('iblock');
	$encodedCode = sanitizeCode($sectionCode);
	$section = CIBlockSection::GetList(
		[],
		['IBLOCK_ID' => $iblockId, 'CODE' => $encodedCode, 'SECTION_ID' => $parentSectionId],
		false,
		['ID', 'NAME', 'CODE']
	)->Fetch();
	if ($section) return $section['ID'];

	$bs = new CIBlockSection;
	$sectionId = $bs->Add([
		"IBLOCK_ID"        => $iblockId,
		"IBLOCK_SECTION_ID"=> $parentSectionId,
		"NAME"             => $sectionName ?: $sectionCode,
		"CODE"             => $encodedCode,
		"ACTIVE"           => "Y",
		"SORT"             => 500,
	]);
	return $sectionId ?: false;
}

function getOrCreateElement($iblockId, $sectionId, $elementName) {

	CModule::IncludeModule('iblock');
	$res = CIBlockElement::GetList(
		[],
		['IBLOCK_ID' => $iblockId, 'IBLOCK_SECTION_ID' => $sectionId, 'INCLUDE_SUBSECTIONS' => 'N', 'NAME' => $elementName],
		false, false,
		['ID', 'NAME']
	);
	if ($element = $res->Fetch()) return $element['ID'];

	$el = new CIBlockElement;
	$cleanCode = sanitizeCode($elementName);
	$elementId = $el->Add([
		"IBLOCK_ID"        => $iblockId,
		"NAME"             => $elementName,
		"CODE"             => $cleanCode,
		"IBLOCK_SECTION_ID"=> $sectionId,
		"ACTIVE"           => "Y",
		"PREVIEW_TEXT"     => "",
		"DETAIL_TEXT"      => "",
	]);
	return $elementId ?: false;
}

function getAllExistingElements($iblockId, $parentSectionId) {
	CModule::IncludeModule('iblock');
	$existingElements = [];
	$res = CIBlockElement::GetList(
		[],
		['IBLOCK_ID' => $iblockId, 'SECTION_ID' => $parentSectionId, 'INCLUDE_SUBSECTIONS' => 'Y', 'CHECK_PERMISSIONS' => 'N'],
		false, false,
		['ID', 'NAME', 'IBLOCK_SECTION_ID']
	);
	// Кэшируем коды секций
	$sectionCodeCache = [];
	while ($element = $res->Fetch()) {
		$sid = $element['IBLOCK_SECTION_ID'];
		if (!isset($sectionCodeCache[$sid])) {
			$sr = CIBlockSection::GetList([], ['ID' => $sid], false, ['ID', 'CODE']);
			$sc = $sr->Fetch();
			$sectionCodeCache[$sid] = $sc ? $sc['CODE'] : '';
		}
		$key = $sectionCodeCache[$sid] . '_' . $element['NAME'];
		$existingElements[$key] = ['ID' => $element['ID'], 'NAME' => $element['NAME'], 'SECTION_CODE' => $sectionCodeCache[$sid]];
	}
	return $existingElements;
}

function sanitizeCode($string) {
	// Транслитерация кириллицы в латиницу
	$translit = CUtil::translit($string, "ru", [
		"replace_space" => "_",
		"replace_other" => "_",
		"safe_chars" => "",
	]);

	// Удаляем все недопустимые символы (оставляем только латиницу, цифры, дефис, подчеркивание)
	$code = preg_replace('/[^a-zA-Z0-9_-]/', '_', $translit);

	// Убираем повторяющиеся подчеркивания
	$code = preg_replace('/_+/', '_', $code);

	// Удаляем подчеркивания в начале и конце
	$code = trim($code, '_');

	// Если после всех операций строка пуста, генерируем случайный код
	if (empty($code)) {
		$code = 'item_' . time() . '_' . rand(1000, 9999);
	}

	return $code;
}

// ─── CORE UPDATE ─────────────────────────────────────────────────────────────



function updateMaterialsBySettings($iblockId, $settings, $parentSectionId) {
	CModule::IncludeModule('iblock');

	$updatedCount = 0;
	$createdCount = 0;
	$errorCount   = 0;
	$log          = [];
	$processedElements = [];

	$existingElements = getAllExistingElements($iblockId, $parentSectionId);

	foreach ($settings as $setting) {
		if (empty($setting['MATERIAL_NAME'])) {
			$errorCount++;
			$log[] = ['type' => 'error', 'msg' => 'Пустое название материала, строка пропущена'];
			continue;
		}

		$sectionId = getOrCreateSection($iblockId, $setting['SECTION_CODE'],  $setting['PRINTER_NAME'] ?: $setting['SECTION_CODE'], $parentSectionId);
		if (!$sectionId) {
			$errorCount++;
			$log[] = ['type' => 'error', 'msg' => "Не удалось получить/создать раздел: {$setting['SECTION_CODE']}"];
			continue;
		}

		$elementId = getOrCreateElement($iblockId, $sectionId, $setting['MATERIAL_NAME']);
		if (!$elementId) {
			$errorCount++;
			$log[] = ['type' => 'error', 'msg' => "Не удалось получить/создать элемент: {$setting['MATERIAL_NAME']}"];
			continue;
		}

		$elementKey = $setting['SECTION_CODE'] . '_' . $setting['MATERIAL_NAME'];
		$isNew = !isset($existingElements[$elementKey]);
		$processedElements[$elementKey] = true;

		$el = new CIBlockElement;
		$ok = $el->Update($elementId, [
			'PROPERTY_VALUES' => [
				'BASE_LAYORTS'             => $setting['BASE_LAYERS']        ?: '0',
				'T_50_ILLUMINATION'        => $setting['EXPOSURE_50']        ?: '0',
				'T_50_ILLUMINATION_FOOTER' => $setting['BOTTOM_EXPOSURE_50'] ?: '0',
				'T_100_ILLUMINATION'       => $setting['EXPOSURE_100']       ?: '0',
				'T_100_ILLUMINATION_FOOTER'=> $setting['BOTTOM_EXPOSURE_100']?: '0',
				'T_200_ILLUMINATION'       => $setting['EXPOSURE_200']       ?: '0',
				'T_200_ILLUMINATION_FOOTER'=> $setting['BOTTOM_EXPOSURE_200']?: '0',
				'PAUSE_FOOTER'             => $setting['PAUSE']              ?: '0',
				'TABLE_HEIGHT'             => $setting['LIFT_HEIGHT']        ?: '0',
				'TABLE_UP'                 => $setting['LIFT_SPEED']         ?: '0',
				'TABLE_DOWN'               => $setting['RETRACT_SPEED']      ?: '0',
			]
		]);

		if ($ok) {
			if ($isNew) {
				$createdCount++;
				$log[] = ['type' => 'created', 'msg' => "[{$setting['SECTION_CODE']}] {$setting['MATERIAL_NAME']} — создан"];
			} else {
				$updatedCount++;
				$log[] = ['type' => 'updated', 'msg' => "[{$setting['SECTION_CODE']}] {$setting['MATERIAL_NAME']} — обновлён"];
			}
		} else {
			$errorCount++;
			$log[] = ['type' => 'error', 'msg' => "[{$setting['SECTION_CODE']}] {$setting['MATERIAL_NAME']} — ошибка обновления"];
		}
	}

	// Удаляем элементы, отсутствующие в файле
	$deletedCount = 0;
	foreach ($existingElements as $key => $element) {
		if (!isset($processedElements[$key])) {
			if (CIBlockElement::Delete($element['ID'])) {
				$deletedCount++;
				$log[] = ['type' => 'deleted', 'msg' => "[{$element['SECTION_CODE']}] {$element['NAME']} — удалён (отсутствует в файле)"];
			} else {
				$errorCount++;
				$log[] = ['type' => 'error', 'msg' => "[{$element['SECTION_CODE']}] {$element['NAME']} — ошибка удаления"];
			}
		}
	}

	return [
		'updated' => $updatedCount,
		'created' => $createdCount,
		'deleted' => $deletedCount,
		'errors'  => $errorCount,
		'log'     => $log,
	];
}

// ─── REQUEST HANDLING ────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['settings_file'])) {
	// Обрабатываем, сохраняем результат в сессию и делаем redirect (PRG)
	try {
		$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/upload/temp/";
		if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

		$filePath = $uploadDir . time() . "_" . basename($_FILES['settings_file']['name']);
		if (!move_uploaded_file($_FILES['settings_file']['tmp_name'], $filePath)) {
			throw new Exception("Ошибка загрузки файла на сервер");
		}

		$settings = parseSettingsTable($filePath);
		if (empty($settings)) {
			throw new Exception("Файл не содержит данных или имеет неверный формат");
		}

		$updateMode = $_POST['update_mode'];
		$result1 = $result2 = null;
		$backup1 = $backup2 = null;

		if ($updateMode === 'first' || $updateMode === 'both') {
			$backup1 = createBackup($iblockId1, $parentSectionId1, 'ИБ 71');
			$result1 = updateMaterialsBySettings($iblockId1, $settings, $parentSectionId1);
		}
		if ($updateMode === 'second' || $updateMode === 'both') {
			$backup2 = createBackup($iblockId2, $parentSectionId2, 'ИБ 72');
			$result2 = updateMaterialsBySettings($iblockId2, $settings, $parentSectionId2);
		}

		@unlink($filePath);

		$_SESSION['upload_result'] = [
			'success'  => true,
			'result1'  => $result1,
			'result2'  => $result2,
			'backup1'  => $backup1,
			'backup2'  => $backup2,
			'mode'     => $updateMode,
			'rows'     => count($settings),
		];

	} catch (Exception $e) {
		$_SESSION['upload_result'] = ['success' => false, 'error' => $e->getMessage()];
	}

	// PRG: редиректим на GET — при F5 форма не повторится
	$selfUrl = strtok($_SERVER['REQUEST_URI'], '?');
	header('Location: ' . $selfUrl);
	exit;
}

// На GET — забираем результат из сессии (один раз) и очищаем
if (!empty($_SESSION['upload_result'])) {
	$uploadResult = $_SESSION['upload_result'];
	unset($_SESSION['upload_result']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Загрузка настроек материалов</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
	<style>
		:root {
			--bg: #0d0f14;
			--surface: #13161d;
			--surface2: #1a1e28;
			--border: #252836;
			--border2: #2e3347;
			--accent: #5b8dee;
			--accent2: #7c5cfc;
			--green: #3dd68c;
			--red: #f55;
			--yellow: #f5c542;
			--orange: #ff8c42;
			--text: #e8eaf0;
			--text2: #8b90a4;
			--text3: #555a6e;
			--mono: 'JetBrains Mono', monospace;
			--sans: 'Syne', sans-serif;
		}

		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

		body {
			background: var(--bg);
			color: var(--text);
			font-family: var(--sans);
			min-height: 100vh;
			padding: 32px 16px 64px;
			line-height: 1.5;
		}

		/* Grid noise overlay */
		body::before {
			content: '';
			position: fixed; inset: 0;
			background-image:
				linear-gradient(rgba(91,141,238,.03) 1px, transparent 1px),
				linear-gradient(90deg, rgba(91,141,238,.03) 1px, transparent 1px);
			background-size: 40px 40px;
			pointer-events: none;
			z-index: 0;
		}

		.wrap {
			position: relative; z-index: 1;
			max-width: 860px;
			margin: 0 auto;
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		/* ── HEADER ── */
		.hdr {
			display: flex;
			align-items: flex-start;
			justify-content: space-between;
			gap: 16px;
			padding: 28px 32px;
			background: var(--surface);
			border: 1px solid var(--border);
			border-radius: 16px;
			position: relative;
			overflow: hidden;
		}
		.hdr::after {
			content: '';
			position: absolute;
			top: -40px; right: -40px;
			width: 200px; height: 200px;
			border-radius: 50%;
			background: radial-gradient(circle, rgba(91,141,238,.15) 0%, transparent 70%);
			pointer-events: none;
		}
		.hdr-title {
			font-size: 22px;
			font-weight: 800;
			letter-spacing: -.5px;
			line-height: 1.2;
		}
		.hdr-title span { color: var(--accent); }
		.hdr-sub {
			margin-top: 6px;
			font-size: 13px;
			color: var(--text2);
			font-family: var(--mono);
		}
		.badge-wrap { display: flex; gap: 8px; flex-shrink: 0; }
		.badge {
			font-family: var(--mono);
			font-size: 11px;
			padding: 4px 10px;
			border-radius: 6px;
			border: 1px solid;
			white-space: nowrap;
		}
		.badge-blue  { color: var(--accent);  border-color: rgba(91,141,238,.3);  background: rgba(91,141,238,.08); }
		.badge-purple{ color: #a87dff;        border-color: rgba(124,92,252,.3);   background: rgba(124,92,252,.08); }

		/* ── CARD ── */
		.card {
			background: var(--surface);
			border: 1px solid var(--border);
			border-radius: 16px;
			overflow: hidden;
		}
		.card-ttl {
			padding: 16px 24px;
			border-bottom: 1px solid var(--border);
			font-size: 12px;
			font-family: var(--mono);
			color: var(--text2);
			letter-spacing: .08em;
			text-transform: uppercase;
			display: flex;
			align-items: center;
			gap: 8px;
		}
		.card-ttl::before {
			content: '';
			display: inline-block;
			width: 6px; height: 6px;
			border-radius: 50%;
			background: var(--accent);
		}
		.card-body { padding: 24px; }

		/* ── FORM ── */
		.fgroup { margin-bottom: 20px; }
		.flabel {
			display: block;
			font-size: 12px;
			font-family: var(--mono);
			color: var(--text2);
			text-transform: uppercase;
			letter-spacing: .08em;
			margin-bottom: 8px;
		}
		.flabel .req { color: var(--accent); margin-left: 2px; }

		.file-drop {
			position: relative;
			border: 2px dashed var(--border2);
			border-radius: 10px;
			padding: 28px 20px;
			text-align: center;
			cursor: pointer;
			transition: border-color .2s, background .2s;
			background: var(--surface2);
		}
		.file-drop:hover, .file-drop.drag { border-color: var(--accent); background: rgba(91,141,238,.06); }
		.file-drop input[type="file"] {
			position: absolute; inset: 0;
			opacity: 0; cursor: pointer;
			width: 100%; height: 100%;
		}
		.file-drop-icon { font-size: 28px; margin-bottom: 8px; }
		.file-drop-text { font-size: 14px; color: var(--text2); }
		.file-drop-text strong { color: var(--accent); }
		.file-drop-hint { font-family: var(--mono); font-size: 11px; color: var(--text3); margin-top: 6px; }
		.file-name-display {
			display: none;
			margin-top: 10px;
			font-family: var(--mono);
			font-size: 12px;
			color: var(--green);
			background: rgba(61,214,140,.08);
			border: 1px solid rgba(61,214,140,.2);
			border-radius: 6px;
			padding: 6px 12px;
		}

		/* Radio tabs */
		.radio-tabs { display: flex; gap: 1px; background: var(--border); border-radius: 10px; overflow: hidden; padding: 1px; }
		.radio-tabs label {
			flex: 1;
			position: relative;
			cursor: pointer;
		}
		.radio-tabs input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
		.radio-tabs .tab-inner {
			display: block;
			padding: 10px 14px;
			border-radius: 8px;
			text-align: center;
			font-size: 13px;
			color: var(--text2);
			transition: background .2s, color .2s;
			line-height: 1.3;
		}
		.radio-tabs .tab-inner small {
			display: block;
			font-family: var(--mono);
			font-size: 10px;
			opacity: .7;
			margin-top: 2px;
		}
		.radio-tabs input:checked + .tab-inner {
			background: var(--accent);
			color: #fff;
		}
		.radio-tabs input:checked + .tab-inner small { opacity: 1; }

		/* IB info */
		.ib-info {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 12px;
			margin-bottom: 20px;
		}
		.ib-card {
			background: var(--surface2);
			border: 1px solid var(--border);
			border-radius: 10px;
			padding: 14px 16px;
		}
		.ib-card-num {
			font-family: var(--mono);
			font-size: 20px;
			font-weight: 600;
			color: var(--accent);
			line-height: 1;
		}
		.ib-card-name { font-size: 13px; color: var(--text2); margin-top: 4px; }
		.ib-card-id { font-family: var(--mono); font-size: 11px; color: var(--text3); margin-top: 6px; }

		/* Submit */
		.btn-submit {
			width: 100%;
			padding: 14px;
			background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
			color: #fff;
			border: none;
			border-radius: 10px;
			font-family: var(--sans);
			font-size: 15px;
			font-weight: 700;
			cursor: pointer;
			transition: opacity .2s, transform .15s;
			letter-spacing: .02em;
		}
		.btn-submit:hover { opacity: .9; transform: translateY(-1px); }
		.btn-submit:active { transform: translateY(0); }
		.btn-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; }

		/* ── LOADING ── */
		.loading-panel {
			display: none;
			background: var(--surface);
			border: 1px solid var(--border);
			border-radius: 16px;
			padding: 32px;
			text-align: center;
		}
		.loading-panel.show { display: block; }
		.spinner {
			width: 44px; height: 44px;
			border: 3px solid var(--border2);
			border-top-color: var(--accent);
			border-radius: 50%;
			animation: spin .8s linear infinite;
			margin: 0 auto 16px;
		}
		@keyframes spin { to { transform: rotate(360deg); } }
		.loading-text { font-family: var(--mono); font-size: 13px; color: var(--text2); }
		.loading-steps { margin-top: 16px; display: flex; flex-direction: column; gap: 6px; text-align: left; max-width: 340px; margin-inline: auto; }
		.lstep { font-family: var(--mono); font-size: 12px; color: var(--text3); display: flex; align-items: center; gap: 8px; }
		.lstep.active { color: var(--accent); }
		.lstep.done { color: var(--green); }
		.lstep::before { content: '·'; font-size: 20px; line-height: 1; flex-shrink: 0; }
		.lstep.active::before { content: '›'; color: var(--accent); }
		.lstep.done::before  { content: '✓'; font-size: 12px; }

		/* ── RESULT ── */
		.result-panel {
			background: var(--surface);
			border: 1px solid var(--border);
			border-radius: 16px;
			overflow: hidden;
		}
		.result-hdr {
			padding: 16px 24px;
			display: flex;
			align-items: center;
			gap: 10px;
			font-size: 14px;
			font-weight: 700;
		}
		.result-hdr.success { background: rgba(61,214,140,.08); border-bottom: 1px solid rgba(61,214,140,.15); color: var(--green); }
		.result-hdr.error   { background: rgba(255,85,85,.08);  border-bottom: 1px solid rgba(255,85,85,.15);  color: var(--red); }
		.result-hdr-icon { font-size: 18px; }

		.stats-grid {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 1px;
			background: var(--border);
			border-bottom: 1px solid var(--border);
		}
		.stat-cell {
			background: var(--surface2);
			padding: 18px 16px;
			text-align: center;
		}
		.stat-val {
			font-family: var(--mono);
			font-size: 30px;
			font-weight: 600;
			line-height: 1;
		}
		.stat-val.green  { color: var(--green); }
		.stat-val.blue   { color: var(--accent); }
		.stat-val.red    { color: var(--red); }
		.stat-val.orange { color: var(--orange); }
		.stat-lbl { font-size: 11px; color: var(--text3); margin-top: 5px; font-family: var(--mono); text-transform: uppercase; letter-spacing: .06em; }

		.ib-result-label {
			padding: 12px 20px 0;
			font-family: var(--mono);
			font-size: 11px;
			color: var(--text2);
			text-transform: uppercase;
			letter-spacing: .08em;
		}

		/* Backup block */
		.backup-block {
			margin: 16px 20px;
			background: var(--surface2);
			border: 1px solid var(--border2);
			border-radius: 10px;
			padding: 14px 16px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			flex-wrap: wrap;
		}
		.backup-info { flex: 1; min-width: 0; }
		.backup-info-title {
			font-size: 12px;
			font-family: var(--mono);
			color: var(--text2);
			margin-bottom: 4px;
		}
		.backup-info-file {
			font-family: var(--mono);
			font-size: 13px;
			color: var(--yellow);
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.backup-info-rows { font-family: var(--mono); font-size: 11px; color: var(--text3); margin-top: 2px; }
		.btn-download {
			padding: 8px 16px;
			border-radius: 8px;
			background: rgba(245,197,66,.12);
			border: 1px solid rgba(245,197,66,.3);
			color: var(--yellow);
			font-family: var(--mono);
			font-size: 12px;
			font-weight: 600;
			cursor: pointer;
			text-decoration: none;
			white-space: nowrap;
			transition: background .2s;
		}
		.btn-download:hover { background: rgba(245,197,66,.2); }

		/* Log */
		.log-toggle {
			padding: 14px 20px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			cursor: pointer;
			user-select: none;
			border-top: 1px solid var(--border);
			font-family: var(--mono);
			font-size: 12px;
			color: var(--text2);
			transition: background .15s;
		}
		.log-toggle:hover { background: var(--surface2); }
		.log-toggle-arrow { transition: transform .2s; }
		.log-toggle.open .log-toggle-arrow { transform: rotate(180deg); }

		.log-body {
			display: none;
			max-height: 360px;
			overflow-y: auto;
			border-top: 1px solid var(--border);
			padding: 12px 0;
			background: #0a0c10;
		}
		.log-body.show { display: block; }
		.log-line {
			padding: 3px 20px;
			font-family: var(--mono);
			font-size: 12px;
			line-height: 1.6;
			display: flex;
			align-items: baseline;
			gap: 10px;
		}
		.log-line:hover { background: rgba(255,255,255,.02); }
		.log-icon { flex-shrink: 0; width: 14px; text-align: center; }
		.log-line.created .log-icon  { color: var(--green); }
		.log-line.updated .log-icon  { color: var(--accent); }
		.log-line.deleted .log-icon  { color: var(--orange); }
		.log-line.error   .log-icon  { color: var(--red); }
		.log-line.created .log-msg   { color: #c8e6c9; }
		.log-line.updated .log-msg   { color: #bbdefb; }
		.log-line.deleted .log-msg   { color: #ffe0b2; }
		.log-line.error   .log-msg   { color: #ffcdd2; }

		/* Log filter */
		.log-filters {
			display: flex;
			gap: 6px;
			padding: 12px 20px;
			border-top: 1px solid var(--border);
			flex-wrap: wrap;
		}
		.filter-btn {
			padding: 4px 10px;
			border-radius: 5px;
			font-family: var(--mono);
			font-size: 11px;
			cursor: pointer;
			border: 1px solid var(--border2);
			background: transparent;
			color: var(--text2);
			transition: all .15s;
		}
		.filter-btn.active { border-color: var(--accent); color: var(--accent); background: rgba(91,141,238,.1); }

		/* Error panel */
		.error-body { padding: 20px 24px; font-family: var(--mono); font-size: 13px; color: var(--red); }

		/* Scrollbar */
		::-webkit-scrollbar { width: 5px; }
		::-webkit-scrollbar-track { background: transparent; }
		::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 3px; }

		@media (max-width: 560px) {
			.ib-info { grid-template-columns: 1fr; }
			.stats-grid { grid-template-columns: repeat(2, 1fr); }
			.radio-tabs { flex-direction: column; }
			.hdr { flex-direction: column; }
		}
	</style>
</head>
<body>
<div class="wrap">

	<!-- HEADER -->
	<div class="hdr">
		<div>
			<div class="hdr-title">Загрузка настроек<br><span>материалов</span></div>
			<div class="hdr-sub">// iblock material sync tool</div>
		</div>
		<div class="badge-wrap">
			<span class="badge badge-blue">ИБ 71</span>
			<span class="badge badge-purple">ИБ 72</span>
		</div>
	</div>

	<?php if ($uploadResult): ?>

		<?php if ($uploadResult['success']): ?>

			<!-- RESULT SUCCESS -->
			<div class="result-panel">
				<div class="result-hdr success">
					<span class="result-hdr-icon">✓</span>
					Операция выполнена успешно — обработано строк: <?= $uploadResult['rows'] ?>
				</div>

				<?php foreach ([
								   ['result' => $uploadResult['result1'], 'backup' => $uploadResult['backup1'], 'id' => 71, 'label' => 'Совместимые'],
								   ['result' => $uploadResult['result2'], 'backup' => $uploadResult['backup2'], 'id' => 72, 'label' => 'Частично совместимые'],
							   ] as $idx => $ib):
					if (!$ib['result']) continue;
					$r = $ib['result'];
					$b = $ib['backup'];
					?>

					<div class="ib-result-label">// ИБ <?= $ib['id'] ?> — <?= $ib['label'] ?></div>

					<!-- backup -->
					<?php if ($b): ?>
					<div class="backup-block">
						<div class="backup-info">
							<div class="backup-info-title">📦 Бэкап создан до обработки</div>
							<div class="backup-info-file"><?= htmlspecialchars($b['file']) ?></div>
							<div class="backup-info-rows"><?= $b['rows'] ?> элементов сохранено</div>
						</div>
						<a class="btn-download" href="<?= htmlspecialchars($b['url']) ?>" download>⬇ Скачать CSV</a>
					</div>
				<?php endif; ?>

					<!-- stats -->
					<div class="stats-grid">
						<div class="stat-cell">
							<div class="stat-val blue"><?= $r['updated'] ?></div>
							<div class="stat-lbl">Обновлено</div>
						</div>
						<div class="stat-cell">
							<div class="stat-val green"><?= $r['created'] ?></div>
							<div class="stat-lbl">Создано</div>
						</div>
						<div class="stat-cell">
							<div class="stat-val orange"><?= $r['deleted'] ?></div>
							<div class="stat-lbl">Удалено</div>
						</div>
						<div class="stat-cell">
							<div class="stat-val red"><?= $r['errors'] ?></div>
							<div class="stat-lbl">Ошибок</div>
						</div>
					</div>

					<!-- log -->
					<?php if (!empty($r['log'])): ?>
					<div class="log-filters" id="filters-<?= $idx ?>">
						<button class="filter-btn active" data-filter="all" onclick="filterLog(<?= $idx ?>, 'all', this)">Все (<?= count($r['log']) ?>)</button>
						<?php
						$counts = ['updated' => 0, 'created' => 0, 'deleted' => 0, 'error' => 0];
						foreach ($r['log'] as $l) if (isset($counts[$l['type']])) $counts[$l['type']]++;
						$labels = ['updated' => 'Обновлено', 'created' => 'Создано', 'deleted' => 'Удалено', 'error' => 'Ошибки'];
						foreach ($counts as $t => $c): if (!$c) continue; ?>
							<button class="filter-btn" data-filter="<?= $t ?>" onclick="filterLog(<?= $idx ?>, '<?= $t ?>', this)"><?= $labels[$t] ?> (<?= $c ?>)</button>
						<?php endforeach; ?>
					</div>

					<div class="log-toggle" id="logtoggle-<?= $idx ?>" onclick="toggleLog(<?= $idx ?>, this)">
						<span>Журнал операций</span>
						<span class="log-toggle-arrow">▾</span>
					</div>
					<div class="log-body" id="log-<?= $idx ?>">
						<?php
						$icons = ['updated' => '~', 'created' => '+', 'deleted' => '−', 'error' => '✕'];
						foreach ($r['log'] as $l):
							?>
							<div class="log-line <?= $l['type'] ?>" data-type="<?= $l['type'] ?>">
								<span class="log-icon"><?= $icons[$l['type']] ?? '·' ?></span>
								<span class="log-msg"><?= htmlspecialchars($l['msg']) ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php endforeach; ?>
			</div>

		<?php else: ?>
			<!-- RESULT ERROR -->
			<div class="result-panel">
				<div class="result-hdr error">
					<span class="result-hdr-icon">✕</span>
					Ошибка выполнения
				</div>
				<div class="error-body"><?= htmlspecialchars($uploadResult['error']) ?></div>
			</div>
		<?php endif; ?>

	<?php endif; ?>

	<!-- FORM -->
	<div class="card">
		<div class="card-ttl">Параметры загрузки</div>
		<div class="card-body">

			<div class="ib-info">
				<div class="ib-card">
					<div class="ib-card-num">71</div>
					<div class="ib-card-name">Совместимые с актуал</div>
					<div class="ib-card-id">section_id: 5211</div>
				</div>
				<div class="ib-card">
					<div class="ib-card-num">72</div>
					<div class="ib-card-name">Частично совместимые</div>
					<div class="ib-card-id">section_id: 5213</div>
				</div>
			</div>

			<form method="POST" enctype="multipart/form-data" id="uploadForm">

				<div class="fgroup">
					<label class="flabel">CSV файл <span class="req">*</span></label>
					<div class="file-drop" id="fileDrop">
						<input type="file" name="settings_file" accept=".csv,.txt" required id="fileInput">
						<div class="file-drop-icon">📂</div>
						<div class="file-drop-text">Перетащите файл или <strong>выберите на диске</strong></div>
						<div class="file-drop-hint">CSV · разделители: запятая</div>
						<div class="file-name-display" id="fileName"></div>
					</div>
				</div>

				<div class="fgroup">
					<label class="flabel">Целевой инфоблок <span class="req">*</span></label>
					<div class="radio-tabs">
						<label>
							<input type="radio" name="update_mode" value="first" checked>
							<span class="tab-inner">ИБ 71<small>Совместимые</small></span>
						</label>
						<label>
							<input type="radio" name="update_mode" value="second">
							<span class="tab-inner">ИБ 72<small>Частично совместимые</small></span>
						</label>
					</div>
				</div>

				<button type="submit" class="btn-submit" id="submitBtn">
					Создать бэкап и начать загрузку
				</button>
			</form>
		</div>
	</div>

	<!-- LOADING -->
	<div class="loading-panel" id="loadingPanel">
		<div class="spinner"></div>
		<div class="loading-text">Обработка данных, пожалуйста подождите…</div>
		<div class="loading-steps">
			<div class="lstep" id="ls1">Чтение и парсинг файла</div>
			<div class="lstep" id="ls2">Создание бэкапа инфоблока</div>
			<div class="lstep" id="ls3">Синхронизация разделов</div>
			<div class="lstep" id="ls4">Обновление элементов и свойств</div>
			<div class="lstep" id="ls5">Удаление устаревших записей</div>
		</div>
	</div>

</div>

<script>
	// File drop
	const drop = document.getElementById('fileDrop');
	const input = document.getElementById('fileInput');
	const nameEl = document.getElementById('fileName');

	input.addEventListener('change', () => {
		if (input.files[0]) showFileName(input.files[0].name);
	});

	function showFileName(name) {
		nameEl.textContent = '✓ ' + name;
		nameEl.style.display = 'block';
	}

	['dragover','dragenter'].forEach(e => drop.addEventListener(e, ev => {
		ev.preventDefault();
		drop.classList.add('drag');
	}));

	drop.addEventListener('dragleave', ev => {
		// Только если курсор ушёл за пределы зоны (не на дочерний элемент)
		if (!drop.contains(ev.relatedTarget)) drop.classList.remove('drag');
	});

	drop.addEventListener('drop', ev => {
		ev.preventDefault();
		drop.classList.remove('drag');
		const files = ev.dataTransfer.files;
		if (!files.length) return;
		// Передаём файл в input через DataTransfer API
		const dt = new DataTransfer();
		dt.items.add(files[0]);
		input.files = dt.files;
		showFileName(files[0].name);
	});

	// Form submit + animated steps
	const form = document.getElementById('uploadForm');
	const panel = document.getElementById('loadingPanel');
	const submitBtn = document.getElementById('submitBtn');
	const steps = [document.getElementById('ls1'), document.getElementById('ls2'), document.getElementById('ls3'), document.getElementById('ls4'), document.getElementById('ls5')];

	form.addEventListener('submit', function(e) {
		if (!input.files[0]) { e.preventDefault(); return; }
		submitBtn.disabled = true;
		panel.classList.add('show');
		let i = 0;
		function nextStep() {
			if (i > 0) steps[i-1].classList.replace('active', 'done');
			if (i < steps.length) { steps[i].classList.add('active'); i++; setTimeout(nextStep, 900 + Math.random()*400); }
		}
		nextStep();
	});

	// Log toggle
	function toggleLog(idx, el) {
		const body = document.getElementById('log-' + idx);
		const tog  = document.getElementById('logtoggle-' + idx);
		body.classList.toggle('show');
		tog.classList.toggle('open');
	}

	// Log filter
	function filterLog(idx, type, btn) {
		document.querySelectorAll('#filters-' + idx + ' .filter-btn').forEach(b => b.classList.remove('active'));
		btn.classList.add('active');
		document.querySelectorAll('#log-' + idx + ' .log-line').forEach(line => {
			line.style.display = (type === 'all' || line.dataset.type === type) ? '' : 'none';
		});
	}

	// Auto-open log if errors
	document.querySelectorAll('.log-body').forEach((lb, i) => {
		if (lb.querySelector('.log-line.error')) {
			lb.classList.add('show');
			const tog = document.getElementById('logtoggle-' + i);
			if (tog) tog.classList.add('open');
		}
	});
</script>
</body>
</html>
