<?php
// exam-group-store.php
require_once 'db.php'; // ហៅឯកសារភ្ជាប់ Database មកប្រើ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // ចាប់យកទិន្នន័យពី Form
    $name            = trim($_POST['name']);
    $exam_type       = trim($_POST['exam_type']);
    $exam_purpose    = trim($_POST['exam_purpose']);
    $exam_curriculum = trim($_POST['exam_curriculum']);
    $description     = trim($_POST['description']);

    // ត្រួតពិនិត្យលក្ខខណ្ឌសញ្ញាផ្កាយ (Validation ផ្នែក Back-end ម្តងទៀតដើម្បីសុវត្ថិភាព)
    if (empty($name) || empty($exam_type) || empty($exam_purpose) || empty($exam_curriculum)) {
        die("សូមបំពេញរាល់ព័ត៌មានដែលមានសញ្ញាផ្កាយ (*) ឱ្យបានគ្រប់ជ្រុងជ្រោយ!");
    }

    // រៀបចំ Query សម្រាប់បញ្ចូលទិន្នន័យ
    $sql = "INSERT INTO exam_groups (name, exam_type, exam_purpose, exam_curriculum, description) 
            VALUES (:name, :exam_type, :exam_purpose, :exam_curriculum, :description)";
    
    $stmt = $pdo->prepare($sql);

    try {
        // ដំណើរការបញ្ចូលទៅកាន់ MySQL
        $stmt->execute([
            ':name'            => $name,
            ':exam_type'       => $exam_type,
            ':exam_purpose'    => $exam_purpose,
            ':exam_curriculum' => $exam_curriculum,
            ':description'     => !empty($description) ? $description : null
        ]);

        // នៅពេលរក្សាទុកជោគជ័យ ឱ្យវាលោតទៅទំព័រណាមួយដែលអ្នកចង់បង្ហាញ (ឧទាហរណ៍៖ ទំព័រដើម)
        echo "<script>alert('រក្សាទុកទិន្នន័យ Exam Group ជោគជ័យ!'); window.location.href='exam-group-form.php';</script>";
        exit();

    } catch (PDOException $e) {
        echo "មានបញ្ហាបច្ចេកទេសក្នុងការរក្សាទុកទិន្នន័យ: " . $e->getMessage();
    }
}
?>
