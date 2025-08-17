-- Learnora Categories and Subcategories Hierarchical Structure
-- Table structure: id, parent_id, category_name, slug

-- Main Categories (parent_id = NULL)
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(1, NULL, 'Academic', 'academic'),
(2, NULL, 'Business & Professional', 'business-professional'),
(3, NULL, 'Personal Development', 'personal-development'),
(4, NULL, 'Vocational & Technical Skills', 'vocational-technical-skills'),
(5, NULL, 'Languages & Communication', 'languages-communication'),
(6, NULL, 'Sports & Physical', 'sports-physical'),
(7, NULL, 'Creative & Artistic', 'creative-artistic'),
(8, NULL, 'Technology & IT', 'technology-it'),
(9, NULL, 'Certifications & Exams', 'certifications-exams');

-- ACADEMIC Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(10, 1, 'International Curriculum', 'international-curriculum'),
(11, 1, 'Special Needs', 'special-needs'),
(12, 1, 'Adult Education & Literacy', 'adult-education-literacy'),
(13, 1, 'University & Higher Education', 'university-higher-education'),
(14, 1, 'Agriculture', 'agriculture'),
(15, 1, 'Arts', 'arts'),
(16, 1, 'Biological Sciences', 'biological-sciences'),
(17, 1, 'Dentistry', 'dentistry'),
(18, 1, 'Education', 'education'),
(19, 1, 'Religion', 'religion'),
(20, 1, 'Engineering', 'engineering'),
(21, 1, 'Environmental Sciences', 'environmental-sciences'),
(22, 1, 'Health Sciences & Technology', 'health-sciences-technology'),
(23, 1, 'Law', 'law'),
(24, 1, 'Medical Sciences', 'medical-sciences'),
(25, 1, 'Pharmaceutical Sciences', 'pharmaceutical-sciences'),
(26, 1, 'Physical Sciences', 'physical-sciences'),
(27, 1, 'Social Sciences', 'social-sciences'),
(28, 1, 'Veterinary Medicine', 'veterinary-medicine');

-- International Curriculum Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(29, 10, 'British Curriculum', 'british-curriculum'),
(30, 10, 'American Curriculum', 'american-curriculum'),
(31, 10, 'Montessori Learning', 'montessori-learning'),
(32, 10, 'IB (International Baccalaureate)', 'ib-international-baccalaureate');

-- Special Needs Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(33, 11, 'Learning Disabilities', 'learning-disabilities'),
(34, 11, 'Emotional & Behavioral Needs', 'emotional-behavioral-needs'),
(35, 11, 'Speech & Communication Challenges', 'speech-communication-challenges'),
(36, 11, 'Physical Disabilities', 'physical-disabilities'),
(37, 11, 'Gifted & Talented Education', 'gifted-talented-education'),
(38, 11, 'Home Schooling for Special Needs', 'home-schooling-special-needs');

-- University & Higher Education Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(39, 13, 'Administration', 'administration'),
(40, 13, 'Accountancy', 'accountancy'),
(41, 13, 'Actuarial Science', 'actuarial-science'),
(42, 13, 'Business Administration', 'business-administration'),
(43, 13, 'Business Management', 'business-management'),
(44, 13, 'Banking & Finance', 'banking-finance'),
(45, 13, 'Hospitality & Tourism', 'hospitality-tourism'),
(46, 13, 'Marketing', 'marketing'),
(47, 13, 'Insurance', 'insurance'),
(48, 13, 'Industrial Relations & Personnel Management', 'industrial-relations-personnel-management'),
(49, 13, 'Office Technology & Management', 'office-technology-management'),
(50, 13, 'Entrepreneurship', 'entrepreneurship');

-- Agriculture Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(51, 14, 'Agricultural Economics', 'agricultural-economics'),
(52, 14, 'Soil Science', 'soil-science'),
(53, 14, 'Agricultural Extension', 'agricultural-extension'),
(54, 14, 'Agronomy', 'agronomy'),
(55, 14, 'Animal Science', 'animal-science'),
(56, 14, 'Crop Science', 'crop-science'),
(57, 14, 'Food Science & Technology', 'food-science-technology'),
(58, 14, 'Fisheries', 'fisheries'),
(59, 14, 'Forest Resources Management (forestry)', 'forest-resources-management'),
(60, 14, 'Home Science, Nutrition & Dietetics', 'home-science-nutrition-dietetics');

-- Arts Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(61, 15, 'Music', 'music'),
(62, 15, 'Arabic & Islamic Studies', 'arabic-islamic-studies'),
(63, 15, 'Archeology & Tourism', 'archeology-tourism'),
(64, 15, 'Christian Religious Studies', 'christian-religious-studies'),
(65, 15, 'English & Literary Studies', 'english-literary-studies'),
(66, 15, 'Fine & Applied Arts (creative Arts)', 'fine-applied-arts'),
(67, 15, 'Foreign Languages & Literature', 'foreign-languages-literature'),
(68, 15, 'History & International Studies', 'history-international-studies'),
(69, 15, 'Linguistics & Nigerian Languages', 'linguistics-nigerian-languages'),
(70, 15, 'Mass Communication (communication & Language Arts)', 'mass-communication'),
(71, 15, 'Theatre & Film Studies', 'theatre-film-studies');

-- Biological Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(72, 16, 'Biochemistry', 'biochemistry'),
(73, 16, 'Botany', 'botany'),
(74, 16, 'Microbiology', 'microbiology'),
(75, 16, 'Marine Biology', 'marine-biology'),
(76, 16, 'Cell Biology & Genetics', 'cell-biology-genetics'),
(77, 16, 'Zoology', 'zoology');

-- Dentistry Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(78, 17, 'Child Dental Health', 'child-dental-health'),
(79, 17, 'Preventive Dentistry', 'preventive-dentistry'),
(80, 17, 'Restorative Dentistry', 'restorative-dentistry'),
(81, 17, 'Oral & Maxillofacial Surgery', 'oral-maxillofacial-surgery');

