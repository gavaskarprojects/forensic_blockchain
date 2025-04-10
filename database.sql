CREATE DATABASE forensic_chain;
USE forensic_chain;

-- Table to store forensic experts
CREATE TABLE experts (
    expert_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for uploaded files
CREATE TABLE uploaded_files (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    expert_id INT,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expert_id) REFERENCES experts(expert_id)
);

-- Table simulating IPFS storage
CREATE TABLE ipfs_storage (
    ipfs_id INT AUTO_INCREMENT PRIMARY KEY,
    file_id INT,
    ipfs_hash VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (file_id) REFERENCES uploaded_files(file_id)
);

-- Log actions for transparency
CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    expert_id INT,
    action TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expert_id) REFERENCES experts(expert_id)
);
