/*
User 			: guest_user
Password 		: guest123

Database name 	: bachao
*/

DROP TABLE IF EXISTS user_profile;

CREATE TABLE user_profile(
name		VARCHAR(100)
, phone		VARCHAR(12)	
, email		VARCHAR(100)
, gender	VARCHAR(1)
, dob		DATE
, PRIMARY KEY (phone)
);

DROP TABLE IF EXISTS user_location;

CREATE TABLE user_location(
phone			VARCHAR(12)
, latitude		VARCHAR(20)
, longitude		VARCHAR(20)
, last_updated	TIMESTAMP	DEFAULT CURRENT_TIMESTAMP()		-- stores timestamp in UTC and converts back current time-zone of retrieval
, FOREIGN KEY (phone)
	REFERENCES user_profile(phone)
	ON DELETE CASCADE
);

DROP TABLE IF EXISTS user_contacts_phone;

CREATE TABLE user_contacts_phone(
phone			VARCHAR(12)
, con_phone		VARCHAR(12)
, FOREIGN KEY (phone)
	REFERENCES user_profile(phone)
	ON DELETE CASCADE
);

DROP TABLE IF EXISTS user_contacts_email;

CREATE TABLE user_contacts_email(
phone			VARCHAR(12)
, con_email		VARCHAR(100)
, FOREIGN KEY (phone)
	REFERENCES user_profile(phone)
	ON DELETE CASCADE
);