<?php
/**
 * Connect to DB
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';
/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
$sql = <<<'SQL'
SELECT DISTINCT (FirstLetters) FROM (SELECT name, LEFT(name, 1) AS FirstLetters FROM airports) AS UniqueFirstLetters ORDER BY FirstLetters;
SQL;
$uniqueFirstLetters = $pdo->query($sql)->fetchAll();
$sql = <<<'SQL'
SELECT airports.name as name,
       airports.code as code,
       states.name as state_name,
       cities.name as city_name,
       airports.address as address,
       airports.timezone as timezone
FROM airports LEFT JOIN states ON airports.state_id = states.id
        LEFT JOIN cities ON airports.city_id = cities.id
SQL;

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */
if (isset($_GET['filter_by_first_letter'])) {
    $sql .= ' WHERE airports.name LIKE \'' . $_GET['filter_by_first_letter'] . '%\'';
}
if (isset($_GET['filter_by_state'])) {
    $connector = isset($_GET['filter_by_first_letter']) ? 'AND' : 'WHERE';
    $sql .= ' ' . $connector . ' states.name=\'' . $_GET['filter_by_state'] . '\'';
}
// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */
if (isset($_GET['sort'])) {
    $sortFields = [
        'name' => 'airports.name',
        'code' => 'airports.code',
        'state' => 'states.name',
        'city' => 'cities.name',
    ];
    $sql .= ' ORDER BY ' . $sortFields[$_GET['sort']];
}
// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */

if (isset($_GET['page'])) {
    $perPage = 5;
    $countSql = $sql . ';';
    $totalRecords = $pdo->query($countSql)->rowCount();
    $totalPages = ceil($totalRecords / $perPage);
    $_GET['page'] = $totalPages < $_GET['page'] ? $totalPages : $_GET['page'];
    $offset = (int)$_GET['page'] - 1;
    $sql .= ' LIMIT ' . $perPage . ' OFFSET ' . $offset;
} else {
    $totalPages = 1;
}
/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$sql .= ';';
$airports = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:
        <?php foreach ($uniqueFirstLetters as $letter): ?>
            <?php if (isset($_GET['page'])): ?>
                <a href="/?<?= http_build_query(array_replace($_GET, ['filter_by_first_letter' => $letter['FirstLetters']])) ?>">
                    <?= $letter['FirstLetters'] ?>
                </a>
            <?php else: ?>
                <a href="/?<?= http_build_query(array_replace($_GET, ['filter_by_first_letter' => $letter['FirstLetters']], ['page' => 1])) ?>">
                    <?= $letter['FirstLetters'] ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>

        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">
                <a href="/?<?= http_build_query(array_replace($_GET, ['sort' => 'name'])) ?>">Name</a>
            </th>
            <th scope="col">
                <a href="/?<?= http_build_query(array_replace($_GET, ['sort' => 'code'])) ?>">Code</a>
            </th>
            <th scope="col">
                <a href="/?<?= http_build_query(array_replace($_GET, ['sort' => 'state'])) ?>">State</a>
            </th>
            <th scope="col">
                <a href="/?<?= http_build_query(array_replace($_GET, ['sort' => 'city'])) ?>">City</a>
            </th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td>
                <?php if (isset($_GET['page'])): ?>
                    <a href="/?<?= http_build_query(array_replace($_GET, ['filter_by_state' => $airport['state_name']])) ?>">
                        <?= $airport['state_name'] ?>
                    </a>
                <?php else: ?>
                    <a href="/?<?= http_build_query(array_replace($_GET, ['filter_by_state' => $airport['state_name']], ['page' => 1])) ?>">
                        <?= $airport['state_name'] ?>
                    </a>
                <?php endif; ?>

            </td>
            <td><?= $airport['city_name'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php
                $isActive = 'active';
                if (isset($_GET['page'])) {
                    $isActive = (int)$_GET['page'] === $i ? 'active' : '';
                }
                ?>
                <li class="page-item <?= $isActive ?>">
                    <a class="page-link" href="/?<?= http_build_query(array_replace($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</main>
</html>
