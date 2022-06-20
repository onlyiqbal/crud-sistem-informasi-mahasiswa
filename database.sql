CREATE DATABASE db_student;

CREATE DATABASE db_student_test;

CREATE TABLE users(
    id VARCHAR(255) PRIMARY KEY ,
    name VARCHAR(255) NOT NULL ,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE sessions(
    id VARCHAR(255) PRIMARY KEY ,
    user_id VARCHAR(255) NOT NULL
);

CREATE TABLE students(
    nim VARCHAR(8) PRIMARY KEY ,
    nama VARCHAR(255),
    tempat_lahir VARCHAR(255),
    tanggal_lahir DATE,
    fakultas VARCHAR(255),
    jurusan VARCHAR(255)
    ipk FLOAT(2,3)
);

ALTER TABLE sessions
ADD CONSTRAINT fk_sessions_user
FOREIGN KEY (user_id)
REFERENCES users(id);