DROP DATABASE IF EXISTS  sms;
CREATE DATABASE sms;
USE sms;

--  CREATE THE ADMIN TABLE
CREATE TABLE Admin(
    admin_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    username VARCHAR(40),
    fname VARCHAR(40),
    lname VARCHAR(30),
    password VARCHAR(100), 
    profile VARCHAR(100)
);

-- ADD DEFAULT ADMIN FOR
INSERT INTO admin (
    username ,
    fname,
    lname,
    password , 
    profile
)VALUES(
    'khan',
    "Khan",
    "Hamidi",
    "$2y$10$6pGpFI0Uq8beqoTAWAf0EeJV400K7rIEKDgAKVMSfeD.vpMMGwlPu",
    "assets/images/admin.jpg"
);
-- CREATE THE TEACHERS TABLE 
CREATE TABLE teachers(
    teacher_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    username VARCHAR(40),
    fname VARCHAR(40),
    lname VARCHAR(30),
    password VARCHAR(100),
    profile VARCHAR(255),
    address VARCHAR(50),
    employee_number VARCHAR(40),
    date_of_birth DATE,
    phone_number VARCHAR(20),
    qualification VARCHAR(255),
    gender VARCHAR(8),
    email VARCHAR (255),
    join_date DATE DEFAULT CURRENT_TIMESTAMP

);


-- INSERT INTO TEACHER TABLE 

INSERT INTO teachers (
    username,
    fname ,
    lname,
    password,
    profile,
    address,
    employee_number,
    date_of_birth,
    phone_number,
    qualification,
    gender,
    email
)VALUES(
    "alikhan",
    "Ali Khan",
    "Hakimi",
    "$2y$10$6pGpFI0Uq8beqoTAWAf0EeJV400K7rIEKDgAKVMSfeD.vpMMGwlPu",
    'assets/images/default.jpg',
    "Kubal",
    "40442",
    "2002-2-19",
    "0772640404",
    "BSC",
    "Male",
    "alikhan22@gmail.com"
);

-- CREATE STUDENTS TABLE
CREATE TABLE students(
    student_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    username VARCHAR(40),
    fname VARCHAR(40),
    lname VARCHAR(30),
    password VARCHAR(100),
    profile VARCHAR(255),
    address VARCHAR(49),
    gender VARCHAR(9),
    email VARCHAR(200),
    date_of_birth DATE,
    join_date DATE DEFAULT CURRENT_TIMESTAMP,
    parent_first_name VARCHAR(40),
    parent_last_name VARCHAR(40),
    parent_phone_number VARCHAR (20)
);

-- INSERT INTO STUDENTS 
INSERT INTO students (
    username,
    fname ,
    lname,
    password,
    profile,
    address,
    gender,
    email,
    date_of_birth,
    parent_first_name,
    parent_last_name,
    parent_phone_number
)VALUES(
    "mohammad",
    "Mohammad",
    "Hakimi",
    "$2y$10$6pGpFI0Uq8beqoTAWAf0EeJV400K7rIEKDgAKVMSfeD.vpMMGwlPu",
    'assets/images/default.jpg',
    "Ghor",
    "Male",
    "mohammad@gmail.com",
    "2002-2-19",
    "Khan",
    "Hakimi",
    "0779284923"
);



-- CREATE GRADES TABLE 
CREATE TABLE grades(
    grade_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    grade VARCHAR(58),
    grade_code VARCHAR(40)
);

-- INSERT INTO GRADES
INSERT INTO grades (
    grade,
    grade_code
)VALUES(
    '1',
    'G'
),
(
    '2',
    "G"
),
(
    '3',
    "G"
);

-- CREATE SUBJECTS OR COURSE TABLE
CREATE TABLE subjects(
    subject_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(58),
    subject_code VARCHAR(40),
    grade INT NOT NULL,
    FOREIGN KEY (grade) REFERENCES grades(grade_id) ON DELETE CASCADE  ON UPDATE CASCADE

);

-- INSERT INTO SUBJECTS
INSERT INTO subjects (
    subject,
    subject_code,
    grade
)VALUES (
    'English',
    'english-01',
    1
),(
    "Chemistry",
    "chemistry-01",
    2
),
(
    'Physic',
    'physic-01',
    1
);


