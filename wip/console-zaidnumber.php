<?php

/**
 * Develop: Basic Environment
 *
 * A simple script that lerages the develop project's autoloader.
 *
 * $Id$
 * $Date$
 *
 * PHP version 8.4
 *
 * @author Philip Michael Raab<philip@cathedral.co.za>
 * @package playground\develop
 * @category playground
 *
 * @license Unlicense
 * @license https://unlicense.org/UNLICENSE Unlicense
 *
 * @version $version
 */

declare(strict_types=1);

// Ensure the develop autoloader is included
require_once 'C:/www/develop/vendor/autoload.php';

//***************************************************************
// Basic Quick Script
// version: 1
// date   : 2025 May 30
// POWERED BY THE DEVELOP PROJECT
//***************************************************************

// \Inane\Cli\Cli::line('Basic Quick Script');

// $times = [1744252934, 1744255009, 1744308331, 1744252934];

// foreach ($times as $time) {
//     $ts = new \Inane\Datetime\Timestamp($time);
//     echo (string) $time . ' => ' . $ts->format('Y-m-d H:i:s') . PHP_EOL;
// }

/**
 * Exception thrown for errors related to ZAID number validation or processing.
 *
 * Extends the InvalidArgumentException to provide more specific exception handling
 * for ZAID number related operations.
 */
class ZAIDNumberException extends \InvalidArgumentException {
    /**
     * Stores validation or processing errors encountered during execution.
     *
     * @var array $errors Array of error messages or error details.
     */
    protected array $errors = [];

    /**
     * Retrieves an array of errors.
     *
     * @return array An array containing error messages or error details.
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * Constructs a new exception for invalid South African ID numbers.
     *
     * @param string         $message   The exception message (default: "Invalid South African ID number").
     * @param int            $code      The exception code (default: 3100).
     * @param \Throwable|null $previous The previous throwable used for exception chaining.
     * @param array          $errors    An array of validation errors (default: empty array).
     */
    public function __construct(string $message = "Invalid South African ID number", int $code = 3100, ?\Throwable $previous = null, array $errors = []) {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }
}

/**
 * Class ZAIDNumber
 *
 * Provides functionality for handling and validating South African ID numbers (ZA ID).
 * Typically includes methods for parsing, validating, and extracting information from ZA ID numbers.
 *
 * Example usage:
 *   $zaid = new ZAIDNumber('8001015009087');
 */
class ZAIDNumber {
    /**
     * Indicates whether the ID number should be verified during object construction.
     *
     * @var bool
     */
    private bool $verify = true; // Whether to verify the ID number on construction

    /**
     * The identification number.
     *
     * @var string
     * @access public (read), private (write)
     */
    public private(set) string $idNumber {
        get => $this->idNumber;
        set(string $value) {
            if ($this->verify && ($errors = static::isValidIdNumber($value)) !== true)
                throw new ZAIDNumberException(message: "Invalid South African ID number: $value", errors: $errors);
            $this->idNumber = $value;
        }
    }

    #region ID Number Properties

    /**
     * The birth date of the individual.
     * 
     * - DateTime object: The birth date as a DateTime object.
     * - string: A date string in the format 'Y-m-d'.
     * - timestamp: A Unix timestamp.
     * - random: Randomly selects a date between 1930-01-01 and now.
     *
     * @var \DateTime
     */
    public \DateTime $birthDate {
        get {
            // Extract birth date from ID number
            $year = static::getFullYear($this->idNumber);
            $month = substr($this->idNumber, 2, 2);
            $day = substr($this->idNumber, 4, 2);

            return \DateTime::createFromFormat('Y-m-d', "{$year}-{$month}-{$day}");
        }
        set(\DateTime|string $value) {
            if (is_string($value)) {
                if (strtolower($value) === 'random') {
                    // Generate a random date between 1930-01-01 and now
                    $min = \DateTime::createFromFormat('Y-m-d', '1930-01-01');
                    $max = new \DateTime();
                    $rand = rand($min->getTimestamp(), $max->getTimestamp());
                    $value = \DateTime::createFromFormat('U', (string)$rand);
                } elseif (($ts = strtotime($value)) !== false) {
                    $value = \DateTime::createFromFormat('U', (string)$ts);
                } else {
                    $value = new \DateTime();
                }
            }
            
            $this->idNumber = $this->updateIdNumber($value->format('ymd'), 0, 6); // Update the first 6 digits with the new date
        }
    }

