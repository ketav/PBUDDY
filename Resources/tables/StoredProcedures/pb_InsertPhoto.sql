Delimiter //
Create Procedure pb_InsertPhoto(
IN id INT(100), IN src VARCHAR(1000), IN pid INT(100)
)
BEGIN
    INSERT INTO photo_detail (user_id, photo_url, avg_rating,rating_received,photo_id,active_flag)
	VALUES (id, src,NULL,NULL,pid,1);
END //
Delimiter;