-- Education Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(82, 18, 'Education & Social Science', 'education-social-science'),
(83, 18, 'Adult Education & Extra-mural Studies', 'adult-education-extra-mural-studies'),
(84, 18, 'Arts Education', 'arts-education'),
(85, 18, 'Education & Accountancy', 'education-accountancy'),
(86, 18, 'Education & Computer Science', 'education-computer-science'),
(87, 18, 'Education & Economics', 'education-economics'),
(88, 18, 'Education & Mathematics', 'education-mathematics'),
(89, 18, 'Education & Physics', 'education-physics'),
(90, 18, 'Education & Religious Studies', 'education-religious-studies'),
(91, 18, 'Education & Biology', 'education-biology'),
(92, 18, 'Education & Chemistry', 'education-chemistry'),
(93, 18, 'Education & English Language', 'education-english-language'),
(94, 18, 'Education & French', 'education-french'),
(95, 18, 'Education & Geography/physics', 'education-geography-physics'),
(96, 18, 'Education & Political Science', 'education-political-science'),
(97, 18, 'Educational Foundations', 'educational-foundations'),
(98, 18, 'Educational / Psychology Guidance & Counselling', 'educational-psychology-guidance-counselling'),
(99, 18, 'Health & Physical Education', 'health-physical-education'),
(100, 18, 'Library & Information Science', 'library-information-science'),
(101, 18, 'Science Education', 'science-education'),
(102, 18, 'Social Sciences Education', 'social-sciences-education'),
(103, 18, 'Vocational Teacher Education (technical Education)', 'vocational-teacher-education'),
(104, 18, 'Igbo Linguistics', 'igbo-linguistics'),
(105, 18, 'Educational Management', 'educational-management');

-- Engineering Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(106, 20, 'Civil Engineering', 'civil-engineering'),
(107, 20, 'Agricultural & Bioresources Engineering', 'agricultural-bioresources-engineering'),
(108, 20, 'Chemical Engineering', 'chemical-engineering'),
(109, 20, 'Computer Engineering', 'computer-engineering'),
(110, 20, 'Electrical Engineering', 'electrical-engineering'),
(111, 20, 'Electronic Engineering', 'electronic-engineering'),
(112, 20, 'Marine Engineering', 'marine-engineering'),
(113, 20, 'Mechanical Engineering', 'mechanical-engineering'),
(114, 20, 'Metallurgical & Materials Engineering', 'metallurgical-materials-engineering'),
(115, 20, 'Petroleum & Gas Engineering', 'petroleum-gas-engineering'),
(116, 20, 'Systems Engineering', 'systems-engineering'),
(117, 20, 'Structural Engineering', 'structural-engineering'),
(118, 20, 'Production & Industrial Engineering', 'production-industrial-engineering');

-- Environmental Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(119, 21, 'Architecture', 'architecture'),
(120, 21, 'Estate Management', 'estate-management'),
(121, 21, 'Quantity Surveying', 'quantity-surveying'),
(122, 21, 'Building', 'building'),
(123, 21, 'Geoinformatics & Surveying', 'geoinformatics-surveying'),
(124, 21, 'Urban & Regional Planning', 'urban-regional-planning');

-- Health Sciences & Technology Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(125, 22, 'Nursing Sciences', 'nursing-sciences'),
(126, 22, 'Health Administration & Management', 'health-administration-management'),
(127, 22, 'Medical Laboratory Sciences', 'medical-laboratory-sciences'),
(128, 22, 'Medical Radiography & Radiological Sciences', 'medical-radiography-radiological-sciences'),
(129, 22, 'Medical Rehabilitation', 'medical-rehabilitation');

-- Law Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(130, 23, 'Commercial & Property Law', 'commercial-property-law'),
(131, 23, 'International & Jurisprudence', 'international-jurisprudence'),
(132, 23, 'Private & Public Law', 'private-public-law'),
(133, 23, 'Paralegal', 'paralegal');

-- Medical Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(134, 24, 'Anatomy', 'anatomy'),
(135, 24, 'Anesthesia', 'anesthesia'),
(136, 24, 'Chemical Pathology', 'chemical-pathology'),
(137, 24, 'Community Medicine', 'community-medicine'),
(138, 24, 'Dermatology', 'dermatology'),
(139, 24, 'Hematology & Immunology', 'hematology-immunology'),
(140, 24, 'Medical Biochemistry', 'medical-biochemistry'),
(141, 24, 'Medical Microbiology', 'medical-microbiology'),
(142, 24, 'Medicine', 'medicine'),
(143, 24, 'Morbid Anatomy', 'morbid-anatomy'),
(144, 24, 'Nursing & Midwifery', 'nursing-midwifery'),
(145, 24, 'Obstetrics & Gynecology', 'obstetrics-gynecology'),
(146, 24, 'Ophthalmology', 'ophthalmology'),
(147, 24, 'Otolaryngology', 'otolaryngology'),
(148, 24, 'Pediatrics', 'pediatrics'),
(149, 24, 'Pharmacology & Therapeutics', 'pharmacology-therapeutics'),
(150, 24, 'Physiology', 'physiology'),
(151, 24, 'Radiation Medicine', 'radiation-medicine'),
(152, 24, 'Surgery', 'surgery'),
(153, 24, 'Psychological Medicine', 'psychological-medicine'),
(154, 24, 'Child Dental Health', 'child-dental-health-medical');

-- Pharmaceutical Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(155, 25, 'Pharmacognosy', 'pharmacognosy'),
(156, 25, 'Clinical Pharmacy & Pharmacy Management', 'clinical-pharmacy-management'),
(157, 25, 'Pharmaceutical Chemistry & Industrial Pharmacy', 'pharmaceutical-chemistry-industrial-pharmacy'),
(158, 25, 'Pharmaceutical Technology & Industrial Pharmacy', 'pharmaceutical-technology-industrial-pharmacy'),
(159, 25, 'Pharmaceutics', 'pharmaceutics'),
(160, 25, 'Pharmacology & Toxicology', 'pharmacology-toxicology');

