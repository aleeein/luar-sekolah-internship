CREATE DATABASE db_lembaga_pelatihan;
USE db_lembaga_pelatihan;

CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255),
    alamat TEXT,
    no_telp VARCHAR(15),
    email VARCHAR(255),
    foto VARCHAR(255),
    role ENUM('1', '2', '3') 
);


CREATE TABLE program (
    id_program INT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255),
    deskripsi TEXT,
    jadwal TEXT,
    biaya INT,
    materi TEXT
);

CREATE TABLE program (
    id_program INT PRIMARY KEY AUTO_INCREMENT,
    nama_program VARCHAR(255),
    deskripsi TEXT,
    jadwal TEXT,
    biaya INT,
    materi TEXT
);


CREATE TABLE nilai (
    id_nilai INT PRIMARY KEY AUTO_INCREMENT,
    id_peserta INT,
    id_program INT,
    nilai_ujian INT,
    nilai_tugas INT,
    FOREIGN KEY (id_peserta) REFERENCES user(id),
    FOREIGN KEY (id_program) REFERENCES program(id_program)
);


CREATE TABLE berita (
    id_berita INT PRIMARY KEY AUTO_INCREMENT,
    judul_berita VARCHAR(255),
    isi_berita TEXT,
    tanggal_publikasi DATE,
    foto_berita VARCHAR(255)
);


CREATE TABLE agenda (
    id_agenda INT PRIMARY KEY AUTO_INCREMENT,
    judul_agenda VARCHAR(255),
    tanggal_agenda DATE,
    waktu_agenda TIME,
    lokasi_agenda VARCHAR(255)
);


INSERT INTO user (nama, alamat, no_telp, email, foto, role)
VALUES
('John Doe', 'Jl. Mawar No. 1', '08123456789', 'johndoe@example.com', 'john.jpg', '2'),
('Jane Smith', 'Jl. Melati No. 2', '08123456790', 'janesmith@example.com', 'jane.jpg', '3'),
('Admin User', 'Jl. Dahlia No. 3', '08123456791', 'admin@example.com', 'admin.jpg', '1');


INSERT INTO program (nama_program, deskripsi, jadwal, biaya, materi)
VALUES
('Web Development', 'Learn to build websites', 'Monday-Wednesday', 5000000, 'HTML, CSS, JavaScript'),
('Data Science', 'Data analysis and machine learning', 'Tuesday-Thursday', 7000000, 'Python, Pandas, ML Algorithms');


INSERT INTO nilai (id_peserta, id_program, nilai_ujian, nilai_tugas)
VALUES
(1, 1, 85, 90),
(1, 2, 78, 82),
(2, 1, 88, 91);


INSERT INTO berita (judul_berita, isi_berita, tanggal_publikasi, foto_berita)
VALUES
('New Web Development Course Launched', 'We are excited to launch our new course this week', '2024-10-20', 'webdev.jpg'),
('Data Science Seminar', 'Join our upcoming seminar in a week, registration below', '2024-10-22', 'datascience.jpg');

INSERT INTO agenda (judul_agenda, tanggal_agenda, waktu_agenda, lokasi_agenda)
VALUES
('Web Dev Workshop', '2024-11-01', '10:00:00', 'Online Zoom'),
('Data Science Meetup', '2024-11-05', '14:00:00', 'Jakarta Convention Center');


SELECT u.nama AS peserta, p.nama_program
FROM user u
JOIN nilai n ON u.id = n.id_peserta
JOIN program p ON n.id_program = p.id_program
WHERE u.role = '2';

SELECT u.nama AS pelatih, p.nama_program
FROM user u
JOIN program p ON u.id = p.id_program
WHERE u.role = '3';

SELECT u.nama AS peserta, AVG((n.nilai_ujian + n.nilai_tugas) / 2) AS nilai_rata_rata
FROM user u
JOIN nilai n ON u.id = n.id_peserta
GROUP BY u.id;

SELECT judul_berita, tanggal_publikasi 
FROM berita 
ORDER BY tanggal_publikasi DESC 
LIMIT 1;

SELECT judul_berita, isi_berita 
FROM berita 
WHERE kategori = 'Technology';

SELECT judul_agenda, tanggal_agenda, waktu_agenda, lokasi_agenda
FROM agenda
WHERE tanggal_agenda >= CURDATE()
ORDER BY tanggal_agenda ASC;






