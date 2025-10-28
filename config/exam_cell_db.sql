CREATE DATABASE exam_cell_db;
USE exam_cell_db;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    department VARCHAR(50),
    role ENUM('HOD', 'COE', 'STAFF') NOT NULL
);

INSERT INTO users (username, password, full_name, department, role)
VALUES 
('cse',        'cse@2727',        'CSE Dept HOD',         'CSE',         'HOD'),
('ece',        'ece@2727',        'ECE Dept HOD',         'ECE',         'HOD'),
('cyber',      'cyber@2727',      'CYBER Dept HOD',       'CYBER',       'HOD'),
('civil',      'civil@2727',      'Civil Dept HOD',       'CIVIL',       'HOD'),
('aiml',       'aiml@2727',       'AIML Dept HOD',        'AIML',        'HOD'),
('aids',       'aids@2727',       'AIDS Dept HOD',        'AIDS',        'HOD'),
('mech',       'mech@2727',       'Mechanical Dept HOD',  'MECHANICAL',  'HOD'),
('eee',        'eee@2727',        'EEE Dept HOD',         'EEE',         'HOD'),
('vlsi',       'vlsi@2727',       'VLSI Dept HOD',        'VLSI',        'HOD'),
('agri',       'agri@2727',       'Agriculture Dept HOD', 'AGRICULTURE', 'HOD'),
('foodtech',   'foodtech@2727',   'Food Tech Dept HOD',   'FOODTECH',    'HOD'),
('biotech',    'biotech@2727',    'Biotech Dept HOD',     'BIOTECH',     'HOD'),
('biomedical', 'biomedical@2727', 'Biomedical Dept HOD',  'BIOMEDICAL',  'HOD'),
('it',         'it@2727',         'IT Dept HOD',          'IT',          'HOD'),
('admin',      'admin@2727',       'COE',                  NULL,          'COE'),
('staff',      'staff@2727',       'STAFF',                NULL,          'STAFF');


CREATE TABLE issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_role ENUM('HOD', 'COE') NOT NULL,
    from_dept VARCHAR(100) NOT NULL,
    to_dept VARCHAR(100) DEFAULT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    attachment VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Pending',
    reply TEXT,
    reply_attachment VARCHAR(255),
    reply_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    message TEXT,
    file_path VARCHAR(255),
    posted_by VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    reg_no VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100),
    dob DATE,
    degree VARCHAR(100),
    branch VARCHAR(100),
    regulation VARCHAR(20),
    semester INT
);

CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_no VARCHAR(20) NOT NULL,
    semester INT NOT NULL,
    exam_month VARCHAR(50) NOT NULL,
    subject_code VARCHAR(20) NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    grade VARCHAR(5) NOT NULL,
    result_status VARCHAR(20) NOT NULL,
    publish TINYINT(1) DEFAULT 0
);

CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_role ENUM('HOD', 'COE', 'STAFF'),
    user_id INT,
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Messages sent by COE to departments
CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    receiver_department VARCHAR(50),
    subject VARCHAR(100),
    message TEXT,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO students (reg_no, name, dob, degree, branch, regulation, semester)
VALUES 
('714023104001', 'Abinaya', '2004-12-23', 'B.E.', 'Computer Science and Engineering', '2021', 1),
('714023104002', 'Abitha', '2004-12-23', 'B.E.', 'Computer Science and Engineering', '2021', 1),
('714023104003', 'Ajay', '2004-12-23', 'B.E.', 'Computer Science and Engineering', '2021', 1),
('714023104004', 'Akil', '2004-12-23', 'B.E.', 'Computer Science and Engineering', '2021', 1),
('714023104005', 'Akshatha P', '2004-12-23', 'B.E.', 'Computer Science and Engineering', '2021', 1);

INSERT INTO results (reg_no, semester, subject_code, subject_name, grade, result_status, exam_month, publish)
VALUES 
('714023104001', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104001', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104001', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104002', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104002', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104002', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104003', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104003', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104003', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104004', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104004', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104004', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104005', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104005', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104005', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104005', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1),
('714023104005', 3, '21CS301', 'Advanced Data Structures', 'A', 'PASS', 'Nov 2024', 1);

