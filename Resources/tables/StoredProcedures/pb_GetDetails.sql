-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `pb_GetDetails`(IN `FillterValue` VARCHAR(50), IN `PageNumber` INT(10), IN `SortOrder` VARCHAR(50))
BEGIN
	DECLARE First INT;
	DECLARE Last INT;
	SET First = (PageNumber-1)*10 + 1;
	SET Last = PageNumber*10 ;
						CREATE TEMPORARY TABLE TempTable 
						SELECT 		user_detail.email_id,	user_detail.name,	user_detail.sex,	user_detail.geography,	
								photo_detail.photo_id,	photo_detail.photo_url,	photo_detail.user_id,		photo_detail.avg_rating											
						FROM photo_detail 
						INNER JOIN user_detail  
						ON  photo_detail.user_id = user_detail.user_id
						WHERE photo_detail.active_flag = 1;
						
					CREATE TEMPORARY TABLE Total AS 
						SELECT COUNT(1) CountTotal FROM TempTable;
					
					SELECT	TempTable.email_id,	TempTable.name,		TempTable.sex,		TempTable.geography,
							TempTable.photo_id,		TempTable.photo_url,		TempTable.user_id,	TempTable.avg_rating,
							Total.CountTotal
					FROM TempTable ,Total;					
END