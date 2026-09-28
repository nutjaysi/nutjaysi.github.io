<?php
// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'jaydb'; // เปลี่ยนชื่อฐานข้อมูลตามระบบของคุณ

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// [จุดแก้ไข] ดึงข้อมูลทั้งหมดที่สถานะเป็น 'published' (เผยแพร่แล้ว) 
// โดยไม่จำกัดว่าเป็นของแอดมินคนไหน เพื่อให้ผู้ใช้บริการทุกคนมองเห็นเหมือนกัน
$sql = "SELECT * FROM scripts WHERE status = 'published' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>JAYSI - แหล่งรวมสคริปต์</title>
    <!-- ใส่ CSS ตามระบบของคุณ -->
</head>
<body>

    <div class="container">
        <h1>รายการสคริปต์ทั้งหมด</h1>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="script-card">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <small>ผู้ลง: <?php echo htmlspecialchars($row['author']); ?> | ยอดใช้: <?php echo $row['downloads']; ?> ครั้ง</small>
                    <br>
                    <a href="download.php?id=<?php echo $row['id']; ?>" class="btn-download">ดาวน์โหลดไฟล์</a>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>ยังไม่มีสคริปต์ในระบบ</p>
        <?php endif; ?>

    </div>

</body>
</html>
<?php $conn->close(); ?>