    /**
     * The gender of the individual.
     * 
     * - f, female
     * - m, male
     * - random: Randomly selects one.
     *
     * @var string
     */
    public string $gender {
        get => (int)substr($this->idNumber, 6, 4) < 5000 ? 'Female' : 'Male';
        set(string $value) {
            if (in_array(strtolower($value), ['f', 'female'])) {
                // random number between 0 and 4999
                $value = str_pad((string)rand(0, 4999), 4, '0', STR_PAD_LEFT);
            } elseif (in_array(strtolower($value), ['m', 'male'])) {
                // random number between 5000 and 9999
                $value = str_pad((string)rand(5000, 9999), 4, '0', STR_PAD_LEFT);
            } elseif (in_array(strtolower($value), ['random'])) {
                // random number between 0 and 9999
                $value = str_pad((string)rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } elseif (ctype_digit($value) && strlen($value) !== 4) {
                // Ensure the value is a valid 4-digit number
                $value = substr(str_pad($value, 4, '0', STR_PAD_LEFT), 0, 4); // Ensure the value is a valid 4-digit number
            }
var_dump($value);
            if (strlen($value) === 4 && ctype_digit($value) && (int)$value >= 0 && (int)$value <= 9999) {
                $this->idNumber = $this->updateIdNumber($value, 6, 4);
            }
        }
    }

    /**
     * The citizenship status of the individual.
     * 
     * - 0, sa, south african, citizen: South African Citizen
     * - 1, pr, permanent, resident, permanent resident: Permanent Resident
     * - 2, r, refugee: Refugee
     * - random: Randomly selects one
     *
     * @var string
     */
    public string $citizenship {
        get => match (substr($this->idNumber, 10, 1)) {
            '0' => 'South African',
            '1' => 'Permanent Resident',
            '2' => 'Refugee',
            default => 'Invalid'
        };
        set(string $value) {
            if (in_array(strtolower($value), ['0', 'sa', 'south african', 'citizen'])) {
                $this->idNumber = $this->updateIdNumber('0', 10, 1);
            } elseif (in_array(strtolower($value), ['1', 'pr', 'permanent', 'resident', 'permanent resident'])) {
                $this->idNumber = $this->updateIdNumber('1', 10, 1);
            } elseif (in_array(strtolower($value), ['2', 'r', 'refugee'])) {
                $this->idNumber = $this->updateIdNumber('2', 10, 1);
            } elseif (in_array(strtolower($value), ['random'])) {
                $this->idNumber = $this->updateIdNumber((string)rand(0, 2), 10, 1);
            }
        }
    }

    /**
     * The race of the individual.
     * 
     * - 8, w, white: White
     * - 9, b, black: Black
     * - random: Randomly selects one.
     *
     * @var string
     */
    public string $race {
        get => match (substr($this->idNumber, 11, 1)) {
            '8' => 'White',
            '9' => 'Black',
            default => 'Invalid'
        };
        set(string $value) {
            if (in_array(strtolower($value), ['8', 'w', 'white'])) {
                $this->idNumber = $this->updateIdNumber('8', 11, 1);
            } elseif (in_array(strtolower($value), ['9', 'b', 'black'])) {
                $this->idNumber = $this->updateIdNumber('9', 11, 1);
            } elseif (in_array(strtolower($value), ['random'])) {
                $this->idNumber = $this->updateIdNumber((string)rand(8, 9), 11, 1);
            }
        }
    }

    #endregion ID Number Properties

    /**
     * Updates a portion of an ID number string with a new value.
     * 
     * Then recalculates and inserts the checksum digit at the end of the ID number.
     *
     * @param string $value   The new value to insert into the ID number.
     * @param int    $offset  The position in the ID number where the update should begin.
     * @param int    $length  The number of characters to replace in the ID number.
     *
     * @return string The updated ID number string.
     */
    private function updateIdNumber(string $value, int $offset, int $length): string {
        $idNumber = substr_replace($this->idNumber, $value, $offset, $length);
        return substr_replace($idNumber, static::calculateChecksum($idNumber), 12, 1);
    }

    /**
     * Constructor for the class.
     *
     * Initializes a new instance using the provided ID number.
     *
     * @param string $idNumber The identification number to be used for initialization, null if a random ID number should be generated.
     */
    public function __construct(?string $idNumber = null) {
        if ($idNumber === null) {
            $this->verify = false; // Do not verify if no ID number is provided

            $this->idNumber = str_pad((string)rand(0, 999999999999), 13, '0', STR_PAD_LEFT); // Generate a random 13-digit ID number
            $this->idNumber = '7707065111083'; // Generate a random 13-digit ID number
            $this->birthDate = 'random'; // Set a random birth date
            $this->gender = 'random'; // Set a random gender
            $this->citizenship = 'random'; // Set a random citizenship status
            $this->race = 'random'; // Set a random race

            $this->verify = true; // Re-enable verification
        } else {
            $this->idNumber = $idNumber;
        }
    }

    /**
     * Magic method to convert the object to its string representation.
     *
     * @return string A valid South African ID Number..
     */
    public function __toString() {
        return $this->idNumber;
    }

    #region Validation Methods

    /**
     * Calculates the checksum digit for a given ID number.
     *
     * This method takes an ID number as a string and computes its checksum
     * according to the specific algorithm implemented within the method.
     *
     * @param string $idNumber The ID number for which to calculate the checksum.
     * 
     * @return string The calculated checksum digit as a string.
     */
    protected static function calculateChecksum(string $idNumber): string {
        // calculate checksum using Luhn algorithm
        $test = strrev(substr($idNumber, 0, 12)); // Reverse the first 12 digits
        $sum = 0;
        for ($i = 0; $i < strlen($test); $i++) {
            $n = (int)$test[$i];
            if ($i % 2 !== 0) { // Double every second digit
                $sum += $n;
            } else {
                $temp = $n * 2; // Double the digit
                $sum += ($temp > 9) ? $temp - 9 : $temp; // If the result is greater than 9, subtract 9
            }
        }

        return (string) (10 - ($sum % 10)); // Return the checksum
    }

    /**
     * Validates the checksum of a given ID number.
     *
     * This method checks whether the provided ID number has a valid checksum
     * according to the implemented algorithm.
     *
     * @param string $idNumber The ID number to validate.
     * 
     * @return bool True if the checksum is valid, false otherwise.
     */
    private static function isValidChecksum(string $idNumber): bool {
        // Check if the last digit matches the calculated checksum
        return $idNumber[12] === static::calculateChecksum($idNumber);
    }

    /**
     * Validates a South African ID number.
     *
     * @param string $idNumber The ID number to validate.
     * 
     * @return true|array Returns true if the ID number is valid, or an array of error details if invalid.
     */
    private static function isValidIdNumber(string $idNumber): true|array {
        $errors = [];

        // Implement validation logic here
        if (empty($idNumber)) {
            $errors[] = 'ID number cannot be empty';
            return $errors; // Empty ID number is invalid
        }

        // Check if the ID number is a string of digits
        if (!is_string($idNumber) || !preg_match('/^\d{13}$/', $idNumber)) {
            $errors[] = 'ID number must be a string of 13 digits';
            return $errors; // ID number must be a string of 13 digits
        }

        // Check if the calculated checksum matches the last digit of the ID number
        if (static::isValidChecksum($idNumber) === false)
            $errors[] = 'Invalid checksum for ID number (' . static::calculateChecksum($idNumber) . ')';

        // Additional checks can be added here, such as checking the date of birth
        $year = (int) substr($idNumber, 0, 2);
        $month = (int) substr($idNumber, 2, 2);
        $day = (int) substr($idNumber, 4, 2);
        // Check if the date is valid
        if (!checkdate($month, $day, $year))
            $errors[] = 'Invalid date of birth in ID number';

        // Check if the citizenship number is within a valid range
        $citizenshipDigit = (int) substr($idNumber, 10, 1);
        if ($citizenshipDigit < 0 || $citizenshipDigit > 2)
            $errors[] = 'Invalid citizenship status in ID number';

        // Check if the race number is within a valid range
        $raceDigit = (int) substr($idNumber, 11, 1);
        if ($raceDigit < 8 || $raceDigit > 9)
            $errors[] = 'Invalid race ID number';

        if (!empty($errors)) return $errors; // Return the errors if any validation fails

        // If all checks pass, the ID number is valid
        // Note: This is a simplified validation; real-world validation may require more checks
        //       Just because the ID number passes these checks does not mean the number is valid in regarts to being assigned to a person.
        return true; // Placeholder for actual validation
    }

    #endregion Validation Methods

    #region helpers

    /**
     * Extracts and returns the full year from a given ID number.
     *
     * @param string $idNumber The identification number from which to extract the year.
     * 
     * @return string The full year (e.g., "1985", "2001") extracted from the ID number.
     */
    private static function getFullYear(string $idNumber): string {
        // Extract the year from the ID number
        $year = substr($idNumber, 0, 2);
        $century = (int) date('y'); // Get the current century
        return ($year <= $century ? '20' : '19') . $year; // Determine the full year
    }

    #endregion helpers
}

// $idNumber = new ZAIDNumber($ids[0]);
// echo (string) $idNumber . PHP_EOL; // Set birth date
// echo $idNumber->birthDate->format('Y-m-d') . PHP_EOL; // Get birth date
// echo $idNumber->gender . PHP_EOL;
// $idNumber->birthDate = new \DateTime('1977-07-06');
// $idNumber->gender = '5111';
// echo (string) $idNumber . PHP_EOL; // Set birth date
// echo $idNumber->birthDate->format('Y-m-d') . PHP_EOL; // Get birth date
// echo $idNumber->gender . PHP_EOL;

// exit;

$ids = [
    // '8001015009087', // Valid ID number
    // '8001015009088', // Invalid checksum
    // '1234567890123', // Invalid ID number
    // '1234567890128', // Invalid ID number
    // null, // Random ID number
];

foreach ($ids as $id) {
    try {
        $idNumber = new ZAIDNumber($id);
        echo "ID Number: " . $idNumber->idNumber . PHP_EOL;
        echo "\tBirth Date\t: " . $idNumber->birthDate->format('Y-m-d') . PHP_EOL;
        echo "\tGender\t\t: " . $idNumber->gender . PHP_EOL;
        echo "\tCitizenship\t: " . $idNumber->citizenship . PHP_EOL;
        echo "\tRace\t\t: " . $idNumber->race . PHP_EOL . PHP_EOL;
    } catch (ZAIDNumberException $e) {
        echo "Error: " . $e->getMessage();
        echo "\n\t" . implode("\n\t", $e->getErrors()) . PHP_EOL . PHP_EOL;
    }
}

// create a random date between 1900 and now
// $min = \DateTime::createFromFormat('Y-m-d', '1930-01-01');
// echo $min->format('Y-m-d') . PHP_EOL;
// echo $min->format('U') . PHP_EOL;

// $max = new \DateTime();
// echo $max->format('Y-m-d') . PHP_EOL;
// echo $max->format('U') . PHP_EOL;

// $rand = rand($min->getTimestamp(), $max->getTimestamp());
// echo $rand . PHP_EOL;

// // $randomDate = \DateTime::createFromFormat((string)$rand, 'U');
// $randomDate = \DateTime::createFromFormat('U', (string)$rand);
// // $randomDate = new \DateTime();
// // $randomDate->setTimestamp($rand);

// echo $randomDate->format('Y-m-d') . PHP_EOL;
try {
    $idNumber = new ZAIDNumber();
    // echo "Generated ID Number: " . $idNumber->idNumber . PHP_EOL;
    $idNumber->gender = 'm';
    // $idNumber->gender = 'random'; //
    // $idNumber->gender = '8'; //
    $idNumber->race = 'w';
    $idNumber->citizenship = 'sa';
    echo "Generated ID Number: " . $idNumber->idNumber . PHP_EOL;
    echo "\tBirth Date\t: " . $idNumber->birthDate->format('Y-m-d') . PHP_EOL;
    echo "\tGender\t\t: " . $idNumber->gender . PHP_EOL;
    echo "\tCitizenship\t: " . $idNumber->citizenship . PHP_EOL;
    echo "\tRace\t\t: " . $idNumber->race . PHP_EOL . PHP_EOL;
} catch (ZAIDNumberException $e) {
    echo "Error: " . $e->getMessage();
    echo "\n\t" . implode("\n\t", $e->getErrors()) . PHP_EOL . PHP_EOL;
}
