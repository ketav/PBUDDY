CREATE DEFINER=`root`@`localhost` PROCEDURE `pb_UpdateRating`(IN `pid` VARCHAR(1000), IN `rating` INT)
BEGIN
DECLARE Votes INT;
DECLARE Avg DECIMAL;
Select avg_rating,rating_received into Avg,Votes from photo_detail where photo_id = pid;
UPDATE photo_detail SET avg_rating = ((Avg*Votes)+Rating)/(Votes+1),
rating_received = Votes+1 where photo_id = pid;
END