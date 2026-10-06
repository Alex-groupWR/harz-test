<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
Loader::includeModule("iblock");

$IBLOCK_ID = 43; // ID инфоблока статей из настроек

// Выборка элементов
$res = CIBlockElement::GetList(
    ["SORT" => "ASC", "ID" => "DESC"],
    ["IBLOCK_ID" => $IBLOCK_ID, "ACTIVE" => "Y"],
    false,
    false,
    ["ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_YES_COUNTER", "PROPERTY_NO_COUNTER", "PROPERTY_IS_HIDE_VOTE", "PROPERTY_NAME_RU"]
);

$articles = [];
$totalYes = 0;
$totalNo = 0;
$totalVotes = 0;

while ($item = $res->GetNext()) {
    $yes = (int)($item["PROPERTY_YES_COUNTER_VALUE"] ?? 0);
    $no = (int)($item["PROPERTY_NO_COUNTER_VALUE"] ?? 0);
    $sum = $yes + $no;
    $rate = $sum > 0 ? round(($yes / $sum) * 100, 1) : 0;
    
    $totalYes += $yes;
    $totalNo += $no;
    $totalVotes += $sum;

    $articles[] = [
        "ID" => $item["ID"],
        "NAME" => $item["PROPERTY_NAME_RU_VALUE"],
        "URL" => $item["DETAIL_PAGE_URL"],
        "YES" => $yes,
        "NO" => $no,
        "TOTAL" => $sum,
        "RATE" => $rate,
        "IS_HIDDEN" => !empty($item["PROPERTY_IS_HIDE_VOTE_VALUE"])
    ];
}

