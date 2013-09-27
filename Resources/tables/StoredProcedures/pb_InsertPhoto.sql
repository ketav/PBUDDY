-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pb_InsertPhoto`(IN `id` INT(100), IN `src` VARCHAR(1000), IN `pid` VARCHAR(1000))
BEGIN
DECLARE photoFlag INT;
    SELECT COUNT(1) into photoFlag from photo_detail  WHERE photo_id = pid;
	if photoFlag = 0
	then
	begin
    INSERT INTO photo_detail (user_id, photo_url, avg_rating,rating_received,photo_id,active_flag)
	VALUES (id, src,0,0,pid,1);
	end;
	end if;
END