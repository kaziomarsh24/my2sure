<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class source_plan extends Model
{
    protected $table = "source_plan";
    protected $fillable = ['id', 'number'];
    public $timestamps = false;

    function getLetters($index)
    {

        $charIndex = $index % 26; // Calculate the character index (0-25)
        $char = chr(65 + $charIndex); // Convert the character index to A-Z

        if ($index < 26) {
            // If $index is less than 26, return A-Z
            return $char;
        } else {
            // If $index is 26 or greater, append the repetition number (1-based)
            $repetitionNumber = floor($index / 26);
            return $char . $repetitionNumber;
        }
    }

    function createPlans($sourcePlansArray)
    {


        // Step 1: Define the source table with n number of 2s.
//        $sourceTable = [[22, 33], [19, 11], [20, 50], [27, 9], [12, 23], [21, 13], [22, 33], [19, 11], [20, 50], [27, 9], [12, 23], [21, 13], [22, 33], [19, 11], [20, 50], [27, 9], [12, 23], [21, 13], [22, 33], [19, 11], [20, 50], [27, 9], [12, 23], [21, 13]];
        $sourceTable = $sourcePlansArray;

// Step 2: Generate the target table based on the source table.
        $targetTable = [];


        function generateSequence($index)
        {

            $charIndex = $index % 26; // Calculate the character index (0-25)
            $char = chr(65 + $charIndex); // Convert the character index to A-Z

            if ($index < 26) {
                // If $index is less than 26, return A-Z
                return $char;
            } else {
                // If $index is 26 or greater, append the repetition number (1-based)
                $repetitionNumber = floor($index / 26);
                return $char . $repetitionNumber;
            }
        }

        $additionalEntries = count($sourceTable) * 2;

// Generate 2s entries from the source table.
        foreach ($sourceTable as $index => $values) {
            $letter = generateSequence($index);
            $object = new stdClass();
            $object->type = "2";
            $object->letter = $letter;
            $object->values = [$values[0], $values[1]];
            $targetTable[] = $object;
        }

// Generate additional 2s entries by modifying n1 and n2.
        for ($i = 0; $i < $additionalEntries; $i += 2) {
            $n1 = $sourceTable[$i / 2][0] - 10;
            $n2 = $sourceTable[$i / 2][1] + 1;
            $letter = generateSequence(count($sourceTable) + $i / 2); // Automatically generate letters
            $object = new stdClass();
            $object->type = "2";
            $object->letter = $letter;
            $object->values = [$n1, $n2];
            $targetTable[] = $object;

        }


        $generated6s = [];

        foreach ($targetTable as $item) {
            if ($item->type === "2") {
                list($n1, $n2) = $item->values;

                // Generate three values for n1 and n2
                $n1Values = [$n1 - 1, $n1, $n1 + 1];
                $n2Values = [$n2 - 1, $n2, $n2 + 1];
                $finalValue = array_merge($n1Values, $n2Values);

                $object = new stdClass();
                $object->type = "6";
                $object->letter = $item->letter;
                $object->values = $finalValue;
                $generated6s[] = $object;

            }
        }

// Merge the generated 6s elements into the targetTable
        $targetTable = array_merge($targetTable, $generated6s);

        $generated3s = [];

        foreach ($targetTable as $item) {
            if ($item->type === "6") {
                // Split the 6s values into two groups, A1 and A2
                $values = $item->values;
                $groupA1 = array_slice($values, 0, 3);
                $groupA2 = array_slice($values, 3);

                // Generate 3s A1
                $objectA1 = new stdClass();
                $objectA1->type = "3";
                $objectA1->letter = $item->letter . "1";
                $objectA1->values = $groupA1;
                $generated3s[] = $objectA1;

                // Generate 3s A2
                $objectA2 = new stdClass();
                $objectA2->type = "3";
                $objectA2->letter = $item->letter . "2";
                $objectA2->values = $groupA2;
                $generated3s[] = $objectA2;
            }
        }

        $targetTable = array_merge($targetTable, $generated3s);


        $jsonTargetTablePretty = json_encode($targetTable, JSON_PRETTY_PRINT);
        $jsonTargetTable = json_encode($targetTable);

//        echo '<pre>';
//        echo $jsonTargetTablePretty;

        return $targetTable;


    }
}
