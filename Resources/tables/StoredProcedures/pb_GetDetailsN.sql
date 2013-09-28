-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `pb_GetDetailsN`(IN `start` INT(50), IN `dataSize` INT(10),IN `userId` INT(50), IN `SortOrder` VARCHAR(50))
BEGIN 
	select a.photo_url,a.avg_rating,a.rating_received,b.name,b.email_id,b.user_id from photo_detail a , user_detail b
	where a.user_id=b.user_id
	and a.user_id <> userId
	limit start,dataSize;
END