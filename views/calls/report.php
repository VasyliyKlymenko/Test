<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calls Report</title>
</head>
<body>
<table border="1">
    <tr>
        <th>Customer ID</th>
        <th>Number of calls within the same continent</th>
        <th>Total Duration of calls within the same continent</th>
        <th>Total number of all calls</th>
        <th>The total duration of all calls</th>
    </tr>
    <?php foreach ($callsReportData as $customerId => $customerReportData) { ?>
        <tr>
            <td><?= $customerId ?></td>
            <td><?= $customerReportData["sameContinentNumber"] ?></td>
            <td><?= $customerReportData["sameContinentDuration"] ?></td>
            <td><?= $customerReportData["totalNumber"] ?></td>
            <td><?= $customerReportData["totalDuration"] ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>