<?php
class Appointment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function saveAppointment($data)
    {
        $sql = "INSERT INTO appointments (name, email, phone, notes, contact_method, available_days, preferred_time)
                VALUES (:name, :email, :phone, :notes, :contact_method, :available_days, :preferred_time)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':notes' => $data['notes'],
            ':contact_method' => $data['contact_method'],
            ':available_days' => implode(',', $data['available_days']),
            ':preferred_time' => implode(',', $data['preferred_time'])
        ]);
    }
}
?>