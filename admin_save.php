<?php
session_start();
// ตรวจสอบสิทธิ์แอดมิน (ปรับแก้ตามระบบ Login ของคุณ)
// if (!isset($_SESSION['is_admin'])) { exit("Access Denied"); }

$conn = new mysqli('localhost', 'root', '', 'jaydb');
$conn->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $author = $conn->real_escape_string($_POST['author']);
    
    // [จุดสำคัญ] กำหนดสถานะเป็น 'published' เพื่อให้ทุกคนมองเห็น
    $status = 'published'; 

    if ($id > 0) {
        // --- กรณีแก้ไขข้อมูล (UPDATE) ---
        $sql = "UPDATE scripts SET title='$title', description='$description', author='$author', status='$status' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('แก้ไขข้อมูลสำเร็จ!'); window.location='admin_dashboard.php';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    } else {
        // --- กรณีเพิ่มข้อมูลใหม่ (INSERT) ---
        $sql = "INSERT INTO scripts (title, description, author, downloads, status) VALUES ('$title', '$description', '$author', 0, '$status')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('เพิ่มข้อมูลสำเร็จ!'); window.location='admin_dashboard.php';</script>";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}
$conn->close();
?>
