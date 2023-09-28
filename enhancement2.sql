--Query 1
INSERT INTO clients (clientEmail, clientFirstname, clientId, clientLastName,  clientPassword, comment) VALUES ('tony@starkent.com', 'Tony', 1, 'Stark',  'Iam1ronM@n', 'I am the real Ironman');

--Query 2
UPDATE clients SET clientLevel = 3 WHERE clientEmail = 'tony@starkent.com';

--Query 3
tes