-- Physical Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(161, 26, 'Computer Science', 'computer-science'),
(162, 26, 'Mathematics', 'mathematics'),
(163, 26, 'Geology', 'geology'),
(164, 26, 'Physics & Astronomy', 'physics-astronomy'),
(165, 26, 'Geophysics', 'geophysics'),
(166, 26, 'Pure & Industrial Chemistry', 'pure-industrial-chemistry'),
(167, 26, 'Statistics', 'statistics');

-- Social Sciences Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(168, 27, 'Economics', 'economics'),
(169, 27, 'Geography', 'geography'),
(170, 27, 'Philosophy', 'philosophy'),
(171, 27, 'Political Science', 'political-science'),
(172, 27, 'Psychology', 'psychology'),
(173, 27, 'Public Administration & Local Government', 'public-administration-local-government'),
(174, 27, 'Religion', 'religion-social'),
(175, 27, 'Social Work & Development', 'social-work-development'),
(176, 27, 'Sociology/anthropology', 'sociology-anthropology'),
(177, 27, 'Criminology', 'criminology');

-- Veterinary Medicine Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(178, 28, 'Veterinary Anatomy', 'veterinary-anatomy'),
(179, 28, 'Animal Health & Production', 'animal-health-production'),
(180, 28, 'Veterinary Physiology/pharmacology', 'veterinary-physiology-pharmacology'),
(181, 28, 'Veterinary Parasitology & Entomology', 'veterinary-parasitology-entomology'),
(182, 28, 'Veterinary Pathology & Microbiology', 'veterinary-pathology-microbiology'),
(183, 28, 'Veterinary Public Health & Preventive Medicine', 'veterinary-public-health-preventive-medicine'),
(184, 28, 'Veterinary Surgery', 'veterinary-surgery'),
(185, 28, 'Veterinary Medicine', 'veterinary-medicine-specific'),
(186, 28, 'Veterinary Obstetrics & Reproductive Diseases', 'veterinary-obstetrics-reproductive-diseases'),
(187, 28, 'Veterinary Teaching Hospital', 'veterinary-teaching-hospital');

-- BUSINESS & PROFESSIONAL Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(188, 2, 'Entrepreneurship & Startups', 'entrepreneurship-startups'),
(189, 2, 'Sales & Marketing', 'sales-marketing'),
(190, 2, 'Finance & Accounting', 'finance-accounting'),
(191, 2, 'Leadership & Management', 'leadership-management'),
(192, 2, 'Human Resources & Recruitment', 'human-resources-recruitment'),
(193, 2, 'Project Management', 'project-management'),
(194, 2, 'Customer Service & Client Relations', 'customer-service-client-relations'),
(195, 2, 'Legal & Regulatory', 'legal-regulatory'),
(196, 2, 'Technology for Business', 'technology-for-business'),
(197, 2, 'Career & Professional Development', 'career-professional-development'),
(198, 2, 'Industries', 'industries');

-- Entrepreneurship & Startups Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(199, 188, 'Starting a Small Business in Nigeria', 'starting-small-business-nigeria'),
(200, 188, 'Business Model Development', 'business-model-development'),
(201, 188, 'Writing Business Plans & Proposals', 'writing-business-plans-proposals'),
(202, 188, 'Funding & Pitching to Investors', 'funding-pitching-investors'),
(203, 188, 'Digital Tools for Entrepreneurs', 'digital-tools-entrepreneurs'),
(204, 188, 'Research Methodology & Analytics', 'research-methodology-analytics'),
(205, 188, 'Financial Literacy & Business Accounting', 'financial-literacy-business-accounting'),
(206, 188, 'Business Communication & Etiquette', 'business-communication-etiquette');

-- Sales & Marketing Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(207, 189, 'Digital Marketing (SEO, Social Media, Email)', 'digital-marketing'),
(208, 189, 'Sales Techniques & Lead Generation', 'sales-techniques-lead-generation'),
(209, 189, 'Branding & Product Positioning', 'branding-product-positioning'),
(210, 189, 'Customer Relationship Management (CRM)', 'customer-relationship-management'),
(211, 189, 'Copywriting & Content Marketing', 'copywriting-content-marketing');

-- Finance & Accounting Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(212, 190, 'Bookkeeping & Accounting Basics', 'bookkeeping-accounting-basics'),
(213, 190, 'Financial Modeling & Budgeting', 'financial-modeling-budgeting'),
(214, 190, 'Personal & Small Business Finance', 'personal-small-business-finance'),
(215, 190, 'Taxation (Nigeria & International)', 'taxation-nigeria-international'),
(216, 190, 'Investment Analysis & Portfolio Management', 'investment-analysis-portfolio-management');

-- Leadership & Management Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(217, 191, 'Strategic Leadership', 'strategic-leadership'),
(218, 191, 'Operations & Business Management', 'operations-business-management'),
(219, 191, 'People Management & Team Building', 'people-management-team-building'),
(220, 191, 'Change Management', 'change-management'),
(221, 191, 'Emotional Intelligence at Work', 'emotional-intelligence-work');

-- Human Resources & Recruitment Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(222, 192, 'HR Fundamentals & Labour Law (Nigeria)', 'hr-fundamentals-labour-law'),
(223, 192, 'Recruitment & Talent Acquisition', 'recruitment-talent-acquisition'),
(224, 192, 'Employee Onboarding & Training', 'employee-onboarding-training'),
(225, 192, 'Performance Management', 'performance-management'),
(226, 192, 'Workplace Diversity & Inclusion', 'workplace-diversity-inclusion');

-- Project Management Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(227, 193, 'Project Planning & Execution', 'project-planning-execution'),
(228, 193, 'PMP Exam Prep', 'pmp-exam-prep'),
(229, 193, 'Agile, Scrum & Kanban', 'agile-scrum-kanban'),
(230, 193, 'Risk & Time Management', 'risk-time-management'),
(231, 193, 'Project Monitoring & Evaluation', 'project-monitoring-evaluation');

