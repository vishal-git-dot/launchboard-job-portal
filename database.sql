CREATE DATABASE IF NOT EXISTS launchboard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE launchboard;
CREATE TABLE IF NOT EXISTS users (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('student','admin') NOT NULL DEFAULT 'student',
 company_name VARCHAR(160) NULL,
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS jobs (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 posted_by INT UNSIGNED NOT NULL,
 company_name VARCHAR(160) NOT NULL,
 title VARCHAR(180) NOT NULL,
 description TEXT NOT NULL,
 location VARCHAR(180) NOT NULL,
 category ENUM('Internship','Full-time','Part-time','Contract','Freelance','Apprenticeship') NOT NULL DEFAULT 'Internship',
 deadline DATE NULL,
 status ENUM('published','draft','closed') NOT NULL DEFAULT 'published',
 created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_jobs_poster FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE CASCADE,
 INDEX idx_jobs_search (status, category, location), INDEX idx_jobs_created (created_at)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS applications (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 job_id INT UNSIGNED NOT NULL,
 user_id INT UNSIGNED NOT NULL,
 resume VARCHAR(255) NOT NULL,
 cover_note TEXT NULL,
 status ENUM('Submitted','Under Review','Shortlisted','Rejected','Accepted') NOT NULL DEFAULT 'Submitted',
 applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
 CONSTRAINT fk_app_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
 UNIQUE KEY unique_application (job_id,user_id), INDEX idx_app_status (status)
) ENGINE=InnoDB;
