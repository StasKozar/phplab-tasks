<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    // put your logic here
    $result = [];

    foreach ($airports as $airport) {
        $airportNameArray = str_split($airport['name']);
        $result[] = $airportNameArray[0];
    }
    sort($result);

    return array_unique($result);
}

function filterAirportsByFirstLetter(array $airports): array
{
    $filteredArray = $airports;
    if (isset($_GET['filter_by_first_letter'])) {
        $filteredArray = array_filter($airports, function ($airport) {
            if ($airport['name']{0} === $_GET['filter_by_first_letter']) {
                return $airport;
            }
        });
    }

    return $filteredArray;
}

function filterAirportsByState(array $airports): array
{
    $filteredArray = $airports;
    if (isset($_GET['filter_by_state'])) {
        $filteredArray = array_filter($airports, function ($airport) {
            if ($airport['state']{0} === $_GET['filter_by_state']) {
                return $airport;
            }
        });
    }

    return $filteredArray;
}

function getTotalPages($airports, int $perPage): int
{
    if (isset($_GET['page'])) {
        return (int)ceil(count($airports)/$perPage);
    }
    return 1;
}

function getAirportsForCurrentPage(array $airports, int $perPage): array
{
    if (isset($_GET['page'])) {
        return array_slice($airports, ($_GET['page']-1)*$perPage, $perPage);
    }

    return $airports;
}