-- Customer Service & Client Relations Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(232, 194, 'Customer Experience (CX) Design', 'customer-experience-design'),
(233, 194, 'Handling Complaints & Conflict', 'handling-complaints-conflict'),
(234, 194, 'Service Excellence in Retail & Hospitality', 'service-excellence-retail-hospitality'),
(235, 194, 'Communication & Empathy Skills', 'communication-empathy-skills'),
(236, 194, 'Call Center & Front Desk Skills', 'call-center-front-desk-skills');

-- Legal & Regulatory Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(237, 195, 'Business Law & Contracts', 'business-law-contracts'),
(238, 195, 'Intellectual Property (IP) Basics', 'intellectual-property-basics'),
(239, 195, 'Regulatory Compliance', 'regulatory-compliance'),
(240, 195, 'Data Protection & Privacy', 'data-protection-privacy');

-- Technology for Business Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(241, 196, 'Business Productivity Tools (Excel, Google Workspace)', 'business-productivity-tools'),
(242, 196, 'E-commerce & Online Stores', 'ecommerce-online-stores'),
(243, 196, 'Digital Transformation Strategies', 'digital-transformation-strategies'),
(244, 196, 'CRM & ERP Software', 'crm-erp-software'),
(245, 196, 'Cybersecurity for Small Businesses', 'cybersecurity-small-businesses');

-- Career & Professional Development Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(246, 197, 'CV Writing & Cover Letters', 'cv-writing-cover-letters'),
(247, 197, 'Interview Techniques', 'interview-techniques'),
(248, 197, 'Workplace Communication', 'workplace-communication'),
(249, 197, 'Time Management & Productivity', 'time-management-productivity'),
(250, 197, 'Remote Work & Freelancing Skills', 'remote-work-freelancing-skills'),
(251, 197, 'Pre-Retirement & New Beginnings', 'pre-retirement-new-beginnings');

-- Industries Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(252, 198, 'Actuary & Insurance', 'actuary-insurance'),
(253, 198, 'Agriculture & Agribusiness', 'agriculture-agribusiness'),
(254, 198, 'Manufacturing & Processing', 'manufacturing-processing'),
(255, 198, 'Oil, Gas & Energy', 'oil-gas-energy'),
(256, 198, 'Mining & Solid Minerals', 'mining-solid-minerals'),
(257, 198, 'Construction & Real Estate', 'construction-real-estate'),
(258, 198, 'Financial Services', 'financial-services'),
(259, 198, 'Healthcare & Life Sciences', 'healthcare-life-sciences'),
(260, 198, 'Education & Training', 'education-training'),
(261, 198, 'Telecommunications, ICT & Technology', 'telecommunications-ict-technology'),
(262, 198, 'Transportation & Logistics', 'transportation-logistics'),
(263, 198, 'Retail & Consumer Goods', 'retail-consumer-goods'),
(264, 198, 'Hospitality & Tourism', 'hospitality-tourism-industries'),
(265, 198, 'Media & Entertainment', 'media-entertainment'),
(266, 198, 'Security & Crime Prevention', 'security-crime-prevention'),
(267, 198, 'Environmental & Waste Management', 'environmental-waste-management'),
(268, 198, 'Government & Public Services', 'government-public-services'),
(269, 198, 'Aviation', 'aviation'),
(270, 198, 'Maritime', 'maritime'),
(271, 198, 'Banking & Finance', 'banking-finance-industries'),
(272, 198, 'Art & Craft', 'art-craft');

-- PERSONAL DEVELOPMENT Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(273, 3, 'Self-Improvement', 'self-improvement'),
(274, 3, 'Emotional Intelligence & Mental Wellness', 'emotional-intelligence-mental-wellness'),
(275, 3, 'Communication Skills', 'communication-skills'),
(276, 3, 'Leadership & Influence', 'leadership-influence'),
(277, 3, 'Career & Professional Growth', 'career-professional-growth'),
(278, 3, 'Financial Literacy & Personal Finance', 'financial-literacy-personal-finance'),
(279, 3, 'Creativity & Innovation', 'creativity-innovation'),
(280, 3, 'Habits & Lifestyle Optimization', 'habits-lifestyle-optimization'),
(281, 3, 'Personal Branding & Online Presence', 'personal-branding-online-presence');

-- Self-Improvement Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(282, 273, 'Goal Setting & Achievement', 'goal-setting-achievement'),
(283, 273, 'Time Management & Productivity', 'time-management-productivity-personal'),
(284, 273, 'Building Self-Discipline', 'building-self-discipline'),
(285, 273, 'Confidence & Self-Esteem', 'confidence-self-esteem'),
(286, 273, 'Personal Values & Life Vision', 'personal-values-life-vision');

-- Emotional Intelligence & Mental Wellness Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(287, 274, 'Emotional Regulation', 'emotional-regulation'),
(288, 274, 'Stress Management', 'stress-management'),
(289, 274, 'Mindfulness & Meditation', 'mindfulness-meditation'),
(290, 274, 'Resilience Building', 'resilience-building'),
(291, 274, 'Overcoming Limiting Beliefs', 'overcoming-limiting-beliefs');

-- Communication Skills Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(292, 275, 'Public Speaking & Presentation', 'public-speaking-presentation'),
(293, 275, 'Active Listening', 'active-listening'),
(294, 275, 'Assertiveness Training', 'assertiveness-training'),
(295, 275, 'Conflict Resolution', 'conflict-resolution'),
(296, 275, 'Non-Verbal Communication', 'non-verbal-communication');

-- Leadership & Influence Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(297, 276, 'Personal Leadership', 'personal-leadership'),
(298, 276, 'Influence & Persuasion', 'influence-persuasion'),
(299, 276, 'Decision Making', 'decision-making'),
(300, 276, 'Visionary Thinking', 'visionary-thinking'),
(301, 276, 'Ethical Leadership', 'ethical-leadership');

-- Career & Professional Growth Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(302, 277, 'Career Planning', 'career-planning'),
(303, 277, 'Networking & Relationship Building', 'networking-relationship-building'),
(304, 277, 'Workplace Etiquette', 'workplace-etiquette'),
(305, 277, 'Productivity Tools & Techniques', 'productivity-tools-techniques'),
(306, 277, 'Work-Life Balance', 'work-life-balance');

