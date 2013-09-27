-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE PROCEDURE `pb_UpdateRating`(IN `pid` VARCHAR(100), IN `rating` INT)
BEGIN
	DECLARE Votes INT;
	DECLARE Avrg DECIMAL;
	Select avg_rating,rating_received into Avrg,Votes from photo_detail where photo_id = pid;
	UPDATE photo_detail SET avg_rating = ((Avrg*Votes)+Rating)/(Votes+1),
	rating_received = Votes+1 where photo_id = pid;
	END