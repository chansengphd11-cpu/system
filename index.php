<?php
// index.php
require_once 'db.php';

// (កូដសម្រាប់ទាញទិន្នន័យពី MySQL ដូចមុន...)
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : '';
$campus = isset($_GET['campus']) ? $_GET['campus'] : '';
$query = "SELECT * FROM students WHERE 1=1";
$params = [];
if (!empty($search_type)) { $query .= " AND search_type = :search_type"; $params[':search_type'] = $search_type; }
if (!empty($campus)) { $query .= " AND campus = :campus"; $params[':campus'] = $campus; }
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_admissions = count($students);
?>

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>Golden Gate American School - Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column" style="min-height: 100vh;">

    <!-- រួមបញ្ចូល Header ខាងលើ -->
    <?php include 'header.php'; ?>

    <div class="d-flex flex-grow-1">
        <!-- រួមបញ្ចូល Sidebar ខាងឆ្វេង -->
        <?php include 'sidebar.php'; ?>

        <!-- ផ្ទាំងមាតិកាកណ្តាល (Main Content) -->
        <div class="p-4 flex-grow-1" style="overflow-x: hidden;">
            
            <!-- Select Criteria Block -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-secondary">Select Criteria</h5>
                        <a href="admission-form.php" class="btn btn-dark btn-sm"><i class="fas fa-plus"></i> Student Admission</a>
                    </div>
                    
                    <form method="GET" action="index.php" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Search Type</label>
                            <select name="search_type" class="form-select">
                                <option value="">Select</option>
                                <option value="Type A" <?php if($search_type == 'Type A') echo 'selected'; ?>>Type A</option>
                                <option value="Type B" <?php if($search_type == 'Type B') echo 'selected'; ?>>Type B</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Campus</label>
                            <select name="campus" class="form-select">
                                <option value="">Select</option>
                                <option value="Campus 1" <?php if($campus == 'Campus 1') echo 'selected'; ?>>Campus 1</option>
                                <option value="Campus 2" <?php if($campus == 'Campus 2') echo 'selected'; ?>>Campus 2</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-dark btn-sm px-4"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admission Report Table Block -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-secondary">Admission Report</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th>Admission No</th>
                                <th>Student Name</th>
                                <th>Latin Name</th>
                                <th>Father Name</th>
                                <th>Date of Birth</th>
                                <th>Admission Date</th>
                                <th>Gender</th>
                                <th>Mobile Number</th>
				<th>Other</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total_admissions > 0): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($student['admission_no']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['latin_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['father_name']); ?></td>
                                        <td><?php echo htmlspecialchars($student['dob']); ?></td>
                                        <td><?php echo htmlspecialchars($student['admission_date']); ?></td>
                                        <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($student['mobile_number']); ?></td>
					<td><?php echo htmlspecialchars($student['Other']); ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-light btn-sm text-primary"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">មិនទាន់មានទិន្នន័យសិស្សចុះឈ្មោះក្នុងប្រព័ន្ធឡើយ។</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-muted small d-flex justify-content-between py-3">
                    <span>Total Admission in this duration : <strong><?php echo $total_admissions; ?></strong></span>
                    <span>Duration: 01.01.2026 To 31.12.2026</span>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
