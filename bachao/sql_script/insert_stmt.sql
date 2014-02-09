INSERT INTO user_profile VALUES('XXXXX', '8755716980', 'xx9898@gmail.com', 'M', '1991-03-11');

INSERT INTO user_location VALUES('8755716980', '47.117828', '-88.545625', DEFAULT);

INSERT INTO user_contacts_phone VALUES('8755716980', '8755306798'); 
INSERT INTO user_contacts_email VALUES('8755716980', 'singh.rishi54@gmail.com');
INSERT INTO user_contacts_phone VALUES('8755716980', '947555163'); 
INSERT INTO user_contacts_email VALUES('8755716980', 'jishnu.unique@gmail.com');
INSERT INTO user_contacts_phone VALUES('8755716980', '9432104173'); 
INSERT INTO user_contacts_email VALUES('8755716980', 'banerjee.soumyajyoti4@gmail.com');


select * from user_profile;
select * from user_location;
select * from user_contacts_phone;
select * from user_contacts_email;

SELECT con_name, con_phone, con_email FROM user_contacts uc WHERE phone = '987654321'
UNION
SELECT name, phone, email
FROM user_profile up
WHERE 	up.phone <> '987654321';

SELECT (6378.10 * ACOS(COS(RADIANS(latpoint))
                 * COS(RADIANS(latitude))
                 * COS(RADIANS(longpoint) - RADIANS(longitude))
                 + SIN(RADIANS(latpoint))
                 * SIN(RADIANS(latitude)))) AS distance_in_km
FROM user_location ul,
(SELECT  47.117828  AS latpoint,  -88.545625 AS longpoint) t;