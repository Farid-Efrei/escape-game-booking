<?php

class Pricing
{
    private const BASE_PRICE = 20; // Prix par joueur
    private const GROUP_DISCOUNT = 0.15; // 15% si ≥4 joueurs
    private const WEEKDAY_DISCOUNT = 0.10; // 10% en semaine

    /**
     * Calcule le prix total avec réductions.
     * @param int $playerCount
     * @param string $date (format: "Y-m-d H:i")
     * @return float
     */
    public function calculatePrice(int $playerCount, string $date): float
    {
        $price = $playerCount * self::BASE_PRICE;
        $dateTime = new DateTime($date);

        // Réduction de 10% en semaine (lundi à vendredi)
        if ($this->isWeekday($dateTime)) {
            $price *= (1 - self::WEEKDAY_DISCOUNT);
        }

        // Réduction de 15% pour les groupes ≥4
        if ($playerCount >= 4) {
            $price *= (1 - self::GROUP_DISCOUNT);
        }

        return round($price, 2);
    }

    /**
     * Vérifie si la date est en semaine (lundi à vendredi).
     * @param DateTime $dateTime
     * @return bool
     */
    private function isWeekday(DateTime $dateTime): bool
    {
        $dayOfWeek = $dateTime->format('N'); // 1 (lundi) à 7 (dimanche)
        return ($dayOfWeek <= 5);
    }
}