<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'db_connect.php';

// Fetch resume data
if(isset($_GET['id'])) {
    $resume_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    // Query to fetch the resume with specific id and user id to ensure user's privacy
    $query = "SELECT * FROM resumes WHERE id = '$resume_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $resume = mysqli_fetch_assoc($result);

    if(!$resume) {
        // Redirect if resume not found or doesn't belong to the current user
        header("Location: dashboard.php");
        exit;
    }
} else {
    // Redirect if id parameter is not provided in the URL
    header("Location: dashboard.php");
    exit;
}

// Generate PDF
require_once('./tc-lib-pdf-main/src/Tcpdf.php'); // Ensure this path is correct based on your project structure

// Extend TCPDF class to create custom header and footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 10, 'Resume: ' . $this->resume['resume_title'], 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Resume: ' . $resume['resume_title']);
$pdf->SetHeaderData('', 0, 'Resume: ' . $resume['resume_title'], '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();
$pdf->resume = $resume;
$html = '<h1>' . $resume['resume_title'] . '</h1>';
$html .= '<p>' . $resume['summary'] . '</p>';
$pdf->writeHTML($html, true, false, true, false, '');
//Close and output PDF document
$pdf->Output('resume_' . $resume_id . '.pdf', 'D');

// No need to output anything else after PDF generation
exit;
?>