-- Financial Literacy & Personal Finance Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(307, 278, 'Budgeting & Saving', 'budgeting-saving'),
(308, 278, 'Debt Management', 'debt-management'),
(309, 278, 'Investment Basics', 'investment-basics'),
(310, 278, 'Retirement & Long-Term Planning', 'retirement-long-term-planning'),
(311, 278, 'Money Mindset & Habits', 'money-mindset-habits');

-- Creativity & Innovation Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(312, 279, 'Creative Thinking', 'creative-thinking'),
(313, 279, 'Problem-Solving Skills', 'problem-solving-skills'),
(314, 279, 'Brainstorming Techniques', 'brainstorming-techniques'),
(315, 279, 'Design Thinking Basics', 'design-thinking-basics'),
(316, 279, 'Lateral Thinking', 'lateral-thinking');

-- Habits & Lifestyle Optimization Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(317, 280, 'Building Positive Habits', 'building-positive-habits'),
(318, 280, 'Breaking Bad Habits', 'breaking-bad-habits'),
(319, 280, 'Digital Detox & Focus', 'digital-detox-focus'),
(320, 280, 'Morning & Evening Routines', 'morning-evening-routines'),
(321, 280, 'Health & Wellness Practices', 'health-wellness-practices');

-- Personal Branding & Online Presence Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(322, 281, 'Building a Personal Brand', 'building-personal-brand'),
(323, 281, 'Social Media Presence', 'social-media-presence'),
(324, 281, 'LinkedIn Optimization', 'linkedin-optimization'),
(325, 281, 'Blogging & Content Creation', 'blogging-content-creation'),
(326, 281, 'Thought Leadership', 'thought-leadership');

-- VOCATIONAL & TECHNICAL SKILLS Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(327, 4, 'Technical & Engineering Trades', 'technical-engineering-trades'),
(328, 4, 'ICT & Digital Skills', 'ict-digital-skills'),
(329, 4, 'Fashion & Beauty', 'fashion-beauty'),
(330, 4, 'Catering & Hospitality', 'catering-hospitality'),
(331, 4, 'Creative & Media Arts', 'creative-media-arts'),
(332, 4, 'Agriculture & Agro-Tech', 'agriculture-agro-tech'),
(333, 4, 'Building & Construction', 'building-construction'),
(334, 4, 'Automotive & Transport', 'automotive-transport'),
(335, 4, 'Business & Entrepreneurship Skills', 'business-entrepreneurship-skills');

-- Technical & Engineering Trades Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(336, 327, 'Electrical Installation & Maintenance', 'electrical-installation-maintenance'),
(337, 327, 'Plumbing & Pipefitting', 'plumbing-pipefitting'),
(338, 327, 'Welding & Fabrication', 'welding-fabrication'),
(339, 327, 'Carpentry & Joinery', 'carpentry-joinery'),
(340, 327, 'Mechanical Engineering Craft', 'mechanical-engineering-craft'),
(341, 327, 'Solar Panel Installation & Maintenance', 'solar-panel-installation-maintenance');

-- ICT & Digital Skills Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(342, 328, 'Computer Hardware & Networking', 'computer-hardware-networking'),
(343, 328, 'Web Design & Development', 'web-design-development'),
(344, 328, 'Graphic Design (CorelDraw, Photoshop, Canva)', 'graphic-design-tools'),
(345, 328, 'Digital Marketing & SEO', 'digital-marketing-seo'),
(346, 328, 'Software Development (Python, JavaScript, etc.)', 'software-development-vocational'),
(347, 328, 'CCTV & Home Automation Installation', 'cctv-home-automation-installation');

-- Fashion & Beauty Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(348, 329, 'Fashion Design & Tailoring', 'fashion-design-tailoring'),
(349, 329, 'Makeup Artistry', 'makeup-artistry'),
(350, 329, 'Hairdressing & Barbering', 'hairdressing-barbering'),
(351, 329, 'Skincare & Spa Therapy', 'skincare-spa-therapy'),
(352, 329, 'Nail Technology', 'nail-technology');

-- Catering & Hospitality Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(353, 330, 'Culinary Arts & Catering', 'culinary-arts-catering'),
(354, 330, 'Baking & Pastry Making', 'baking-pastry-making'),
(355, 330, 'Event Planning & Management', 'event-planning-management'),
(356, 330, 'Housekeeping & Hotel Services', 'housekeeping-hotel-services'),
(357, 330, 'Front Desk & Customer Service', 'front-desk-customer-service');

-- Creative & Media Arts Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(358, 331, 'Photography & Videography', 'photography-videography'),
(359, 331, 'Film & Video Editing', 'film-video-editing'),
(360, 331, 'Music Production & Studio Engineering', 'music-production-studio-engineering'),
(361, 331, 'Animation & Motion Graphics', 'animation-motion-graphics'),
(362, 331, 'Radio & TV Broadcasting', 'radio-tv-broadcasting');

-- Agriculture & Agro-Tech Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(363, 332, 'Crop Production Techniques', 'crop-production-techniques'),
(364, 332, 'Animal Husbandry & Poultry Farming', 'animal-husbandry-poultry-farming'),
(365, 332, 'Fish Farming', 'fish-farming'),
(366, 332, 'Agro-Processing', 'agro-processing'),
(367, 332, 'Greenhouse & Smart Farming', 'greenhouse-smart-farming');

-- Building & Construction Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(368, 333, 'Masonry & Bricklaying', 'masonry-bricklaying'),
(369, 333, 'Painting & Interior Decoration', 'painting-interior-decoration'),
(370, 333, 'Tiling & Flooring', 'tiling-flooring'),
(371, 333, 'Roofing & Ceiling Installation', 'roofing-ceiling-installation'),
(372, 333, 'Drafting & Building Technology', 'drafting-building-technology');

-- Automotive & Transport Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(373, 334, 'Auto Mechanics & Vehicle Diagnostics', 'auto-mechanics-vehicle-diagnostics'),
(374, 334, 'Auto Electrical & Rewiring', 'auto-electrical-rewiring'),
(375, 334, 'Driving School & Road Safety', 'driving-school-road-safety'),
(376, 334, 'Logistics & Fleet Management', 'logistics-fleet-management');

