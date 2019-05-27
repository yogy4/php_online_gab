# untuk menjalankan ini pastikan langkah berikut ditaati(dalam hal ini menggunakan os linux, web server apache/2.4.39, mariadb 10.3.15 dan php 7.3.5)
1. Taruh/upload project di document root
2. Impor database(file.sql dan users.sql pada database yang telah dibuat)
3. Set configurasi pada folder config(file database.php untuk konfigurasi database, file core.php untuk konfigurasi url serta token dan pengaturan halaman)
4. Lalu jalankan


url \
[GET] /content/read.php \
[GET] /content/read_one.php?id= \
[GET] /content/read_paging.php?id= \
[POST] /content/create.php (author, isi, jwt) \
[POST] /user/registration.php (firstname, lastname, email, password) \
[POST] /user/login.php (email, password) \
