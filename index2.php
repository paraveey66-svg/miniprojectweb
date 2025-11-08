<?php
header('Content-Type: application/json');

// กำหนดค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost";
$dbname = "nsk";
$user = "postgres";
$password = "postgres";

try {
    // เชื่อมต่อฐานข้อมูล
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // คำสั่ง SQL
    $sql = "
        SELECT e.*
        FROM house e
        JOIN (
            SELECT ST_Buffer(h.geom, 500) AS geom
            FROM hospital_npao h
            WHERE h.namt LIKE '%เก้าเลี้ยว%'
        ) AS buffer_zone
        ON ST_Intersects(e.geom, buffer_zone.geom)
        LIMIT 100;
    ";

    // เตรียมและรันคำสั่ง SQL
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // ดึงผลลัพธ์
    $houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ส่งผลลัพธ์เป็น JSON
    echo json_encode(["status" => "success", "data" => $houses]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