-- Business & Entrepreneurship Skills Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(377, 335, 'Small Business Management', 'small-business-management'),
(378, 335, 'Financial Literacy & Bookkeeping', 'financial-literacy-bookkeeping'),
(379, 335, 'E-commerce Setup', 'ecommerce-setup'),
(380, 335, 'POS Business Operation', 'pos-business-operation'),
(381, 335, 'Customer Service & Sales Skills', 'customer-service-sales-skills');

-- LANGUAGES & COMMUNICATION Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(382, 5, 'English Language', 'english-language'),
(383, 5, 'Nigerian & Indigenous Languages', 'nigerian-indigenous-languages'),
(384, 5, 'Sign Language', 'sign-language'),
(385, 5, 'Foreign Languages', 'foreign-languages'),
(386, 5, 'Public Speaking & Presentation Skills', 'public-speaking-presentation-skills'),
(387, 5, 'Writing & Literacy Skills', 'writing-literacy-skills'),
(388, 5, 'Business & Professional Communication', 'business-professional-communication'),
(389, 5, 'Soft Skills & Interpersonal Communication', 'soft-skills-interpersonal-communication');

-- English Language Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(390, 382, 'Basic Grammar & Vocabulary', 'basic-grammar-vocabulary'),
(391, 382, 'Spoken English & Pronunciation', 'spoken-english-pronunciation'),
(392, 382, 'Business English', 'business-english'),
(393, 382, 'Academic English (Essay Writing, Reports, Research)', 'academic-english'),
(394, 382, 'English as a Second Language (ESL)', 'english-second-language'),
(395, 382, 'IELTS / TOEFL Preparation', 'ielts-toefl-preparation'),
(396, 382, 'Creative Writing & Storytelling', 'creative-writing-storytelling'),
(397, 382, 'Public Speaking in English', 'public-speaking-english');

-- Nigerian & Indigenous Languages Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(398, 383, 'Yoruba Language', 'yoruba-language'),
(399, 383, 'Igbo Language', 'igbo-language'),
(400, 383, 'Hausa Language', 'hausa-language'),
(401, 383, 'Efik', 'efik'),
(402, 383, 'Ibibio', 'ibibio'),
(403, 383, 'Tiv', 'tiv'),
(404, 383, 'Other local dialects', 'other-local-dialects');

-- Foreign Languages Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(405, 385, 'French Language', 'french-language'),
(406, 385, 'German Language', 'german-language'),
(407, 385, 'Spanish Language', 'spanish-language'),
(408, 385, 'Chinese (Mandarin)', 'chinese-mandarin'),
(409, 385, 'Arabic Language', 'arabic-language'),
(410, 385, 'Language for Travel & Business', 'language-travel-business'),
(411, 385, 'DELF, Goethe, DELE Exam Preparation', 'delf-goethe-dele-exam-preparation');

-- Public Speaking & Presentation Skills Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(412, 386, 'Confidence Building & Stage Presence', 'confidence-building-stage-presence'),
(413, 386, 'Speech Writing & Delivery', 'speech-writing-delivery'),
(414, 386, 'Debate & Argumentation Skills', 'debate-argumentation-skills'),
(415, 386, 'Toastmasters-style Training', 'toastmasters-style-training'),
(416, 386, 'Interview Preparation', 'interview-preparation'),
(417, 386, 'Virtual & Corporate Presentation Skills', 'virtual-corporate-presentation-skills');

-- Writing & Literacy Skills Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(418, 387, 'Report & Proposal Writing', 'report-proposal-writing'),
(419, 387, 'Copywriting & Content Writing', 'copywriting-content-writing'),
(420, 387, 'Technical Writing', 'technical-writing'),
(421, 387, 'Grammar & Punctuation Mastery', 'grammar-punctuation-mastery'),
(422, 387, 'Academic Writing (for students & researchers)', 'academic-writing'),
(423, 387, 'Reading Comprehension Strategies', 'reading-comprehension-strategies');

-- Business & Professional Communication Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(424, 388, 'Business Writing (Emails, Letters, Memos)', 'business-writing'),
(425, 388, 'Negotiation & Persuasion Skills', 'negotiation-persuasion-skills'),
(426, 388, 'Workplace Communication Etiquette', 'workplace-communication-etiquette'),
(427, 388, 'Customer Service Communication', 'customer-service-communication'),
(428, 388, 'Communication for Managers & Executives', 'communication-managers-executives');

-- Soft Skills & Interpersonal Communication Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(429, 389, 'Active Listening', 'active-listening-communication'),
(430, 389, 'Conflict Resolution', 'conflict-resolution-communication'),
(431, 389, 'Team Communication', 'team-communication'),
(432, 389, 'Emotional Intelligence in Communication', 'emotional-intelligence-communication'),
(433, 389, 'Communication for Leadership', 'communication-leadership');

-- SPORTS & PHYSICAL Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(434, 6, 'Fitness & Aerobics', 'fitness-aerobics'),
(435, 6, 'Strength Training & Bodybuilding', 'strength-training-bodybuilding'),
(436, 6, 'Yoga & Meditation', 'yoga-meditation'),
(437, 6, 'Dance & Choreography', 'dance-choreography'),
(438, 6, 'Sports Coaching (Football, Basketball, etc.)', 'sports-coaching'),
(439, 6, 'Nutrition & Wellness', 'nutrition-wellness'),
(440, 6, 'First Aid & Safety Training', 'first-aid-safety-training'),
(441, 6, 'Self-Defense & Martial Arts', 'self-defense-martial-arts'),
(442, 6, 'Physical Education for Schools', 'physical-education-schools'),
(443, 6, 'Wellness Retreats', 'wellness-retreats');