$avgRating = $totalVotes > 0 ? round(($totalYes / $totalVotes) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Аналитика полезности статей</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f4f7f9; margin: 0; padding: 25px; color: #333; }
        .analytics-container { max-width: 1200px; margin: 0 auto; }
        
        /* KPI Карточки */
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .kpi-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .kpi-title { font-size: 13px; color: #7f8fa4; text-transform: uppercase; margin-bottom: 8px; font-weight: 600; }
        .kpi-value { font-size: 26px; font-weight: bold; }
        .kpi-value.green { color: #2ecc71; }
        .kpi-value.red { color: #e74c3c; }

        /* Фильтры */
        .filter-panel { background: #fff; padding: 15px 20px; border-radius: 8px; display: flex; gap: 15px; align-items: center; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .filter-panel input, .filter-panel select { padding: 8px 12px; border: 1px solid #dcdfe6; border-radius: 6px; font-size: 14px; outline: none; }
        .filter-panel input:focus, .filter-panel select:focus { border-color: #409eff; }
        .filter-search { flex-grow: 1; }

        /* Таблица */
        .table-card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background: #fafbfc; color: #5c6b77; padding: 14px 16px; border-bottom: 1px solid #eef1f5; font-weight: 600; }
        td { padding: 14px 16px; border-bottom: 1px solid #f0f2f5; }
        tr:hover { background-color: #f9fafc; }
        
        /* Прогресс-бар */
        .progress-wrap { display: flex; align-items: center; gap: 10px; }
        .progress-bar-bg { width: 100px; height: 8px; background: #ebedf2; border-radius: 4px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 4px; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-green { background: #e8f8f0; color: #2ecc71; }
        .badge-red { background: #fdeeee; color: #e74c3c; }
        .badge-gray { background: #f0f2f5; color: #909399; }
    </style>
</head>
<body>

<div class="analytics-container">
    <h2>Сводный отчет: Оценка полезности контента</h2>

    <!-- Аналитические выводы / KPI -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-title">Всего статей</div>
            <div class="kpi-value"><?= count($articles) ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Всего голосов</div>
            <div class="kpi-value"><?= $totalVotes ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Средняя полезность</div>
            <div class="kpi-value <?= $avgRating >= 70 ? 'green' : ($avgRating < 40 ? 'red' : '') ?>"><?= $avgRating ?>%</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Голосов «Да» / «Нет»</div>
            <div class="kpi-value"><span class="green"><?= $totalYes ?></span> / <span class="red"><?= $totalNo ?></span></div>
        </div>
    </div>

    <!-- Фильтры -->
    <div class="filter-panel">
        <input type="text" id="searchInput" class="filter-search" placeholder="Поиск по названию или ID статьи...">
        <select id="rateFilter">
            <option value="all">Все оценки</option>
            <option value="high">Высокая полезность (>= 75%)</option>
            <option value="low">Требует доработки (< 50%)</option>
            <option value="novotes">Без оценок (0 голосов)</option>
        </select>
        <select id="statusFilter">
            <option value="all">Все статьи</option>
            <option value="active_vote">Голосование включено</option>
            <option value="hidden_vote">Голосование скрыто</option>
        </select>
    </div>

    <!-- Таблица -->
    <div class="table-card">
        <table id="analyticsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название статьи</th>
                    <th>Оценка (Да / Нет)</th>
                    <th>Всего голосов</th>
                    <th>Индекс полезности</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $row): 
                    $fillColor = $row["RATE"] >= 70 ? '#2ecc71' : ($row["RATE"] <= 40 ? '#e74c3c' : '#f39c12');
                ?>
                <tr data-name="<?= strtolower(htmlspecialchars($row["NAME"])) ?>" 
                    data-id="<?= $row["ID"] ?>" 
                    data-votes="<?= $row["TOTAL"] ?>" 
                    data-rate="<?= $row["RATE"] ?>"
                    data-hidden="<?= $row["IS_HIDDEN"] ? '1' : '0' ?>">
                    <td><?= $row["ID"] ?></td>
                    <td><strong><?= htmlspecialchars($row["NAME"]) ?></strong></td>
                    <td>
                        <span class="badge badge-green">+<?= $row["YES"] ?></span>
                        <span class="badge badge-red">-<?= $row["NO"] ?></span>
                    </td>
                    <td><?= $row["TOTAL"] ?></td>
                    <td>
                        <div class="progress-wrap">
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: <?= $row["TOTAL"] > 0 ? $row["RATE"] : 0 ?>%; background-color: <?= $fillColor ?>;"></div>
                            </div>
                            <span><?= $row["TOTAL"] > 0 ? $row["RATE"].'%' : '—' ?></span>
                        </div>
                    </td>
                    <td>
                        <?php if ($row["IS_HIDDEN"]): ?>
                            <span class="badge badge-gray">Скрыто</span>
                        <?php else: ?>
                            <span class="badge badge-green">Активно</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const rateFilter = document.getElementById('rateFilter');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('#analyticsTable tbody tr');

    function filterTable() {
        const query = searchInput.value.toLowerCase().trim();
        const rateVal = rateFilter.value;
        const statusVal = statusFilter.value;

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const id = row.getAttribute('data-id');
            const votes = parseInt(row.getAttribute('data-votes'), 10);
            const rate = parseFloat(row.getAttribute('data-rate'));
            const isHidden = row.getAttribute('data-hidden') === '1';

            // Поиск
            const matchesSearch = !query || name.includes(query) || id.includes(query);

            // Фильтр по рейтингу
            let matchesRate = true;
            if (rateVal === 'high') matchesRate = votes > 0 && rate >= 75;
            if (rateVal === 'low') matchesRate = votes > 0 && rate < 50;
            if (rateVal === 'novotes') matchesRate = votes === 0;

            // Фильтр по статусу опроса (IS_HIDE_VOTE)
            let matchesStatus = true;
            if (statusVal === 'active_vote') matchesStatus = !isHidden;
            if (statusVal === 'hidden_vote') matchesStatus = isHidden;

            row.style.display = (matchesSearch && matchesRate && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    rateFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>

</body>
</html>