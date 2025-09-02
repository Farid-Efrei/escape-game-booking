<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/Booking.php';
require_once __DIR__ . '/../src/Pricing.php';

class BookingTest extends TestCase
{
    // Test : vérifier qu'une réservation est bien enregistrée
    public function testBookingIsRegistered()
    {
        $booking = new Booking();
        $result = $booking->book("2023-12-25 15:00", "Room 1", ["Alice", "Bob"]);
        $this->assertTrue($result);
        $this->assertCount(1, $booking->getReservations());
    }

    // Test : calcul du prix avec/sans réduction
    public function testPriceCalculation()
    {
        $pricing = new Pricing();
        
        // Sans réduction (2 joueurs, weekend)
        $priceNoDiscount = $pricing->calculatePrice(2, "2023-12-24 15:00"); // Dimanche
        $this->assertEquals(40.0, $priceNoDiscount);
        
        // Avec réduction groupe (4 joueurs)
        $priceGroupDiscount = $pricing->calculatePrice(4, "2023-12-24 15:00");
        $this->assertEquals(68.0, $priceGroupDiscount); // 80 * 0.85
        
        // Avec réduction semaine (2 joueurs, lundi)
        $priceWeekdayDiscount = $pricing->calculatePrice(2, "2023-12-25 15:00"); // Lundi
        $this->assertEquals(36.0, $priceWeekdayDiscount); // 40 * 0.9
    }

    // Test : validation des contraintes (âge, créneaux horaires)
    public function testValidationConstraints()
    {
        $booking = new Booking();
        
        // Test âge : refus si < 12 ans
        $this->assertFalse($booking->validateAge([10, 15]));
        $this->assertTrue($booking->validateAge([12, 15]));
        
        // Test créneaux : refus si hors horaires (9h-22h)
        $this->assertFalse($booking->checkAvailability("2023-12-25 08:00", "Room 1"));
        $this->assertTrue($booking->checkAvailability("2023-12-25 15:00", "Room 1"));
    }
}