-- CREATIVE & ARTISTIC Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(444, 7, 'Visual Arts', 'visual-arts'),
(445, 7, 'Design & Media', 'design-media'),
(446, 7, 'Crafts & Handmade Art', 'crafts-handmade-art'),
(447, 7, 'Photography & Videography', 'photography-videography-creative'),
(448, 7, 'Performing Arts', 'performing-arts'),
(449, 7, 'Music & Sound', 'music-sound'),
(450, 7, 'Writing & Literary Arts', 'writing-literary-arts'),
(451, 7, 'Fashion & Beauty', 'fashion-beauty-creative');

-- Visual Arts Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(452, 444, 'Drawing & Sketching', 'drawing-sketching'),
(453, 444, 'Painting', 'painting'),
(454, 444, 'Digital Art & Illustration', 'digital-art-illustration'),
(455, 444, 'Calligraphy & Typography', 'calligraphy-typography'),
(456, 444, 'Comic & Manga Art', 'comic-manga-art');

-- Design & Media Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(457, 445, 'Graphic Design', 'graphic-design'),
(458, 445, 'UI/UX Design', 'ui-ux-design'),
(459, 445, 'Fashion Design & Illustration', 'fashion-design-illustration'),
(460, 445, 'Interior Design & Decoration', 'interior-design-decoration'),
(461, 445, 'Product Design & Branding', 'product-design-branding');

-- Crafts & Handmade Art Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(462, 446, 'Bead Making & Jewelry Design', 'bead-making-jewelry-design'),
(463, 446, 'Textile Art (Tie & Dye, Batik)', 'textile-art'),
(464, 446, 'Pottery & Ceramics', 'pottery-ceramics'),
(465, 446, 'Paper Craft & Origami', 'paper-craft-origami'),
(466, 446, 'DIY Home Decor Projects', 'diy-home-decor-projects');

-- Photography & Videography Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(467, 447, 'Photography Basics', 'photography-basics'),
(468, 447, 'Portrait & Event Photography', 'portrait-event-photography'),
(469, 447, 'Video Editing', 'video-editing'),
(470, 447, 'Cinematography & Storyboarding', 'cinematography-storyboarding'),
(471, 447, 'Drone Photography', 'drone-photography');

-- Performing Arts Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(472, 448, 'Acting & Stage Performance', 'acting-stage-performance'),
(473, 448, 'Theatre Arts & Drama', 'theatre-arts-drama'),
(474, 448, 'Dance', 'dance'),
(475, 448, 'Stage Directing & Production', 'stage-directing-production');

-- Music & Sound Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(476, 449, 'Instrument Lessons (Piano, Guitar, Drums, Violin)', 'instrument-lessons'),
(477, 449, 'Voice Training & Singing', 'voice-training-singing'),
(478, 449, 'Music Theory & Composition', 'music-theory-composition'),
(479, 449, 'Music Production (FL Studio, Logic Pro, Ableton)', 'music-production'),
(480, 449, 'DJ & Live Sound Management', 'dj-live-sound-management');

-- Writing & Literary Arts Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(481, 450, 'Creative Writing (Poetry, Short Stories, Novels)', 'creative-writing'),
(482, 450, 'Scriptwriting (Stage, Screen, Radio)', 'scriptwriting'),
(483, 450, 'Spoken Word & Performance Poetry', 'spoken-word-performance-poetry'),
(484, 450, 'Blogging & Digital Storytelling', 'blogging-digital-storytelling'),
(485, 450, 'Editing & Proofreading Skills', 'editing-proofreading-skills');

-- Fashion & Beauty Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(486, 451, 'Sewing & Tailoring', 'sewing-tailoring'),
(487, 451, 'Makeup Artistry & Skincare', 'makeup-artistry-skincare'),
(488, 451, 'Hair Styling & Braiding', 'hair-styling-braiding'),
(489, 451, 'Fashion Styling & Personal Branding', 'fashion-styling-personal-branding'),
(490, 451, 'Runway & Model Training', 'runway-model-training');

-- TECHNOLOGY & IT Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(491, 8, 'Computer Basics & Digital Literacy', 'computer-basics-digital-literacy'),
(492, 8, 'Software & Office Tools', 'software-office-tools'),
(493, 8, 'Programming & Software Development', 'programming-software-development'),
(494, 8, 'Web Development & Design', 'web-development-design'),
(495, 8, 'Data & Analytics', 'data-analytics'),
(496, 8, 'Cybersecurity', 'cybersecurity'),
(497, 8, 'Networking & Infrastructure', 'networking-infrastructure'),
(498, 8, 'Cloud Computing', 'cloud-computing'),
(499, 8, 'IT Certifications', 'it-certifications'),
(500, 8, 'Tech for Business & Entrepreneurship', 'tech-business-entrepreneurship'),
(501, 8, 'Blockchain & Cryptocurrency', 'blockchain-cryptocurrency'),
(502, 8, 'Artificial Intelligence', 'artificial-intelligence');

-- Computer Basics & Digital Literacy Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(503, 491, 'Introduction to Computers', 'introduction-computers'),
(504, 491, 'Internet & Email Skills', 'internet-email-skills'),
(505, 491, 'Typing & Office Productivity Tools', 'typing-office-productivity-tools'),
(506, 491, 'Computer Maintenance & Troubleshooting', 'computer-maintenance-troubleshooting');

-- Software & Office Tools Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(507, 492, 'Microsoft Office', 'microsoft-office'),
(508, 492, 'Google Workspace', 'google-workspace'),
(509, 492, 'PDF & Document Management', 'pdf-document-management'),
(510, 492, 'Collaboration Tools', 'collaboration-tools');

-- Programming & Software Development Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(511, 493, 'Python Programming', 'python-programming'),
(512, 493, 'JavaScript, HTML & CSS', 'javascript-html-css'),
(513, 493, 'Java, C++, C#', 'java-cpp-csharp'),
(514, 493, 'Mobile App Development', 'mobile-app-development'),
(515, 493, 'Game Development', 'game-development'),
(516, 493, 'Software Engineering Principles', 'software-engineering-principles');

-- Web Development & Design Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(517, 494, 'Front-End Development', 'front-end-development'),
(518, 494, 'Back-End Development', 'back-end-development'),
(519, 494, 'Full-Stack Web Development', 'full-stack-web-development'),
(520, 494, 'WordPress & CMS Tools', 'wordpress-cms-tools'),
(521, 494, 'UI/UX Design Basics', 'ui-ux-design-basics'),
(522, 494, 'Web Hosting & Deployment', 'web-hosting-deployment');

