<?php
/**
 * The $input variable contains an array of digits
 * Return an array which will contain the same digits but repetitive by its value
 * without changing the order.
 * Example: [1,3,2] => [1,3,3,3,2,2]
 *
 * @param  array  $input
 * @return array
 */
function repeatArrayValues(array $input)
{
    $resultArray = [];

    foreach ($input as $value) {
        for ($i = 0; $i < $value; $i++) {
            $resultArray[] = $value;
        }
    }

    return $resultArray;
}

/**
 * The $input variable contains an array of digits
 * Return the lowest unique value or 0 if there is no unique values or array is empty.
 * Example: [1, 2, 3, 2, 1, 5, 6] => 3
 *
 * @param  array  $input
 * @return int
 */
function getUniqueValue(array $input)
{
    if (empty($input)) {
        return 0;
    }
    sort($input);
    $value = array_shift($input);
    if (!in_array($value, $input)) {
        return $value;
    } else {
        array_shift($input);
        return getUniqueValue($input);
    }
}

/**
 * The $input variable contains an array of arrays
 * Each sub array has keys: name (contains strings), tags (contains array of strings)
 * Return the list of names grouped by tags
 * !!! The 'names' in returned array must be sorted ascending.
 *
 * Example:
 * [
 *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
 *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
 *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
 * ]
 *
 * Should be transformed into:
 * [
 *  'fruit' => ['apple', 'orange'],
 *  'green' => ['apple'],
 *  'vegetable' => ['potato'],
 *  'yellow' => ['orange', 'potato'],
 * ]
 *
 * @param  array  $input
 * @return array
 */
function groupByTag(array $input)
{
    $tagsArray = [];

    foreach ($input as $value) {
        foreach ($value['tags'] as $tag) {
            if (!array_key_exists($tag, $tagsArray)) {
                $tagsArray[$tag] = [];
            }
            if (!in_array($value['name'], $tagsArray[$tag])) {
                array_push($tagsArray[$tag], $value['name']);
            }
            sort($tagsArray[$tag]);
        }
    }

    return $tagsArray;
}