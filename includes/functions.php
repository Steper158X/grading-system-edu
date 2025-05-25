<?php

if (!function_exists('calculateGrade')) {
    /**
     * Calculates the grade based on the score.
     *
     * @param int|float $score The score to calculate the grade for.
     * @return string The calculated grade (A, B, C, D, F).
     */
    function calculateGrade($score) {
        if ($score >= 80) {
            return 'A';
        } elseif ($score >= 70) {
            return 'B';
        } elseif ($score >= 60) {
            return 'C';
        } elseif ($score >= 50) {
            return 'D';
        } else {
            return 'F';
        }
    }
}

// You can add other utility functions here in the future.

?>
