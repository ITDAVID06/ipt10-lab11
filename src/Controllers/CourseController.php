<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;

class CourseController extends BaseController
{
    public function list()
    {
        $obj = new Course();
        $courses = $obj->all();

        $template = 'courses';
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrolees = $courseObj->getEnrolees($course_code);

        $template = 'single-course';
        $data = [
            'course' => $course,
            'enrolees' => $enrolees
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function exportCourse(){

        $obj = new Course();

        $courses = $obj->getEnrolees();
        $allcourses = $obj->all();

        $this->pdf = new Fpdf();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(0, 10, 'Profile of ' . $profile->getFullName(), 0, 1, 'C');

        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->Cell(0, 10, 'Email: ' . $profile->getContactDetails()['email'], 0, 1);
        $this->pdf->Cell(0, 10, 'Phone: ' . $profile->getContactDetails()['phone_number'], 0, 1);
        
        // Address
        $address = implode(", ", $profile->getContactDetails()['address']);
        $this->pdf->Cell(0, 10, 'Address: ' . $address, 0, 1);
        
        // Education
        $this->pdf->Cell(0, 10, 'Education: ' . $profile->getEducation()['degree'] . ' at ' . $profile->getEducation()['university'], 0, 1);
        
        // Skills
        $this->pdf->Cell(0, 10, 'Skills: ');
        $this->pdf->Ln();
        foreach ($profile->getSkills() as $skill) {
            $this->pdf->Cell(0, 10, '- ' . $skill, 0, 1);
        }

        // Experience
        $this->pdf->Cell(0, 10, 'Experience:', 0, 1);
        foreach ($profile->getExperience() as $job) {
            $this->pdf->Cell(0, 10, '- ' . $job['job_title'] . ' at ' . $job['company'] . ' (' . $job['start_date'] . ' to ' . $job['end_date'] . ')', 0, 1);
        }
    }

    

   



}
