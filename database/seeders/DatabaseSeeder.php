<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Question;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = [
            "firstname" => "sibi",
            "lastname" => "haseb",
            "email" => "abdul.haseeb@pk.xtendum.com",
            "email_verified_at" => Carbon::now(),
            "password" => bcrypt("123456"),
            "role" => "superadmin"
        ];

        User::create($user);

        $question1 = [
            'step' => 1,
            'sort_order' => 0,
            'title' =>  array(
                'value' => 'Project Description',
                'name' =>
                array(
                    'de' => 'Projektbeschreibung',
                    'en' => 'Project Description',
                ),
            ),
            'description' =>
            array(
                'value' => 'Please email description to:startup@startfeld.ch',
                'name' =>
                array(
                    'de' => 'Please email description to:startup@startfeld.ch',
                    'en' => 'Please email description to:startup@startfeld.ch',
                ),
            ),
            'answer_type' => 'title'
        ];

        $question2 = [
            'step' => 1,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Project name',
                'name' =>
                array(
                    'de' => 'Project name',
                    'en' => 'Project name',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1
        ];

        $question3 = [
            'step' => 1,
            'sort_order' => 2,
            'title' => array(
                'value' => 'Project number',
                'name' =>
                array(
                    'de' => 'Project number',
                    'en' => 'Project number',
                ),
            ),
            'answer_type' => 'text',
            'is_hidden' => 1,
            'is_mandatory' => 1
        ];

        $question4 = [
            'step' => 1,
            'sort_order' => 3,
            'title' => array(
                'value' => 'Short Summary',
                'name' =>
                array(
                    'de' => 'Short Summary',
                    'en' => 'Short Summary',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question5 = [
            'step' => 2,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Main Contact Detail',
                'name' =>
                array(
                    'de' => 'Main Contact Detail',
                    'en' => 'Main Contact Detail',
                ),
            ),
            'answer_type' => 'key',
            'options' => array(
                'key' => 'applicant',
            )
        ];

        $question6 = [
            'step' => 3,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Company Related Data',
                'name' =>
                array(
                    'de' => 'Company Related Data',
                    'en' => 'Company Related Data',
                ),
            ),
            'answer_type' => 'title'
        ];

        $question7 = [
            'step' => 3,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Current Status',
                'name' =>
                array(
                    'de' => 'Current Status',
                    'en' => 'Current Status',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Company Already Exists',
                        'name' =>
                        array(
                            'de' => 'Company Already Exists',
                            'en' => 'Company Already Exists',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'Company is not yet Founded',
                        'name' =>
                        array(
                            'de' => 'Company is not yet Founded',
                            'en' => 'Company is not yet Founded',
                        ),
                    ),
                ),
            ),
            'is_mandatory' => 1
        ];

        $question8 = [
            'step' => 3,
            'sort_order' => 2,
            'title' => array(
                'value' => 'Company Name',
                'name' =>
                array(
                    'de' => 'Company Name',
                    'en' => 'Company Name',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1
        ];

        $question9 = [
            'step' => 3,
            'sort_order' => 3,
            'title' => array(
                'value' => 'Choose an industry',
                'name' =>
                array(
                    'de' => 'Choose an industry',
                    'en' => 'Choose an industry',
                ),
            ),
            'answer_type' => 'dropdown',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Services',
                        'name' =>
                        array(
                            'de' => 'Services',
                            'en' => 'Services',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'trade',
                        'name' =>
                        array(
                            'de' => 'trade',
                            'en' => 'trade',
                        ),
                    ),
                    2 =>
                    array(
                        'value' => 'High-tech',
                        'name' =>
                        array(
                            'de' => 'High-tech',
                            'en' => 'High-tech',
                        ),
                    ),
                    3 =>
                    array(
                        'value' => 'ICT',
                        'name' =>
                        array(
                            'de' => 'ICT',
                            'en' => 'ICT',
                        ),
                    ),
                    4 =>
                    array(
                        'value' => 'Production',
                        'name' =>
                        array(
                            'de' => 'Production',
                            'en' => 'Production',
                        ),
                    ),
                    5 =>
                    array(
                        'value' => 'Miscellaneous',
                        'name' =>
                        array(
                            'de' => 'Miscellaneous',
                            'en' => 'Miscellaneous',
                        ),
                    ),
                ),
            ),
            'is_mandatory' => 1
        ];

        $question10 = [
            'step' => 3,
            'sort_order' => 4,
            'title' => array(
                'value' => 'Location',
                'name' =>
                array(
                    'de' => 'Location',
                    'en' => 'Location',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1
        ];

        $question11 = [
            'step' => 3,
            'sort_order' => 5,
            'title' => array(
                'value' => 'Location Canton',
                'name' =>
                array(
                    'de' => 'Location Canton',
                    'en' => 'Location Canton',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1
        ];

        $question12 = [
            'step' => 3,
            'sort_order' => 6,
            'title' => array(
                'value' => 'Planned Form of Organization',
                'name' =>
                array(
                    'de' => 'Planned Form of Organization',
                    'en' => 'Planned Form of Organization',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Sole Partnership',
                        'name' =>
                        array(
                            'de' => 'Sole Partnership',
                            'en' => 'Sole Partnership',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'Inc',
                        'name' =>
                        array(
                            'de' => 'Inc',
                            'en' => 'Inc',
                        ),
                    ),
                    2 =>
                    array(
                        'value' => 'Gmbh',
                        'name' =>
                        array(
                            'de' => 'Gmbh',
                            'en' => 'Gmbh',
                        ),
                    ),
                    3 =>
                    array(
                        'value' => 'other',
                        'name' =>
                        array(
                            'de' => 'other',
                            'en' => 'other',
                        ),
                    ),
                ),
            ),
            'is_mandatory' => 1
        ];

        $question13 = [
            'step' => 3,
            'sort_order' => 7,
            'title' => array(
                'value' => 'Founding Date',
                'name' =>
                array(
                    'de' => 'Founding Date',
                    'en' => 'Founding Date',
                ),
            ),
            'answer_type' => 'date',
        ];

        $question14 = [
            'step' => 3,
            'sort_order' => 8,
            'title' => array(
                'value' => 'Commercial Register Entry',
                'name' =>
                array(
                    'de' => 'Commercial Register Entry',
                    'en' => 'Commercial Register Entry',
                ),
            ),
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Yes',
                        'name' =>
                        array(
                            'de' => 'Yes',
                            'en' => 'Yes',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'No',
                        'name' =>
                        array(
                            'de' => 'No',
                            'en' => 'No',
                        ),
                    ),
                ),
            ),
            'answer_type' => 'radio',
        ];

        $question15 = [
            'step' => 3,
            'sort_order' => 9,
            'title' => array(
                'value' => 'website',
                'name' =>
                array(
                    'de' => 'website',
                    'en' => 'website',
                ),
            ),
            'answer_type' => 'text',
        ];

        $question16 = [
            'step' => 4,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Problem',
                'name' =>
                array(
                    'de' => 'Problem',
                    'en' => 'Problem',
                ),
            ),
            'description' => array(
                'value' => 'Which Problem or need is targeted with business idea',
                'name' =>
                array(
                    'de' => 'Which Problem or need is targeted with business idea',
                    'en' => 'Which Problem or need is targeted with business idea',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question17 = [
            'step' => 4,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Solution',
                'name' =>
                array(
                    'de' => 'Solution',
                    'en' => 'Solution',
                ),
            ),
            'description' => array(
                'value' => 'What is being done to solve the problem/need? What value is created?',
                'name' =>
                array(
                    'de' => 'What is being done to solve the problem/need? What value is created?',
                    'en' => 'What is being done to solve the problem/need? What value is created?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question18 = [
            'step' => 5,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Business Model',
                'name' =>
                array(
                    'de' => 'Business Model',
                    'en' => 'Business Model',
                ),
            ),
            'description' => array(
                'value' => 'How is money made? Who is paying? Which Sales channels are used? what is the gross margin?',
                'name' =>
                array(
                    'de' => 'How is money made? Who is paying? Which Sales channels are used? what is the gross margin?',
                    'en' => 'How is money made? Who is paying? Which Sales channels are used? what is the gross margin?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question19 = [
            'step' => 5,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Secret Behind It',
                'name' =>
                array(
                    'de' => 'Secret Behind It',
                    'en' => 'Secret Behind It',
                ),
            ),
            'description' => array(
                'value' => 'What is the technology or secret behind the product or service?',
                'name' =>
                array(
                    'de' => 'What is the technology or secret behind the product or service?',
                    'en' => 'What is the technology or secret behind the product or service?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question20 = [
            'step' => 5,
            'sort_order' => 2,
            'title' => array(
                'value' => 'Marketing & Sales',
                'name' =>
                array(
                    'de' => 'Marketing & Sales',
                    'en' => 'Marketing & Sales',
                ),
            ),
            'description' => array(
                'value' => 'How are customers reached? What are the key levers that will being success in the market?',
                'name' =>
                array(
                    'de' => 'How are customers reached? What are the key levers that will being success in the market?',
                    'en' => 'How are customers reached? What are the key levers that will being success in the market?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question21 = [
            'step' => 5,
            'sort_order' => 3,
            'title' => array(
                'value' => 'Competition',
                'name' =>
                array(
                    'de' => 'Competition',
                    'en' => 'Competition',
                ),
            ),
            'description' => array(
                'value' => 'What is the competition like in the targeted area?',
                'name' =>
                array(
                    'de' => 'What is the competition like in the targeted area?',
                    'en' => 'What is the competition like in the targeted area?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question22 = [
            'step' => 6,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Team',
                'name' =>
                array(
                    'de' => 'Team',
                    'en' => 'Team',
                ),
            ),
            'description' => array(
                'value' => 'Who are the key people behind the project (operational, strategic, advisory)?',
                'name' =>
                array(
                    'de' => 'Who are the key people behind the project (operational, strategic, advisory)?',
                    'en' => 'Who are the key people behind the project (operational, strategic, advisory)?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question23 = [
            'step' => 6,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Financial',
                'name' =>
                array(
                    'de' => 'Financial',
                    'en' => 'Financial',
                ),
            ),
            'description' => array(
                'value' => 'What is the expected profit and loss account for the first 3 years? How high are the investments required? How much debt capital is required?',
                'name' =>
                array(
                    'de' => 'What is the expected profit and loss account for the first 3 years? How high are the investments required? How much debt capital is required?',
                    'en' => 'What is the expected profit and loss account for the first 3 years? How high are the investments required? How much debt capital is required?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question24 = [
            'step' => 6,
            'sort_order' => 2,
            'title' => array(
                'value' => 'Current Status',
                'name' =>
                array(
                    'de' => 'Current Status',
                    'en' => 'Current Status',
                ),
            ),
            'description' => array(
                'value' => 'What is the current project status? What are the next implementation steps?',
                'name' =>
                array(
                    'de' => 'What is the current project status? What are the next implementation steps?',
                    'en' => 'What is the current project status? What are the next implementation steps?',
                ),
            ),
            'answer_type' => 'textarea',
            'is_mandatory' => 1
        ];

        $question25 = [
            'step' => 7,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Needs',
                'name' =>
                array(
                    'de' => 'Needs',
                    'en' => 'Needs',
                ),
            ),
            'description' => array(
                'value' => 'What are your expectations of Startfeld?',
                'name' =>
                array(
                    'de' => 'What are your expectations of Startfeld?',
                    'en' => 'What are your expectations of Startfeld?',
                ),
            ),
            'answer_type' => 'title',
        ];

        $question26 = [
            'step' => 7,
            'sort_order' => 1,
            'title' =>  array(
                'value' => 'Free Information / initial consultation',
                'name' =>
                array(
                    'de' => 'Free Information / initial consultation',
                    'en' => 'Free Information / initial consultation',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Yes',
                        'name' =>
                        array(
                            'de' => 'Yes',
                            'en' => 'Yes',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'No',
                        'name' =>
                        array(
                            'de' => 'No',
                            'en' => 'No',
                        ),
                    ),
                ),
            )

        ];

        $question27 = [
            'step' => 7,
            'sort_order' => 2,
            'title' =>  array(
                'value' => 'Entrepreneurship Course',
                'name' =>
                array(
                    'de' => 'Entrepreneurship Course',
                    'en' => 'Entrepreneurship Course',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Yes',
                        'name' =>
                        array(
                            'de' => 'Yes',
                            'en' => 'Yes',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'No',
                        'name' =>
                        array(
                            'de' => 'No',
                            'en' => 'No',
                        ),
                    ),
                ),
            )
        ];

        $question28 = [
            'step' => 7,
            'sort_order' => 3,
            'title' => array(
                'value' => 'Start Feld Promotion Package',
                'name' =>
                array(
                    'de' => 'Start Feld Promotion Package',
                    'en' => 'Start Feld Promotion Package',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array (
            'values' =>
                    array (
                        0 =>
                        array (
                        'value' => 'Yes',
                        'name' =>
                        array (
                            'de' => 'Yes',
                            'en' => 'Yes',
                        ),
                        ),
                        1 =>
                        array (
                        'value' => 'No',
                        'name' =>
                        array (
                            'de' => 'No',
                            'en' => 'No',
                        ),
                        ),
                    ),
                    )
        ];

        $question29 = [
            'step' => 7,
            'sort_order' => 4,
            'title' => array(
                'value' => 'Financing',
                'name' =>
                array(
                    'de' => 'Financing',
                    'en' => 'Financing',
                ),
            ),
            'answer_type' => 'key',
            'options' => array(
                'key' => 'subelements',
            )
        ];

        $question30 = [
            'step' => 7,
            'sort_order' => 5,
            'title' => array(
                'value' => 'Space and Infrastructure',
                'name' =>
                array(
                    'de' => 'Space and Infrastructure',
                    'en' => 'Space and Infrastructure',
                ),
            ),
            'answer_type' => 'radio',
            'options' => array (
            'values' =>
                    array (
                        0 =>
                        array (
                        'value' => 'Yes',
                        'name' =>
                        array (
                            'de' => 'Yes',
                            'en' => 'Yes',
                        ),
                        ),
                        1 =>
                        array (
                        'value' => 'No',
                        'name' =>
                        array (
                            'de' => 'No',
                            'en' => 'No',
                        ),
                        ),
                    ),
                    )
        ];

        $question31 = [
            'step' => 7,
            'sort_order' => 6,
            'title' => array(
                'value' => 'Other Expectations Or Comments',
                'name' =>
                array(
                    'de' => 'Other Expectations Or Comments',
                    'en' => 'Other Expectations Or Comments',
                ),
            ),
            'answer_type' => 'textarea',
        ];

        $question32 = [
            'step' => 8,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Attachments',
                'name' =>
                array(
                    'de' => 'Attachments',
                    'en' => 'Attachments',
                ),
            ),
            'answer_type' => 'title',
        ];

        $question33 = [
            'step' => 8,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Documents',
                'name' =>
                array(
                    'de' => 'Documents',
                    'en' => 'Documents',
                ),
            ),
            'answer_type' => 'title',
        ];
        $question34 = [
            'step' => 8,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Business Plan',
                'name' =>
                array(
                    'de' => 'Business Plan',
                    'en' => 'Business Plan',
                ),
            ),
            'answer_type' => 'file',
        ];
        $question35 = [
            'step' => 8,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Financial Plan',
                'name' =>
                array(
                    'de' => 'Financial Plan',
                    'en' => 'Financial Plan',
                ),
            ),
            'answer_type' => 'file',
        ];
        $question36 = [
            'step' => 8,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Resume',
                'name' =>
                array(
                    'de' => 'Resume',
                    'en' => 'Resume',
                ),
            ),
            'answer_type' => 'file',
        ];

        $question37 = [
            'step' => 8,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Other',
                'name' =>
                array(
                    'de' => 'Other',
                    'en' => 'Other',
                ),
            ),
            'answer_type' => 'file',
        ];

        $question38 = [
            'step' => 8,
            'sort_order' => 2,
            'title' => array(
                'value' => 'How did find out about Startfeld?',
                'name' =>
                array(
                    'de' => 'How did find out about Startfeld?',
                    'en' => 'How did find out about Startfeld?',
                ),
            ),
            'answer_type' => 'dropdown',
            'options' => array(
                'values' =>
                array(
                    0 =>
                    array(
                        'value' => 'Event',
                        'name' =>
                        array(
                            'de' => 'Event',
                            'en' => 'Event',
                        ),
                    ),
                    1 =>
                    array(
                        'value' => 'Media',
                        'name' =>
                        array(
                            'de' => 'Media',
                            'en' => 'Media',
                        ),
                    ),
                    2 =>
                    array(
                        'value' => 'Colleges',
                        'name' =>
                        array(
                            'de' => 'Colleges',
                            'en' => 'Colleges',
                        ),
                    ),
                    3 =>
                    array(
                        'value' => 'Miscellaneous',
                        'name' =>
                        array(
                            'de' => 'Miscellaneous',
                            'en' => 'Miscellaneous',
                        ),
                    ),
                ),
            )
        ];

        $question39 = [
            'step' => 8,
            'sort_order' => 3,
            'title' => array(
                'value' => 'Place and Date',
                'name' =>
                array(
                    'de' => 'Place and Date',
                    'en' => 'Place and Date',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1,
        ];

        $question40 = [
            'step' => 8,
            'sort_order' => 4,
            'title' => array(
                'value' => 'Completed By',
                'name' =>
                array(
                    'de' => 'Completed By',
                    'en' => 'Completed By',
                ),
            ),
            'answer_type' => 'text',
            'is_mandatory' => 1,
        ];

        $question41 = [
            'step' => 9,
            'sort_order' => 0,
            'title' => array(
                'value' => 'Contact Detail of Other Team Memebers',
                'name' =>
                array(
                    'de' => 'Contact Detail of Other Team Memebers',
                    'en' => 'Contact Detail of Other Team Memebers',
                ),
            ),
            'answer_type' => 'title',
        ];

        $question42 = [
            'step' => 9,
            'sort_order' => 1,
            'title' => array(
                'value' => 'Contact Detail',
                'name' =>
                array(
                    'de' => 'Contact Detail',
                    'en' => 'Contact Detail',
                ),
            ),
            'answer_type' => 'key',
            'options' => array(
                'key' => 'team_members',
            )
        ];


        $allQuestions = [
            '0' => $question1,
            '1' => $question2,
            '2' => $question3,
            '3' => $question4,
            '4' => $question5,
            '5' => $question6,
            '6' => $question7,
            '7' => $question8,
            '8' => $question9,
            '9' => $question10,
            '10' => $question11,
            '11' => $question12,
            '12' => $question13,
            '13' => $question14,
            '14' => $question15,
            '15' => $question16,
            '16' => $question17,
            '17' => $question18,
            '18' => $question19,
            '19' => $question20,
            '20' => $question21,
            '21' => $question22,
            '22' => $question23,
            '23' => $question24,
            '24' => $question25,
            '25' => $question26,
            '26' => $question27,
            '27' => $question28,
            '28' => $question29,
            '29' => $question30,
            '30' => $question31,
            '31' => $question32,
            '32' => $question33,
            '33' => $question34,
            '34' => $question35,
            '35' => $question36,
            '36' => $question37,
            '37' => $question38,
            '38' => $question39,
            '39' => $question40,
            '40' => $question41,
            '41' => $question42
        ];

        foreach ($allQuestions as $question) {
            Question::create($question);
        }
    }
}
