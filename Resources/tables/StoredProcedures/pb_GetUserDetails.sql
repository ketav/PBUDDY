-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pb_GetUserDetails`(IN `userID` VARCHAR(50))
BEGIN
		SELECT 		user_detail.email_id,	user_detail.name,	user_detail.sex,	user_detail.geography,	
					photo_detail.photo_id,	photo_detail.photo_url,	photo_detail.user_id,		photo_detail.avg_rating											
		FROM photo_detail 
		INNER JOIN user_detail  
		ON  photo_detail.user_id = user_detail.user_id
		where user_detail.user_id =  userID;					
END