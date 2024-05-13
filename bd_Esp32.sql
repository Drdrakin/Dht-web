CREATE DATABASE esp32;

USE esp32;

CREATE TABLE dht_data (
	id INT AUTO_INCREMENT PRIMARY KEY,
    temperatura FLOAT,
    umidade FLOAT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);





































