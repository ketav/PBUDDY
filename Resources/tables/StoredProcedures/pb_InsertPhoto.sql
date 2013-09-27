-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE  PROCEDURE `pb_InsertPhoto`(IN `id` INT(100), IN `src` VARCHAR(1000), IN `pid` VARCHAR(1000))
BEGIN
    INSERT INTO photo_detail (user_id, photo_url, avg_rating,rating_received,photo_id,active_flag)
	VALUES (id, src,0,0,pid,1);
END