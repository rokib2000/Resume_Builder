<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_connect.php';
require_once 'vendor/autoload.php'; // Include TCPDF library

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Retrieve resume data from the database
    $query = "SELECT * FROM resumes WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Create PDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        
        // Add resume content to the PDF
        $pdf->Cell(0, 10, 'Resume Title: ' . $row['resume_title'], 0, 1);
        $pdf->Cell(0, 10, 'Name: ' . $row['name'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $row['phone'], 0, 1);
        $pdf->Cell(0, 10, 'Address: ' . $row['address'], 0, 1);
        $pdf->Ln();
        $pdf->MultiCell(0, 10, 'Summary: ' . $row['summary'], 0, 1);
        $pdf->Ln();
        $pdf->MultiCell(0, 10, 'Education: ' . $row['education'], 0, 1);
        $pdf->Ln();
        $pdf->MultiCell(0, 10, 'Experience: ' . $row['experience'], 0, 1);
        $pdf->Ln();
        $pdf->MultiCell(0, 10, 'Skills: ' . $row['skills'], 0, 1);
        
        // Output PDF as download
        $pdf->Output('resume.pdf', 'D');
    } else {
        echo "Resume not found";
    }
} else {
    echo "Invalid request";
}
?>
