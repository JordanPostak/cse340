--Query 1
INSERT INTO clients (clientEmail, clientFirstname, clientId, clientLastName,  clientPassword, comment) VALUES ('tony@starkent.com', 'Tony', 1, 'Stark',  'Iam1ronM@n', 'I am the real Ironman');

--Query 2
UPDATE clients SET clientLevel = 3 WHERE clientEmail = 'tony@starkent.com';

--Query 3
UPDATE inventory SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior') WHERE invMake = 'GM' AND invModel = 'Hummer';

--Query 4
SELECT i.invModel, c.classificationName FROM inventory i INNER JOIN carclassification c ON i.classificationId = c.classificationId WHERE c.classificationName = 'SUV';

--Query 5
DELETE FROM inventory WHERE invModel = 'Wrangler' AND invMake = 'Jeep';

--Query 6
UPDATE Inventory SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail);