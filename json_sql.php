<?php
include('conn.php');

// ===========================================
// json_cafe_phrae.php : ดึงข้อมูลทั้งหมดเป็น GeoJSON
// ===========================================

$sql = "
    SELECT 
        id,
        Name,
        Address,
        Latitude,
        Longitude,
        Opening_hours,
        Open_Daily,
        ST_AsGeoJSON(geom) AS geojson
    FROM cafe_phrae
    ORDER BY id DESC;
";

$result = pg_query($conn, $sql);
if (!$result) {
    die(json_encode([
        'status' => 'error',
        'message' => pg_last_error($conn)
    ]));
}

// 🔹 สร้าง FeatureCollection
$geojson = [
    'type' => 'FeatureCollection',
    'features' => []
];

// 🔹 วนลูปเพิ่มข้อมูลแต่ละแถวเป็น Feature
while ($row = pg_fetch_assoc($result)) {
    $geojson['features'][] = [
        'type' => 'Feature',
        'geometry' => json_decode($row['geojson']),
        'properties' => [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'address' => $row['address'],
            'latitude' => (float)$row['latitude'],
            'longitude' => (float)$row['longitude'],
            'opening_hours' => $row['opening_hours'],
            'open_daily' => $row['open_daily']
        ]
    ];
}

// 🔹 ส่ง JSON response
header('Content-Type: application/json; charset=utf-8');
echo json_encode($geojson, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

// 🔹 ปิด connection
pg_close($conn);
?>