-- Data & Analytics Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(523, 495, 'Microsoft Excel for Data Analysis', 'microsoft-excel-data-analysis'),
(524, 495, 'SQL & Database Management', 'sql-database-management'),
(525, 495, 'Data Visualization', 'data-visualization'),
(526, 495, 'Python for Data Science', 'python-data-science'),
(527, 495, 'Machine Learning & AI Basics', 'machine-learning-ai-basics'),
(528, 495, 'Big Data Tools (Hadoop, Spark)', 'big-data-tools');

-- Cybersecurity Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(529, 496, 'Introduction to Cybersecurity', 'introduction-cybersecurity'),
(530, 496, 'Ethical Hacking & Penetration Testing', 'ethical-hacking-penetration-testing'),
(531, 496, 'Network Security', 'network-security'),
(532, 496, 'Data Privacy & Compliance', 'data-privacy-compliance'),
(533, 496, 'Cybersecurity Certifications', 'cybersecurity-certifications');

-- Networking & Infrastructure Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(534, 497, 'Computer Networking Fundamentals', 'computer-networking-fundamentals'),
(535, 497, 'Cisco', 'cisco'),
(536, 497, 'Cloud Networking', 'cloud-networking'),
(537, 497, 'Network Administration & Support', 'network-administration-support'),
(538, 497, 'Server Management', 'server-management');

-- Cloud Computing Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(539, 498, 'Cloud Fundamentals', 'cloud-fundamentals'),
(540, 498, 'DevOps & Cloud Automation', 'devops-cloud-automation'),
(541, 498, 'Infrastructure as a Service (IaaS)', 'infrastructure-as-service'),
(542, 498, 'Software as a Service (SaaS)', 'software-as-service'),
(543, 498, 'Cloud Security', 'cloud-security');

-- IT Certifications Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(544, 499, 'CompTIA', 'comptia'),
(545, 499, 'Cisco Certifications', 'cisco-certifications'),
(546, 499, 'Microsoft Certifications', 'microsoft-certifications'),
(547, 499, 'Google IT Support', 'google-it-support'),
(548, 499, 'AWS / Azure Certifications', 'aws-azure-certifications');

-- Tech for Business & Entrepreneurship Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(549, 500, 'E-commerce Website Development', 'ecommerce-website-development'),
(550, 500, 'Digital Marketing Tools', 'digital-marketing-tools'),
(551, 500, 'CRM & ERP Systems', 'crm-erp-systems'),
(552, 500, 'Business Automation Tools', 'business-automation-tools'),
(553, 500, 'Tech Start-Up Essentials', 'tech-startup-essentials');

-- CERTIFICATIONS & EXAMS Subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(554, 9, 'Business & Finance', 'business-finance-certifications'),
(555, 9, 'Technology & IT', 'technology-it-certifications'),
(556, 9, 'Education & Teaching', 'education-teaching-certifications'),
(557, 9, 'Supply Chain & Operations', 'supply-chain-operations-certifications'),
(558, 9, 'Healthcare & Medical', 'healthcare-medical-certifications'),
(559, 9, 'Legal & Compliance', 'legal-compliance-certifications'),
(560, 9, 'International Exams', 'international-exams');

-- Business & Finance Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(561, 554, 'Accounting Certifications', 'accounting-certifications'),
(562, 554, 'Finance & Investment', 'finance-investment-certifications'),
(563, 554, 'Banking & Microfinance', 'banking-microfinance-certifications'),
(564, 554, 'Project Management', 'project-management-certifications');

-- Accounting Certifications Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(565, 561, 'ACCA (Association of Chartered Certified Accountants)', 'acca'),
(566, 561, 'ICAN (Institute of Chartered Accountants of Nigeria)', 'ican'),
(567, 561, 'CPA (Certified Public Accountant)', 'cpa');

-- Finance & Investment Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(568, 562, 'CFA (Chartered Financial Analyst)', 'cfa'),
(569, 562, 'CFI (Certified Financial Modeling & Valuation Analyst)', 'cfi'),
(570, 562, 'FRM (Financial Risk Manager)', 'frm');

-- Banking & Microfinance Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(571, 563, 'CIBN Certifications', 'cibn-certifications'),
(572, 563, 'Microfinance Certification Programs', 'microfinance-certification-programs');

-- Project Management Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(573, 564, 'PMP (Project Management Professional)', 'pmp'),
(574, 564, 'PRINCE2 (Projects IN Controlled Environments)', 'prince2'),
(575, 564, 'CAPM (Certified Associate in Project Management)', 'capm'),
(576, 564, 'Agile & Scrum Certifications (Scrum Master, PMI-ACP)', 'agile-scrum-certifications');

-- Technology & IT Sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(577, 555, 'Networking & Infrastructure', 'networking-infrastructure-certifications'),
(578, 555, 'Cloud & DevOps', 'cloud-devops-certifications'),
(579, 555, 'Programming & Software', 'programming-software-certifications'),
(580, 555, 'Cybersecurity', 'cybersecurity-certifications-specific'),
(581, 555, 'Data & Analytics', 'data-analytics-certifications');

-- Networking & Infrastructure Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(582, 577, 'Cisco (CCNA, CCNP)', 'cisco-ccna-ccnp'),
(583, 577, 'CompTIA (A+, Network+, Security+)', 'comptia-certifications');

-- Cloud & DevOps Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(584, 578, 'AWS Certification (Cloud Practitioner, Solutions Architect)', 'aws-certification'),
(585, 578, 'Microsoft Azure Certifications', 'microsoft-azure-certifications'),
(586, 578, 'Google Cloud Certifications', 'google-cloud-certifications');

-- Programming & Software Sub-sub-subcategories
INSERT INTO ln_categories (id, parent_id, category_name, slug) VALUES
(587, 579, 'Python, Java, JavaScript Certifications', 'python-java-javascript-certifications'),