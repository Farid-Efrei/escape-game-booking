<?php

class Booking
{
    private $reservations = [];
    private $openingHours = ['09:00', '22:00'];
    private $minAge = 12;

    /**
     * Vérifie si une salle est disponible à une date donnée.
     * @param string $date (format: "Y-m-d H:i")
     * @param string $room (ex: "Room 1")
     * @return bool
     */
    public function checkAvailability(string $date, string $room): bool
    {
        $dateTime = new DateTime($date);
        $currentHour = $dateTime->format('H:i');

        // Vérifie les horaires d'ouverture
        if ($currentHour < $this->openingHours[0] || $currentHour > $this->openingHours[1]) {
            return false;
        }

        // Vérifie si la salle est déjà réservée
        foreach ($this->reservations as $reservation) {
            if ($reservation['room'] === $room && $reservation['date'] === $date) {
                return false;
            }
        }

        return true;
    }

    /**
     * Enregistre une réservation.
     * @param string $date
     * @param string $room
     * @param array $players (ex: ["Alice", "Bob"])
     * @return bool (true si réservation réussie)
     */
    public function book(string $date, string $room, array $players): bool
    {
        if (!$this->checkAvailability($date, $room)) {
            return false;
        }

        $this->reservations[] = [
            'date' => $date,
            'room' => $room,
            'players' => $players
        ];

        return true;
    }

    /**
     * Valide que tous les joueurs ont +12 ans.
     * @param array $ages (ex: [14, 15, 12])
     * @return bool
     */
    public function validateAge(array $ages): bool
    {
        foreach ($ages as $age) {
            if ($age < $this->minAge) {
                return false;
            }
        }
        return true;
    }

    /**
     * Récupère toutes les réservations (pour les tests).
     * @return array
     */
    public function getReservations(): array
    {
        return $this->reservations;
    }
}