-- CREATE TEACHER SUBJECTS TABLE
CREATE TABLE teacher_subjects(
    teacher_subject_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    teacher_id1 INT NOT NULL,
    subject_id1 INT NOT NULL,
    FOREIGN KEY (subject_id1) REFERENCES subjects(subject_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (teacher_id1) REFERENCES teachers(teacher_id) ON DELETE CASCADE ON UPDATE CASCADE
);
-- INSERT INTO TEACHER SUBJECTS 
INSERT INTO teacher_subjects(
    teacher_id1,
    subject_id1
)VALUES (
    1,
    1
),
(
    1,
    2
);



-- STUDENTS GRADE TABLE 
CREATE TABLE student_grades(
    student_grade_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id1 INT NOT NULL,
    grade_id1 INT NOT NULL,
    FOREIGN KEY (grade_id1) REFERENCES grades(grade_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (student_id1) REFERENCES students(student_id)  ON DELETE CASCADE ON UPDATE CASCADE
);
-- INSERT INTO STUDENTS GRADES 
INSERT INTO student_grades (
    student_id1,
    grade_id1
)VALUES(
    1,
    1
);



-- SECTION TABLE 
CREATE TABLE section (
    section_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(20)
);
-- INSERT INTO  SECTION
INSERT INTO section(
    section
)VALUES(
    'A'
),(
    "B"
),(
    "C"
),(
    "D"
),(
    "E"
);

-- STUDENT SECTION TABLE
CREATE TABLE student_section(
    student_section_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    student_id1 INT NOT NULL,
    section_id1 INT NOT NULL,
    FOREIGN KEY (section_id1) REFERENCES section(section_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (student_id1) REFERENCES students(student_id)  ON DELETE CASCADE ON UPDATE CASCADE
);
-- INSERT INTO STUDENTS SECTIONS
INSERT INTO student_section(
    student_id1,
    section_id1
)VALUES(
    1,
    1
);


--  CREATE CLASS TABLE FOR DATABASE 
CREATE TABLE classes (
    class_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    grade_id INT NOT NULL,
    section_id INT NOT NULL ,
    FOREIGN KEY (grade_id) REFERENCES grades(grade_id) ON DELETE CASCADE ON UPDATE CASCADE ,
    FOREIGN KEY (section_id) REFERENCES section(section_id) ON DELETE CASCADE ON UPDATE CASCADE
);
-- INSERT INTO CLASSES 
INSERT INTO classes (
    grade_id,
    section_id
)VALUES(
    1,
    1
),(
    2,
    2
);

--  CREATE THE TEACHER CLASS TABLE
CREATE TABLE teacher_class (
teacher_class_id  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
class_id1 INT NOT NULL,
teacher_id1 INT NOT NULL,
FOREIGN KEY (class_id1) REFERENCES classes(class_id) ON DELETE CASCADE ON UPDATE CASCADE ,
FOREIGN KEY (teacher_id1) REFERENCES teachers(teacher_id) ON DELETE CASCADE ON UPDATE CASCADE
);
-- INSERT INTO TEACHER CLASSES
INSERT INTO teacher_class(
    class_id1,
    teacher_id1
)VALUES(
    1,
    1
),(
    2,
    1
);



-- REGISTERER OFFICE TABLE 
CREATE TABLE registerer_office(
    r_user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(200),
    profile VARCHAR(255),
    fname VARCHAR(100),
    lname VARCHAR(100),
    address VARCHAR(100),
    employee_number VARCHAR(100),
    date_of_birth DATE,
    phone_number VARCHAR(100),
    qualification VARCHAR(244),
    gender VARCHAR(100),
    email VARCHAR(255),
    join_date DATE DEFAULT CURRENT_TIMESTAMP
);
-- INSERT INTO REGISTERER OFFICE
INSERT INTO registerer_office(
    username ,
    password,
    profile ,
    fname,
    lname ,
    address ,
    employee_number ,
    date_of_birth,
    phone_number ,
    qualification ,
    gender ,
    email
)VALUES(
    'Nabi',
    '$2y$10$6pGpFI0Uq8beqoTAWAf0EeJV400K7rIEKDgAKVMSfeD.vpMMGwlPu',
    'assets/images/default.jpg',
    'Mohammad Nabi',
    "Shizali",
    'Khost',
    "5234",
    "2000-2-4",
    "7848295498",
    "BBA",
    "Male",
    "nabi@gmail.com"
);


-- SETTING TABLE 
CREATE TABLE setting (
    setting_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    school_name VARCHAR(50),
    school_slogan VARCHAR(50),
    school_about TEXT(2000)

);

-- INSERT INTO THE SETTING TABLE DATA
INSERT INTO setting (
    school_name,
    school_slogan,
    school_about
)VALUES(
    'PSKH School',
    'This is the best School for the children and the good for the trust',
    "This is the best School for the people and we should support it and it provide the best ways the the teaching for the students and give the good quality to the students "
);




-- YEAR TABLE
CREATE TABLE years(
    year_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR (54)
);
-- INSERT INTO YEARS
INSERT INTO years(
    year
)VALUES(
    "2024"
),(
    '2025'
),(
    '2026'
),(
    '2027'
),(
    '2028'
),(
    '2029'
);


-- YEAR TABLE
CREATE TABLE semesters(
    semester_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    semester VARCHAR (54)
);
-- INSERT INTO SEMESTERS 
INSERT INTO semesters(
    semester
)VALUES(
    "1"
),(
    "2"
),(
    "3"
),(
    "4"
),(
    "5"
),(
    "6"
),(
    "7"
),(
    "8"
);

-- CREATE STUDENT SCORE TABLE
CREATE TABLE student_score(
    score_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    semester VARCHAR (40),
    year VARCHAR(40),
    student_id1 INT NOT NULL,
    teacher_id1 INT NOT NULL,
    subject_id1 INT NOT NULL,
    results VARCHAR(80),
    FOREIGN KEY (student_id1) REFERENCES students(student_id),
    FOREIGN KEY (teacher_id1) REFERENCES teachers(teacher_id),
    FOREIGN KEY (subject_id1) REFERENCES subjects(subject_id)
);
-- INSERT INTO students Score 
INSERT INTO student_score(
    semester ,
    year,
    student_id1,
    teacher_id1,
    subject_id1,
    results
)VALUES(
    '1',
    '2024',
    1,
    1,
    1,
    '89'
),(
    '2',
    '2024',
    1,
    1,
    2,
    '90'
);
-- MESSAGE TABLE
CREATE TABLE messages(
    message_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    send_full_name VARCHAR(40),
    send_email VARCHAR(50),
    send_message TEXT(10000),
    created_at DATE DEFAULT CURRENT_TIMESTAMP,
    read_status VARCHAR(50)
);

INSERT INTO messages(
    send_full_name,
    send_email,
    send_message,
    read_status
)VALUES(
    'Khan',
    'khan@gmail.com',
    'How can I see my results',
    'Read'
),(
    "Ahmad",
    'ahmad@gmail.com',
    'How can I change my password',
    "Read"
);

